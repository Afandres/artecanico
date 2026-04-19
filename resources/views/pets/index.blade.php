<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mascotas
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table id="pets" class="display nowrap"> 
                    <thead>
                        <tr>
                            <th>Dueño</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Raza</th>
                            <th>Edad</th>
                            <th>Sexo</th>
                            <th>Condiciones médicas</th>
                            <th>Observaciones</th>
                            <th>
                                <button type="button"
                                    class="btn btn-success"
                                    onclick="fromAppointments = false"
                                    data-bs-toggle="modal"
                                    data-bs-target="#createPetModal">

                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($pets as $pet)
                    <tr>
                        <td>{{ $pet->client->name }}</td>
                        <td>
                            <img src="{{ $pet->profile_photo 
                                ? asset('storage/' . $pet->profile_photo) 
                                : asset('storage/pets/images.png') }}"
                                width="70" height="70"
                                style="object-fit:cover;border-radius:8px;">
                        </td>
                        <td>{{ $pet->name }} - {{ $pet->sobriquet }}</td>
                        <td>{{ $pet->breed->name }}</td>
                        <td>{{ $pet->age_nullable }}</td>
                        <td>{{ $pet->gender }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($pet->medical_condition_nullable, 15, '...' )}}</td>
                        <td> {{ \Illuminate\Support\Str::limit($pet->observations_nullable, 15, '...') }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pets.pet_modal')
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // =====================================
    // ABRIR MODAL
    // =====================================
    $('#createPetModal').on('shown.bs.modal', function () {

        // ===============================
        // SELECT RAZA
        // ===============================
        if (!$('#breed_id').hasClass("select2-hidden-accessible")) {

            $('#breed_id').select2({
                placeholder: 'Selecciona una raza',
                dropdownParent: $('#createPetModal'),
                width: '100%',
                ajax: {
                    url: '{{ route("pet.breeds") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params){
                        return {
                            search: params.term || ''
                        };
                    },
                    processResults: function(data){
                        return {
                            results: data.map(item => ({
                                id: item.id,
                                text: item.name
                            }))
                        };
                    }
                }
            });
        }

        // ===============================
        // SELECT DUEÑO
        // ===============================
        if (!$('#client_id').hasClass("select2-hidden-accessible")) {

            $('#client_id').select2({
                placeholder: 'Buscar dueño',
                dropdownParent: $('#createPetModal'),
                width: '100%',
                tags: true,

                createTag: function (params) {

                    let term = $.trim(params.term);

                    if (term === '') return null;

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                },

                ajax: {
                    url: '{{ route("pet.clients") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params){
                        return {
                            search: params.term || ''
                        };
                    },
                    processResults: function(data){
                        return {
                            results: data.map(item => ({
                                id: item.id,
                                text: item.name
                            }))
                        };
                    }
                }
            });
        }

    });


    // =====================================
    // MOSTRAR CELULAR SI ES CLIENTE NUEVO
    // =====================================
    $(document).on('select2:select', '#client_id', function (e) {

        let data = e.params.data;

        if (data.newTag || isNaN(data.id)) {

            $('#phone_container').fadeIn();

        } else {

            $('#phone_container').fadeOut();
            $('#emergency_phone').val('');
        }
    });


    // =====================================
    // SI ESCRIBEN Y CIERRAN SELECT2
    // =====================================
    $(document).on('select2:close', '#client_id', function () {

        let data = $(this).select2('data');

        if (!data.length) return;

        let selected = data[0];

        if (selected.newTag || isNaN(selected.id)) {
            $('#phone_container').fadeIn();
        }
    });


    // =====================================
    // GUARDAR MASCOTA
    // =====================================
    $('#createPetForm').on('submit', function(e){

        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({

            url: '{{ route("pet.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(response){

                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                // ===============================
                // SI CREÓ CLIENTE NUEVO
                // ===============================
                if(response.new_client){

                    let phone = response.phone;
                    let code  = response.access_code;

                    let mensaje =
                    `Hola 👋 Bienvenido a Arte Canino 🐶✨ Tu código para consultar tus citas es: ${code} Ingresa aquí: https://pin-collapse-journal-softball.trycloudflare.com/appointments`;

                    let url = `https://wa.me/57${phone}?text=${encodeURIComponent(mensaje)}`;

                    window.open(url, '_blank');
                }

                setTimeout(() => {
                    location.reload();
                }, 1200);

            },

            error: function(xhr){

                $('.error-text').remove();

                if(xhr.status === 422){

                    let errors = xhr.responseJSON.errors;

                    for(let field in errors){

                        $('[name="'+field+'"]').after(
                            '<small class="text-danger error-text">'+errors[field][0]+'</small>'
                        );
                    }

                }else{

                    Swal.fire({
                        icon:'error',
                        title:'Error al guardar'
                    });
                }
            }
        });

    });


    // =====================================
    // LIMPIAR MODAL AL CERRAR
    // =====================================
    $('#createPetModal').on('hidden.bs.modal', function () {

        $('#createPetForm')[0].reset();

        $('#client_id').val(null).trigger('change');
        $('#breed_id').val(null).trigger('change');

        $('#phone_container').hide();

        $('.error-text').remove();
    });

});
</script>