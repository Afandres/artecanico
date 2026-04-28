<!-- Modal Delete Mascota -->
<div class="modal fade pet-modal" id="petDeleteModal{{ $pet->id }}" tabindex="-1" aria-labelledby="petDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="petDeleteModalLabel">
          <i class="fa-solid fa-trash-alt me-2"></i> Eliminar Mascota
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('pet.delete', ['id' => $pet->id]) }}" method="post">
        @csrf
        @method('DELETE')  
        <div class="modal-body text-center">
            <i class="fa-solid fa-triangle-exclamation text-danger fs-1 mb-3 d-block"></i>
            
            <p class="mb-3">¿Quieres eliminar a <strong class="text-danger">{{ $pet->name }} @if($pet->sobriquet) ({{ $pet->sobriquet }}) @endif</strong>?</p>
            
            <div class="alert alert-warning">
              <i class="fa-solid fa-info-circle me-2"></i>
              <small>Esta acción no se puede deshacer.</small>
            </div>

            @if($pet->appointments->count() > 0)
              <div class="alert alert-danger mt-2">
                <i class="fa-solid fa-exclamation-circle me-2"></i>
                <small>¡Advertencia! Esta mascota tiene <strong>{{ $pet->appointments->count() }}</strong> cita(s) registrada(s).</small>
              </div>
            @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-danger">
            <i class="fa-solid fa-trash-alt me-1"></i> Eliminar mascota
          </button>
        </div>
      </form>
    </div>
  </div>
</div>