<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>
    
    <div class="py-1">
        <div class="max-w-8xl mx-auto sm:px-1 lg:px-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Aquí comienza la integración del chat -->
                    <div id="container" class="flex">
                        <div id="userList" class="flex-1 p-2" style="max-width: 500px;"> <!-- Reducir el ancho de la lista de usuarios -->
                            <div class="user-card mb-2 cursor-pointer">
                                <div class="profile-image">
                                    <img src="ruta de foto" alt="Foto de perfil" class="rounded-full w-12 h-12">
                                </div>
                                <div class="user-details">
                                    <h3>Nombre de usuario</h3>
                                    <p class="last-message-preview">Último mensaje enviado por este usuario.</p>
                                </div>
                            </div>

                            <div class="user-card mb-2 cursor-pointer">
                                <div class="profile-image">
                                    <img src="ruta_de_la_foto" alt="Foto de perfil" class="rounded-full w-12 h-12">
                                </div>
                                <div class="user-details">
                                    <h3>Nombre de usuario</h3>
                                    <p class="last-message-preview">Último mensaje enviado por este usuario.</p>
                                </div>
                            </div>

                            <div class="user-card mb-2 cursor-pointer">
                                <div class="profile-image">
                                    <img src="ruta_de_la_foto" alt="Foto de perfil" class="rounded-full w-12 h-12">
                                </div>
                                <div class="user-details">
                                    <h3>Nombre de usuario</h3>
                                    <p class="last-message-preview">Último mensaje enviado por este usuario.</p>
                                </div>
                            </div>
                            <!-- Agrega más usuarios aquí o intégralos dinámicamente -->
                        </div>
                        <div id="chat" class="flex-1 p-2" style="min-width: 600px; max-height: 500px;"> <!-- Aumentar el ancho mínimo y limitar la altura del espacio de chat -->
                            <div class="user-card mb-2">
                                <div class="profile-image">
                                    <img src="ruta_de_la_foto" alt="Foto de perfil" class="rounded-full w-12 h-12">
                                </div>
                                <div class="user-details">
                                    <h3>Nombre de usuario</h3>
                                </div>
                            </div>
                            <div id="chatMessages" class="border border-gray-300 rounded-lg h-72 overflow-y-auto p-2 mb-4"> <!-- Limitar la altura del chat -->
                                <!-- Aquí se mostrarán los mensajes del chat -->
                            </div>
                            <input type="text" id="messageInput" class="w-full border border-lightgray-300 p-2 mb-2" placeholder="Escribe un mensaje">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .user-card {
        font-size: 18px;
        background-color: #f2f2f2;
        padding: 10px;
        border-radius: 0px;
        margin-bottom: 5px;
        cursor: pointer;
        display: flex;
        align-items: center; /* Alineación vertical centrada */
    }

    .profile-image {
        margin-right: 10px;
    }

    .profile-image img {
        border-radius: 50%;
    }

    .user-details {
        display: flex;
        flex-direction: column;
        flex-grow: 1; /* Ajusta el crecimiento automático del contenido */
    }

    .last-message-preview {
        font-size: 14px;
        color: gray;
    }

    .user-card:hover {
        background-color: #e0e0e0;
    }
</style>
