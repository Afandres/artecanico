@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">Algo salio mal.</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>Las credenciales ingresadas no coinciden con nuestros registros.</li>
            @endforeach
        </ul>
    </div>
@endif
