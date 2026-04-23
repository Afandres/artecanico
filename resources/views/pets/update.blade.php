<!-- Modal Update -->
<div class="modal fade" id="petUpdateModal{{ $pet->id }}" tabindex="-1" aria-labelledby="petUpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="petUpdateModalLabel">Actualizar Mascota</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('pet.update')}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $pet->id }}">
        <div class="modal-body">
            <div class="mb-3">
              <img class="previewImg" src="{{ $pet->profile_photo ? asset('storage/' . $pet->profile_photo) : asset('storage/pets/images.png') }}" width="70" height="70" style="object-fit:cover;border-radius:8px;">
              <label for="photo" class="form-label">Foto</label>
                <input type="file" name="profile_photo" class="form-control profile-photo-input">            
              </div>
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $pet->name }}">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="sobriquet" class="form-label">Apodo</label>
              <input type="text" name="sobriquet" class="form-control @error('sobriquet') is-invalid @enderror" id="sobriquet" value="{{ $pet->sobriquet }}">
              @error('sobriquet')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Raza</label>
                <select name="breed_id" class="breed-select form-select w-100">
                    @foreach ($breeds as $breed)
                        <option value="{{ $breed->id }}" {{ $pet->breed_id == $breed->id ? 'selected' : '' }}>
                            {{ $breed->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
              <label for="age" class="form-label">Edad</label>
              <input type="text" name="age" class="form-control" id="age" value="{{ $pet->age }}">
            </div>
            <div class="mb-3">
              <label for="gender" class="form-label">Sexo</label>
              <select name="gender" id="gender" class="form-control">
                 <option value="Macho" {{ $pet->gender == 'Macho' ? 'selected' : '' }}>
                    Macho
                </option>
                <option value="Hembra" {{ $pet->gender == 'Hembra' ? 'selected' : '' }}>
                    Hembra
                </option>
              </select>
            </div>
            <div class="mb-3">
              <label for="medical_condition" class="form-label">Condiciones Médicas</label>
              <input type="text" name="medical_condition" class="form-control" id="size" value="{{ $pet->medical_condition }}">
            </div>
            <div class="mb-3">
              <label for="observations" class="form-label">Observaciones</label>
              <input type="text" name="observations" class="form-control" id="size" value="{{ $pet->observations }}">
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