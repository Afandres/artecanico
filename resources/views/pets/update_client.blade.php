<!-- Modal Update -->
<div class="modal fade" id="clientUpdateModal{{ $pet->client->id }}" tabindex="-1" aria-labelledby="clientUpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="clientUpdateModalLabel">Actualizar Cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('client.update')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $pet->client->id }}">
        <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $pet->client->name }}">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="emergency_phone" class="form-label">Celular</label>
              <input type="text" name="emergency_phone" class="form-control @error('emergency_phone') is-invalid @enderror" value="{{ $pet->client->emergency_phone }}">
              @error('emergency_phone')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
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