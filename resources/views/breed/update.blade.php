<!-- Modal Update Raza -->
<div class="modal fade breed-modal" id="breedUpdateModal{{ $breed->id }}" tabindex="-1" aria-labelledby="breedUpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="breedUpdateModalLabel">
          <i class="fa-solid fa-edit me-2"></i> Actualizar Raza
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('breed.update')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $breed->id }}">
        <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $breed->name }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Descripción</label>
              <textarea name="description" class="form-control" id="description" rows="3">{{ $breed->description }}</textarea>
            </div>
            <div class="mb-3">
              <label for="size" class="form-label">Tamaño <span class="text-danger">*</span></label>
              <select name="size" class="form-select @error('size') is-invalid @enderror" id="size" required>
                <option value="">Selecciona un tamaño</option>
                <option value="Pequeño" {{ $breed->size == 'Pequeño' ? 'selected' : '' }}>🐕 Pequeño (hasta 10 kg)</option>
                <option value="Mediano" {{ $breed->size == 'Mediano' ? 'selected' : '' }}>🐕‍🦺 Mediano (10-25 kg)</option>
                <option value="Grande" {{ $breed->size == 'Grande' ? 'selected' : '' }}>🦮 Grande (más de 25 kg)</option>
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
            <i class="fa-solid fa-save me-1"></i> Guardar cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>