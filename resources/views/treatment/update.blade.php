<!-- Modal Update -->
<div class="modal fade" id="treatmentUpdateModal{{ $treatment->id }}" tabindex="-1" aria-labelledby="treatmentUpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="treatmentUpdateModalLabel">Actualizar Tratamiento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('treatment.update')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $treatment->id }}">
        <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $treatment->name }}">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Descripción</label>
              <input type="text" name="description" class="form-control" id="description" value="{{ $treatment->description }}">
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