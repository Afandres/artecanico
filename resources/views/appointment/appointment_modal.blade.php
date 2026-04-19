<div class="modal fade" id="appointmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title">Detalle de la cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="appointmentForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="appointment_id" id="appointment_id">
                    <input type="hidden" name="client_code" id="client_code_hidden">
                    <div class="mb-3 d-flex align-items-center gap-4">  
                        <img id="event_pet_photo" style="height: 150px; width: 150px; display: none; border-radius: 50%; object-fit: cover;">
                        <div id="pet_info" style="flex: 1; background: #f8f9fa; padding: 10px; border-radius: 10px;">
                            <div><strong id="event_title"></strong></div>
                            <div><small id="event_client"></small> - <small id="event_phone"></small></div>
                            <div><small id="event_breed"></small></div>
                            <div><small id="event_age"></small></div>
                            <div><small id="event_gender"></small></div>
                            <div><small id="event_medical_condition"></small></div>
                            <div><small id="event_observations"></small></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p class="mb-2"><strong>Estado actual de la cita:</strong></p>
                        <div class="progress" style="height: 28px; border-radius: 20px;">
                            <div id="status_progress" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%;"></div>
                        </div>
                        <small class="mt-2 d-block fw-bold" id="event_status"></small>
                    </div>
                    <div id="extra_fields" style="display: none;">
                         <div class="mb-3">
                            <label for="price" class="form-lavbe">Precio</label>
                            <input type="number" name="price" id="price" class="form-control">
                        </div>                   
                        <div class="mb-3">
                            <label for="treatment_id" class="form-label">Tratamientos</label>
                            <select name="treatment_id" id="treatment_id" class="form-control">
                                <option value="">--- Seleccione el tratamiento aplicado ---</option>
                                @foreach ($treatments as $t)
                                    <option value="{{ $t->id }}">{{$t->name}}</option>
                                @endforeach
                            </select>
                        </div>
                       <div class="mb-3">
                            <label for="observations" class="form-label">Observaciones</label>
                            <textarea name="observations" id="observations" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">
                                <input type="file" name="photo" id="photo" class="form-control">
                            </label>
                        </div>
                    </div>
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