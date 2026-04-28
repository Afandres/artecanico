<!-- Modal Delete Cliente -->
<div class="modal fade pet-modal" id="clientDeleteModal{{ $pet->client->id }}" tabindex="-1" aria-labelledby="clientDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="clientDeleteModalLabel">
          <i class="fa-solid fa-trash-alt me-2"></i> Eliminar Cliente
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('client.delete', $pet->client->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-body text-center">
            <i class="fa-solid fa-triangle-exclamation text-danger fs-1 mb-3"></i>
            <p class="mb-3">¿Quieres eliminar a <strong class="text-danger">{{ $pet->client->name }}</strong>?</p>
            <div class="alert alert-warning">
              <i class="fa-solid fa-info-circle me-2"></i>
              <small>También se eliminarán todas sus mascotas ({{ $pet->client->pets->count() }} mascota(s)).</small>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-danger" onclick="return confirmDelete(event)">
            <i class="fa-solid fa-trash-alt me-1"></i> Confirmar eliminación
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function confirmDelete(event) {
    event.preventDefault();
    let form = event.target.closest('form');
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>