<div class="modal fade" id="appointmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detalle de la cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="appointment_id" id="appointment_id">
                @if (!auth()->check())
                    <input type="hidden" name="client_code" id="client_code_hidden" value="{{ $code ?? '' }}">
                @endif

                <!-- Info de la mascota -->
                <div class="mb-3 d-flex align-items-center gap-4">
                    <img id="event_pet_photo"
                        style="height: 120px; width: 120px; border-radius: 50%; object-fit: cover;">
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
                        <div id="status_progress" class="progress-bar progress-bar-striped progress-bar-animated"
                            style="width: 0%;"></div>
                    </div>
                    <small class="mt-2 d-block fw-bold" id="event_status"></small>
                </div>
                <div class="mb-3">
                    <a href="#" id="btnHistoryPet" class="btn btn-sm btn-primary timeline-more">
                        <i class="fa-solid fa-clock-rotate-left me-1"></i>
                        Ver detalles del historial
                    </a>
                </div>
                <!-- Timeline de checkin/checkout -->
                <div id="timeline_info" class="row mb-3" style="display: none;">
                    <div class="mb-2"><strong>Historial</strong></div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body p-2"> 
                                <div class="timeline-content">
                                    <small class="text-muted">Llegada</small>
                                    <div class="fw-bold" id="checkin_time_display">---</div>
                                    <div id="checkin_photo_preview" class="mt-1"></div>
                                    <small class="text-muted">Observaciones:</small>
                                    <div class="small" id="checkin_obs_display">---</div>           
                                </div>                         
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body p-2">
                                <div class="timeline-content">
                                    <small class="text-muted">Proceso</small>
                                    <div id="process_photo_preview" class="mt-1"></div>
                                    <small class="text-muted">Observaciones:</small>
                                    <div class="small" id="process_obs_display">---</div>
                                </div>     
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="card bg-light">
                            <div class="card-body p-2">
                                <div class="timeline-content">
                                    <small class="text-muted">Salida</small>
                                    <div class="fw-bold" id="checkout_time_display">---</div>
                                    <div id="checkout_photo_preview" class="mt-1"></div>
                                    <small class="text-muted">Observaciones:</small>
                                    <div class="small" id="checkout_obs_display">---</div>
                                </div>
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
                    <div class="btn-group w-100" role="group" style="flex-wrap: wrap; gap: 5px;">
                        <button type="button" id="btnCheckin" class="btn btn-warning"
                            onclick="window.openCheckinModal()">
                            <i class="fa-solid fa-right-to-bracket"></i> Registrar llegada
                        </button>
                        <button type="button" id="btnProcess" class="btn btn-primary"
                            onclick="window.openProcessModal()">
                            <i class="fa-solid fa-camera"></i> Novedades del proceso
                        </button>
                        <button type="button" id="btnCheckout" class="btn btn-success"
                            onclick="window.openCheckoutModal()">
                            <i class="fa-solid fa-right-from-bracket"></i> Completar servicio
                        </button>
                        <button type="button" id="btnCancel" class="btn btn-danger"
                            onclick="window.cancelAppointment()">
                            <i class="fa-solid fa-ban"></i> Cancelar cita
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentAppointmentId = null;
    let currentAppointmentStatus = null;

    // Reemplaza toda la sección de cancelar en tu modal con esto:

    // ============================================
    // CANCELAR CITA
    // ============================================
    window.cancelAppointment = function() {
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
                        appointment_id: currentAppointmentId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Cancelada', response.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'No se pudo cancelar la cita', 'error');
                    }
                });
            }
        });
    };

    // ============================================
    // REGISTRAR LLEGADA
    // ============================================
    window.openCheckinModal = function() {
        let currentModal = bootstrap.Modal.getInstance(document.getElementById('appointmentModal'));
        if (currentModal) currentModal.hide();

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
                confirmButtonColor: '#10b981',
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
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            });
        }, 300);
    };

    // ============================================
    // FOTO PROCESO
    // ============================================
    window.openProcessModal = function() {
        let event = window.currentEventProps; // guardaremos props globalmente
        console.log(event);

        const yaExisteProceso =
            event.process_photo ||
            event.process_observations;

        if (yaExisteProceso) {

            Swal.fire({
                title: 'Ya existe registro de proceso',
                text: 'Si continúas, la foto y observación anterior serán reemplazadas.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, reemplazar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#10b981',
            }).then((result) => {
                if (result.isConfirmed) {
                    abrirModalProceso();
                }
            });

        } else {
            abrirModalProceso();
        }
    };

    function abrirModalProceso(){
        let currentModal = bootstrap.Modal.getInstance(document.getElementById('appointmentModal'));
        if (currentModal) currentModal.hide();

        setTimeout(() => {
            Swal.fire({
                title: 'Novedades durante el proceso',
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
                confirmButtonColor: '#10b981',
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
                            url: '{{ route('appointments.process') }}',
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
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            });
        }, 300);
    }

    // ============================================
    // COMPLETAR SERVICIO
    // ============================================
    window.openCheckoutModal = function() {
        let currentModal = bootstrap.Modal.getInstance(document.getElementById('appointmentModal'));
        if (currentModal) currentModal.hide();

        setTimeout(() => {
            $.ajax({
                url: '/treatments/list',
                method: 'GET',
                success: function(treatments) {
                    let treatmentsHtml = '<div class="mb-3">';
                    treatmentsHtml +=
                    '<label class="form-label">Tratamientos aplicados</label>';
                    treatmentsHtml +=
                        '<select id="checkout_treatment_ids" class="form-control">';
                    treatmentsHtml += `<option value=""></option>`;
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
                                <label class="form-label">Precio</label>
                                <input type="text" id="checkout_price" class="form-control" inputmode="numeric" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Metodo de pago</label>
                                <select id="checkout_payment_method" class="form-control">
                                    <option>---Seleccione el metodo de pago ---</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Nequi">Nequi</option>
                                    <option value="Daviplata">Daviplata</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Llave_nequi">Llave Nequi</option>
                                    <option value="Llave_daviplata">Llave Daviplata</option>
                                </select>
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
                        confirmButtonColor: '#10b981',
                        allowOutsideClick: false,
                        backdrop: true,
                        didOpen: () => {
                            $('#checkout_treatment_ids').select2({
                                dropdownParent: $('.swal2-container'),
                                width: '100%',
                                placeholder: 'Selecciona el tratamiento aplicado'
                            });

                            $('#checkout_price').on('input', function () {

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
                                const priceInput = document.getElementById(
                                    'checkout_price');
                                if (priceInput) priceInput.focus();
                            }, 100);
                        },
                        preConfirm: () => {
                            const treatmentId = $('#checkout_treatment_ids').val();
                            const price = $('#checkout_price').val().replace(/\./g, '');
                            const payment_method = $('#checkout_payment_method').val();
                            const observations = $('#checkout_obs_input').val();
                            const photoFile = $('#checkout_photo_input')[0].files[0];

                            if (!treatmentId) {
                                Swal.showValidationMessage('Selecciona un tratamiento');
                                return false;
                            }

                            if (!price) {
                                Swal.showValidationMessage('Ingresa el precio final');
                                return false;
                            }

                            if (!payment_method) {
                                Swal.showValidationMessage('Ingresa el precio final');
                                return false;
                            }

                            const formData = new FormData();
                            formData.append('appointment_id', currentAppointmentId);
                            formData.append('treatment_id', treatmentId);
                            formData.append('price', price);
                            formData.append('payment_method', payment_method);
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
                            }).catch(error => {
                                Swal.showValidationMessage(
                                    error.responseJSON?.message || 'Error al completar servicio'
                                );
                            });
                        }
                    }).then((result) => {
                        if (result.isConfirmed && result.value?.success) {
                            Swal.fire('Éxito', result.value.message, 'success');
                            let pet = result.value.pet;      // nombre mascota
                            let pet_temp = result.value.pet_temp;
                            let phone = result.value.phone;  // teléfono cliente
                            let phone_temp = result.value.phone_temp;
                            let gender = result.value.gender;
                            let status = 'Completada';

                            let estadoTexto = (gender === 'Hembra') ? 'lista' : 'listo';

                            if (status === 'Completada' && phone) {

                                let mensaje = `Hola 👋 Te informamos que ${pet} ya está ${estadoTexto} 🐶✨. Gracias por confiar en nosotros ☺️`;

                                let encoded = encodeURIComponent(mensaje);

                                let appUrl = `whatsapp://send?phone=57${phone}&text=${encoded}`;
                                let webUrl = `https://api.whatsapp.com/send?phone=57${phone}&text=${encoded}`;

                                let isAndroid = /Android/i.test(navigator.userAgent);

                                setTimeout(() => {
                                    if (isAndroid) {
                                        window.location.href = appUrl;

                                        setTimeout(() => {
                                            window.location.href = webUrl;
                                        }, 1500);
                                    } else {
                                        window.open(webUrl, '_blank');
                                    }
                                }, 800);
                            }else{
                                let mensaje = `Hola 👋 Te informamos que ${pet_temp} ya está ${estadoTexto} 🐶✨. Gracias por confiar en nosotros ☺️`;

                                let encoded = encodeURIComponent(mensaje);

                                let appUrl = `whatsapp://send?phone=57${phone_temp}&text=${encoded}`;
                                let webUrl = `https://api.whatsapp.com/send?phone=57${phone_temp}&text=${encoded}`;

                                let isAndroid = /Android/i.test(navigator.userAgent);

                                setTimeout(() => {
                                    if (isAndroid) {
                                        window.location.href = appUrl;

                                        setTimeout(() => {
                                            window.location.href = webUrl;
                                        }, 1500);
                                    } else {
                                        window.open(webUrl, '_blank');
                                    }
                                }, 800);
                            }
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    });
                }
            });
        }, 300);
    };

    // ============================================
    // MOSTRAR MODAL CON DATOS DE LA CITA
    // ============================================
    window.handleEventClick = function(info) {
        let event = info.event;
        let props = event.extendedProps;
        window.currentEventProps = props;
        console.log(info.event.extendedProps);
        let petId = props.pet_id;
        let status = props.status;
        let photo = props.photo ? props.photo : '/storage/pets/images.png';
        let isAuth = {{ auth()->check() ? 'true' : 'false' }};
        let code = "{{ request()->route('code') }}";

        if(isAuth){
            $('#btnHistoryPet').attr('href', '/history?pet_id=' + petId);
        }else{
            $('#btnHistoryPet').attr('href', '/history/client/' + code + '?pet_id=' + petId);
        }

        currentAppointmentId = event.id;
        currentAppointmentStatus = status;
        
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
            progress.css('width', '33%').removeClass().addClass('progress-bar bg-warning');
            $('#event_status').text('Pendiente');
        } else if (status === 'En proceso') {
            progress.css('width', '66%').removeClass().addClass(
                'progress-bar bg-primary progress-bar-striped progress-bar-animated');
            $('#event_status').text('En proceso');
        } else if (status === 'Completada') {
            progress.css('width', '100%').removeClass().addClass('progress-bar bg-success');
            $('#event_status').text('Completada');
        } else if (status === 'Cancelada') {
            progress.css('width', '100%').removeClass().addClass('progress-bar bg-danger');
            $('#event_status').text('Cancelada');
        }

        $('#timeline_info').show();
        $('#checkin_time_display').text(props.checkin_time || '---');
        $('#checkin_obs_display').text(props.checkin_observations || '---');
        $('#checkin_photo_preview').html(props.checkin_photo ?
            `<img src="${props.checkin_photo}" style="max-width: 100px; border-radius: 5px;">` : '');
        $('#process_obs_display').text(props.process_observations || '---');
        $('#process_photo_preview').html(props.process_photo ?
            `<img src="${props.process_photo}" style="max-width: 100px; border-radius: 5px;">` : '');
        $('#checkout_time_display').text(props.checkout_time || '---');
        $('#checkout_obs_display').text(props.checkout_observations || '---');
        $('#checkout_photo_preview').html(props.checkout_photo ?
            `<img src="${props.checkout_photo}" style="max-width: 100px; border-radius: 5px;">` : '');
        $('#final_price_display').text(props.price ? '$' + props.price : '---');

        if (props.treatments && props.treatments.length > 0) {
            let treatmentsHtml = '';
            props.treatments.forEach(t => {
                treatmentsHtml += `<span class="badge bg-info me-1">${t.name}</span>`;
            });
            $('#treatments_display').html(treatmentsHtml);
        } else {
            $('#treatments_display').text('---');
        }

        // Botones de acción para admin
        if (isAuth) {
            $('#admin_actions').show();

            const hasCheckin = props.checkin_time;
            const hasCheckout = props.checkout_time;
            const isCanceled = status === 'Cancelada';
            const isCompleted = status === 'Completada';

            // Si la cita ya está cancelada o completada, deshabilitar TODO
            if (isCanceled || isCompleted ) {
                $('#admin_actions').hide();
            } 
            else {
                // Configurar botón de llegada
                if (hasCheckin) {
                    $('#btnCheckin').prop('disabled', true).html(
                        '<i class="fa-regular fa-check-circle"></i> Llegada registrada');
                } else {
                    $('#btnCheckin').prop('disabled', false).html(
                        '<i class="fa-solid fa-right-to-bracket"></i> Registrar llegada');
                }

                // Configurar botones de proceso y salida
                if (hasCheckout) {
                    $('#btnCheckout').prop('disabled', true).html(
                        '<i class="fa-regular fa-check-circle"></i> Servicio completado');
                    $('#btnProcess').prop('disabled', true);
                } else if (!hasCheckin) {
                    $('#btnCheckout').prop('disabled', true);
                    $('#btnProcess').prop('disabled', true);
                } else {
                    $('#btnCheckout').prop('disabled', false).html(
                        '<i class="fa-solid fa-right-from-bracket"></i> Completar servicio');
                    $('#btnProcess').prop('disabled', false).html(
                        '<i class="fa-regular fa-camera"></i> Novedades del proceso');
                }

                // Botón cancelar SOLO habilitado si NO está completada
                $('#btnCancel').prop('disabled', false).html('<i class="fa-solid fa-ban"></i> Cancelar cita');
            }
        } else {
            $('#admin_actions').hide();
        }

        let modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
        modal.show();
    };
</script>

<style>
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
    
    #timeline_info .col-md-6{
        display:flex;
    }

    /* tarjeta completa */
    #timeline_info .card{
        width:100%;
        height:100px; /* tamaño compacto */
        border-radius:12px;
    }

    /* cuerpo fijo */
    #timeline_info .card-body{
        height:100%;
        display:flex;
        flex-direction:column;
        position:relative;
        overflow:hidden;
        padding:10px;
    }

    /* contenido interno */
    .timeline-content{
        flex:1;
        overflow-y:auto;
        overflow-x:hidden;
        padding-right:4px;
    }

    /* imágenes pequeñas */
    #timeline_info img{
        max-width:90px;
        max-height:60px;
        object-fit:cover;
        border-radius:6px;
    }
</style>
