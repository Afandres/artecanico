<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historial de Servicios
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
                                        {{ $pet->name }} {{ $pet->sobriquet ? '- ' . $pet->sobriquet : '' }}
                                        (Dueño: {{ $pet->client->name }})
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
                                <p class="mb-0">
                                    <i class="fa-solid fa-user"></i> Dueño: <span id="client_name_display"></span> |
                                    <i class="fa-solid fa-phone"></i> <span id="client_phone_display"></span>
                                </p>
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
                            ${!hasCheckin && app.status !== 'Cancelada' && app.status !== 'Completada' ? 
                                `<button class="btn btn-sm btn-warning" onclick="openCheckinModal(${app.id})">
                                    <i class="fa-solid fa-sign-in-alt"></i> Registrar llegada
                                </button>` : ''}
                            ${hasCheckin && !hasCheckout && app.status !== 'Cancelada' ? 
                                `<button class="btn btn-sm btn-primary" onclick="openProcessModal(${app.id})">
                                    <i class="fa-solid fa-camera"></i> Foto proceso
                                </button>` : ''}
                            ${hasCheckin && !hasCheckout && app.status !== 'Cancelada' ? 
                                `<button class="btn btn-sm btn-success" onclick="openCheckoutModal(${app.id})">
                                    <i class="fa-solid fa-sign-out-alt"></i> Completar servicio
                                </button>` : ''}
                        </div>
                    </div>
                `;
                container.append(card);
            });
        };
    });

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
                            placeholder="¿Cómo llegó el perro? Estado de salud, comportamiento, etc."></textarea>
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
        Swal.fire({
            title: 'Foto durante el proceso',
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
            confirmButtonText: 'Registrar foto',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const photoFile = document.getElementById('process_photo').files[0];
                const observations = document.getElementById('process_obs').value;

                const formData = new FormData();
                formData.append('appointment_id', appointmentId);
                formData.append('process_observations', observations);
                if (photoFile) formData.append('process_photo', photoFile);

                return $.ajax({
                        url: '{{ route('history.process') }}',
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
                            'Error al registrar foto');
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
                treatmentsHtml += '<label class="form-label">Tratamientos aplicados</label>';
                treatmentsHtml +=
                    '<select id="treatment_ids" class="form-control select2-treatments" multiple>';
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
                                <input type="number" id="price" class="form-control" step="0.01" required>
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
                    showCancelButton: true,
                    confirmButtonText: 'Completar servicio',
                    cancelButtonText: 'Cancelar',
                    didOpen: () => {
                        $('.select2-treatments').select2({
                            dropdownParent: $('.swal2-container'),
                            width: '100%',
                            placeholder: 'Selecciona los tratamientos aplicados'
                        });
                    },
                    preConfirm: () => {
                        const treatmentIds = $('#treatment_ids').val();
                        const price = document.getElementById('price').value;
                        const observations = document.getElementById('checkout_obs').value;
                        const photoFile = document.getElementById('checkout_photo').files[0];

                        if (!treatmentIds || treatmentIds.length === 0) {
                            Swal.showValidationMessage('Selecciona al menos un tratamiento');
                            return false;
                        }

                        if (!price) {
                            Swal.showValidationMessage('Ingresa el precio final');
                            return false;
                        }

                        const formData = new FormData();
                        formData.append('appointment_id', appointmentId);

                        treatmentIds.forEach(id => {
                            formData.append('treatment_ids[]', id);
                        });

                        formData.append('price', price);
                        formData.append('checkout_observations', observations);
                        if (photoFile) formData.append('checkout_photo', photoFile);

                        return $.ajax({
                                url: '{{ route('history.checkout') }}',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            }).then(response => response)
                            .catch(error => {
                                Swal.showValidationMessage(error.responseJSON?.message ||
                                    'Error al completar servicio');
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
                    <span>Detalle de cita - ${data.pet_name}</span>
                </div>`,
            html: `
            <div class="text-start" style="max-height: 500px; overflow-y: auto; padding: 5px;">
                <!-- Información general -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 p-2 bg-light rounded">
                            <i class="fa-solid fa-calendar-day text-primary"></i>
                            <div>
                                <small class="text-muted">Fecha</small>
                                <div class="fw-semibold">${data.appointment_date}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 p-2 bg-light rounded">
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
                        <strong><i class="fa-solid fa-chart-line"></i> Estado de la cita</strong>
                        <span class="badge ${data.status === 'Completada' ? 'bg-success' : data.status === 'En proceso' ? 'bg-primary' : data.status === 'Pendiente' ? 'bg-warning' : 'bg-danger'}">
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
                        <i class="fa-solid fa-sign-in-alt text-warning"></i>
                        <strong class="ms-2">Llegada del perro</strong>
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
                        <i class="fa-solid fa-camera text-primary"></i>
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
                        <i class="fa-solid fa-sign-out-alt text-success"></i>
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
            confirmButtonText: '<i class="fa-solid fa-check"></i> Cerrar',
            confirmButtonColor: '#4f46e5',
            showCloseButton: true,
            customClass: {
                popup: 'rounded-4',
                title: 'fs-4 fw-bold',
                confirmButton: 'px-4 py-2'
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
</script>
