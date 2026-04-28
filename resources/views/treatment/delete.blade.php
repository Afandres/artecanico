<!-- Modal Delete Tratamiento -->
<div class="modal fade treatment-modal" id="treatmentDeleteModal{{ $treatment->id }}" tabindex="-1" aria-labelledby="treatmentDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="treatmentDeleteModalLabel">
          <i class="fa-solid fa-trash-alt me-2"></i> Eliminar Tratamiento
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('treatment.delete', ['id' => $treatment->id]) }}" method="post">
        @csrf
        @method('DELETE')  
        <div class="modal-body text-center">
            <i class="fa-solid fa-triangle-exclamation text-danger fs-1 mb-3 d-block"></i>
            <p class="mb-3">¿Quieres eliminar el tratamiento <strong class="text-danger">{{ $treatment->name }}</strong>?</p>
            <div class="alert alert-warning">
              <i class="fa-solid fa-info-circle me-2"></i>
              <small>Esta acción no se puede deshacer.</small>
            </div>
            @if(isset($treatment->appointments_count) && $treatment->appointments_count > 0)
              <div class="alert alert-danger mt-2">
                <i class="fa-solid fa-exclamation-circle me-2"></i>
                <small>¡Advertencia! Este tratamiento se ha usado en <strong>{{ $treatment->appointments_count }}</strong> cita(s). Al eliminarlo, se eliminará el historial asociado.</small>
              </div>
            @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-danger">
            <i class="fa-solid fa-trash-alt me-1"></i> Eliminar tratamiento
          </button>
        </div>
      </form>
    </div>
  </div>
</div>