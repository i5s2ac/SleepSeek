<!-- Para ver este view en el lcoalhost utilizar /verPlaza en el browser -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Perfil de Usuario') }}
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="max-w-7x1 mx-auto sm:px-6 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center space-x-8">
                        <div class="w-20 h-20">
                            <!-- Coloca aquí la ruta a la foto de perfil -->
                            <img src="{{ asset('ruta_de_la_foto') }}" alt="Foto de perfil" class="rounded-full w-20 h-20">
                        </div>
                        <div>
                            <!-- Nombre de usuario (Reemplaza 'nombre_de_usuario') -->
                            <h1 class="text-2xl font-semibold">nombre_de_usuario</h1>
                            <!-- Correo electrónico (Reemplaza 'correo_de_usuario') -->
                            <p class="text-gray-600">correo_de_usuario</p>
                            <!-- Ubicación (Reemplaza 'ubicacion_de_usuario') -->
                            <p class="text-gray-600">ubicacion_de_usuario</p>
                            <!-- Número de teléfono (Reemplaza 'numero_de_telefono') -->
                            <p class="text-gray-600">numero_de_telefono</p>
                            <!-- Agrega más campos según la información de tu base de datos -->
                        </div>
                    </div>
                    <!-- Agregar el enlace para descargar el archivo de CV -->
                    <!-- Reemplaza 'nombre_del_cv.pdf' con el nombre real del archivo de CV -->
                    <div class="mt-8">
                        <a href="{{ asset('ruta_al_archivo_cv/nombre_del_cv.pdf') }}" class=" hover:underline">
                            Descargar CV
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>

<style>
    .text-2xl  {

        margin-bottom: 10px;
    }

    .text-gray-600 {
        color: #6f6f6f;
    }
</style>