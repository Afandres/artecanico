<!-- Modal Create -->
<div class="modal fade" id="expenseAddModal" tabindex="-1" aria-labelledby="expenseAddModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="expenseAddModalLabel">Agregar Gasto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('report.expenses.store') }}" method="post">
      @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" id="name" placeholder="Descripción del gasto" autocomplete="off">
            @error('description')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="amount" class="form-label">Precio</label>
            <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" id="amount" placeholder="Valor del gasto">
            @error('amount')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="expense_date" class="form-label">Fecha</label>
            <input type="date" name="expense_date" class="form-control @error('expense_date') is-invalid @enderror" value="{{ old('expense_date') }}" id="expense_date" placeholder="Fecha del gasto">
            @error('expense_date')
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

