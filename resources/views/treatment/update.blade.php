<!-- Modal Update Tratamiento -->
<div class="modal fade treatment-modal" id="treatmentUpdateModal{{ $treatment->id }}" tabindex="-1" aria-labelledby="treatmentUpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="treatmentUpdateModalLabel">
          <i class="fa-solid fa-edit me-2"></i> Actualizar Tratamiento
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('treatment.update')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $treatment->id }}">
        <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                     id="name" value="{{ $treatment->name }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Descripción</label>
              <textarea name="description" class="form-control" id="description" rows="3">{{ $treatment->description }}</textarea>
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