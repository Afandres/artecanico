<!-- Offcanvas Crear Mascota -->
<div class="offcanvas offcanvas-end pet-offcanvas" tabindex="-1" id="petCanvas" aria-labelledby="petCanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="petCanvasLabel">
      <i class="fa-solid fa-paw me-2"></i> Crear nueva mascota
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body">
    <form id="createPetForm" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="client_id" class="form-label">
          <i class="fa-solid fa-user me-1"></i> Cliente/Dueño <span class="text-danger">*</span>
        </label>
        <select id="client_id" name="client_id" class="form-select" required>
          <option value="">Selecciona un dueño o crea uno nuevo</option>
        </select>
        <div class="invalid-feedback"></div>
        <small class="text-muted">Puedes buscar un dueño existente o escribir un nombre nuevo para crearlo</small>
      </div>

      <div class="mb-3" id="phone_container" style="display:none;">
        <label for="emergency_phone" class="form-label">
          <i class="fa-solid fa-phone me-1"></i> Celular <span class="text-danger">*</span>
        </label>
        <input type="tel" name="emergency_phone" id="emergency_phone" class="form-control" placeholder="Ej: 3001234567">
        <small class="text-muted">10 dígitos sin el +57</small>
        <div class="invalid-feedback"></div>
      </div>

      <div class="mb-3">
        <label for="new_pet_name" class="form-label">
          <i class="fa-solid fa-dog me-1"></i> Nombre de la mascota <span class="text-danger">*</span>
        </label>
        <input type="text" id="new_pet_name" name="new_pet_name" class="form-control" placeholder="Ej: Max, Luna, Rocky..." required>
        <small class="text-muted">Puedes agregar el apodo después con un guión: Max - El travieso</small>
        <div class="invalid-feedback"></div>
      </div>

      <div class="mb-3">
        <label for="breed_id" class="form-label">
          <i class="fa-solid fa-tag me-1"></i> Raza <span class="text-danger">*</span>
        </label>
        <select id="breed_id" name="breed_id" class="form-select" required>
          <option value="">Selecciona una raza</option>
        </select>
        <div class="invalid-feedback"></div>
      </div>

      <div class="mb-3">
        <label for="age" class="form-label">
          <i class="fa-regular fa-calendar me-1"></i> Edad (años)
        </label>
        <input type="number" step="0.5" id="age" name="age" class="form-control" placeholder="Ej: 2.5">
        <small class="text-muted">Usa .5 para medios años (ej: 1.5, 2.5)</small>
      </div>

      <div class="mb-3">
        <label for="gender" class="form-label">
          <i class="fa-solid fa-venus-mars me-1"></i> Género <span class="text-danger">*</span>
        </label>
        <select name="gender" id="gender" class="form-select" required>
          <option value="">--- Seleccione el género ---</option>
          <option value="Hembra">🐩 Hembra</option>
          <option value="Macho">🐕 Macho</option>
        </select>
        <div class="invalid-feedback"></div>
      </div>

      <div class="mb-3">
        <label for="medical_condition" class="form-label">
          <i class="fa-solid fa-stethoscope me-1"></i> Condiciones médicas
        </label>
        <input type="text" id="medical_condition" name="medical_condition" class="form-control" placeholder="Ej: Alergias, diabetes, epilepsia...">
        <small class="text-muted">Si tiene alguna condición médica importante, indícala aquí</small>
      </div>

      <div class="mb-3">
        <label for="observations" class="form-label">
          <i class="fa-solid fa-pen me-1"></i> Observaciones
        </label>
        <textarea id="observations" name="observations" class="form-control" rows="2" placeholder="Información adicional sobre la mascota..."></textarea>
      </div>

      <div class="mb-3">
        <label for="profile_photo" class="form-label">
          <i class="fa-solid fa-camera me-1"></i> Foto de perfil
        </label>
        <input type="file" id="profile_photo" name="profile_photo" class="form-control profile-photo-input" accept="image/*">
        <img class="previewImg mt-2" src="{{ asset('storage/pets/images.png') }}" 
             style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; display: none; border: 2px solid #fce7f0;">
        <small class="text-muted d-block mt-1">Formatos aceptados: JPG, PNG. Tamaño máximo: 2MB</small>
      </div>

      <div class="d-grid gap-2 mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">
          <i class="fa-solid fa-times me-1"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-success">
          <i class="fa-solid fa-save me-1"></i> Crear mascota
        </button>
      </div>
    </form>
  </div>
</div>

