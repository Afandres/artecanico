<style>
    /* =====================================
   FULLCALENDAR
===================================== */
    .fc {
        padding: 20px;
    }

    /* toolbar */
    .fc .fc-toolbar-title {
        font-size: 34px !important;
        font-weight: 800;
        color: #334155;
    }

    .fc .fc-button {
        background: #1e293b !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 8px 16px !important;
        font-weight: 700;
    }

    .fc .fc-button:hover {
        background: #334155 !important;
    }

    /* días */
    .fc-theme-standard td,
    .fc-theme-standard th {
        border: 1px solid #f1f5f9 !important;
    }

    .fc-col-header-cell {
        background: #fff7f2;
        color: #444;
        font-weight: 800;
        padding: 12px 0;
    }

    /* celdas */
    .fc-daygrid-day {
        transition: .2s;
        background: #fff;
    }

    .fc-daygrid-day:hover {
        background: #fff8f3;
    }

    /* número del día */
    .fc-daygrid-day-number {
        font-weight: 700;
        color: #475569;
        padding: 8px;
    }

    /* hoy */
    .fc-day-today {
        background: #fff4db !important;
    }

    /* =====================================
    EVENTOS CITAS
    ===================================== */
    .fc-event {
        border: none !important;
        border-radius: 10px !important;
        padding: 4px 8px !important;
        font-weight: 700;
        font-size: 14px;
    }

    .fc-event:hover {
        transform: scale(1.02);
    }

    /* =====================================
    DOMINGOS / BLOQUEADOS
    ===================================== */
    .domingo-bloqueado,
    .dia-pasado {
        background: #f8fafc !important;
        opacity: .55;
    }

    /* =====================================
    MODALES
    ===================================== */
    .modal-content {
        border: none !important;
        border-radius: 22px !important;
        box-shadow: 0 20px 45px rgba(0, 0, 0, .12);
    }

    .modal-header {
        border-bottom: 1px solid #f5f5f5;
        background: linear-gradient(90deg, #fff, #fff7f2);
    }

    .modal-title {
        font-weight: 800;
    }
    /* =====================================
    TIMELINE CARDS IGUALES
    ===================================== */

    

    @media (max-width:768px) {

        /* espacio general */
        .fc {
            padding: 8px !important;
        }

        /* toolbar completo */
        .fc-header-toolbar {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px;
            align-items: center;
        }

        /* bloques */
        .fc-toolbar-chunk {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
            width: 100%;
        }

        /* título */
        .fc-toolbar-title {
            font-size: 22px !important;
            font-weight: 800;
            text-align: center;
            line-height: 1.1;
            margin: 4px 0 !important;
        }

        /* botones */
        .fc .fc-button {
            padding: 6px 10px !important;
            font-size: 13px !important;
            border-radius: 10px !important;
        }

        /* columnas días */
        .fc-col-header-cell {
            font-size: 13px;
            padding: 6px 0;
        }

        /* números día */
        .fc-daygrid-day-number {
            font-size: 14px;
            padding: 4px;
        }

        /* eventos */
        .fc-daygrid-event {
            padding: 2px 4px !important;
            min-height: 20px !important;
            font-size: 10px !important;
            overflow: hidden !important;
        }

        /* hora pequeña */
        .fc-event-time {
            font-size: 9px !important;
            font-weight: 700;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        /* nombre mascota */
        .fc-event-title {
            font-size: 9px !important;
            font-weight: 700 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            max-width: 100% !important;
            display: block !important;
        }

        /* link +más */
        .fc-daygrid-more-link {
            font-size: 10px !important;
            font-weight: 700;
        }
        
        #timeline_info .card-body{
            min-height:auto;
        }

        #timeline_info img{
            width:80px;
            height:80px;
        }
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (auth()->check())
                Citas
            @else
                Mis citas
            @endif
        </h2>
    </x-slot>
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
    @include('pets.create')
    @include('appointment.appointment_modal')
</x-app-layout>
<script>
    //php artisan serve
    //cloudflared tunnel --url http://127.0.0.1:8000
    let isAuth = {{ auth()->check() ? 'true' : 'false' }};
    let reopenScheduleModal = true;
    let fromAppointments = false;
    let routeCode = @json($code ?? null);

    document.addEventListener('DOMContentLoaded', function() {
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
                    url: '{{ route('appointment.events') }}',
                    method: 'GET'
                }] : []),

                ...(!isAuth ? [{
                    url: '{{ route('appointment.fullDays') }}',
                    method: 'GET'
                }] : [])

            ],
            eventClick: function(info) {
                if (typeof window.handleEventClick === 'function') {
                    window.handleEventClick(info);
                }
            },
            dateClick: function(info) {
                let fechaSeleccionada = new Date(info.dateStr + 'T00:00:00');
                let hoy = new Date();
                hoy.setHours(0, 0, 0, 0);

                if (!isAuth && fechaSeleccionada < hoy) {
                    Swal.fire({
                        title: "No puedes agendar citas en fechas pasadas",
                        icon: "warning",
                        timer: 1800
                    });
                    return;
                }

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
                let hoy = new Date();
                hoy.setHours(0, 0, 0, 0);

                if (!isAuth && arg.date < hoy) {
                    return ['dia-pasado'];
                }

                if (arg.date.getDay() === 0) {
                    return ['domingo-bloqueado'];
                }
            }

        });
        calendar.render();

        if (!isAuth && routeCode) {

            cargarCitasCliente(routeCode, calendar);

        }

    });

    $(document).on('select2:select', '#client_id', function(e) {

        let data = e.params.data;

        if (data.newTag || isNaN(data.id)) {
            $('#phone_container').fadeIn();
        } else {
            $('#phone_container').fadeOut();
            $('#emergency_phone').val('');
        }
    });

    $(document).on('select2:close', '#client_id', function() {

        let select = $(this);
        let data = select.select2('data');

        if (!data.length) return;

        let selected = data[0];

        if (selected.newTag || isNaN(selected.id)) {
            $('#phone_container').fadeIn();
        }
    });

    $('#schedule_appointment_Modal').on('shown.bs.modal', function() {

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
            createTag: function(params) {
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
            templateResult: function(data) {
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
            templateSelection: function(data) {
                return data.sobriquet ?
                    `${data.text} - ${data.sobriquet}` :
                    data.text;
            },
            ajax: {
                url: '{{ route('appointment.pet.search') }}',
                method: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    $('#pet_name').data('existsExact', data.existsExact);

                    return {
                        results: data.results
                    };
                }
            }
        });

    });

    $('#pet_name').on('select2:close', function() {

        let data = $(this).select2('data');

        if (!data.length) return;

        let selected = data[0];

        if (selected.newTag) {

            $('#new_pet_name').val(selected.text);

            // cerrar modal primero
            let modal = bootstrap.Modal.getInstance(
                document.getElementById('schedule_appointment_Modal')
            );

            if (modal) {
                modal.hide();
            }
            fromAppointments = true;
            setTimeout(() => {

                let panel = new bootstrap.Offcanvas(
                    document.getElementById('petCanvas')
                );

                panel.show();

            }, 400);
        }
    });

    $('#petCanvas').on('hidden.bs.offcanvas', function() {

        if (reopenScheduleModal === true) {

            let modal = new bootstrap.Modal(
                document.getElementById('schedule_appointment_Modal')
            );

            modal.show();
        }

    });

    $('#petCanvas').on('shown.bs.offcanvas', function() {

        if ($('#client_id').hasClass('select2-hidden-accessible')) {
            $('#client_id').select2('destroy');
        }

        $('#client_id').select2({
            placeholder: 'Buscar dueño de la mascota',
            dropdownParent: $('#petCanvas'),
            width: '100%',
            tags: true,
            ajax: {
                url: '{{ route('pet.clients') }}',
                dataType: 'json',
                delay: 250,
                data: params => ({
                    search: params.term || ''
                }),
                processResults: data => ({
                    results: data.map(client => ({
                        id: client.id,
                        text: client.name
                    }))
                })
            }
        });


        if ($('#breed_id').hasClass('select2-hidden-accessible')) {
            $('#breed_id').select2('destroy');
        }

        $('#breed_id').select2({
            placeholder: 'Selecciona una raza',
            dropdownParent: $('#petCanvas'),
            width: '100%',
            ajax: {
                url: '{{ route('pet.breeds') }}',
                dataType: 'json',
                delay: 250,
                data: params => ({
                    search: params.term || ''
                }),
                processResults: data => ({
                    results: data.map(breed => ({
                        id: breed.id,
                        text: breed.name
                    }))
                })
            }
        });

    });

    $('#schedule_appointment_Modal').on('hidden.bs.modal', function() {

        let select = $('#pet_name');

        $('.select2-container').remove();

        // limpiar todos los backdrops
        $('.modal-backdrop').remove();

        // restaurar body
        $('body').removeClass('modal-open');
        $('body').css({
            overflow: 'auto',
            paddingRight: '0'
        });

        // limpiar clases extras bootstrap
        $('body').attr('style', '');

        // destruir instancia
        let modal = bootstrap.Modal.getInstance(this);
        if (modal) {
            modal.dispose();
        }
    });

    $('#pet_name').on('select2:select', function(e) {
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

    $('#pet_name').on('select2:clear', function() {
        $('#pet_photo').hide();
        $('#pet_info').hide();
    });

    $('#pet_name').on('change', function() {

        if (!$(this).hasClass('select2-hidden-accessible')) {
            return;
        }

        let selected = $(this).select2('data')[0];

        if (selected && selected.photo) {
            $('#pet_photo').attr('src', selected.photo).show();
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
            url: '{{ route('pet.store') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.new_client) {

                    let phone = response.phone;
                    let code = response.access_code;

                    let mensaje =
                        `Hola 👋 Bienvenido a Arte Canino 🐶✨ Puedes navegar en nuestra plataforma haciendo click aquí: https://takes-editors-walt-butter.trycloudflare.com/appointments/client/${code}`;
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

                    let select = $('#pet_name');

                    if (select.hasClass('select2-hidden-accessible')) {

                        // crear nueva opción seleccionada
                        let newOption = new Option(
                            response.name, // texto visible
                            response.id, // value = id mascota
                            true, // selected por defecto
                            true // marcar seleccionada
                        );

                        // agregar al select
                        select.append(newOption).trigger('change');

                        // disparar evento para mostrar foto/info
                        select.trigger({
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
                    }

                    let canvas = document.getElementById('petCanvas');
                    let offcanvas = bootstrap.Offcanvas.getInstance(canvas);

                    if (offcanvas) {
                        offcanvas.hide();
                    }

                    setTimeout(() => {

                        let modal = new bootstrap.Modal(
                            document.getElementById('schedule_appointment_Modal')
                        );

                        modal.show();

                    }, 500);
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
                        input.after('<small class="text-danger error-text">' + errors[field][0] +
                            '</small>');
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

    $('#pet_name').on('change', function() {
        let photo = $(this).find(':selected').data('photo');

        if (photo) {
            $('#pet_photo')
                .attr('src', photo)
                .show();
        } else {
            $('#pet_photo').hide();
        }
    });

    $(document).on('hidden.bs.modal', '.modal', function() {

        if ($('.modal.show').length === 0) {
            $('.modal-backdrop').remove();

            $('body').removeClass('modal-open');
            $('body').css({
                overflow: 'auto',
                paddingRight: '0'
            });

            $('body').attr('style', '');
        }

    });

    function cargarCitasCliente(code, calendar) {

        if (!code) return;

        calendar.getEventSources().forEach(source => source.remove());

        calendar.addEventSource({
            url: '{{ route('appointment.fullDays') }}',
            method: 'GET'
        });

        calendar.addEventSource({
            url: '/appointments/client-events/' + code,
            method: 'GET',
            failure: function() {
                Swal.fire('Código inválido o sin citas');
            }
        });

        if (typeof OneSignalDeferred !== 'undefined') {

            OneSignalDeferred.push(async function(OneSignal) {

                try {

                    await OneSignal.Notifications.requestPermission();

                    if (Notification.permission === 'granted') {

                        await OneSignal.logout();
                        await OneSignal.login(code);

                    }

                } catch (error) {
                    console.error(error);
                }

            });
        }
    }

    function scheduleModal(info) {
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

    function scheduleAppointment(info) {

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
        let modal = new bootstrap.Modal(el, {
            backdrop: true,
            keyboard: true
        });

        modal.show();

        $('#schedule_appointment_id').val(info.dateStr);

        let date = new Date(info.dateStr + 'T00:00:00');

        let formatedDate = date.toLocaleDateString('es-CO', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
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

@if (session('success'))
    <script>
        Swal.fire({
            title: "{{ session('success') }}",
            icon: "success",
            draggable: true,
            timer: 1500
        });

        let status = "{{ session('status') }}";
        let gender = "{{ session('gender') }}"
        let estadoTexto = '';

        if (gender === 'Hembra') {
            estadoTexto = 'lista';
        } else {
            estadoTexto = 'listo';
        }

        if (status === 'Completada') {

            let pet = @json(session('pet'));
            let phone = @json(session('phone'));

            let mensaje = "Hola 👋 Te informamos que " + pet + " ya está " + estadoTexto +
                " 🐶✨. Gracias por confiar en nosotros ☺️";

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
