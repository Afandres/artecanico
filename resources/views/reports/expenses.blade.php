<x-app-layout>
    <h2 class="page-title font-semibold text-xl text-gray-800 leading-tight">Gastos</h2>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table id="expenses" class="display nowrap">
                    <thead>
                        <tr>
                            <td>Descripción</td>
                            <td>Precio</td>
                            <td>Fecha</td>
                            <td>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#expenseAddModal">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->description }}</td>
                                <td>$ {{ number_format($expense->amount, 0, ',', '.') }}</td>
                                <td>{{ $expense->expense_date }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#expenseUpdateModal{{ $expense->id }}">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    @include('reports.expenses.update')
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#expenseDeleteModal{{ $expense->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    @include('reports.expenses.delete')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('reports.expenses.create')
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const amount = document.querySelector('#expenseAddModal #amount');
        const form = document.querySelector('#expenseAddModal form');

        if (!amount || !form) return;

        // Formatear mientras escribe
        amount.addEventListener('input', function() {

            let value = this.value.replace(/\D/g, '');

            if (value === '') {
                this.value = '';
                return;
            }

            this.value = new Intl.NumberFormat('es-CO').format(value);
        });

        // Antes de enviar limpiar puntos
        form.addEventListener('submit', function() {
            amount.value = amount.value.replace(/\./g, '');
        });

        const moneyInputs = document.querySelectorAll('.money-input');

        moneyInputs.forEach(input => {

            // Formatear mientras escribe
            input.addEventListener('input', function() {

                let value = this.value.replace(/\D/g, '');

                if (value === '') {
                    this.value = '';
                    return;
                }

                this.value = new Intl.NumberFormat('es-CO').format(value);
            });

            // Limpiar antes de enviar
            input.closest('form').addEventListener('submit', function() {
                input.value = input.value.replace(/\./g, '');
            });

        });

    });
</script>
@if (session('success'))
    <script>
        Swal.fire({
            title: "{{ session('success') }}",
            icon: "success",
            draggable: true,
            timer: 1500
        });
    </script>
@elseif(session('error'))
    <script>
        Swal.fire({
            title: "{{ session('error') }}",
            icon: "error",
            draggable: true,
            timer: 1500
        });
    </script>
@endif
