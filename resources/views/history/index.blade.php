<style>
/* ============================================
   HISTORIAL - PELUQUERÍA CANINA
   Versión Optimizada
============================================ */
@import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Quicksand:wght@400;500;600;700&display=swap');

/* ── ESTADÍSTICAS ── */
.history-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 22px;
    padding: 0 4px;
}

.history-stat-card {
    background: #fff;
    border-radius: 18px;
    padding: 16px 18px;
    border: 1.5px solid #fce7f0;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 4px 14px rgba(196, 79, 128, .07);
    transition: .2s;
}

.history-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(196, 79, 128, .13);
}

.history-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.history-stat-label {
    font-size: 11.5px;
    font-weight: 700;
    color: #b08090;
    text-transform: uppercase;
    letter-spacing: .4px;
    font-family: 'Quicksand', sans-serif;
}

.history-stat-num {
    font-family: 'Fredoka One', cursive;
    font-size: 26px;
    color: #3d1a28;
    line-height: 1.1;
}

/* ── SELECTOR DE MASCOTA ── */
.pet-selector-card {
    background: #fff;
    border-radius: 24px;
    border: 1.5px solid #fce7f0;
    margin-bottom: 24px;
    overflow: hidden;
}

.pet-selector-header {
    background: linear-gradient(90deg, #fff8fb, #fff);
    padding: 16px 20px;
    border-bottom: 2px solid #fce7f0;
}

.pet-selector-header h4 {
    font-family: 'Fredoka One', cursive;
    font-size: 18px;
    color: #3d1a28;
    margin: 0;
}

.pet-selector-body {
    padding: 20px;
}

/* ── TARJETA DE INFORMACIÓN DE MASCOTA ── */
.pet-info-card {
    background: #fff;
    border-radius: 24px;
    border: 1.5px solid #fce7f0;
    margin-bottom: 24px;
    overflow: hidden;
}

.pet-info-header {
    background: linear-gradient(90deg, #fff8fb, #fff);
    padding: 16px 20px;
    border-bottom: 2px solid #fce7f0;
}

.pet-info-header h4 {
    font-family: 'Fredoka One', cursive;
    font-size: 18px;
    color: #3d1a28;
    margin: 0;
}

.pet-info-body {
    padding: 20px;
}

.pet-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fce7f0;
    box-shadow: 0 4px 12px rgba(196, 79, 128, .1);
}

.pet-details h3 {
    font-family: 'Fredoka One', cursive;
    font-size: 22px;
    color: #3d1a28;
    margin-bottom: 8px;
}

.pet-details .pet-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 10px;
}

.pet-meta-item {
    background: #fff8fb;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: #c44f80;
}

.pet-contact {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #5a2a3a;
}

.contact-item i {
    color: #c44f80;
    width: 16px;
}

/* ── TARJETAS DE CITAS ── */
.appointment-card {
    border: 1.5px solid #fce7f0;
    border-radius: 20px;
    margin-bottom: 16px;
    overflow: hidden;
    transition: all .2s;
}

.appointment-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(196, 79, 128, .13);
}

