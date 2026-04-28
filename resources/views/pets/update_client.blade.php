<!-- Modal Update Cliente -->
<div class="modal fade pet-modal" id="clientUpdateModal{{ $pet->client->id }}" tabindex="-1" aria-labelledby="clientUpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="clientUpdateModalLabel">
          <i class="fa-solid fa-user-edit me-2"></i> Actualizar Cliente
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('client.update') }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $pet->client->id }}">
        <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" value="{{ $pet->client->name }}" required>
            </div>
            <div class="mb-3">
              <label for="emergency_phone" class="form-label">Celular <span class="text-danger">*</span></label>
              <input type="tel" name="emergency_phone" class="form-control" value="{{ $pet->client->emergency_phone }}" required>
              <small class="text-muted">Formato: 10 dígitos sin el +57</small>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fa-solid fa-save me-1"></i> Guardar cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>