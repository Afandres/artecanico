<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tratamientos
        </h2>
    </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table id="treatments" class="display nowrap">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>
                                    <button type="button" class="btn btn_success" data-bs-toggle="modal" data-bs-target="#treatmentAddModal">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($treatments as $treatment)
                            <tr>
                                <td>{{ $treatment->name }}</td>
                                <td>{{ $treatment->description_nullable }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#treatmentUpdateModal{{ $treatment->id }}">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    @include('treatment.update')
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#treatmentDeleteModal{{ $treatment->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    @include('treatment.delete')
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('treatment.create')
</x-app-layout>
@if(session('success'))
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