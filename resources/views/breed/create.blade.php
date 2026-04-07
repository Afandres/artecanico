<!-- Modal Create -->
<div class="modal fade" id="breedAddModal" tabindex="-1" aria-labelledby="breedAddModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="breedAddModalLabel">Agregar Raza</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('breed.store') }}" method="post">
      @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name" placeholder="Nombre de la raza">
            @error('name')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <input type="text" name="description" class="form-control" id="description" placeholder="Descripción de la raza">
          </div>
          <div class="mb-3">
            <label for="size" class="form-label">Tamaño</label>
            <input type="text" name="size" class="form-control @error('size') is-invalid @enderror" value="{{ old('size') }}" id="size" placeholder="Tamaño de la raza">
            @error('size')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="averageGroomingTime" class="form-label">Tiempo de arreglo (Minutos)</label>
            <input type="number" name="averageGroomingTime" class="form-control @error('averageGroomingTime') is-invalid @enderror" value="{{ old('averageGroomingTime') }}" id="averageGroomingTime" placeholder="Tiempo de arreglo de la raza" step="1" min="0">
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