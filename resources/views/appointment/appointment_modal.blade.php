<div class="modal fade" id="appointmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title">Detalle de la cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="appointmentForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="appointment_id" id="appointment_id">
                    @if (!auth()->check())
                    <input type="hidden" name="client_code" id="client_code_hidden" value="{{ $code ?? '' }}">
                    @endif   
                    
                    <!-- Info de la mascota -->
                    <div class="mb-3 d-flex align-items-center gap-4">  
                        <img id="event_pet_photo" style="height: 120px; width: 120px; border-radius: 50%; object-fit: cover;">
                        <div id="pet_info" style="flex: 1; background: #f8f9fa; padding: 10px; border-radius: 10px;">
                            <div><strong id="event_title"></strong></div>
                            @auth
                            <div><small id="event_client"></small> - <small id="event_phone"></small></div>
                            @endauth
                            <div><small id="event_breed"></small></div>
                            <div><small id="event_age"></small> | <small id="event_gender"></small></div>
                            <div><small id="event_medical_condition"></small></div>
                            <div><small id="event_observations"></small></div>
                        </div>
                    </div>

                    <!-- Barra de progreso -->
                    <div class="mb-3">
                        <p class="mb-2"><strong>Estado actual de la cita:</strong></p>
                        <div class="progress" style="height: 28px; border-radius: 20px;">
                            <div id="status_progress" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%;"></div>
                        </div>
                        <small class="mt-2 d-block fw-bold" id="event_status"></small>
                    </div>

                    <!-- Timeline de checkin/checkout -->
                    <div id="timeline_info" class="row mb-3" style="display: none;">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body p-2">
                                    <small class="text-muted">Llegada</small>
                                    <div class="fw-bold" id="checkin_time_display">---</div>
                                    <div id="checkin_photo_preview" class="mt-1"></div>
                                    <small class="text-muted">Observaciones:</small>
                                    <div class="small" id="checkin_obs_display">---</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body p-2">
                                    <small class="text-muted">Proceso</small>
                                    <div id="process_photo_preview" class="mt-1"></div>
                                    <small class="text-muted">Observaciones:</small>
                                    <div class="small" id="process_obs_display">---</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="card bg-light">
                                <div class="card-body p-2">
                                    <small class="text-muted">Salida</small>
                                    <div class="fw-bold" id="checkout_time_display">---</div>
                                    <div id="checkout_photo_preview" class="mt-1"></div>
                                    <small class="text-muted">Observaciones:</small>
                                    <div class="small" id="checkout_obs_display">---</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="card bg-light">
                                <div class="card-body p-2">
                                    <small class="text-muted">Precio final</small>
                                    <div class="fw-bold text-success" id="final_price_display">---</div>
                                    <small class="text-muted">Tratamientos aplicados</small>
                                    <div id="treatments_display" class="small">---</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción para ADMIN -->
                    <div id="admin_actions" class="mb-3" style="display: none;">
                        <div class="btn-group w-100" role="group">
                            <button type="button" id="btnCheckin" class="btn btn-warning" onclick="openCheckinModal()">
                                <i class="fa-solid fa-sign-in-alt"></i> Registrar llegada
                            </button>
                            <button type="button" id="btnProcess" class="btn btn-primary" onclick="openProcessModal()">
                                <i class="fa-solid fa-camera"></i> Foto proceso
                            </button>
                            <button type="button" id="btnCheckout" class="btn btn-success" onclick="openCheckoutModal()">
                                <i class="fa-solid fa-sign-out-alt"></i> Completar servicio
                            </button>
                        </div>
                    </div>

                    <!-- Selector de estado (solo para cambios manuales) -->
                    <div class="mb-3">
                        <label for="status" class="form-label"><strong>Cambiar estado de la cita</strong></label>
                        <select id="appointment_status" name="status" class="form-control"></select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="saveBtn">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentAppointmentId = null;
let currentAppointmentStatus = null;

