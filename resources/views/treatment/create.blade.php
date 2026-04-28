<!-- Modal Create Tratamiento -->
<div class="modal fade treatment-modal" id="treatmentAddModal" tabindex="-1" aria-labelledby="treatmentAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="treatmentAddModalLabel">
          <i class="fa-solid fa-plus-circle me-2"></i> Agregar Nuevo Tratamiento
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('treatment.store') }}" method="post">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name') }}" id="name" placeholder="Ej: Baño medicado, Corte de uñas, Vacunación..." required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" id="description" rows="3" 
                      placeholder="Describe en qué consiste el tratamiento...">{{ old('description') }}</textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fa-solid fa-save me-1"></i> Guardar Tratamiento
          </button>
        </div>
      </form>
    </div>
  </div>
</div>