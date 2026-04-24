<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (auth()->check())
                Historial de Servicios
            @else
                Historial de mis mascotas
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Selector de mascota -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-4">
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Seleccionar mascota</label>
                            <select id="pet_selector" class="form-control select2">
                                <option value="">-- Seleccione una mascota --</option>
                                @foreach ($pets as $pet)
                                    <option value="{{ $pet->id }}">
                                        {{ $pet->name }}  
                                        @auth
                                            {{ $pet->sobriquet ? '- ' . $pet->sobriquet : '' }}
                                       
                                            (Dueño: {{ $pet->client->name }})
                                        @endauth
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button id="btnSearch" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass"></i> Ver historial
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenedor del historial -->
            <div id="historyContainer" style="display: none;">
                <!-- Info de la mascota -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-4">
                    <div class="p-4">
                        <div class="d-flex align-items-center gap-4">
                            <img id="pet_profile_photo" src=""
                                style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                            <div>
                                <h3 id="pet_name_display" class="mb-0"></h3>
                                <p class="text-muted mb-0">
                                    <span id="pet_breed_display"></span> |
                                    <span id="pet_age_display"></span> |
                                    <span id="pet_gender_display"></span>
                                </p>
                                @auth
                                <p class="mb-0">
                                    <i class="fa-solid fa-user"></i> Dueño: <span id="client_name_display"></span> |
                                    <i class="fa-brands fa-whatsapp"></i> <span id="client_phone_display"></span>
                                </p>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Listado de citas -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4">
                        <h4 class="mb-3">Historial de Citas</h4>
                        <div id="appointmentsList">
                            <!-- Se llena con JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    let currentPetId = null;

    $(document).ready(function() {
        $('#pet_selector').select2({
            placeholder: 'Buscar mascota...',
            width: '100%'
        });

        $('#btnSearch').on('click', function() {
            currentPetId = $('#pet_selector').val();

            if (!currentPetId) {
                Swal.fire('Error', 'Selecciona una mascota', 'warning');
                return;
            }

            reloadFullHistory();
        });

        function reloadFullHistory() {
            if (!currentPetId) return;

            $('#appointmentsList').html(
                '<div class="text-center"><i class="fa-solid fa-spinner fa-spin"></i> Cargando...</div>');

            loadPetInfo(currentPetId);
            loadPetHistory(currentPetId);
        }

        function loadPetInfo(petId) {
            $.ajax({
                url: `/api/pets/${petId}/info`,
                method: 'GET',
                success: function(data) {
                    $('#pet_profile_photo').attr('src', data.photo || '/storage/pets/images.png');
                    $('#pet_name_display').text(data.name);
                    $('#pet_breed_display').text(data.breed);
                    $('#pet_age_display').text(data.age ? data.age + ' años' :
                        'Edad no registrada');
                    $('#pet_gender_display').text(data.gender);
                    $('#client_name_display').text(data.client_name);
                    $('#client_phone_display').text(data.client_phone);
                    $('#historyContainer').show();
                },
                error: function() {
                    Swal.fire('Error', 'No se pudo cargar la información de la mascota', 'error');
                }
            });
        }

        function loadPetHistory(petId) {
            $.ajax({
                url: `/history/pet/${petId}`,
                method: 'GET',
                success: function(data) {
                    renderAppointments(data.appointments);
                },
                error: function() {
                    $('#appointmentsList').html(
                        '<div class="alert alert-danger">Error al cargar el historial</div>');
                }
            });
        }

        window.renderAppointments = function(appointments) {
            const container = $('#appointmentsList');
            container.empty();

            if (appointments.length === 0) {
                container.html(
                    '<div class="alert alert-info">No hay citas registradas para esta mascota</div>');
                return;
            }

            appointments.forEach(app => {
                const statusClass = {
                    'Pendiente': 'warning',
                    'En proceso': 'primary',
                    'Completada': 'success',
                    'Cancelada': 'danger'
                } [app.status] || 'secondary';

                const hasCheckin = app.checkin_time;
                const hasCheckout = app.checkout_time;
                let isAuth = {{ auth()->check() ? 'true' : 'false' }};
                const isCanceled = app.status === 'Cancelada';

                const card = `
            <div class="card mb-3 appointment-card" data-appointment-id="${app.id}">
                <div class="card-header bg-${statusClass} text-white d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fa-regular fa-calendar"></i> ${app.date} - ${app.time}
                    </span>
                    <span class="badge bg-light text-dark">
                        ${app.status}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Precio:</strong> ${app.price ? '$' + app.price : 'Pendiente'}
                        </div>
                        <div class="col-md-8">
                            <strong>Tratamientos:</strong><br>
                            ${app.treatments.map(t => `<span class="badge bg-info me-1">${t.name}</span>`).join('') || 'Ninguno'}
                        </div>
                    </div>
                    ${app.observations ? `<div class="mt-2"><strong>Observaciones generales:</strong><br><small>${app.observations}</small></div>` : ''}
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-sm btn-info" onclick="viewAppointmentDetail(${app.id})">
                        <i class="fa-regular fa-eye"></i> Ver detalle
                    </button>
                    ${isAuth && !hasCheckin && app.status !== 'Cancelada' && app.status !== 'Completada' ? 
                        `<button class="btn btn-sm btn-warning" onclick="openCheckinModal(${app.id})">
                            <i class="fa-solid fa-sign-in-alt"></i> Registrar llegada
                        </button>` : ''}
                    ${isAuth && hasCheckin && !hasCheckout && app.status !== 'Cancelada' ? 
                        `<button class="btn btn-sm btn-primary" onclick="openProcessModal(${app.id})">
                            <i class="fa-solid fa-camera"></i> Novedades del proceso
                        </button>` : ''}
                    ${isAuth && hasCheckin && !hasCheckout && app.status !== 'Cancelada' ? 
                        `<button class="btn btn-sm btn-success" onclick="openCheckoutModal(${app.id})">
                            <i class="fa-solid fa-right-from-bracket"></i> Completar servicio
                        </button>` : ''}
                    ${!isCanceled && app.status !== 'Completada' ? 
                        `<button class="btn btn-sm btn-danger" onclick="cancelAppointment(${app.id})">
                            <i class="fa-solid fa-ban"></i> Cancelar cita
                        </button>` : ''}
                </div>
            </div>
        `;
                container.append(card);
            });
        };
    });

    function cancelAppointment(appointmentId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción cancelará la cita. No podrás revertirla.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Cancelando...',
                    text: 'Por favor espere',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '{{ route('appointment.cancel.appointment') }}',
                    type: 'POST',
                    data: {
                        appointment_id: appointmentId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Cancelada', response.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        let errorMsg = 'No se pudo cancelar la cita';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', errorMsg, 'error');
                    }
                });
            }
        });
    }

    // Funciones globales para los modales
    function viewAppointmentDetail(appointmentId) {
        $.ajax({
            url: `/history/appointment/${appointmentId}`,
            method: 'GET',
            success: function(data) {
                mostrarDetalleCita(data);
            }
        });
    }

    function openCheckinModal(appointmentId) {
        Swal.fire({
            title: 'Registrar llegada',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label">Foto de cómo llegó</label>
                        <input type="file" id="checkin_photo" class="form-control" accept="image/*" capture="environment">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones de llegada</label>
                        <textarea id="checkin_obs" class="form-control" rows="3" 
                            placeholder="¿Cómo llegó la mascota? Estado de salud, comportamiento, etc."></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Registrar llegada',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const photoFile = document.getElementById('checkin_photo').files[0];
                const observations = document.getElementById('checkin_obs').value;

                const formData = new FormData();
                formData.append('appointment_id', appointmentId);
                formData.append('checkin_observations', observations);
                if (photoFile) formData.append('checkin_photo', photoFile);

                return $.ajax({
                        url: '{{ route('history.checkin') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }).then(response => response)
                    .catch(error => {
                        Swal.showValidationMessage(error.responseJSON?.message ||
                            'Error al registrar llegada');
                    });
            }
        }).then((result) => {
            if (result.isConfirmed && result.value?.success) {
                Swal.fire('Éxito', result.value.message, 'success');
                if (currentPetId) {
                    $('#appointmentsList').html(
                        '<div class="text-center"><i class="fa-solid fa-spinner fa-spin"></i> Actualizando...</div>'
                    );
                    loadPetInfo(currentPetId);
                    loadPetHistory(currentPetId);
                }
            }
        });
    }

    function openProcessModal(appointmentId) {

        // 1. Consultar detalle de la cita para validar si ya existe proceso
        $.ajax({
            url: `/history/appointment/${appointmentId}`,
            method: 'GET',
            success: function(data) {

                const yaExisteProceso =
                    data.process?.photo ||
                    data.process?.observations;

                // Si ya existe proceso mostrar advertencia
                if (yaExisteProceso) {

                    Swal.fire({
                        title: 'Ya existe registro del proceso',
                        text: 'Si continúas, la foto y observación anterior serán reemplazadas.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, reemplazar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#10b981'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            abrirFormularioProceso(appointmentId);
                        }
                    });

                } else {
                    abrirFormularioProceso(appointmentId);
                }

            },
            error: function() {
                Swal.fire('Error', 'No se pudo validar la información de la cita', 'error');
            }
        });
    }


    // FORMULARIO REAL
    function abrirFormularioProceso(appointmentId) {

        Swal.fire({
            title: 'Novedades durante el proceso',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label">Foto del proceso</label>
                        <input type="file" id="process_photo" class="form-control" accept="image/*" capture="environment">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Observaciones del proceso</label>
                        <textarea id="process_obs" class="form-control" rows="3"
                            placeholder="¿Cómo va el proceso? Alguna novedad, etc."></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Guardar proceso',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#10b981',

            preConfirm: () => {

                const photoFile = document.getElementById('process_photo').files[0];
                const observations = document.getElementById('process_obs').value;

                const formData = new FormData();
                formData.append('appointment_id', appointmentId);
                formData.append('process_observations', observations);

                if (photoFile) {
                    formData.append('process_photo', photoFile);
                }

                return $.ajax({
                    url: '{{ route("history.process") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

                }).then(response => response)
                .catch(error => {
                    Swal.showValidationMessage(
                        error.responseJSON?.message ||
                        'Error al guardar el proceso'
                    );
                });
            }

        }).then((result) => {

            if (result.isConfirmed && result.value?.success) {

                Swal.fire('Éxito', result.value.message, 'success');

                if (currentPetId) {
                    loadPetHistory(currentPetId);
                }
            }
        });
    }

    function openCheckoutModal(appointmentId) {

        $.ajax({
            url: '/treatments/list',
            method: 'GET',

            success: function(treatments) {

                let treatmentsHtml = '<div class="mb-3">';
                treatmentsHtml += '<label class="form-label">Tratamiento aplicado</label>';
                treatmentsHtml += '<select id="treatment_id" class="form-control">';
                treatmentsHtml += '<option value=""></option>';

                treatments.forEach(t => {
                    treatmentsHtml += `<option value="${t.id}">${t.name}</option>`;
                });

                treatmentsHtml += '</select></div>';

                Swal.fire({
                    title: 'Completar servicio',
                    html: `
                        <div class="text-start">

                            ${treatmentsHtml}

                            <div class="mb-3">
                                <label class="form-label">Precio final</label>
                                <input type="number" id="price" class="form-control" step="0.01">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto de salida</label>
                                <input type="file" id="checkout_photo" class="form-control" accept="image/*" capture="environment">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Observaciones finales</label>
                                <textarea id="checkout_obs" class="form-control" rows="3"
                                    placeholder="Resultado del servicio, recomendaciones, etc."></textarea>
                            </div>

                        </div>
                    `,
                    width: '600px',
                    showCancelButton: true,
                    confirmButtonText: 'Completar servicio',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#10b981',

                    didOpen: () => {

                        $('#treatment_id').select2({
                            dropdownParent: $('.swal2-container'),
                            width: '100%',
                            placeholder: 'Selecciona el tratamiento'
                        });

                        $('#price').on('input', function () {

                            let valor = $(this).val().replace(/\D/g, ''); // solo números

                            if (valor === '') {
                                $(this).val('');
                                return;
                            }

                            $(this).val(
                                parseInt(valor).toLocaleString('es-CO')
                            );
                        });

                        setTimeout(() => {
                            $('#price').focus();
                        }, 100);
                    },

                    preConfirm: () => {

                        const treatmentId = $('#treatment_id').val();
                        const price = $('#price').val().replace(/\./g, '');
                        const observations = $('#checkout_obs').val();
                        const photoFile = $('#checkout_photo')[0].files[0];

                        if (!treatmentId) {
                            Swal.showValidationMessage('Selecciona un tratamiento');
                            return false;
                        }

                        if (!price) {
                            Swal.showValidationMessage('Ingresa el precio final');
                            return false;
                        }

                        const formData = new FormData();
                        formData.append('appointment_id', appointmentId);
                        formData.append('treatment_id', treatmentId);
                        formData.append('price', price);
                        formData.append('checkout_observations', observations);

                        if (photoFile) {
                            formData.append('checkout_photo', photoFile);
                        }

                        return $.ajax({
                            url: '{{ route("history.checkout") }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }

                        }).then(response => response)
                        .catch(error => {
                            Swal.showValidationMessage(
                                error.responseJSON?.message ||
                                'Error al completar servicio'
                            );
                        });
                    }

                }).then((result) => {

                    if (result.isConfirmed && result.value?.success) {

                        Swal.fire('Éxito', result.value.message, 'success');

                        if (currentPetId) {
                            $('#appointmentsList').html(
                                '<div class="text-center"><i class="fa-solid fa-spinner fa-spin"></i> Actualizando...</div>'
                            );

                            loadPetInfo(currentPetId);
                            loadPetHistory(currentPetId);
                        }
                    }

                });

            }
        });
    }

    function mostrarDetalleCita(data) {
        let treatmentsHtml = '';
        data.treatments.forEach(t => {
            treatmentsHtml += `<span class="badge bg-info me-1">${t.name}</span>`;
        });

        // Formatear el precio
        const precioFormateado = data.price ? `$${parseFloat(data.price).toLocaleString()}` : 'Pendiente';

        Swal.fire({
            title: `<div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-calendar-check" style="color: #4f46e5;"></i>
                    <span>Cita de ${data.pet_name}</span>
                </div>`,
            html: `
            <div class="text-start" style="max-height: 500px; overflow-y: auto; padding: 5px;">
                <!-- Información general -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6 d-flex">
                        <div class="d-flex align-items-center gap-2 p-2 bg-light rounded w-100 h-100">
                            <i class="fa-solid fa-calendar-day text-primary"></i>
                            <div>
                                <small class="text-muted">Fecha</small>
                                <div class="fw-semibold">${data.appointment_date}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="d-flex align-items-center gap-2 p-2 bg-light rounded w-100 h-100">
                            <i class="fa-solid fa-user text-primary"></i>
                            <div>
                                <small class="text-muted">Cliente</small>
                                <div class="fw-semibold">${data.client_name}</div>
                                <small class="text-muted">${data.client_phone}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estado de la cita -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong><i class="fa-solid fa-hourglass-half text-primary me-1"></i> Estado de la cita</strong>
                        <span class="badge ${data.status === 'Completada' ? 'bg-success' : data.status === 'En proceso' ? 'bg-primary' : data.status === 'Pendiente' ? 'bg-warning text-dark' : 'bg-danger'}">
                            ${data.status}
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar ${data.status === 'Completada' ? 'bg-success' : data.status === 'En proceso' ? 'bg-primary progress-bar-striped progress-bar-animated' : 'bg-warning'}" 
                             style="width: ${data.status === 'Completada' ? '100%' : data.status === 'En proceso' ? '66%' : '33%'}"></div>
                    </div>
                </div>

                <!-- Llegada -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-header bg-warning bg-opacity-10 border-0">
                        <i class="fa-solid fa-paw text-warning"></i>
                        <strong class="ms-2">Llegada de la mascota</strong>
                    </div>
                    <div class="card-body">
                        ${data.checkin.time ? `
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Hora de llegada</small>
                                    <div class="fw-semibold"><i class="fa-regular fa-clock me-1"></i> ${data.checkin.time}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Observaciones</small>
                                    <div class="small">${data.checkin.observations || 'Ninguna'}</div>
                                </div>
                                ${data.checkin.photo ? `
                                <div class="col-12 mt-2">
                                    <small class="text-muted">Foto de llegada</small>
                                    <div class="mt-1">
                                        <img src="${data.checkin.photo}" style="max-width: 100%; max-height: 200px; border-radius: 10px; cursor: pointer;" onclick="window.open(this.src)" class="img-fluid">
                                    </div>
                                </div>
                                ` : ''}
                            </div>
                        ` : '<div class="alert alert-warning mb-0 py-2"><i class="fa-solid fa-triangle-exclamation"></i> No se ha registrado la llegada</div>'}
                    </div>
                </div>

                <!-- Durante el proceso -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-header bg-primary bg-opacity-10 border-0">
                        <i class="fa-solid fa-scissors text-primary"></i>
                        <strong class="ms-2">Durante el proceso</strong>
                    </div>
                    <div class="card-body">
                        ${data.process.photo ? `
                            <div class="row">
                                <div class="col-md-12">
                                    <small class="text-muted">Observaciones</small>
                                    <div class="small">${data.process.observations || 'Ninguna'}</div>
                                </div>
                                <div class="col-12 mt-2">
                                    <small class="text-muted">Foto del proceso</small>
                                    <div class="mt-1">
                                        <img src="${data.process.photo}" style="max-width: 100%; max-height: 200px; border-radius: 10px; cursor: pointer;" onclick="window.open(this.src)" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        ` : '<div class="alert alert-info mb-0 py-2"><i class="fa-solid fa-info-circle"></i> No hay foto del proceso registrada</div>'}
                    </div>
                </div>

                <!-- Salida y resultados -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-header bg-success bg-opacity-10 border-0">
                        <i class="fa-solid fa-circle-check text-success"></i>
                        <strong class="ms-2">Salida y resultados</strong>
                    </div>
                    <div class="card-body">
                        ${data.checkout.time ? `
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Hora de salida</small>
                                    <div class="fw-semibold"><i class="fa-regular fa-clock me-1"></i> ${data.checkout.time}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Precio final</small>
                                    <div class="fw-semibold text-success">${precioFormateado}</div>
                                </div>
                                <div class="col-12 mt-2">
                                    <small class="text-muted">Tratamientos aplicados</small>
                                    <div class="mt-1">${treatmentsHtml || '<span class="text-muted">Ninguno</span>'}</div>
                                </div>
                                <div class="col-12 mt-2">
                                    <small class="text-muted">Observaciones finales</small>
                                    <div class="small">${data.checkout.observations || 'Ninguna'}</div>
                                </div>
                                ${data.checkout.photo ? `
                                <div class="col-12 mt-2">
                                    <small class="text-muted">Foto de salida</small>
                                    <div class="mt-1">
                                        <img src="${data.checkout.photo}" style="max-width: 100%; max-height: 200px; border-radius: 10px; cursor: pointer;" onclick="window.open(this.src)" class="img-fluid">
                                    </div>
                                </div>
                                ` : ''}
                            </div>
                        ` : '<div class="alert alert-warning mb-0 py-2"><i class="fa-solid fa-triangle-exclamation"></i> Servicio pendiente por completar</div>'}
                    </div>
                </div>
            </div>
        `,
            width: '750px',
            confirmButtonText: 'Cerrar',
            showCloseButton: true,
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-4',
                title: 'fs-4 fw-bold',
                confirmButton: 'btn btn-secondary px-4 py-2'
            }
        });
    }
    window.loadPetInfo = function(petId) {
        $.ajax({
            url: `/api/pets/${petId}/info`,
            method: 'GET',
            success: function(data) {
                $('#pet_profile_photo').attr('src', data.photo || '/storage/pets/images.png');
                $('#pet_name_display').text(data.name);
                $('#pet_breed_display').text(data.breed);
                $('#pet_age_display').text(data.age ? data.age + ' años' : 'Edad no registrada');
                $('#pet_gender_display').text(data.gender);
                $('#client_name_display').text(data.client_name);
                $('#client_phone_display').text(data.client_phone);
                $('#historyContainer').show();
            }
        });
    };

    window.loadPetHistory = function(petId) {
        $.ajax({
            url: `/history/pet/${petId}`,
            method: 'GET',
            success: function(data) {
                renderAppointments(data.appointments);
            }
        });
    };
    $(document).ready(function () {

        const urlParams = new URLSearchParams(window.location.search);
        const petId = urlParams.get('pet_id');

        if (petId) {

            $('#pet_selector').val(petId).trigger('change');

            currentPetId = petId;

            loadPetInfo(petId);
            loadPetHistory(petId);
        }

    });
</script>
