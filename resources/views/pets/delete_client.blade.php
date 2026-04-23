<!-- Modal Delete -->
<div class="modal fade" id="clientDeleteModal{{ $pet->client->id }}" tabindex="-1" aria-labelledby="clientDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="clientDeleteModalLabel">Eliminar Cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('client.delete', ['id' => $pet->client->id]) }}" method="post">
        @csrf
        @method('DELETE')  
        <div class="modal-body text-center">
            <i class="fa-solid fa-triangle-exclamation text-danger fs-1 mb-3"></i>

            <p>¿Quieres eliminar a <strong>{{ $pet->client->name }}</strong>?</p>

            <small class="text-danger">
                También se eliminarán todas sus mascotas.
            </small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Confirmar</button>
        </div>
      </form>
    </div>
  </div>
</div>