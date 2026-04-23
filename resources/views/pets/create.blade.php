<!-- Offcanvas Crear Mascota -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="petCanvas" aria-labelledby="petCanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="petCanvasLabel">Crear nueva mascota</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body">
    <form id="createPetForm" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="client_id" class="form-label">Cliente/Dueño</label>
        <select id="client_id" name="client_id" class="form-select"></select>
        <div class="invalid-feedback"></div>
      </div>

      <div class="mb-3" id="phone_container" style="display:none;">
        <label for="emergency_phone" class="form-label">Celular</label>
        <input type="number" name="emergency_phone" id="emergency_phone" class="form-control">
      </div>

      <div class="mb-3">
        <label for="new_pet_name" class="form-label">Nombre de la mascota</label>
        <input type="text" id="new_pet_name" name="new_pet_name" class="form-control">
        <div class="invalid-feedback"></div>
      </div>

      <div class="mb-3">
        <label for="breed_id" class="form-label">Raza</label>
        <select id="breed_id" name="breed_id" class="form-select"></select>
        <div class="invalid-feedback"></div>
      </div>

      <div class="mb-3">
        <label for="age" class="form-label">Edad</label>
        <input type="number" id="age" name="age" class="form-control">
      </div>

      <div class="mb-3">
        <label for="gender" class="form-label">Género</label>
        <select name="gender" id="gender" class="form-control">
          <option value="">--- Seleccione el género ---</option>
          <option value="Hembra">Hembra</option>
          <option value="Macho">Macho</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="medical_condition" class="form-label">Condiciones médicas</label>
        <input type="text" id="medical_condition" name="medical_condition" class="form-control">
      </div>

      <div class="mb-3">
        <label for="observations" class="form-label">Observaciones</label>
        <input type="text" id="observations" name="observations" class="form-control">
      </div>

      <div class="mb-3">
        <label for="profile_photo" class="form-label">Foto</label>
        <input type="file" id="profile_photo" name="profile_photo" class="form-control">
      </div>

      <div class="d-grid gap-2 mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cerrar</button>
        <button type="submit" class="btn btn-success">Crear mascota</button>
      </div>
    </form>
  </div>
</div>

<style>
#petCanvas{width:520px;max-width:100%;}
</style>