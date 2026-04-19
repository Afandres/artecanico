<!-- Modal -->
<div class="modal fade" id="schedule_appointment_Modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Agendar cita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('appointment.store') }}" method="POST">
      @csrf
        <div class="modal-body">
          <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">
          <div class="mb-3"> 
              <label for="pet_name" class="form-label">Nombre de la mascota</label>
              <select class="form-control @error('pet_name') is-invalid @enderror" id="pet_name" name="pet_id"> </select>
              @error('pet_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
          </div>
          <div class="mb-3 d-flex align-items-center gap-4">  
              <img id="pet_photo" style="height: 150px; width: 150px; display: none; border-radius: 50%; object-fit: cover;">
              <div id="pet_info" style="display:none; flex: 1; background: #f8f9fa; padding: 10px; border-radius: 10px;">
                <div><strong id="pet_name_text"></strong></div>
                <div><small id="pet_client"></small></div>
                <div><small id="pet_breed"></small></div>
                <div><small id="pet_age"></small></div>
                <div><small id="pet_gender"></small></div>
                <div><small id="pet_medical"></small></div>
                <div><small id="pet_observations"></small></div>
            </div>
          </div>
          <div class="mb-3"> 
              <label for="schedule_appointment_date" class="form-label">Fecha seleccionada</label>
              <input type="hidden" class="form-control" id="schedule_appointment_id" name="appointment_date" required>
              <input type="text" class="form-control" id="show_appointment_date" name="schedule_appointment_date" readonly>
          </div>
          <div class="mb-3">
            <label for="time class="form-label">Hora de la cita</label>
            <input type="time" name="time" id="time" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success"> Agendar cita</button>
        </div>
      </form>
    </div>
  </div>
</div>