<!-- Modal Delete -->
<div class="modal fade" id="breedDeleteModal{{ $breed->id }}" tabindex="-1" aria-labelledby="breedDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="breedDeleteModalLabel">Eliminar Raza</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('breed.delete', ['id' => $breed->id]) }}" method="post">
        @csrf
        @method('DELETE')  
        <div class="modal-body">
          ¿Quieres eliminar la raza {{ $breed->name }}? Esta acción no se puede deshacer.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>