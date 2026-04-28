<!-- Modal Create Raza -->
<div class="modal fade breed-modal" id="breedAddModal" tabindex="-1" aria-labelledby="breedAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="breedAddModalLabel">
          <i class="fa-solid fa-plus-circle me-2"></i> Agregar Nueva Raza
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('breed.store') }}" method="post">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name" placeholder="Ej: Labrador Retriever" required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" id="description" rows="3" placeholder="Describe las características de la raza...">{{ old('description') }}</textarea>
          </div>
          <div class="mb-3">
            <label for="size" class="form-label">Tamaño <span class="text-danger">*</span></label>
            <select name="size" class="form-select @error('size') is-invalid @enderror" id="size" required>
              <option value="">Selecciona un tamaño</option>
              <option value="Pequeño" {{ old('size') == 'Pequeño' ? 'selected' : '' }}>🐕 Pequeño (hasta 10 kg)</option>
              <option value="Mediano" {{ old('size') == 'Mediano' ? 'selected' : '' }}>🐕‍🦺 Mediano (10-25 kg)</option>
              <option value="Grande" {{ old('size') == 'Grande' ? 'selected' : '' }}>🦮 Grande (más de 25 kg)</option>
            </select>
            @error('size')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fa-solid fa-save me-1"></i> Guardar Raza
          </button>
        </div>
      </form>
    </div>
  </div>
</div>