<style>
/* Offcanvas personalizado */
.pet-offcanvas {
    width: 520px;
    max-width: 100%;
    border-radius: 24px 0 0 24px;
    box-shadow: -5px 0 25px rgba(196, 79, 128, .15);
}

.pet-offcanvas .offcanvas-header {
    background: linear-gradient(90deg, #fff8fb, #fff);
    border-bottom: 2px solid #fce7f0;
    padding: 20px 24px;
}

.pet-offcanvas .offcanvas-title {
    font-family: 'Fredoka One', cursive;
    font-size: 22px;
    color: #3d1a28;
}

.pet-offcanvas .offcanvas-body {
    padding: 24px;
}

/* Formularios */
.pet-offcanvas .form-label {
    font-weight: 700;
    color: #5a2a3a;
    font-size: 13px;
    margin-bottom: 8px;
    display: block;
}

.pet-offcanvas .form-control,
.pet-offcanvas .form-select {
    border: 1.5px solid #fce7f0;
    border-radius: 12px;
    padding: 10px 14px;
    font-family: 'Quicksand', sans-serif;
    transition: all .2s;
    width: 100%;
}

.pet-offcanvas .form-control:focus,
.pet-offcanvas .form-select:focus {
    border-color: #c44f80;
    outline: none;
    box-shadow: 0 0 0 2px rgba(196, 79, 128, .2);
}

.pet-offcanvas .form-control.is-invalid,
.pet-offcanvas .form-select.is-invalid {
    border-color: #dc3545;
    background-image: none;
}

.pet-offcanvas .invalid-feedback {
    font-size: 11px;
    color: #dc3545;
    margin-top: 5px;
}

.pet-offcanvas .text-muted {
    font-size: 11px;
    color: #b08090;
    margin-top: 5px;
    display: block;
}

/* Botones */
.pet-offcanvas .btn {
    border-radius: 12px;
    padding: 10px 16px;
    font-weight: 600;
    font-size: 14px;
    transition: all .2s;
}

.pet-offcanvas .btn-secondary {
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
    border: none;
    color: #475569;
}

.pet-offcanvas .btn-secondary:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #cbd5e1, #94a3b8);
    color: white;
}

.pet-offcanvas .btn-success {
    background: linear-gradient(135deg, #48bb78, #2f855a);
    border: none;
}

.pet-offcanvas .btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(72, 187, 120, .3);
}

/* Preview de imagen */
.pet-offcanvas .previewImg {
    border: 2px solid #fce7f0;
    border-radius: 12px;
    object-fit: cover;
}

/* Select2 dentro del offcanvas */
.pet-offcanvas .select2-container--default .select2-selection--single {
    border: 1.5px solid #fce7f0;
    border-radius: 12px;
    height: 46px;
    padding: 6px 12px;
}

.pet-offcanvas .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 32px;
    color: #4a5568;
    font-family: 'Quicksand', sans-serif;
}

.pet-offcanvas .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 44px;
}

.pet-offcanvas .select2-dropdown {
    border: 1.5px solid #fce7f0;
    border-radius: 12px;
    font-family: 'Quicksand', sans-serif;
}

/* Scroll personalizado */
.pet-offcanvas .offcanvas-body::-webkit-scrollbar {
    width: 6px;
}

.pet-offcanvas .offcanvas-body::-webkit-scrollbar-track {
    background: #fce7f0;
    border-radius: 10px;
}

.pet-offcanvas .offcanvas-body::-webkit-scrollbar-thumb {
    background: #c44f80;
    border-radius: 10px;
}

.pet-offcanvas .offcanvas-body::-webkit-scrollbar-thumb:hover {
    background: #a03a60;
}

/* Responsive */
@media (max-width: 576px) {
    .pet-offcanvas {
        width: 100%;
        border-radius: 24px 0 0 24px;
    }
    
    .pet-offcanvas .offcanvas-header {
        padding: 16px 20px;
    }
    
    .pet-offcanvas .offcanvas-title {
        font-size: 18px;
    }
    
    .pet-offcanvas .offcanvas-body {
        padding: 16px;
    }
}
</style>

<script>
// Preview de imagen en el offcanvas
$(document).ready(function() {
    $('#petCanvas').on('shown.bs.offcanvas', function() {
        // Inicializar preview de imagen
        $('#profile_photo').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#petCanvas .previewImg')
                        .attr('src', event.target.result)
                        .show();
                };
                reader.readAsDataURL(file);
            } else {
                $('#petCanvas .previewImg').hide();
            }
        });
    });
});
</script>