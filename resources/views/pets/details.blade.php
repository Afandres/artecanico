<!-- Modal Detalles Mascota -->
<div class="modal fade" id="petShowModal{{ $pet->id }}" tabindex="-1" aria-labelledby="petShowModalLabel{{ $pet->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow">

            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="petShowModalLabel{{ $pet->id }}">
                    🐶 Detalles de {{ $pet->name }}
                </h1>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <div class="row g-4">

                    <!-- FOTO -->
                    <div class="col-md-4 text-center">

                        <img src="{{ $pet->profile_photo 
                            ? asset('storage/' . $pet->profile_photo) 
                            : asset('storage/pets/images.png') }}"
                            class="img-fluid rounded shadow-sm border"
                            style="width:220px; height:220px; object-fit:cover;">

                    </div>

                    <!-- DATOS -->
                    <div class="@auth col-md-8 @else col-md-8 offset-md-0 @endauth">

                        <div class="row g-3">

                            <div class="@auth col-md-6 @else col-md-12 @endauth">
                                <div class="border rounded p-3 bg-light h-100">
                                    <small class="text-muted">Nombre</small><br>
                                    <strong>{{ $pet->name }}</strong>
                                </div>
                            </div>

                            @auth
                                
                            <div class="col-md-6">
                                <div class="border rounded p-3 bg-light h-100">
                                    <small class="text-muted">Apodo</small><br>
                                    <strong>{{ $pet->sobriquet ?: 'No registra' }}</strong>
                                </div>
                            </div>
                            

                            <div class="col-md-6">
                                <div class="border rounded p-3 bg-light h-100">
                                    <small class="text-muted">Dueño</small><br>
                                    <strong>{{ $pet->client->name }}</strong>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="border rounded p-3 bg-light h-100">
                                    <small class="text-muted">Teléfono</small><br>
                                    <strong>{{ $pet->client->emergency_phone }}</strong>
                                </div>
                            </div>
                            @endauth
                            <div class="@auth col-md-4 @else col-md-12 @endauth">
                                <div class="border rounded p-3 bg-light">
                                    <small class="text-muted">Raza</small><br>
                                    <strong>{{ $pet->breed->name }}</strong>
                                </div>
                            </div>

                            <div class="@auth col-md-4 @else col-md-6 @endauth">
                                <div class="border rounded p-3 bg-light">
                                    <small class="text-muted">Edad</small><br>
                                    <strong>{{ is_numeric($pet->age_nullable) ? $pet->age_nullable . ' ' . ($pet->age_nullable == 1 ? 'año' : 'años') : 'No registra' }}
                                    </strong>
                                </div>
                            </div>

                            <div class="@auth col-md-4 @else col-md-6 @endauth">
                                <div class="border rounded p-3 bg-light">
                                    <small class="text-muted">Sexo</small><br>
                                    <strong>{{ $pet->gender }}</strong>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- CONDICIONES -->
                <div class="mt-4">
                    <label class="fw-bold d-block mb-2">🩺 Condiciones Médicas</label>

                    <div class="border rounded bg-light p-3"
                        style="white-space:normal; overflow-wrap:anywhere; word-break:break-word;">
                        {{ $pet->medical_condition_nullable }}
                    </div>
                </div>

                <!-- OBSERVACIONES -->
                <div class="mt-4">
                    <label class="fw-bold d-block mb-2">📝 Observaciones</label>

                    <div class="border rounded bg-light p-3"
                        style="white-space:normal; overflow-wrap:anywhere; word-break:break-word;">
                        {{ $pet->observations_nullable }}
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>