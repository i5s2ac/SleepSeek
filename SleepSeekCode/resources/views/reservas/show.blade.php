<x-app-layout>
    <head>
        <!-- ... otros enlaces y scripts que ya estén aquí ... -->

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

        <!-- Alpine.js -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <!-- ... cualquier otro contenido que ya esté dentro de <head> ... -->

        <!-- Estilos de Owl Carousel -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

        <!-- Script de Owl Carousel y jQuery (necesario para Owl Carousel) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

        <style>
            /* Estilo base para los botones */
            .custom-button {
                display: inline-block;
                padding: 10px 20px;
                font-size: 16px;
                text-align: center;
                text-decoration: none;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            /* Estilo para el botón Aceptar */
            .custom-button.accept {
                background-color: #04bc78;
                color: white;
            }

            /* Estilo para el botón Rechazar */
            .custom-button.reject {
                background-color: #F44336;
                color: white;
            }

            .custom-button.regret {
                background-color: #F1CF35;
                color: white;
            }

            /* Estilo para el contenedor de los botones */
            .button-container {
                text-align: center; /* Alinea horizontalmente los botones en el centro */
            }

            .custom-button.delete {
                background-color: #F44336; /* Color rojo */
                color: white;
                display: flex; /* Hace que el contenido del botón se distribuya en una línea */
                align-items: center; /* Centra verticalmente el ícono y el texto */
                justify-content: center; /* Centra horizontalmente el ícono y el texto */
            }
        </style>
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de SleepPlaces') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200 space-y-6">

                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Lista de Solicitudes</h2>
                        <a href="{{ route('reservas.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-full">
                            Back
                        </a>
                    </div>

                    <!-- Tarjetas de Reservas -->
                                
                                <div x-data="{ activeImage: 0, open: false }" class="card relative rounded overflow-hidden shadow-lg">
                                    
                                    <!-- Carousel de Imágenes -->
                                    @foreach($reservas->images as $index => $image)
                                        <img src="{{ asset('images/' . $image->image_path) }}" alt="Reserva Image {{ $index + 1 }}" class="absolute top-0 left-0 w-full h-full object-cover" x-show="activeImage === {{ $index }}">
                                    @endforeach

                                    <!-- Botones para controlar el carrusel -->
                                    <button x-show="activeImage !== 0" @click="activeImage--" class="absolute z-10 top-1/2 transform -translate-y-1/2 left-2 bg-black bg-opacity-50 text-white rounded-full p-2 focus:outline-none">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button x-show="activeImage !== {{ $reservas->images->count() - 1 }}" @click="activeImage++" class="absolute z-10 top-1/2 transform -translate-y-1/2 right-2 bg-black bg-opacity-50 text-white rounded-full p-2 focus:outline-none">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                    <!-- Fin del Carousel -->

                                    <!-- Overlay con información de la tarjeta -->
                                    <div class="relative p-6 bg-black bg-opacity-50">                              
                                        <!-- Contenido de la tarjeta -->
                                        <h3 class="font-bold text-xl text-white mb-4">{{ $reservas->title }}</h3>
                                        <p class="text-white mb-4">{{ Str::limit($reservas->description, 100) }}</p>
                                        <p class="text-sm text-white mb-2">Location: {{ $reservas->location }}</p>
                                        <p class="text-sm text-white mb-2">Start Date: {{ $reservas->start_date }}</p>
                                        <p class="text-sm text-white mb-2">End Date: {{ $reservas->end_date }}</p>
                                        <p class="text-sm text-white mb-4">Status: {{ $reservas->status }}</p>
                                    </div>
                                    
                                </div>
                 
                    <br>

                   <!-- Tabla de Solicitudes -->
                    @if (!$solicitudes->isEmpty())
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avatar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitud</th> <!-- Columna "Opciones" -->
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th> <!-- Columna "Acción" -->
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($solicitudes as $solicitud)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $solicitud->correo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <img src="{{ asset('storage/' . $solicitud->avatar) }}" alt="Avatar" class="h-10 w-10 rounded-full">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($solicitud->estado == 'aceptada')
                                                <div class="flex items-center"> <!-- Contenedor para alinear horizontalmente -->
                                                    <span>Aceptada</span>
                                                </div>
                                            @elseif ($solicitud->estado == 'rechazada')
                                                Rechazada
                                            @else
                                                <!-- Contenedor de los botones -->
                                                <div class="flex">
                                                    <!-- Botón Aceptar -->
                                                    <form action="{{ route('reservas.aceptar', $solicitud->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="custom-button accept">Aceptar</button>
                                                    </form>

                                                    <!-- Botón Rechazar -->
                                                    <form action="{{ route('reservas.rechazar', $solicitud->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="custom-button reject">Rechazar</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <!-- Nueva columna para el botón "Arrepentirse" -->
                                            @if ($solicitud->estado == 'aceptada')
                                                <form action="{{ route('reservas.regret', $solicitud->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="custom-button regret">Arrepentirse</button>
                                                </form>
                                            @else
                                                <!-- Puedes agregar otro contenido aquí si lo deseas -->
                                            @endif
                                            

                                            <form action="{{ route('solicitudes.delete', $solicitud->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="custom-button delete">
                                                    <i class="fas fa-trash-alt"></i> 
                                                </button>
                                            </form>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Owl Carousel -->
    <script>
        $(document).ready(function(){
            $(".owl-carousel").owlCarousel({
                loop: false,
                margin: 10,
                nav: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });
        });
    </script>
</x-app-layout>
