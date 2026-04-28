<style>
    /* ============================================
   MASCOTAS - PELUQUERÍA CANINA
   Versión Optimizada
============================================ */
    @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Quicksand:wght@400;500;600;700&display=swap');

    /* ── ESTADÍSTICAS ── */
    .pets-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 22px;
        padding: 0 4px;
    }

    .pets-stat-card {
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

    .pets-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(196, 79, 128, .13);
    }

    .pets-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .pets-stat-label {
        font-size: 11.5px;
        font-weight: 700;
        color: #b08090;
        text-transform: uppercase;
        letter-spacing: .4px;
        font-family: 'Quicksand', sans-serif;
    }

    .pets-stat-num {
        font-family: 'Fredoka One', cursive;
        font-size: 26px;
        color: #3d1a28;
        line-height: 1.1;
    }

.premium-tooltip .tooltip-inner{
    background: linear-gradient(135deg, #111827, #1f2937);
    color: #fff;
    font-weight: 600;
    font-size: 13px;
    padding: 8px 14px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,.18);
    letter-spacing: .2px;
}

.premium-tooltip.bs-tooltip-top .tooltip-arrow::before{
    border-top-color:#1f2937 !important;
}

.premium-tooltip.bs-tooltip-bottom .tooltip-arrow::before{
    border-bottom-color:#1f2937 !important;
}

.premium-tooltip.bs-tooltip-start .tooltip-arrow::before{
    border-left-color:#1f2937 !important;
}

