<style>
/* ============================================
   RAZAS - PELUQUERÍA CANINA
   Versión Optimizada
============================================ */
@import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Quicksand:wght@400;500;600;700&display=swap');

/* ── ESTADÍSTICAS ── */
.breeds-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 22px;
    padding: 0 4px;
}

.breeds-stat-card {
    background: #fff;
    border-radius: 18px;
    padding: 16px 18px;
    border: 1.5px solid #fce7f0;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 4px 14px rgba(196, 79, 128, .07);
    transition: .2s;
}

.breeds-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(196, 79, 128, .13);
}

.breeds-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.breeds-stat-label {
    font-size: 11.5px;
    font-weight: 700;
    color: #b08090;
    text-transform: uppercase;
    letter-spacing: .4px;
    font-family: 'Quicksand', sans-serif;
}

.breeds-stat-num {
    font-family: 'Fredoka One', cursive;
    font-size: 26px;
    color: #3d1a28;
    line-height: 1.1;
}

/* ── TABLA PRINCIPAL ── */
.dataTables_wrapper {
    padding: 15px;
    font-family: 'Quicksand', sans-serif;
    overflow-x: auto;
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 20px;
}

.dataTables_wrapper .dataTables_length select,
.dataTables_wrapper .dataTables_filter input {
    border: 1.5px solid #fce7f0;
    border-radius: 12px;
    padding: 6px 12px;
    font-family: 'Quicksand', sans-serif;
}

.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #c44f80;
    outline: none;
    box-shadow: 0 0 0 2px rgba(196, 79, 128, .2);
}

table.dataTable {
    border-collapse: separate;
    border-spacing: 0 8px;
    width: 100% !important;
}

