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
                    <!-- Botón "Create New Reserva" -->
                    <div class="mb-6">
                        <a class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-6 rounded text-decoration-none inline-flex items-center" href="{{ route('reservas.create') }}">
                            <i class="fas fa-plus mr-2"></i> Crear Nuevo SleepPlace
                        </a>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success bg-green-100 border-l-4 border-green-400 text-green-600 px-4 py-3 rounded relative" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <!-- Verifica si no hay reservas y muestra un mensaje -->
                    @if ($reservas->isEmpty())
                        <br>
                        <div class="text-center text-gray-500">
                            <i class="fas fa-bed fa-3x mb-2"></i>
                            <p>No has creado ninguna plaza de momento.</p>
                        </div>
                    @else
                        <!-- Tarjetas de Reservas -->
                        <div class="owl-carousel owl-theme">
                            @foreach ($reservas as $reserva)
                                <div x-data="{ activeImage: 0, open: false, isBoosted: {{ $reserva->boost ? 'true' : 'false' }} }" class="card relative rounded overflow-hidden shadow-lg">

                                    <!-- Carousel de Imágenes -->
                                    @foreach($reserva->images as $index => $image)
                                        <img src="{{ asset('images/' . $image->image_path) }}" alt="Reserva Image {{ $index + 1 }}" class="absolute top-0 left-0 w-full h-full object-cover" x-show="activeImage === {{ $index }}">
                                    @endforeach

                                    <!-- Botones para controlar el carrusel -->
                                    <button x-show="activeImage !== 0" @click="activeImage--" class="absolute z-10 top-1/2 transform -translate-y-1/2 left-2 bg-black bg-opacity-50 text-white rounded-full p-2 focus:outline-none">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button x-show="activeImage !== {{ $reserva->images->count() - 1 }}" @click="activeImage++" class="absolute z-10 top-1/2 transform -translate-y-1/2 right-2 bg-black bg-opacity-50 text-white rounded-full p-2 focus:outline-none">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                    <!-- Fin del Carousel -->

                                    <!-- Overlay con información de la tarjeta -->
                                    <div class="relative p-6 bg-black bg-opacity-50">
                                        <!-- Menú de tres puntos y desplegable -->
                                        <div class="absolute top-4 right-4">
                                            <!-- Botón de tres puntitos -->
                                            <button @click="open = !open" class="focus:outline-none text-white hover:text-gray-400">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <!-- Menú desplegable -->
                                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-lg z-10">
                                                <a href="{{ route('reservas.show', $reserva->id) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Show</a>
                                                <a href="{{ route('reservas.edit', $reserva->id) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Edit</a>
                                                <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" class="block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100">Delete</button>
                                                </form>
                                            </div>
                                        </div>

                                         <!-- Lightning bolt icon for boosted reservations -->
                                        <div x-show="isBoosted" class="absolute bottom-4 right-3 z-20">
                                            <i class="fas fa-bolt text-yellow-500 text-2xl"></i>
                                        </div>

                                        <!-- Contenido de la tarjeta -->
                                        <h3 class="font-bold text-xl text-white mb-4">{{ $reserva->title }}</h3>
                                        <p class="text-white mb-4">{{ Str::limit($reserva->description, 100) }}</p>
                                        <p class="text-sm text-white mb-2">Location: {{ $reserva->location }}</p>
                                        <p class="text-sm text-white mb-2">Start Date: {{ $reserva->start_date }}</p>
                                        <p class="text-sm text-white mb-2">End Date: {{ $reserva->end_date }}</p>
                                        <p class="text-sm text-white mb-4">Status: {{ $reserva->status }}</p>
                                    </div>

                                    <br>
                                    <br>

                                    <form method="POST" action="{{ route('reservas.addBoost', $reserva) }}" x-show="!isBoosted">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="absolute left-0 bottom-0 w-full p-4 bg-green-500 hover:bg-green-600 text-center text-white font-bold transition duration-300 ease-in-out transform hover:scale-105">¡SleepBoost Now!</button>
                                    </form>

                                    <form method="POST" action="{{ route('reservas.removeBoost', $reserva) }}" x-show="isBoosted">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="absolute left-0 bottom-0 w-full p-4 bg-red-500 hover:bg-red-600 text-center text-white font-bold transition duration-300 ease-in-out transform hover:scale-105">Delete SleepBoost</button>
                                    </form>


                                </div>

                                
                            @endforeach
                        </div>
                    @endif

                    <!-- Paginación -->
                    <div class="mt-4">
                        {!! $reservas->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