.premium-tooltip.bs-tooltip-end .tooltip-arrow::before{
    border-right-color:#1f2937 !important;
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

    /* Imagen en tabla */
    .pet-table-img {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #fce7f0;
        transition: .2s;
    }

    .pet-table-img:hover {
        transform: scale(1.1);
        border-color: #c44f80;
    }

    /* Botones de acción */
    .pet-btn {
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

    .pet-btn-edit {
        background: linear-gradient(135deg, #f48fba, #c44f80);
        color: white;
    }

    .pet-btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(196, 79, 128, .3);
        color: white;
    }

    .pet-btn-delete {
        background: linear-gradient(135deg, #f5a5a5, #e07070);
        color: white;
    }

    .pet-btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(224, 112, 112, .3);
        color: white;
    }

    .pet-btn-view {
        background: linear-gradient(135deg, #a5d6f5, #70b8e0);
        color: white;
    }

    .pet-btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(112, 184, 224, .3);
        color: white;
    }

    .pet-btn-add {
        background: linear-gradient(135deg, #48bb78, #2f855a);
        color: white;
        padding: 8px 16px;
        font-size: 14px;
    }

    .pet-btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(72, 187, 120, .3);
        color: white;
    }

    /* ── MODALES ── */
    .pet-modal .modal-content {
        border: none;
        border-radius: 24px;
        box-shadow: 0 24px 60px rgba(196, 79, 128, .18);
        font-family: 'Quicksand', sans-serif;
        overflow: hidden;
    }

    .pet-modal .modal-header {
        background: linear-gradient(90deg, #fff8fb, #fff);
        border-bottom: 2px solid #fce7f0;
        padding: 20px 24px;
    }

    .pet-modal .modal-title {
        font-family: 'Fredoka One', cursive;
        font-size: 22px;
        color: #3d1a28;
    }

    .pet-modal .modal-body {
        padding: 24px;
        max-height: 60vh;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .pet-modal .modal-footer {
        background: #fff8fb;
        border-top: 1.5px solid #fce7f0;
        padding: 16px 24px;
    }

    /* Scroll personalizado solo vertical */
    .pet-modal .modal-body::-webkit-scrollbar {
        width: 6px;
        height: 0;
    }

    .pet-modal .modal-body::-webkit-scrollbar-track {
        background: #fce7f0;
        border-radius: 10px;
    }

    .pet-modal .modal-body::-webkit-scrollbar-thumb {
        background: #c44f80;
        border-radius: 10px;
    }

    .pet-modal .modal-body::-webkit-scrollbar-thumb:hover {
        background: #a03a60;
    }

    /* Formularios en modales */
    .pet-modal .form-label {
        font-weight: 700;
        color: #5a2a3a;
        font-size: 13px;
        margin-bottom: 8px;
        display: block;
    }

    .pet-modal .form-control,
    .pet-modal .form-select {
        border: 1.5px solid #fce7f0;
        border-radius: 12px;
        padding: 10px 14px;
        font-family: 'Quicksand', sans-serif;
        transition: all .2s;
        width: 100%;
    }

    .pet-modal .form-control:focus,
    .pet-modal .form-select:focus {
        border-color: #c44f80;
        outline: none;
        box-shadow: 0 0 0 2px rgba(196, 79, 128, .2);
    }

    /* Evitar scroll horizontal en inputs */
    .pet-modal .form-control,
    .pet-modal .form-select,
    .pet-modal textarea {
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Preview de imagen */
    .pet-photo-preview {
        width: 150px;
        height: 150px;
        border-radius: 20px;
        object-fit: cover;
        border: 3px solid #fce7f0;
        margin: 10px auto;
        display: block;
        max-width: 100%;
    }

    /* Select2 personalizado */
    .pet-modal .select2-container--default .select2-selection--single {
        border: 1.5px solid #fce7f0;
        border-radius: 12px;
        height: 46px;
        padding: 6px 12px;
    }

    .pet-modal .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 32px;
        color: #4a5568;
        font-family: 'Quicksand', sans-serif;
    }

    .pet-modal .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px;
    }

    .pet-modal .select2-dropdown {
        border: 1.5px solid #fce7f0;
        border-radius: 12px;
    }

    .pet-modal .select2-container {
        width: 100% !important;
    }

    /* Badges para condiciones médicas */
    .medical-badge {
        background: #fce7f0;
        color: #c44f80;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
    }

    /* Offcanvas */
    .offcanvas {
        border-radius: 0 24px 24px 0;
    }

    .offcanvas-header {
        background: linear-gradient(90deg, #fff8fb, #fff);
        border-bottom: 2px solid #fce7f0;
    }

    .offcanvas-title {
        font-family: 'Fredoka One', cursive;
        color: #3d1a28;
    }

    /* Toolbar del dueño */
    .owner-info {
        background: #fff8fb;
        padding: 8px 12px;
        border-radius: 12px;
        font-size: 13px;
    }

    .owner-actions {
        display: flex;
        gap: 5px;
        margin-top: 5px;
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

    /* Prevenir scroll del body cuando el modal está abierto */
    body.modal-open {
        overflow: hidden !important;
        padding-right: 0 !important;
    }

    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-open .modal {
        overflow-x: hidden;
        overflow-y: auto;
    }

    .modal-dialog {
        margin: 1.75rem auto;
    }

    .modal-dialog-centered {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
    }

    /* Prevenir scroll horizontal global */
    html,
    body {
        overflow-x: hidden;
        width: 100%;
        position: relative;
    }

    /* Asegurar que las imágenes no causen scroll horizontal */
    img {
        max-width: 100%;
        height: auto;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .pets-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .pets-stat-card {
            padding: 12px 14px;
        }

        .pets-stat-icon {
            width: 36px;
            height: 36px;
            font-size: 16px;
        }

        .pets-stat-num {
            font-size: 20px;
        }

        .pets-stat-label {
            font-size: 10px;
        }

        .pet-table-img {
            width: 45px;
            height: 45px;
        }

        table.dataTable tbody td {
            font-size: 11px;
            padding: 8px;
        }

        .pet-btn {
            padding: 4px 8px;
            font-size: 10px;
        }

        .pet-modal .modal-body {
            padding: 16px;
            max-height: 50vh;
        }

        .pet-modal .modal-header,
        .pet-modal .modal-footer {
            padding: 12px 16px;
        }

        .pet-modal .modal-title {
            font-size: 18px;
        }

        .pet-photo-preview {
            width: 100px;
            height: 100px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 8px !important;
            font-size: 11px;
        }

        .owner-info {
            font-size: 11px;
            padding: 6px 8px;
        }

        .owner-actions .btn-sm {
            padding: 2px 6px;
            font-size: 10px;
        }
    }

    /* Pantallas muy pequeñas */
    @media (max-width: 576px) {
        .pets-stats {
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

        .pet-btn {
            padding: 3px 6px;
            font-size: 9px;
        }

        .modal-body {
            padding: 12px;
        }
    }

    /* Ajustes para select2 en móviles */
    @media (max-width: 768px) {
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 13px;
        }

        .select2-dropdown {
            font-size: 13px;
        }
    }

    /* Animaciones suaves */
    .modal.fade .modal-dialog {
        transition: transform 0.2s ease-out;
    }

    .modal.show .modal-dialog {
        transform: none;
    }

    /* Mejorar experiencia táctil en móviles */
    @media (hover: none) and (pointer: coarse) {
        .pet-btn:hover {
            transform: none;
        }

        .pet-table-img:hover {
            transform: none;
        }
    }

    /* Estilos para SweetAlert personalizado */
    .pet-modal-swal {
        border-radius: 24px !important;
        padding: 20px !important;
        font-family: 'Quicksand', sans-serif !important;
    }

    .pet-modal-swal .swal2-title {
        font-family: 'Fredoka One', cursive !important;
        color: #3d1a28 !important;
        font-size: 24px !important;
    }

    .pet-modal-swal .swal2-html-container {
        font-family: 'Quicksand', sans-serif !important;
    }

    .pet-modal-swal .swal2-input,
    .pet-modal-swal .swal2-textarea {
        border: 1.5px solid #fce7f0 !important;
        border-radius: 12px !important;
        padding: 10px 14px !important;
        font-family: 'Quicksand', sans-serif !important;
        font-size: 14px !important;
        margin: 0 !important;
        width: 100% !important;
    }

    .pet-modal-swal .swal2-input:focus,
    .pet-modal-swal .swal2-textarea:focus {
        border-color: #c44f80 !important;
        outline: none !important;
        box-shadow: 0 0 0 2px rgba(196, 79, 128, .2) !important;
    }

    .pet-modal-swal .swal2-confirm {
        border-radius: 12px !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
    }

    .pet-modal-swal .swal2-cancel {
        border-radius: 12px !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
    }

    /* Alertas dentro de SweetAlert */
    .pet-modal-swal .alert-warning {
        background: #fff3cd;
        border: 1px solid #ffeeba;
        border-radius: 12px;
        color: #856404;
        font-size: 13px;
        padding: 10px 15px;
        margin-top: 15px;
    }

    /* Labels dentro de SweetAlert */
    .pet-modal-swal .form-label {
        font-weight: 700;
        color: #5a2a3a;
        font-size: 13px;
        margin-bottom: 8px;
        display: block;
        text-align: left;
    }

    /* Eliminar borde gris de las filas de agrupación */
    table.dataTable tr.dtrg-group,
    table.dataTable tr.dtrg-group td,
    table.dataTable tr.dtrg-group th,
    .dataTable tr.dtrg-group,
    #pets tr.dtrg-group {
        background: white !important;
        border: none !important;
        border-bottom: none !important;
    }

    /* Eliminar el borde inferior de las filas de grupo */
    table.dataTable tr.dtrg-group td,
    table.dataTable tr.dtrg-group th {
        border-bottom: none !important;
        box-shadow: none !important;
    }

    /* Quitar cualquier sombra o borde que pueda tener */
    .dtrg-group {
        background: white !important;
    }

    .dtrg-group td,
    .dtrg-group th {
        border: none !important;
        padding: 8px 12px !important;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (auth()->check())
                Mis Mascotas
            @else
                Mis Mascotas
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- Stats --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-6">
            <div class="pets-stats">
                <div class="pets-stat-card">
                    <div class="pets-stat-icon" style="background:#fce7f0;">🐾</div>
                    <div>
                        <div class="pets-stat-label">Total Mascotas</div>
                        <div class="pets-stat-num">{{ $pets->count() }}</div>
                    </div>
                </div>
                <div class="pets-stat-card">
                    <div class="pets-stat-icon" style="background:#e8f1ff;">🐕</div>
                    <div>
                        <div class="pets-stat-label">Perros</div>
                        <div class="pets-stat-num">{{ $pets->where('type', 'Perro')->count() ?? $pets->count() }}</div>
                    </div>
                </div>
                <div class="pets-stat-card">
                    <div class="pets-stat-icon" style="background:#fff8e6;">⭐</div>
                    <div>
                        <div class="pets-stat-label">Machos</div>
                        <div class="pets-stat-num">{{ $pets->where('gender', 'Macho')->count() }}</div>
                    </div>
                </div>
                <div class="pets-stat-card">
                    <div class="pets-stat-icon" style="background:#ffe6f0;">🌸</div>
                    <div>
                        <div class="pets-stat-label">Hembras</div>
                        <div class="pets-stat-num">{{ $pets->where('gender', 'Hembra')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4">
                    <table id="pets" class="display nowrap w-100" data-auth="{{ auth()->check() ? 1 : 0 }}">
                        <thead>
                            <tr>
                                @auth
                                    <th>Dueño</th>
                                @endauth
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Raza</th>
                                <th>Edad</th>
                                <th>Sexo</th>
                                <th>Cond. Médicas</th>
                                <th>Observaciones</th>
                                <th>
                                    @auth
                                        <button type="button" class="pet-btn pet-btn-add"
                                            onclick="fromAppointments = false" data-bs-toggle="offcanvas"
                                            data-bs-target="#petCanvas">
                                            <i class="fa-solid fa-plus me-1"></i> Nueva Mascota
                                        </button>
                                    @else
                                        Acciones
                                    @endauth
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pets as $pet)
                                <tr>
                                    @auth
                                        <td class="align-middle">
                                            <div class="owner-info d-flex justify-content-between align-items-center gap-2">
                                                <div class="fw-bold">{{ $pet->client->name }} -
                                                    {{ $pet->client->emergency_phone }}</div>
                                                <div class="owner-actions">
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                        onclick="editClient({{ $pet->client->id }}, '{{ $pet->client->name }}', '{{ $pet->client->emergency_phone }}')">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="deleteClient({{ $pet->client->id }}, '{{ $pet->client->name }}', {{ $pet->client->pets->count() }})">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    @endauth
                                    <td class="text-center">
                                        <img class="pet-table-img"
                                            src="{{ $pet->profile_photo ? asset('storage/' . $pet->profile_photo) : asset('storage/pets/images.png') }}"
                                            alt="{{ $pet->name }}">
                                    </td>
                                    <td class="fw-bold">{{ $pet->name }} @auth<small
                                            class="text-muted">({{ $pet->sobriquet }})</small>@endauth
                                    </td>
                                    <td>{{ $pet->breed->name }}</td>
                                    <td>{{ is_numeric($pet->age_nullable) ? $pet->age_nullable . ' ' . ($pet->age_nullable == 1 ? 'año' : 'años') : 'No registra' }}
                                    </td>
                                    <td>
                                        <span class="medical-badge">{{ $pet->gender }}</span>
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($pet->medical_condition_nullable, 20, '...') }}
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($pet->observations_nullable, 20, '...') }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @auth
                                                <button type="button" class="pet-btn pet-btn-edit" data-bs-toggle="modal"
                                                    data-bs-target="#petUpdateModal{{ $pet->id }}">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                                @include('pets.update')
                                                <button type="button" class="pet-btn pet-btn-delete" data-bs-toggle="modal"
                                                    data-bs-target="#petDeleteModal{{ $pet->id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                @include('pets.delete')
                                            @endauth
                                            <button type="button" class="pet-btn pet-btn-view" data-bs-toggle="modal"
                                                data-bs-target="#petShowModal{{ $pet->id }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            @include('pets.details')
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
    @include('pets.create')
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (!$.fn.DataTable.isDataTable('#pets')) {
            $('#pets').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                responsive: true,
                pageLength: 10,
                order: [
                    [2, 'asc']
                ]
            });
        }

        // =====================================
        // ABRIR MODAL
        // =====================================
        $('#petCanvas').on('shown.bs.offcanvas', function() {
            // SELECT RAZA
            if (!$('#breed_id').hasClass("select2-hidden-accessible")) {
                $('#breed_id').select2({
                    placeholder: '🐕 Selecciona una raza',
                    dropdownParent: $('#petCanvas'),
                    width: '100%',
                    ajax: {
                        url: '{{ route('pet.breeds') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term || ''
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.name
                                }))
                            };
                        }
                    }
                });
            }

            // SELECT DUEÑO
            if (!$('#client_id').hasClass("select2-hidden-accessible")) {
                $('#client_id').select2({
                    placeholder: '👤 Buscar dueño existente o crear nuevo',
                    dropdownParent: $('#petCanvas'),
                    width: '100%',
                    tags: true,
                    createTag: function(params) {
                        let term = $.trim(params.term);
                        if (term === '') return null;
                        return {
                            id: term,
                            text: term,
                            newTag: true
                        };
                    },
                    ajax: {
                        url: '{{ route('pet.clients') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term || ''
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.name
                                }))
                            };
                        }
                    }
                });
            }
        });

        // =====================================
        // MOSTRAR CELULAR SI ES CLIENTE NUEVO
        // =====================================
        $(document).on('select2:select', '#client_id', function(e) {
            let data = e.params.data;
            if (data.newTag || isNaN(data.id)) {
                $('#phone_container').fadeIn();
            } else {
                $('#phone_container').fadeOut();
                $('#emergency_phone').val('');
            }
        });

        $(document).on('select2:close', '#client_id', function() {
            let data = $(this).select2('data');
            if (!data.length) return;
            let selected = data[0];
            if (selected.newTag || isNaN(selected.id)) {
                $('#phone_container').fadeIn();
            }
        });

        // =====================================
        // GUARDAR MASCOTA
        // =====================================
        $('#createPetForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            Swal.fire({
                title: 'Guardando...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route('pet.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    if (response.new_client) {
                        let phone = response.phone;
                        let code = response.access_code;
                        let mensaje =
                            `Hola 👋 Bienvenido a Arte Canino 🐶✨ Tu código para consultar tus citas es: ${code}`;
                        let url =
                            `https://wa.me/57${phone}?text=${encodeURIComponent(mensaje)}`;
                        window.open(url, '_blank');
                    }

                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    $('.error-text').remove();
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            $('[name="' + field + '"]').after(
                                '<small class="text-danger error-text d-block mt-1">' +
                                errors[field][0] + '</small>'
                            );
                        }
                        Swal.close();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al guardar',
                            text: 'Por favor intenta nuevamente'
                        });
                    }
                }
            });
        });

        // =====================================
        // LIMPIAR MODAL AL CERRAR
        // =====================================
        $('#petCanvas').on('hidden.bs.offcanvas', function() {
            $('#createPetForm')[0].reset();
            $('#client_id').val(null).trigger('change');
            $('#breed_id').val(null).trigger('change');
            $('#phone_container').hide();
            $('.error-text').remove();
            $('.previewImg').attr('src', '{{ asset('storage/pets/images.png') }}');
        });

        // =====================================
        // PREVIEW DE IMAGEN
        // =====================================
        $(document).on('change', '.profile-photo-input', function(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            if (!file) return;
            reader.onload = function(event) {
                $(e.target).closest('.modal, .offcanvas').find('.previewImg').attr('src', event
                    .target.result);
            };
            reader.readAsDataURL(file);
        });

        // Inicializar select2 en todos los modales al abrirse
        $(document).on('shown.bs.modal', '.modal', function() {
            $(this).find('select.breed-select').each(function() {
                if (!$(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2({
                        dropdownParent: $(this).closest('.modal'),
                        width: '100%',
                        placeholder: 'Selecciona una opción'
                    });
                }
            });
        });

        // Manejar envío de formularios de actualización de cliente
        $(document).on('submit', 'form[action="{{ route('client.update') }}"]', function(e) {
            e.preventDefault();
            let form = $(this);

            Swal.fire({
                title: 'Actualizando...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message ||
                            'Cliente actualizado correctamente',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    Swal.close();
                    let message = 'Error al actualizar';
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors).flat()[0];
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message
                    });
                }
            });
        });
        // =====================================
        // EDITAR CLIENTE CON SWEETALERT
        // =====================================
        window.editClient = function(id, name, phone) {
            Swal.fire({
                title: 'Editar Cliente',
                html: `
            <div class="text-start">
                <div class="mb-3">
                    <label class="form-label text-start d-block fw-bold" style="color: #5a2a3a;">Nombre completo</label>
                    <input id="client_name" class="swal2-input form-control" value="${escapeHtml(name)}" placeholder="Nombre del cliente" style="width: 100%;">
                </div>
                <div class="mb-3">
                    <label class="form-label text-start d-block fw-bold" style="color: #5a2a3a;">Número de celular</label>
                    <input id="client_phone" class="swal2-input form-control" value="${escapeHtml(phone)}" placeholder="Ej: 3001234567" style="width: 100%;">
                    <small class="text-muted">10 dígitos sin el +57</small>
                </div>
            </div>
        `,
                showCancelButton: true,
                confirmButtonText: 'Guardar cambios',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'pet-modal-swal'
                },
                preConfirm: () => {
                    const name = document.getElementById('client_name').value;
                    const phone = document.getElementById('client_phone').value;

                    if (!name || !phone) {
                        Swal.showValidationMessage('Por favor completa todos los campos');
                        return false;
                    }

                    if (!/^\d{10}$/.test(phone)) {
                        Swal.showValidationMessage('El celular debe tener 10 dígitos');
                        return false;
                    }

                    // Crear formulario para enviar
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('client.update') }}';

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'id';
                    idInput.value = id;
                    form.appendChild(idInput);

                    const nameInput = document.createElement('input');
                    nameInput.type = 'hidden';
                    nameInput.name = 'name';
                    nameInput.value = name;
                    form.appendChild(nameInput);

                    const phoneInput = document.createElement('input');
                    phoneInput.type = 'hidden';
                    phoneInput.name = 'emergency_phone';
                    phoneInput.value = phone;
                    form.appendChild(phoneInput);

                    document.body.appendChild(form);
                    form.submit();

                    return true;
                }
            });
        };

        // =====================================
        // ELIMINAR CLIENTE CON SWEETALERT
        // =====================================
        window.deleteClient = function(id, name, petsCount) {
            Swal.fire({
                title: '¿Eliminar cliente?',
                html: `
            <div class="text-center">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 48px; color: #e07070;"></i>
                <p class="mt-3">¿Quieres eliminar a <strong class="text-danger">${escapeHtml(name)}</strong>?</p>
                <div class="alert alert-warning">
                    <i class="fa-solid fa-info-circle me-2"></i>
                    También se eliminarán todas sus mascotas (${petsCount} mascota(s)).
                </div>
            </div>
        `,
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'pet-modal-swal'
                },
                preConfirm: () => {

                    const url = '/pets/client/delete/' + id;

                    // Crear formulario para eliminar
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    document.body.appendChild(form);
                    form.submit();

                    return true;
                }
            });
        };

        // Función para escapar HTML y evitar XSS
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
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
