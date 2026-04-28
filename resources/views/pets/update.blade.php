<!-- Modal Update Mascota -->
<div class="modal fade pet-modal" id="petUpdateModal{{ $pet->id }}" tabindex="-1" aria-labelledby="petUpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="petUpdateModalLabel">
          <i class="fa-solid fa-paw me-2"></i> Actualizar Mascota
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('pet.update')}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $pet->id }}">
        <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
            <div class="text-center mb-3">
              <img class="pet-photo-preview previewImg" 
                   src="{{ $pet->profile_photo ? asset('storage/' . $pet->profile_photo) : asset('storage/pets/images.png') }}" 
                   style="width: 120px; height: 120px; object-fit: cover; border-radius: 20px; border: 3px solid #fce7f0;">
              <label for="photo" class="form-label mt-2">Cambiar foto</label>
              <input type="file" name="profile_photo" class="form-control profile-photo-input" accept="image/*">            
            </div>
            
            <div class="mb-3">
              <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $pet->name }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="mb-3">
              <label for="sobriquet" class="form-label">Apodo</label>
              <input type="text" name="sobriquet" class="form-control @error('sobriquet') is-invalid @enderror" id="sobriquet" value="{{ $pet->sobriquet }}">
              @error('sobriquet')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Raza <span class="text-danger">*</span></label>
                <select name="breed_id" class="breed-select form-select w-100" required>
                    @foreach ($breeds as $breed)
                        <option value="{{ $breed->id }}" {{ $pet->breed_id == $breed->id ? 'selected' : '' }}>
                            {{ $breed->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
              <label for="age" class="form-label">Edad (años)</label>
              <input type="number" step="0.5" name="age" class="form-control" id="age" value="{{ $pet->age }}">
            </div>
            
            <div class="mb-3">
              <label for="gender" class="form-label">Sexo <span class="text-danger">*</span></label>
              <select name="gender" id="gender" class="form-control" required>
                <option value="Macho" {{ $pet->gender == 'Macho' ? 'selected' : '' }}>🐕 Macho</option>
                <option value="Hembra" {{ $pet->gender == 'Hembra' ? 'selected' : '' }}>🐩 Hembra</option>
              </select>
            </div>
            
            <div class="mb-3">
              <label for="medical_condition" class="form-label">Condiciones Médicas</label>
              <textarea name="medical_condition" class="form-control" rows="2" placeholder="Ej: Alergias, enfermedades crónicas, medicamentos...">{{ $pet->medical_condition }}</textarea>
            </div>
            
            <div class="mb-3">
              <label for="observations" class="form-label">Observaciones</label>
              <textarea name="observations" class="form-control" rows="2" placeholder="Información adicional sobre la mascota...">{{ $pet->observations }}</textarea>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa-solid fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fa-solid fa-save me-1"></i> Guardar cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Inicializar select2 en el modal de actualización cuando se abre
$(document).ready(function() {
    $('#petUpdateModal{{ $pet->id }}').on('shown.bs.modal', function() {
        // Inicializar select2 para raza si no está inicializado
        if (!$('#petUpdateModal{{ $pet->id }} .breed-select').hasClass('select2-hidden-accessible')) {
            $('#petUpdateModal{{ $pet->id }} .breed-select').select2({
                dropdownParent: $('#petUpdateModal{{ $pet->id }}'),
                width: '100%',
                placeholder: 'Selecciona una raza'
            });
        }
    });
});
</script>