.appointment-header {
    padding: 12px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.appointment-header.bg-pending {
    background: linear-gradient(135deg, #fff8e6, #ffe6c4);
}

.appointment-header.bg-progress {
    background: linear-gradient(135deg, #e8f1ff, #d4e4f7);
}

.appointment-header.bg-completed {
    background: linear-gradient(135deg, #e6faf2, #c8f0e0);
}

.appointment-header.bg-cancelled {
    background: linear-gradient(135deg, #ffe6e6, #ffd4d4);
}

.appointment-date {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 700;
    color: #3d1a28;
}

.appointment-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.appointment-badge.pending {
    background: #ffc107;
    color: #3d1a28;
}

.appointment-badge.progress {
    background: #0d6efd;
    color: white;
}

.appointment-badge.completed {
    background: #198754;
    color: white;
}

.appointment-badge.cancelled {
    background: #dc3545;
    color: white;
}

.appointment-body {
    padding: 16px 20px;
    background: #fff;
}

.appointment-footer {
    padding: 12px 20px;
    background: #fff8fb;
    border-top: 1px solid #fce7f0;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    flex-wrap: wrap;
}

/* Botones de acción */
.history-btn {
    border: none;
    border-radius: 10px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    transition: all .2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.history-btn-view {
    background: linear-gradient(135deg, #a5d6f5, #70b8e0);
    color: white;
}

.history-btn-view:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(112, 184, 224, .3);
    color: white;
}

.history-btn-checkin {
    background: linear-gradient(135deg, #f48fba, #c44f80);
    color: white;
}

.history-btn-checkin:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(196, 79, 128, .3);
    color: white;
}

.history-btn-process {
    background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    color: white;
}

.history-btn-process:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, .3);
    color: white;
}

.history-btn-checkout {
    background: linear-gradient(135deg, #198754, #157347);
    color: white;
}

.history-btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(25, 135, 84, .3);
    color: white;
}

.history-btn-cancel {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.history-btn-cancel:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, .3);
    color: white;
}

/* Badges de tratamientos */
.treatment-badge {
    background: linear-gradient(135deg, #f48fba, #c44f80);
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    display: inline-block;
    margin: 2px;
}

/* Responsive */
@media (max-width: 768px) {
    .history-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    
    .history-stat-card {
        padding: 12px 14px;
    }
    
    .history-stat-icon {
        width: 36px;
        height: 36px;
        font-size: 16px;
    }
    
    .history-stat-num {
        font-size: 20px;
    }
    
    .history-stat-label {
        font-size: 10px;
    }
    
    .pet-avatar {
        width: 70px;
        height: 70px;
        margin-bottom: 15px;
    }
    
    .pet-details h3 {
        font-size: 18px;
        text-align: center;
    }
    
    .pet-meta {
        justify-content: center;
    }
    
    .pet-contact {
        justify-content: center;
    }
    
    .appointment-header {
        flex-direction: column;
        text-align: center;
    }
    
    .appointment-footer {
        justify-content: center;
    }
}

/* Scrollbar personalizado */
.history-modal .modal-body::-webkit-scrollbar {
    width: 6px;
}

.history-modal .modal-body::-webkit-scrollbar-track {
    background: #fce7f0;
    border-radius: 10px;
}

.history-modal .modal-body::-webkit-scrollbar-thumb {
    background: #c44f80;
    border-radius: 10px;
}
</style>

<x-app-layout>
    <h2 class="page-title font-semibold text-xl text-gray-800 leading-tight">
        @if (auth()->check())
                Historial de Servicios
            @else
                Historial de mis mascotas
            @endif
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Estadísticas --}}
            <div class="history-stats" id="statsContainer" style="display: none;">
                <div class="history-stat-card">
                    <div class="history-stat-icon" style="background:#fce7f0;">📅</div>
                    <div>
                        <div class="history-stat-label">Total Citas</div>
                        <div class="history-stat-num" id="totalAppointments">0</div>
                    </div>
                </div>
                <div class="history-stat-card">
                    <div class="history-stat-icon" style="background:#e6faf2;">✅</div>
                    <div>
                        <div class="history-stat-label">Completadas</div>
                        <div class="history-stat-num" id="completedAppointments">0</div>
                    </div>
                </div>
                <div class="history-stat-card">
                    <div class="history-stat-icon" style="background:#fff8e6;">⏳</div>
                    <div>
                        <div class="history-stat-label">Pendientes</div>
                        <div class="history-stat-num" id="pendingAppointments">0</div>
                    </div>
                </div>
                <div class="history-stat-card">
                    <div class="history-stat-icon" style="background:#ffe6f0;">💊</div>
                    <div>
                        <div class="history-stat-label">Tratamientos</div>
                        <div class="history-stat-num" id="totalTreatments">0</div>
                    </div>
                </div>
            </div>

            {{-- Selector de mascota --}}
            <div class="pet-selector-card">
                <div class="pet-selector-header">
                    <h4><i class="fa-solid fa-dog me-2"></i> Seleccionar mascota</h4>
                </div>
                <div class="pet-selector-body">
                    <div class="row align-items-end g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-secondary">Mascota</label>
                            <select id="pet_selector" class="form-select select2">
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
                        <div class="col-md-4">
                            <button id="btnSearch" class="btn btn-primary w-100" style="background: linear-gradient(135deg, #f48fba, #c44f80); border: none;">
                                <i class="fa-solid fa-magnifying-glass me-2"></i> Ver historial
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contenedor del historial --}}
            <div id="historyContainer" style="display: none;">
                {{-- Info de la mascota --}}
                <div class="pet-info-card">
                    <div class="pet-info-header">
                        <h4><i class="fa-solid fa-paw me-2"></i> Información de la mascota</h4>
                    </div>
                    <div class="pet-info-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center text-md-start">
                                <img id="pet_profile_photo" src="" class="pet-avatar">
                            </div>
                            <div class="col-md-9">
                                <div class="pet-details">
                                    <h3 id="pet_name_display"></h3>
                                    <div class="pet-meta">
                                        <span class="pet-meta-item" id="pet_breed_display"></span>
                                        <span class="pet-meta-item" id="pet_age_display"></span>
                                        <span class="pet-meta-item" id="pet_gender_display"></span>
                                    </div>
                                    @auth
                                    <div class="pet-contact">
                                        <span class="contact-item"><i class="fa-solid fa-user"></i> <span id="client_name_display"></span></span>
                                        <span class="contact-item"><i class="fa-brands fa-whatsapp"></i> <span id="client_phone_display"></span></span>
                                    </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Listado de citas --}}
                <div class="pet-info-card">
                    <div class="pet-info-header">
                        <h4><i class="fa-solid fa-calendar-check me-2"></i> Historial de Citas</h4>
                    </div>
                    <div class="pet-info-body">
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
            placeholder: '🔍 Buscar mascota...',
            width: '100%',
            language: 'es'
        });

        $('#btnSearch').on('click', function() {
            currentPetId = $('#pet_selector').val();

            if (!currentPetId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Por favor, selecciona una mascota',
                    confirmButtonColor: '#c44f80'
                });
                return;
            }

            reloadFullHistory();
        });

        // Cargar si viene con parámetro pet_id
        const urlParams = new URLSearchParams(window.location.search);
        const petId = urlParams.get('pet_id');

        if (petId) {
            $('#pet_selector').val(petId).trigger('change');
            currentPetId = petId;
            loadPetInfo(petId);
            loadPetHistory(petId);
        }

        function reloadFullHistory() {
            if (!currentPetId) return;

            $('#appointmentsList').html(`
                <div class="text-center py-5">
                    <i class="fa-solid fa-spinner fa-spin fa-2x" style="color: #c44f80;"></i>
                    <p class="mt-3 text-muted">Cargando historial...</p>
                </div>
            `);

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
                    $('#pet_breed_display').html(`<i class="fa-solid fa-tag me-1"></i> ${data.breed}`);
                    $('#pet_age_display').html(`<i class="fa-regular fa-calendar me-1"></i> ${data.age ? data.age + ' años' : 'Edad no registrada'}`);
                    $('#pet_gender_display').html(`<i class="fa-solid fa-venus-mars me-1"></i> ${data.gender || 'No registrado'}`);
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
                    updateStats(data.appointments);
                    $('#statsContainer').show();
                },
                error: function() {
                    $('#appointmentsList').html(`
                        <div class="alert alert-danger text-center">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>
                            Error al cargar el historial
                        </div>
                    `);
                }
            });
        }

        function updateStats(appointments) {
            const total = appointments.length;
            const completed = appointments.filter(a => a.status === 'Completada').length;
            const pending = appointments.filter(a => a.status === 'Pendiente' || a.status === 'En proceso').length;
            const treatments = appointments.reduce((sum, a) => sum + (a.treatments?.length || 0), 0);

            $('#totalAppointments').text(total);
            $('#completedAppointments').text(completed);
            $('#pendingAppointments').text(pending);
            $('#totalTreatments').text(treatments);
        }

        window.renderAppointments = function(appointments) {
            const container = $('#appointmentsList');
            container.empty();

            if (appointments.length === 0) {
                container.html(`
                    <div class="text-center py-5">
                        <i class="fa-solid fa-calendar-xmark fa-3x" style="color: #fce7f0;"></i>
                        <p class="mt-3 text-muted">No hay citas registradas para esta mascota</p>
                    </div>
                `);
                return;
            }

            appointments.forEach(app => {
                const statusClass = {
                    'Pendiente': 'pending',
                    'En proceso': 'progress',
                    'Completada': 'completed',
                    'Cancelada': 'cancelled'
                }[app.status] || 'pending';

                const headerBgClass = {
                    'Pendiente': 'bg-pending',
                    'En proceso': 'bg-progress',
                    'Completada': 'bg-completed',
                    'Cancelada': 'bg-cancelled'
                }[app.status] || 'bg-pending';

                const hasCheckin = app.checkin_time;
                const hasCheckout = app.checkout_time;
                const isAuth = {{ auth()->check() ? 'true' : 'false' }};
                const isCanceled = app.status === 'Cancelada';
                const isCompleted = app.status === 'Completada';

                const card = `
                    <div class="appointment-card" data-appointment-id="${app.id}">
                        <div class="appointment-header ${headerBgClass}">
                            <div class="appointment-date">
                                <i class="fa-regular fa-calendar"></i>
                                <span>${app.date} - ${app.time}</span>
                            </div>
                            <span class="appointment-badge ${statusClass}">
                                ${app.status}
                            </span>
                        </div>
                        <div class="appointment-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Precio</small>
                                    <strong class="text-success">${app.price ? '$' + parseFloat(app.price).toLocaleString() : 'Pendiente'}</strong>
                                </div>
                                <div class="col-md-8">
                                    <small class="text-muted d-block">Tratamientos aplicados</small>
                                    <div>
                                        ${app.treatments.map(t => `<span class="treatment-badge">${t.name}</span>`).join('') || '<span class="text-muted">Ninguno</span>'}
                                    </div>
                                </div>
                                ${app.observations ? `
                                <div class="col-12">
                                    <small class="text-muted d-block">Observaciones</small>
                                    <div class="small bg-light p-2 rounded">${app.observations}</div>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                        <div class="appointment-footer">
                            <button class="history-btn history-btn-view" onclick="viewAppointmentDetail(${app.id})">
                                <i class="fa-regular fa-eye"></i> Ver detalle
                            </button>
                            ${isAuth && !isCanceled && !isCompleted && !hasCheckin ? 
                                `<button class="history-btn history-btn-checkin" onclick="openCheckinModal(${app.id})">
                                    <i class="fa-solid fa-right-to-bracket"></i> Registrar llegada
                                </button>` : ''}
                            ${isAuth && !isCanceled && !isCompleted && hasCheckin && !hasCheckout ? 
                                `<button class="history-btn history-btn-process" onclick="openProcessModal(${app.id})">
                                    <i class="fa-solid fa-camera"></i> Novedades del proceso
                                </button>` : ''}
                            ${isAuth && !isCanceled && !isCompleted && hasCheckin && !hasCheckout ? 
                                `<button class="history-btn history-btn-checkout" onclick="openCheckoutModal(${app.id})">
                                    <i class="fa-solid fa-right-from-bracket"></i> Completar servicio
                                </button>` : ''}
                            ${!isCanceled && !isCompleted ? 
                                `<button class="history-btn history-btn-cancel" onclick="cancelAppointment(${app.id})">
                                    <i class="fa-solid fa-ban"></i> Cancelar cita
                                </button>` : ''}
                        </div>
                    </div>
                `;
                container.append(card);
            });
        };
    });

    // Funciones globales (se mantienen igual pero con estilos mejorados)
    function cancelAppointment(appointmentId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción cancelará la cita. No podrás revertirla.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#c44f80',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Cancelando...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
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
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message || 'No se pudo cancelar la cita', 'error');
                    }
                });
            }
        });
    }

    function viewAppointmentDetail(appointmentId) {
        $.ajax({
            url: `/history/appointment/${appointmentId}`,
            method: 'GET',
            success: function(data) {
                mostrarDetalleCita(data);
            },
            error: function() {
                Swal.fire('Error', 'No se pudo cargar el detalle de la cita', 'error');
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
