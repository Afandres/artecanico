<!-- Modal Delete -->
<div class="modal fade" id="expenseDeleteModal{{ $expense->id }}" tabindex="-1" aria-labelledby="expenseDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="expenseDeleteModalLabel">Eliminar Gasto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('report.expenses.delete', ['id' => $expense->id]) }}" method="post">
        @csrf
        @method('DELETE')  
        <div class="modal-body text-center">
          <i class="fa-solid fa-triangle-exclamation text-danger fs-1 mb-3"></i>
          <p>¿Quieres eliminar el gasto <strong> {{ $expense->description }}</strong>?</p>
          <small class="text-danger">
              Esta acción no se puede deshacer.
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