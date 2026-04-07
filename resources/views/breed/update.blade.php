<!-- Modal Update -->
<div class="modal fade" id="breedUpdateModal{{ $breed->id }}" tabindex="-1" aria-labelledby="breedUpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="breedUpdateModalLabel">Actualizar Raza</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('breed.update')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $breed->id }}">
        <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $breed->name }}">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Descripción</label>
              <input type="text" name="description" class="form-control" id="description" value="{{ $breed->description }}">
            </div>
            <div class="mb-3">
              <label for="size" class="form-label">Tamaño</label>
              <input type="text" name="size" class="form-control @error('size') is-invalid @enderror" id="size" value="{{ $breed->size }}">
              @error('size')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="averageGroomingTime" class="form-label">Tiempo de arreglo</label>
              <input type="number" name="averageGroomingTime" class="form-control @error('averageGroomingTime') is-invalid @enderror" id="averageGroomingTime" value="{{ $breed->average_grooming_time }}" step="1" min="0">
              @error('averageGroomingTime')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>