function openCheckinModal() {
    let currentModal = bootstrap.Modal.getInstance(document.getElementById('appointmentModal'));
    if (currentModal) {
        currentModal.hide();
    }
    
    setTimeout(() => {
        Swal.fire({
            title: 'Registrar llegada',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label">Foto de cómo llegó</label>
                        <input type="file" id="checkin_photo_input" class="form-control" accept="image/*" capture="environment">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones de llegada</label>
                        <textarea id="checkin_obs_input" class="form-control" rows="3" 
                            placeholder="¿Cómo llegó el perro? Estado de salud, comportamiento, etc."></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Registrar llegada',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
            backdrop: true,
            didOpen: () => {
                setTimeout(() => {
                    const textarea = document.getElementById('checkin_obs_input');
                    if (textarea) textarea.focus();
                }, 100);
            },
            preConfirm: () => {
                const photoFile = document.getElementById('checkin_photo_input').files[0];
                const observations = document.getElementById('checkin_obs_input').value;

                const formData = new FormData();
                formData.append('appointment_id', currentAppointmentId);
                formData.append('checkin_observations', observations);
                if (photoFile) formData.append('checkin_photo', photoFile);

                return $.ajax({
                    url: '{{ route("history.checkin") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then(response => response)
                .catch(error => {
                    Swal.showValidationMessage(error.responseJSON?.message || 'Error al registrar llegada');
                });
            }
        }).then((result) => {
            if (result.isConfirmed && result.value?.success) {
                Swal.fire('Éxito', result.value.message, 'success');
                if (window.calendar) window.calendar.refetchEvents();
            }
        });
    }, 300);
}

function openProcessModal() {
    let currentModal = bootstrap.Modal.getInstance(document.getElementById('appointmentModal'));
    if (currentModal) {
        currentModal.hide();
    }
    
    setTimeout(() => {
        Swal.fire({
            title: 'Foto durante el proceso',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label">Foto del proceso</label>
                        <input type="file" id="process_photo_input" class="form-control" accept="image/*" capture="environment">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones del proceso</label>
                        <textarea id="process_obs_input" class="form-control" rows="3" 
                            placeholder="¿Cómo va el proceso? Alguna novedad, etc."></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Registrar foto',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
            backdrop: true,
            didOpen: () => {
                setTimeout(() => {
                    const textarea = document.getElementById('process_obs_input');
                    if (textarea) textarea.focus();
                }, 100);
            },
            preConfirm: () => {
                const photoFile = document.getElementById('process_photo_input').files[0];
                const observations = document.getElementById('process_obs_input').value;

                const formData = new FormData();
                formData.append('appointment_id', currentAppointmentId);
                formData.append('process_observations', observations);
                if (photoFile) formData.append('process_photo', photoFile);

                return $.ajax({
                    url: '{{ route("appointments.process") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then(response => response)
                .catch(error => {
                    Swal.showValidationMessage(error.responseJSON?.message || 'Error al registrar foto');
                });
            }
        }).then((result) => {
            if (result.isConfirmed && result.value?.success) {
                Swal.fire('Éxito', result.value.message, 'success');
                if (window.calendar) window.calendar.refetchEvents();
            }
        });
    }, 300);
}

function openCheckoutModal() {
    let currentModal = bootstrap.Modal.getInstance(document.getElementById('appointmentModal'));
    if (currentModal) {
        currentModal.hide();
    }
    
    setTimeout(() => {
        $.ajax({
            url: '/treatments/list',
            method: 'GET',
            success: function(treatments) {
                let treatmentsHtml = '<div class="mb-3">';
                treatmentsHtml += '<label class="form-label">Tratamientos aplicados</label>';
                treatmentsHtml += '<select id="checkout_treatment_ids" class="form-control select2-checkout" multiple>';
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
                                <input type="number" id="checkout_price" class="form-control" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto de salida</label>
                                <input type="file" id="checkout_photo_input" class="form-control" accept="image/*" capture="environment">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Observaciones finales</label>
                                <textarea id="checkout_obs_input" class="form-control" rows="3" 
                                    placeholder="Resultado del servicio, recomendaciones, etc."></textarea>
                            </div>
                        </div>
                    `,
                    width: '600px',
                    showCancelButton: true,
                    confirmButtonText: 'Completar servicio',
                    cancelButtonText: 'Cancelar',
                    allowOutsideClick: false,
                    backdrop: true,
                    didOpen: () => {
                        $('.select2-checkout').select2({
                            dropdownParent: $('.swal2-container'),
                            width: '100%',
                            placeholder: 'Selecciona los tratamientos aplicados'
                        });
                        
                        setTimeout(() => {
                            const priceInput = document.getElementById('checkout_price');
                            if (priceInput) priceInput.focus();
                        }, 100);
                    },
                    preConfirm: () => {
                        const treatmentIds = $('#checkout_treatment_ids').val();
                        const price = document.getElementById('checkout_price').value;
                        const observations = document.getElementById('checkout_obs_input').value;
                        const photoFile = document.getElementById('checkout_photo_input').files[0];

                        if (!treatmentIds || treatmentIds.length === 0) {
                            Swal.showValidationMessage('Selecciona al menos un tratamiento');
                            return false;
                        }

                        if (!price) {
                            Swal.showValidationMessage('Ingresa el precio final');
                            return false;
                        }

                        const formData = new FormData();
                        formData.append('appointment_id', currentAppointmentId);

                        treatmentIds.forEach(id => {
                            formData.append('treatment_ids[]', id);
                        });

                        formData.append('price', price);
                        formData.append('checkout_observations', observations);
                        if (photoFile) formData.append('checkout_photo', photoFile);

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
                            Swal.showValidationMessage(error.responseJSON?.message || 'Error al completar servicio');
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed && result.value?.success) {
                        Swal.fire('Éxito', result.value.message, 'success');
                        if (window.calendar) window.calendar.refetchEvents();
                    }
                });
            }
        });
    }, 300);
}
</script>

<style>
/* Asegurar que SweetAlert sea interactivo */
.swal2-container {
    z-index: 2000 !important;
}

.swal2-popup {
    z-index: 2001 !important;
}

.swal2-container input,
.swal2-container textarea,
.swal2-container select {
    pointer-events: auto !important;
    z-index: 2002 !important;
}

.select2-container--open {
    z-index: 9999 !important;
}

.swal2-container .select2-container {
    z-index: 2002 !important;
}

.modal-backdrop {
    z-index: 1040 !important;
}

.swal2-backdrop {
    z-index: 1999 !important;
}
</style>