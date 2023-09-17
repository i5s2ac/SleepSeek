<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $detalle = auth()->user()->detalleUsuario;
        $totalCampos = 7; // Total de campos en tu detalle de usuario
        $camposCompletados = 0;

        if ($detalle) {
            if (!empty($detalle->cv)) $camposCompletados++;
            if (!empty($detalle->direction)) $camposCompletados++;
            if (!empty($detalle->number)) $camposCompletados++;
            if (!empty($detalle->avatar)) $camposCompletados++;
            if (!empty($detalle->birthday)) $camposCompletados++;
            if (!empty($detalle->gender)) $camposCompletados++;
            if (!empty($detalle->country)) $camposCompletados++;
        }
    @endphp

    @if ($camposCompletados < $totalCampos)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-200 p-4 rounded flex items-center justify-between">
                <p class="text-white-700">
                    Has completado {{ $camposCompletados }} de {{ $totalCampos }} detalles dentro de tu perfil. 
                </p>
                <a href="{{ route('profile.edit') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    {{ __('Completar perfil') }}
                </a>
            </div>
        </div>
    @endif

    <!-- preview de Plaza disponible --> 
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="card w-full">
                        <img class="card-img-top w-48 h-auto" src="https://www.becas-santander.com/es/blog/productividad-en-el-trabajo/_jcr_content/root/container/responsivegrid/image_126604164.coreimg.jpeg/1637065958747/productividad-en-el-trabajo-becas.jpeg" alt="Card image cap">
                        <div class="card-body px-4 py-4">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-3">Nombre de Empresa</h2>
                            <p class="Descripción mb-4">Descripción sobre el empleo, información importante sobre la empresa y una breve descripción qué se requiere para poder aplicar a la plaza.</p>
                            <a href="#" class="Botton de Aplicar font-semibold hover:underline" >Ver Plaza</a> <!-- Aquí programar el botón de aplicación -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>
