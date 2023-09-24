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
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de SleepPlaces') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                
                    <!-- Tarjetas de Reservas -->
                        <div class="owl-carousel owl-theme">
                    
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
                        </div>
                 
                    <br>
                    <!-- Tabla de Solicitudes -->
                    @if (!$solicitudes->isEmpty())
                        <h3 class="text-2xl font-medium mb-4">Lista de Solicitudes</h3>
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avatar</th>
                                    <!-- Agrega aquí las columnas adicionales que desees mostrar -->
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($solicitudes as $solicitud)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $solicitud->correo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <img src="{{ asset('storage/' . $solicitud->avatar) }}" alt="Avatar" class="h-10 w-10 rounded-full">
                                        </td>
                                        <!-- Agrega aquí las celdas adicionales según los campos de solicitud -->
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $solicitud->estado }}</td>
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
