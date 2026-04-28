<!-- Modal Detalles Mascota -->
<div class="modal fade pet-modal" id="petShowModal{{ $pet->id }}" tabindex="-1" aria-labelledby="petShowModalLabel{{ $pet->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">

            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="petShowModalLabel{{ $pet->id }}">
                    <i class="fa-solid fa-dog me-2"></i> Detalles de {{ $pet->name }}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <div class="row g-4">

                    <!-- FOTO -->
                    <div class="col-md-4 text-center">
                        <div class="pet-detail-photo-wrapper">
                            <img src="{{ $pet->profile_photo 
                                ? asset('storage/' . $pet->profile_photo) 
                                : asset('storage/pets/images.png') }}"
                                class="pet-detail-photo"
                                alt="{{ $pet->name }}">
                            @if($pet->gender == 'Macho')
                                <span class="pet-gender-badge male">🐕 Macho</span>
                            @elseif($pet->gender == 'Hembra')
                                <span class="pet-gender-badge female">🐩 Hembra</span>
                            @endif
                        </div>
                    </div>

                    <!-- DATOS -->
                    <div class="@auth col-md-8 @else col-md-8 offset-md-0 @endauth">
                        <div class="row g-3">

                            <div class="@auth col-md-6 @else col-md-12 @endauth">
                                <div class="info-card">
                                    <div class="info-icon">
                                        <i class="fa-solid fa-tag"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Nombre</small>
                                        <strong class="info-value">{{ $pet->name }}</strong>
                                    </div>
                                </div>
                            </div>

                            @auth
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-icon">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Apodo</small>
                                        <strong class="info-value">{{ $pet->sobriquet ?: '—' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-icon">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Dueño</small>
                                        <strong class="info-value">{{ $pet->client->name }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="info-icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Teléfono</small>
                                        <strong class="info-value">{{ $pet->client->emergency_phone }}</strong>
                                    </div>
                                </div>
                            </div>
                            @endauth

                            <div class="@auth col-md-4 @else col-md-12 @endauth">
                                <div class="info-card">
                                    <div class="info-icon">
                                        <i class="fa-solid fa-tag"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Raza</small>
                                        <strong class="info-value">{{ $pet->breed->name }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="@auth col-md-4 @else col-md-6 @endauth">
                                <div class="info-card">
                                    <div class="info-icon">
                                        <i class="fa-regular fa-calendar"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Edad</small>
                                        <strong class="info-value">{{ is_numeric($pet->age_nullable) ? $pet->age_nullable . ' ' . ($pet->age_nullable == 1 ? 'año' : 'años') : '—' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="@auth col-md-4 @else col-md-6 @endauth">
                                <div class="info-card">
                                    <div class="info-icon">
                                        <i class="fa-solid fa-venus-mars"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Sexo</small>
                                        <strong class="info-value">{{ $pet->gender ?: '—' }}</strong>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- CONDICIONES MÉDICAS -->
                <div class="detail-section mt-4">
                    <div class="section-title">
                        <i class="fa-solid fa-stethoscope me-2"></i> Condiciones Médicas
                    </div>
                    <div class="section-content">
                        {{ $pet->medical_condition_nullable ?: 'No se han registrado condiciones médicas' }}
                    </div>
                </div>

                <!-- OBSERVACIONES -->
                <div class="detail-section mt-4">
                    <div class="section-title">
                        <i class="fa-solid fa-pen me-2"></i> Observaciones
                    </div>
                    <div class="section-content">
                        {{ $pet->observations_nullable ?: 'No se han registrado observaciones' }}
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa-solid fa-times me-1"></i> Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<style>
/* Estilos específicos para el modal de detalles */
.pet-modal .pet-detail-photo-wrapper {
    position: relative;
    display: inline-block;
}

.pet-modal .pet-detail-photo {
    width: 220px;
    height: 220px;
    object-fit: cover;
    border-radius: 20px;
    border: 3px solid #fce7f0;
    box-shadow: 0 8px 20px rgba(196, 79, 128, .15);
    transition: transform 0.2s;
}

.pet-modal .pet-detail-photo:hover {
    transform: scale(1.02);
}

.pet-modal .pet-gender-badge {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.pet-modal .pet-gender-badge.male {
    background: linear-gradient(135deg, #a5d6f5, #70b8e0);
    color: white;
}

.pet-modal .pet-gender-badge.female {
    background: linear-gradient(135deg, #f48fba, #c44f80);
    color: white;
}

/* Tarjetas de información */
.pet-modal .info-card {
    background: linear-gradient(135deg, #fff8fb, #fff);
    border: 1.5px solid #fce7f0;
    border-radius: 16px;
    padding: 12px 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.2s;
    height: 100%;
}

.pet-modal .info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(196, 79, 128, .1);
}

.pet-modal .info-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #fce7f0, #f48fba);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #c44f80;
    font-size: 18px;
}

.pet-modal .info-content {
    flex: 1;
}

.pet-modal .info-label {
    font-size: 11px;
    font-weight: 700;
    color: #b08090;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
}

.pet-modal .info-value {
    font-size: 14px;
    color: #3d1a28;
    display: block;
    margin-top: 2px;
}

/* Secciones de condiciones y observaciones */
.pet-modal .detail-section {
    margin-top: 20px;
}

.pet-modal .section-title {
    font-family: 'Fredoka One', cursive;
    font-size: 16px;
    color: #3d1a28;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 2px solid #fce7f0;
}

.pet-modal .section-content {
    background: linear-gradient(135deg, #fff8fb, #fff);
    border: 1.5px solid #fce7f0;
    border-radius: 16px;
    padding: 15px;
    font-size: 13px;
    line-height: 1.5;
    color: #4a5568;
    white-space: normal;
    overflow-wrap: anywhere;
    word-break: break-word;
    min-height: 80px;
}

/* Responsive */
@media (max-width: 768px) {
    .pet-modal .pet-detail-photo {
        width: 150px;
        height: 150px;
    }
    
    .pet-modal .info-card {
        padding: 10px 12px;
    }
    
    .pet-modal .info-icon {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
    
    .pet-modal .info-value {
        font-size: 12px;
    }
    
    .pet-modal .section-title {
        font-size: 14px;
    }
    
    .pet-modal .section-content {
        font-size: 12px;
        padding: 12px;
    }
}

@media (max-width: 576px) {
    .pet-modal .modal-body {
        padding: 16px;
    }
    
    .pet-modal .row.g-4 {
        --bs-gutter-y: 1rem;
    }
    
    .pet-modal .pet-detail-photo {
        width: 120px;
        height: 120px;
        margin-bottom: 15px;
    }
}
</style>