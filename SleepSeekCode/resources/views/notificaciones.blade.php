<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notificaciones') }}
        </h2>
    </x-slot>
                <div class="p-6">
                    <!-- Contenido de las notificaciones -->
                    <div class="notification bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="font-semibold text-lg mb-2">Notificación</h3>
                        <p class="text-gray-600">Descripción de la notificación...</p>
                    </div>

                    <div class="notification bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="font-semibold text-lg mb-2">Notificación</h3>
                        <p class="text-gray-600">Descripción de la notificación...</p>
                    </div>
                    <!-- Agrega más notificaciones aquí -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .notification {
        border: 1px solid #e2e8f0;
        padding: 20px;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .notification h3 {
        color: #333;
    }

    .notification p {
        color: #666;
    }
</style>