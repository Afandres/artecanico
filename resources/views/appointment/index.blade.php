<style>
.domingo-bloqueado {
    background-color: #f5f5f5 !important;
    pointer-events: none;
    opacity: 0.6;
}
#createPetModal {
    z-index: 1065;
}

#createPetModal + .modal-backdrop {
    z-index: 1060;
}
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Citas
        </h2>
    </x-slot>
    <div class="py-12 d-flex gap-2" id="client_container">
        <input type="text" placeholder="Ingresa tu código de cliente" id="client_code" class="form-control">
        <button id="search_code" class="btn btn-primary">Buscar mis citas</button>
        <button id="btnNotif" class="btn btn-success mt-2">
        🔔 Activar recordatorios
        </button>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="calendar" id="calendar">
                    
                </div>
            </div>
        </div>
    </div>
    @include('appointment.schedule_modal')
    @include('appointment.schedule_appointment_modal')
    @include('pets.pet_modal')
    @include('appointment.appointment_modal')
</x-app-layout>
<script>
    //php artisan serve --host=127.0.0.1 --port=8000
    //cloudflared tunnel --url http://127.0.0.1:8000
    let isAuth = {{ auth()->check() ? 'true' : 'false' }};
    let reopenScheduleModal = false;
   
    document.addEventListener('DOMContentLoaded', function() {
        if (!isAuth) {
            $('#client_code').focus();
        }else{
            document.getElementById('client_container').style.setProperty('display', 'none', 'important');
        }
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                list: 'Lista'
            },
            height: 'auto',
            aspectRatio: 1.0,
            editable: false,
            droppable: true,
            selectable: true,
            eventTimeFormat: {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            },
            eventSources: [
                // 🟢 ADMIN
                ...(isAuth ? [{
                    url: '{{ route("appointment.events") }}',
                    method: 'GET'
                }] : []),

                ...(!isAuth ? [{
                    url: '{{ route("appointment.fullDays") }}',
                    method: 'GET'
                }] : [])

            ],
            eventClick: function(info) {

                let event = info.event;
                let props = event.extendedProps;

                let status = props.status;
                let photo = props.photo ? props.photo : '/storage/pets/images.png';
                console.log(photo);
                $('#appointment_id').val(event.id);
                $('#event_title').text(event.title);
                $('#event_pet_photo').attr('src', photo).show();

                $('#event_client').text('Dueño: ' + (props.client || ''));
                $('#event_phone').text(props.phone || '');
                $('#event_breed').text('Raza: ' + (props.breed || ''));
                $('#event_age').text('Edad: ' + (props.age || 'No registrada'));
                $('#event_gender').text('Género: ' + (props.gender || ''));
                $('#event_medical_condition').text('Cond. Médica: ' + (props.medical_condition || 'No registrada'));
                $('#event_observations').text('Observaciones: ' + (props.observations || 'No registrada'));
                let progress = $('#status_progress');

                if (status === 'Pendiente') {

                    progress
                        .css('width', '33%')
                        .removeClass()
                        .addClass('progress-bar bg-warning');

                    $('#event_status').text('🟡 Pendiente');
                }

                if (status === 'En proceso') {

                    progress
                        .css('width', '66%')
                        .removeClass()
                        .addClass('progress-bar bg-primary progress-bar-striped progress-bar-animated');

                    $('#event_status').text('🔵 En proceso');
                }

                if (status === 'Completada') {

                    progress
                        .css('width', '100%')
                        .removeClass()
                        .addClass('progress-bar bg-success');

                    $('#event_status').text('🟢 Completada');
                }

                if (status === 'Cancelada') {

                    progress
                        .css('width', '100%')
                        .removeClass()
                        .addClass('progress-bar bg-danger');

                    $('#event_status').text('🔴 Cancelada');
                }

                /*
                ====================================
                CLIENTE
                ====================================
                */
                if (!isAuth) {
                    let select = $('#appointment_status');
                    select.empty();

                    $('#extra_fields').hide();
                    $('#appointment_status').closest('.mb-3').show();
                    $('#saveBtn').show();

                    if (status === 'Pendiente') {
                        select.append(`<option>--- Seleccione ---</option>`);
                        select.append(`<option value="Cancelada">🔴 Cancelar</option>`);
                    }else {
                        $('#appointment_status').closest('.mb-3').hide();
                        $('#saveBtn').hide();
                    }
                    $('#appointmentForm').attr('action', '/appointments/cancel');
                } else {
                    $('#appointment_status').closest('.mb-3').show();

                    let select = $('#appointment_status');
                    select.empty();

                    $('#extra_fields').hide();

                    if (status === 'Pendiente') {
                        select.append(`<option>--- Seleccione ---</option>`);
                        select.append(`<option value="En proceso">🔵 En proceso</option>`);
                        select.append(`<option value="Cancelada">🔴 Cancelar</option>`);
                    }

                    if (status === 'En proceso') {
                        $('#extra_fields').show();

                        select.append(`<option>--- Seleccione ---</option>`);
                        select.append(`<option value="Completada">🟢 Completada</option>`);
                        select.append(`<option value="Cancelada">🔴 Cancelar</option>`);
                    }

                    if (status === 'Completada' || status === 'Cancelada') {
                        select.append(`<option selected>${status}</option>`);
                        select.prop('disabled', true);
                    } else {
                        select.prop('disabled', false);
                    }
                    $('#appointmentForm').attr('action', '/appointments/state');
                }

                let modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
                modal.show();
            },
            dateClick: function(info) {
                let fecha = info.dateStr;

                let isFull = calendar.getEvents().some(e => 
                    e.startStr === fecha && e.display === 'background'
                );

                if (!isAuth && isFull) {
                    Swal.fire({
                        title: "Lo sentimos 🥺 este día ya no tiene cupos disponibles",
                        icon: "warning",
                        timer: 1500
                    });
                    return;
                }

                if (info.date.getDay() === 0) {
                    Swal.fire({
                        title: "Lo sentimos 🥺 los domingos no estamos disponibles para agendar citas.",
                        icon: "warning",
                        draggable: true,
                        timer: 2000
                    });
                    return; // ❌ bloquea domingos
                }

                if (!isAuth) {
                    scheduleModal(info);
                } else {
                    scheduleAppointment(info);
                } 
            },

            dayCellClassNames: function(arg) {
                if (arg.date.getDay() === 0) {
                    return ['domingo-bloqueado'];
                }
            }
            
        });
        calendar.render();

        if(!isAuth){
            $('#search_code').on('click', function () {

                let code = $('#client_code').val().trim();
                $('#client_code_hidden').val(code);

                if (code == '') {
                    Swal.fire('Debes ingresar tu código');
                    return;
                }

                // borrar eventos actuales
                calendar.getEventSources().forEach(source => source.remove());

                // volver a cargar días llenos
                calendar.addEventSource({
                    url: '{{ route("appointment.fullDays") }}',
                    method: 'GET'
                });

                // cargar citas del cliente
                calendar.addEventSource({
                    url: '/appointments/client/' + code,
                    method: 'GET',
                    failure: function () {
                        Swal.fire('Código inválido o sin citas');
                    }
                });

            });
        }
        

        $('#client_code').on('keypress', function (e) {
            if (e.which == 13) {
                $('#search_code').click();
            }
        });

        fromAppointments = true;

        $('#breed_id').select2({
            placeholder: 'Selecciona una raza',
            dropdownParent: $('#createPetModal'),
            width: '100%',
            minimumInputLength: 0,
            ajax: {
                url: '{{ route("pet.breeds") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { search: params.term || ''};
                },
                processResults: function (data) {
                    return {
                        results: data.map(breed => ({
                            id: breed.id,
                            text: breed.name
                        }))
                    };
                }
            }
        });

        $('#client_id').select2({
            placeholder: 'Buscar dueño de la mascota',
            dropdownParent: $('#createPetModal'),
            width: '100%',
            minimumInputLength: 0,
            tags: true,

            createTag: function (params) {
                let term = $.trim(params.term);
                console.log(term);
                if (term === '') return null;

                return {
                    id: term,
                    text: term,
                    newTag: true // 👈 CLAVE
                };
            },
            ajax: {
                url: '{{ route("pet.clients") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { search: params.term || ''};
                },
                processResults: function (data) {
                    return {
                        results: data.map(client => ({
                            id: client.id,
                            text: client.name
                        }))
                    };
                }
            }
        });

        const btn = document.getElementById('btnNotif');
        const permission = Notification.permission;
        if (!btn) return;

        // 🔥 Si ya estaban activadas antes
        if (permission === 'granted') {
            btn.style.display = 'none';
        }
        btn.addEventListener('click', function () {
            let code = $('#client_code').val().trim();

            if (code == '') {
                Swal.fire('Primero busca tus citas');
                return;
            }
            OneSignalDeferred.push(async function(OneSignal) {          
                await OneSignal.Notifications.requestPermission();
                if (Notification.permission !== 'granted') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Debes aceptar las notificaciones'
                    });
                    return;
                }

                await OneSignal.login(code);

                Swal.fire({
                    icon: 'success',
                    title: '🔔 Recordatorios activados'
                });

                $('#btnNotif').hide();

            });

        });
        
    });

    $(document).on('select2:select', '#client_id', function (e) {

        let data = e.params.data;

        if (data.newTag || isNaN(data.id)) {
            $('#phone_container').fadeIn();
        } else {
            $('#phone_container').fadeOut();
            $('#emergency_phone').val('');
        }
    });

    $(document).on('select2:close', '#client_id', function () {

        let select = $(this);
        let data = select.select2('data');

        if (!data.length) return;

        let selected = data[0];

        if (selected.newTag || isNaN(selected.id)) {
            $('#phone_container').fadeIn();
        }
    });

    $('#schedule_appointment_Modal').on('shown.bs.modal', function () {

        let select = $('#pet_name');

        if (select.hasClass('select2-hidden-accessible')) {
            select.select2('destroy');
        }

        select.select2({
            placeholder: 'Buscar mascota...',
            minimumInputLength: 1,
            width: '100%',
            dropdownParent: $('#schedule_appointment_Modal'),
            tags: true,
            selectOnClose: true,
            createTag: function (params) {
                let term = $.trim(params.term);
                if (term === '') return null;

                let existsExact = $('#pet_name').data('existsExact');

                if (existsExact) {
                    return null; // 👈 NO crear si ya existe en BD
                }

                return {
                    id: term,
                    text: term,
                    newTag: true
                };
            },
            templateResult: function (data) {
                if (data.loading) {
                    return data.text;
                }

                // ❌ No mostrar nada si es un tag nuevo o no tiene datos reales
                if (data.newTag || !data.id || !data.client) {
                    return null;
                }

                return $(`
                    <div style="display:flex; align-items:center; gap:10px; padding:5px;">
                        <img src="${data.photo ? data.photo : '/storage/pets/images.png'}" style="width:70px; height:70px; border-radius:10px; object-fit:cover;">
                        <div>
                            <div style="font-weight:600;">${data.text} - ${data.sobriquet}</div>
                            <div> <small style="color:#666;">Dueño: ${data.client} - ${data.phone}</small> </div>
                            <div> <small style="color:#666;">Raza: ${data.breed}</small> </div>
                            <div> <small style="color:#666;">Edad: ${data.age ? data.age + ' años' : 'No registrada'}</small> </div>
                            <div> <small style="color:#666;">Género: ${data.gender}</small> </div>
                            <div> <small style="color:#666;">Cond. Médica: ${data.medical_condition || 'No registrada'}</small> </div>
                            <div> <small style="color:#666;">Observaciones: ${data.observations || 'No registradas'}</small> </div>
                        </div>
                    </div>
                `);
            },
            templateSelection: function (data) {
                return data.sobriquet 
                    ? `${data.text} - ${data.sobriquet}` 
                    : data.text;
            },
            ajax: {
                url: '{{ route('appointment.pet.search') }}',
                method: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { search: params.term };
                },
                processResults: function (data) {   
                    $('#pet_name').data('existsExact', data.existsExact);

                    return {
                        results: data.results
                    };
                }
            }
        });

    });

    $('#pet_name').on('select2:close', function () {

        let data = $(this).select2('data');

        if (!data.length) return;

        let selected = data[0];

        if (selected.newTag) {

            $('#new_pet_name').val(selected.text);

            let petModal = new bootstrap.Modal(
            document.getElementById('createPetModal'),
            {
            backdrop: 'static',
            keyboard: false
            });

            $('#createPetModal').appendTo('body');
            petModal.show();
        }
    });

    $('#createPetModal').on('hidden.bs.modal', function () {

        // esperar a que bootstrap termine animación
        setTimeout(() => {

            // si sigue abierto el modal padre
            if ($('#schedule_appointment_Modal').hasClass('show')) {

                // restaurar estado del body
                $('body').addClass('modal-open');

                // eliminar backdrops sobrantes
                $('.modal-backdrop').not(':last').remove();

            }

        }, 200);
    });

    $('#schedule_appointment_Modal').on('hidden.bs.modal', function () {

        let select = $('#pet_name');

        if (select.hasClass('select2-hidden-accessible')) {
            select.select2('destroy');
        }

        $('.select2-container').remove();
        $('.modal-backdrop').remove();

        $('body').removeClass('modal-open');
        $('body').css({
            overflow:'',
            paddingRight:''
        });

        bootstrap.Modal.getInstance(this)?.dispose();
    });

    $('#pet_name').on('select2:select', function (e) {
        let data = e.params.data;

        if (data.newTag || !data.id) {
            $('#pet_photo').hide();
            $('#pet_info').hide();
            return;
        }

        let photo = data.photo ? data.photo : '/storage/pets/images.png';

        $('#pet_photo')
            .attr('src', photo)
            .show();

        // ✅ Info
        $('#pet_name_text').text(data.text);
        $('#pet_client').text(`Dueño: ${data.client} - ${data.phone}`);
        $('#pet_breed').text(`Raza: ${data.breed}`);
        $('#pet_age').text(`Edad: ${data.age ? data.age + ' años' : 'No registrada'}`);
        $('#pet_gender').text(`Género: ${data.gender}`);
        $('#pet_medical').text(`Cond. Médica: ${data.medical_condition || 'No registrada'}`);
        $('#pet_observations').text(`Observaciones: ${data.observations || 'No registradas'}`);

        $('#pet_info').show();
    });

    $('#pet_name').on('select2:clear', function () {
        $('#pet_photo').hide();
        $('#pet_info').hide();
    });

    $('#pet_name').on('change', function () {
        let selected = $(this).select2('data')[0];

        if (selected && selected.photo) {
            $('#pet_photo')
                .attr('src', selected.photo)
                .show();
        }
    });


    $('#createPetForm').on('submit', function(e) {
        e.preventDefault();

        let form = document.getElementById('createPetForm');

        let formData = new FormData();

        formData.append('client_id', $('#client_id').val());
        formData.append('emergency_phone', $('#emergency_phone').val());
        formData.append('new_pet_name', $('#new_pet_name').val());
        formData.append('breed_id', $('#breed_id').val());
        formData.append('age', $('#age').val());
        formData.append('gender', $('#gender').val());
        formData.append('medical_condition', $('#medical_condition').val());
        formData.append('observations', $('#observations').val());

        let fileInput = document.getElementById('profile_photo');

        if (fileInput.files.length > 0) {
            formData.append('profile_photo', fileInput.files[0]);
        }

        $.ajax({
            url: '{{ route("pet.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.new_client){

                    let phone = response.phone;
                    let code  = response.access_code;

                    let mensaje =`Hola 👋 Bienvenido a Arte Canino 🐶✨ Tu código para consultar tus citas es: ${code} Ingresa aquí: https://pin-collapse-journal-softball.trycloudflare.com/appointments`;
                    let encoded = encodeURIComponent(mensaje);

                    // intento abrir app
                    let appUrl = `whatsapp://send?phone=57${phone}&text=${encoded}`;

                    // fallback web
                    let webUrl = `https://api.whatsapp.com/send?phone=57${phone}&text=${encoded}`;

                    // detectar Android
                    let isAndroid = /Android/i.test(navigator.userAgent);

                    if (isAndroid) {
                        window.location.href = appUrl;

                        // si no abre, fallback
                        setTimeout(() => {
                            window.location.href = webUrl;
                        }, 1500);
                    } else {
                        window.open(webUrl, '_blank');
                    }
                }

                Swal.fire({
                    title: response.message,
                    icon: "success",
                    draggable: true,
                    timer: 1500
                });


                if (fromAppointments) {

                    let newOption = new Option(response.name, response.id, true, true);

                    $('#pet_name').append(newOption).trigger('change');

                    $('#pet_name').trigger({
                        type: 'select2:select',
                        params: {
                            data: {
                                id: response.id,
                                text: response.name,
                                photo: response.photo,
                                client: response.client,
                                phone: response.phone,
                                breed: response.breed,
                                age: response.age,
                                gender: response.gender,
                                medical_condition: response.medical_condition,
                                observations: response.observations
                            }
                        }
                    });

                    bootstrap.Modal.getInstance(
                        document.getElementById('createPetModal')
                    ).hide();

                } else {

                    // =====================================
                    // SI VIENE DESDE MASCOTAS
                    // =====================================
                    setTimeout(() => {
                        location.reload();
                    }, 1200);

                }

            },

            error: function(xhr) {

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    // 🔥 limpia errores anteriores
                    $('.error-text').remove();

                    // 🔥 mostrar errores debajo de cada campo
                    for (let field in errors) {
                        let input = $('[name="' + field + '"]');
                        input.after('<small class="text-danger error-text">' + errors[field][0] + '</small>');
                    }
                } else {
                    Swal.fire({
                        title: "Error al crear la mascota",
                        icon: "error",
                        draggable: true,
                        timer: 1500
                    });
                }
            }
        });
    });

    $('#pet_name').on('change', function () {
        let photo = $(this).find(':selected').data('photo');

        if (photo) {
            $('#pet_photo')
                .attr('src', photo)
                .show();
        } else {
            $('#pet_photo').hide();
        }
    });


    function scheduleModal(info){
        var modal = new bootstrap.Modal(document.getElementById('scheduleModal'));
        modal.show();
        
        let date = new Date(info.dateStr + 'T00:00:00');
        
        let formatedDate = date.toLocaleDateString('es-CO', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        formatedDate = formatedDate.charAt(0).toUpperCase() + formatedDate.slice(1);
        
        document.getElementById('appointment_date').innerText = formatedDate;
    }

   function scheduleAppointment(info){

        let el = document.getElementById('schedule_appointment_Modal');

        // destruir instancia anterior si existe
        let old = bootstrap.Modal.getInstance(el);
        if (old) {
            old.dispose();
        }

        // limpiar residuos visuales
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css({
            overflow: '',
            paddingRight: ''
        });

        // crear nueva instancia limpia
        let modal = new bootstrap.Modal(el,{
            backdrop:true,
            keyboard:true
        });

        modal.show();

        $('#schedule_appointment_id').val(info.dateStr);

        let date = new Date(info.dateStr + 'T00:00:00');

        let formatedDate = date.toLocaleDateString('es-CO', {
            weekday:'long',
            day:'numeric',
            month:'long',
            year:'numeric'
        });

        formatedDate =
            formatedDate.charAt(0).toUpperCase() +
            formatedDate.slice(1);

        $('#show_appointment_date').val(formatedDate);
    }

    function enviarWhatsApp() {
        let fecha = document.getElementById('appointment_date').innerText;

        let numero = "573118961146";

        let mensaje = `Hola, quiero agendar una cita para el día ${fecha}`;

        let url = `https://wa.me/${numero}?text=${encodeURIComponent(mensaje)}`;

        window.open(url, '_blank');
    }
</script> 

@if(session('success'))
    <script>
        Swal.fire({
            title: "{{ session('success') }}",
            icon: "success",
            draggable: true,
            timer: 1500
        });

        let status = "{{ session('status') }}";

        // 🔥 SOLO si está completada
        if (status === 'Pendiente'){
            console.log('sii');
            
        }
        if (status === 'Completada') {

            let pet =  @json(session('pet'));
            let phone = @json(session('phone'));

            let mensaje = "Hola 👋 Te informamos que " + pet + " ya está listo 🐶✨. Gracias por confiar en nosotros ☺️";

            let encoded = encodeURIComponent(mensaje);

            // intento abrir app
            let appUrl = `whatsapp://send?phone=57${phone}&text=${encoded}`;

            // fallback web
            let webUrl = `https://api.whatsapp.com/send?phone=57${phone}&text=${encoded}`;

            // detectar Android
            let isAndroid = /Android/i.test(navigator.userAgent);

            if (isAndroid) {
                window.location.href = appUrl;

                // si no abre, fallback
                setTimeout(() => {
                    window.location.href = webUrl;
                }, 1500);
            } else {
                window.open(webUrl, '_blank');
            }
        }
    </script>
@elseif (session('error'))
    <script>
        Swal.fire({
            title: "{{ session('error') }}",
            icon: "error",
            draggable: true,
            timer: 1500
        });
    </script>
@endif
