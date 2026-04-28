<!-- Modal Delete Raza -->
<div class="modal fade breed-modal" id="breedDeleteModal{{ $breed->id }}" tabindex="-1" aria-labelledby="breedDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="breedDeleteModalLabel">
          <i class="fa-solid fa-trash-alt me-2"></i> Eliminar Raza
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('breed.delete', ['id' => $breed->id]) }}" method="post">
        @csrf
        @method('DELETE')  
        <div class="modal-body text-center">
            <i class="fa-solid fa-triangle-exclamation text-danger fs-1 mb-3 d-block"></i>
            <p class="mb-3">¿Quieres eliminar la raza <strong class="text-danger">{{ $breed->name }}</strong>?</p>
            <div class="alert alert-warning">
              <i class="fa-solid fa-info-circle me-2"></i>
              <small>Esta acción no se puede deshacer.</small>
            </div>
            @if($breed->pets->count() > 0)
              <div class="alert alert-danger mt-2">
                <i class="fa-solid fa-exclamation-circle me-2"></i>
                <small>¡Advertencia! Esta raza tiene <strong>{{ $breed->pets->count() }}</strong> mascota(s) asociada(s). Al eliminarla, las mascotas quedarán sin raza asignada.</small>
              </div>
            @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-danger">
            <i class="fa-solid fa-trash-alt me-1"></i> Eliminar raza
          </button>
        </div>
      </form>
    </div>
  </div>
</div>