table.dataTable thead th {
    background: linear-gradient(135deg, #fff8fb, #fff);
    border-bottom: 2px solid #fce7f0 !important;
    font-family: 'Quicksand', cursive;
    font-size: 14px;
    color: #3d1a28;
    padding: 15px 12px;
}

table.dataTable tbody td {
    background: #fff;
    border-top: none;
    padding: 12px;
    vertical-align: middle;
}

table.dataTable tbody tr:first-child td {
    border-top: 1.5px solid #fce7f0;
}

table.dataTable tbody tr:hover td {
    background: #fff5f9;
}

/* Botones de acción */
.breed-btn {
    border: none;
    border-radius: 10px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    transition: all .2s;
    margin: 2px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.breed-btn-edit {
    background: linear-gradient(135deg, #f48fba, #c44f80);
    color: white;
}

.breed-btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(196, 79, 128, .3);
    color: white;
}

.breed-btn-delete {
    background: linear-gradient(135deg, #f5a5a5, #e07070);
    color: white;
}

.breed-btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(224, 112, 112, .3);
    color: white;
}

.breed-btn-add {
    background: linear-gradient(135deg, #48bb78, #2f855a);
    color: white;
    padding: 8px 16px;
    font-size: 14px;
}

.breed-btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(72, 187, 120, .3);
    color: white;
}

/* ── MODALES ── */
.breed-modal .modal-content {
    border: none;
    border-radius: 24px;
    box-shadow: 0 24px 60px rgba(196, 79, 128, .18);
    font-family: 'Quicksand', sans-serif;
    overflow: hidden;
}

.breed-modal .modal-header {
    background: linear-gradient(90deg, #fff8fb, #fff);
    border-bottom: 2px solid #fce7f0;
    padding: 20px 24px;
}

.breed-modal .modal-title {
    font-family: 'Fredoka One', cursive;
    font-size: 22px;
    color: #3d1a28;
}

.breed-modal .modal-body {
    padding: 24px;
    max-height: 60vh;
    overflow-y: auto;
    overflow-x: hidden;
}

.breed-modal .modal-footer {
    background: #fff8fb;
    border-top: 1.5px solid #fce7f0;
    padding: 16px 24px;
}

/* Scroll personalizado solo vertical */
.breed-modal .modal-body::-webkit-scrollbar {
    width: 6px;
    height: 0;
}

.breed-modal .modal-body::-webkit-scrollbar-track {
    background: #fce7f0;
    border-radius: 10px;
}

.breed-modal .modal-body::-webkit-scrollbar-thumb {
    background: #c44f80;
    border-radius: 10px;
}

.breed-modal .modal-body::-webkit-scrollbar-thumb:hover {
    background: #a03a60;
}

/* Formularios en modales */
.breed-modal .form-label {
    font-weight: 700;
    color: #5a2a3a;
    font-size: 13px;
    margin-bottom: 8px;
    display: block;
}

.breed-modal .form-control,
.breed-modal .form-select {
    border: 1.5px solid #fce7f0;
    border-radius: 12px;
    padding: 10px 14px;
    font-family: 'Quicksand', sans-serif;
    transition: all .2s;
    width: 100%;
}

.breed-modal .form-control:focus,
.breed-modal .form-select:focus {
    border-color: #c44f80;
    outline: none;
    box-shadow: 0 0 0 2px rgba(196, 79, 128, .2);
}

/* Badge para tamaño */
.size-badge {
    background: #fce7f0;
    color: #c44f80;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
}

/* Paginación personalizada */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 10px !important;
    margin: 0 3px;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    padding: 6px 12px !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, #f48fba, #c44f80) !important;
    border: none !important;
    color: white !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: linear-gradient(135deg, #fce7f0, #f48fba) !important;
    border: none !important;
    color: #3d1a28 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .breeds-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .breeds-stat-card {
        padding: 12px 14px;
    }

    .breeds-stat-icon {
        width: 36px;
        height: 36px;
        font-size: 16px;
    }

    .breeds-stat-num {
        font-size: 20px;
    }

    .breeds-stat-label {
        font-size: 10px;
    }

    table.dataTable tbody td {
        font-size: 11px;
        padding: 8px;
    }

    .breed-btn {
        padding: 4px 8px;
        font-size: 10px;
    }

    .breed-modal .modal-body {
        padding: 16px;
        max-height: 50vh;
    }

    .breed-modal .modal-header,
    .breed-modal .modal-footer {
        padding: 12px 16px;
    }

    .breed-modal .modal-title {
        font-size: 18px;
    }
}

@media (max-width: 576px) {
    .breeds-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }

    table.dataTable thead th {
        font-size: 11px;
        padding: 8px 4px;
    }

    table.dataTable tbody td {
        font-size: 10px;
        padding: 6px 4px;
    }

    .breed-btn {
        padding: 3px 6px;
        font-size: 9px;
    }
}
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-paw me-2"></i> Razas
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- Stats --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-6">
            <div class="breeds-stats">
                <div class="breeds-stat-card">
                    <div class="breeds-stat-icon" style="background:#fce7f0;">🐕</div>
                    <div>
                        <div class="breeds-stat-label">Total Razas</div>
                        <div class="breeds-stat-num">{{ $breeds->count() }}</div>
                    </div>
                </div>
                <div class="breeds-stat-card">
                    <div class="breeds-stat-icon" style="background:#e8f1ff;">📏</div>
                    <div>
                        <div class="breeds-stat-label">Razas Pequeñas</div>
                        <div class="breeds-stat-num">{{ $breeds->where('size', 'Pequeño')->count() }}</div>
                    </div>
                </div>
                <div class="breeds-stat-card">
                    <div class="breeds-stat-icon" style="background:#fff8e6;">⭐</div>
                    <div>
                        <div class="breeds-stat-label">Razas Medianas</div>
                        <div class="breeds-stat-num">{{ $breeds->where('size', 'Mediano')->count() }}</div>
                    </div>
                </div>
                <div class="breeds-stat-card">
                    <div class="breeds-stat-icon" style="background:#ffe6f0;">🦴</div>
                    <div>
                        <div class="breeds-stat-label">Razas Grandes</div>
                        <div class="breeds-stat-num">{{ $breeds->where('size', 'Grande')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4">
                    <table id="breeds" class="display nowrap w-100">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Tamaño</th>
                                <th>
                                    <button type="button" class="breed-btn breed-btn-add" data-bs-toggle="modal" data-bs-target="#breedAddModal">
                                        <i class="fa-solid fa-plus me-1"></i> Nueva Raza
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breeds as $breed)
                            <tr>
                                <td><strong class="fw-bold">{{ $breed->name }}</strong></td>
                                <td>{{ $breed->description_nullable ?: '—' }}</td>
                                <td><span class="size-badge">{{ $breed->size ?: 'No especificado' }}</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="breed-btn breed-btn-edit" data-bs-toggle="modal" data-bs-target="#breedUpdateModal{{ $breed->id }}">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button type="button" class="breed-btn breed-btn-delete" data-bs-toggle="modal" data-bs-target="#breedDeleteModal{{ $breed->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modales --}}
    @include('breed.create')
    @foreach($breeds as $breed)
        @include('breed.update')
        @include('breed.delete')
    @endforeach
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTable
        if (!$.fn.DataTable.isDataTable('#breeds')) {
            $('#breeds').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                responsive: true,
                pageLength: 10,
                order: [
                    [0, 'asc']
                ]
            });
        }
    });
</script>

@if(session('success'))
    <script>
        Swal.fire({
            title: "{{ session('success') }}",
            icon: "success",
            draggable: true,
            timer: 1500
        });
    </script>
@elseif (session('error'))
    <script>
        Swal.fire({
            title: "{{ session('error') }}",
            icon: "error",
            draggable: true,
            timer: 1500
        });
    </script>
@endif