<!-- Modal Create -->
<div class="modal fade" id="treatmentAddModal" tabindex="-1" aria-labelledby="treatmentAddModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="treatmentAddModalLabel">Agregar Tratamiento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('treatment.store') }}" method="post">
      @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name" placeholder="Nombre del tratamiento">
            @error('name')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <input type="text" name="description" class="form-control" id="description" placeholder="Descripción del tratamiento">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>