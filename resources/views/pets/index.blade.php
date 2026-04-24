<style>
.modal label.form-label{
    display:block !important;
    width:100%;
    margin-bottom:.5rem;
}

.modal .select2-container{
    display:block !important;
    width:100% !important;
}

.modal .select2-selection{
    height:38px !important;
    padding:4px;
}

.modal .select2-selection__rendered{
    line-height:28px !important;
}

.modal .select2-selection__arrow{
    height:38px !important;
}

/* Tabla principal */
#img_table{
    width:80px !important;
    height:80px !important;
    object-fit:cover !important;
    border-radius:10px;
    display:block;
}

.previewImg{
    width:120px !important;
    height:120px !important;
    object-fit:cover !important;
    border-radius:12px;
    border:1px solid #ddd;
    display:block;
    margin:auto;
}

</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (auth()->check())
                Mascotas
            @else
                Mis mascotas
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table id="pets" class="display nowrap" data-auth="{{ auth()->check() ? 1 : 0 }}"> 
                    <thead>
                        <tr>
                            @auth
                            <th>Dueño</th>
                                
                            @endauth
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Raza</th>
                            <th>Edad</th>
                            <th>Sexo</th>
                            <th>Condiciones médicas</th>
                            <th>Observaciones</th>
                            <th>
                                    @auth                                
                                    <button type="button"
                                        class="btn btn-success"
                                        onclick="fromAppointments = false"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#petCanvas">

                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    @else
                                        Acciones
                                    @endauth
                                </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($pets as $pet)
                    <tr>
                        @auth
                        <td class="align-middle">

                            <div class="d-flex justify-content-between align-items-center gap-2">

                                <div>
                                    {{ $pet->client->name }} - {{ $pet->client->emergency_phone }}
                                </div>

                                <div class="d-flex gap-1">

                                    <button type="button"
                                        class="btn btn-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#clientUpdateModal{{ $pet->client->id }}">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>

                                    <button type="button"
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#clientDeleteModal{{ $pet->client->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </div>

                                @include('pets.update_client')
                                @include('pets.delete_client')
                            </div>
                        </td>
                        @endauth
                        <td>
                            <img id="img_table" src="{{ $pet->profile_photo 
                                ? asset('storage/' . $pet->profile_photo) 
                                : asset('storage/pets/images.png') }}"
                                width="70" height="70"
                                style="object-fit:cover;border-radius:8px;">
                        </td>
                        <td>{{ $pet->name }} @auth- {{ $pet->sobriquet }}@endauth</td>
                        <td>{{ $pet->breed->name }}</td>
                        <td>{{ is_numeric($pet->age_nullable) ? $pet->age_nullable . ' ' . ($pet->age_nullable == 1 ? 'año' : 'años') : 'No registra' }}</td>
                        <td>{{ $pet->gender }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($pet->medical_condition_nullable, 15, '...' )}}</td>
                        <td> {{ \Illuminate\Support\Str::limit($pet->observations_nullable, 15, '...') }}</td>
                        <td>
                            @auth    
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#petUpdateModal{{ $pet->id }}">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                            @include('pets.update')
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#petDeleteModal{{ $pet->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            @include('pets.delete')
                            @endauth
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#petShowModal{{ $pet->id }}">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            @include('pets.details')
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pets.create')
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // =====================================
    // ABRIR MODAL
    // =====================================
    $('#petCanvas').on('shown.bs.offcanvas', function () {

        // ===============================
        // SELECT RAZA
        // ===============================
        if (!$('#breed_id').hasClass("select2-hidden-accessible")) {

            $('#breed_id').select2({
                placeholder: 'Selecciona una raza',
                dropdownParent: $('#petCanvas'),
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
                dropdownParent: $('#petCanvas'),
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
    $('#petCanvas').on('hidden.bs.modal', function () {

        $('#createPetForm')[0].reset();

        $('#client_id').val(null).trigger('change');
        $('#breed_id').val(null).trigger('change');

        $('#phone_container').hide();

        $('.error-text').remove();
    });

    $('.modal').on('shown.bs.modal', function () {

        let modal = $(this);
        let select = modal.find('.breed-select');

        if (!select.hasClass('select2-hidden-accessible')) {
            select.select2({
                dropdownParent: modal,
                width: '100%'
            });
        }

    });

    
    $(document).on('change', '.profile-photo-input', function (e) {

        let file = e.target.files[0];
        let reader = new FileReader();

        if (!file) return;

        reader.onload = function (event) {

            // busca la imagen dentro del mismo modal
            $(e.target)
                .closest('.modal')
                .find('.previewImg')
                .attr('src', event.target.result);
        };

        reader.readAsDataURL(file);
    });
});
</script>

@if(session('success'))
    <script>
        Swal.fire({
            title: "{{ session('success') }}",
            icon: "success",
            draggable: true,
            timer: 1500
        });
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