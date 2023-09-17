{{-- Mostrar errores de validación si existen --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('profile.complete') }}" method="POST">
    @csrf
    <label for="dato_extra1">Dato Extra 1:</label>
    {{-- Nota el uso de la función old() para rellenar el valor anterior --}}
    <input type="text" name="dato_extra1" value="{{ old('dato_extra1') }}" required>
    {{-- Puedes seguir agregando más campos según lo requieras --}}
    <button type="submit">Completar Perfil</button>
</form>
