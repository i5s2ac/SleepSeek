<x-app-layout>
    <head>
        <!-- ... otros enlaces y scripts ... -->

        <!-- Estilos de Owl Carousel -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

        <!-- Font Awesome y Alpine.js (tomados del index) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <!-- Script de Owl Carousel y jQuery (necesario para Owl Carousel) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    </head>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SleepHome') }}
        </h2>
    </x-slot>

    @php
        $detalle = auth()->user()->detalleUsuario;
        $totalCampos = 8; // Total de campos en tu detalle de usuario
        $camposCompletados = 0;

        if ($detalle) {
            if (!empty($detalle->dpi_photo)) $camposCompletados++;
            if (!empty($detalle->direction)) $camposCompletados++;
            if (!empty($detalle->number)) $camposCompletados++;
            if (!empty($detalle->avatar)) $camposCompletados++;
            if (!empty($detalle->birthday)) $camposCompletados++;
            if (!empty($detalle->gender)) $camposCompletados++;
            if (!empty($detalle->country)) $camposCompletados++;
            if (!empty($detalle->DPI)) $camposCompletados++;
        }
    @endphp

    @if(session('error'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-200 p-4 rounded flex items-center justify-between">
                <p class="text-white-700">
                    {{ session('error') }}
                </p>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-200 p-4 rounded flex items-center justify-between">
                <p class="text-white-700">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    @if ($camposCompletados < $totalCampos)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-blue-200 p-4 rounded flex items-center justify-between">
                <p class="text-white-700">
                    Has completado {{ $camposCompletados }} de {{ $totalCampos }} detalles dentro de tu perfil. 
                </p>
                <a href="{{ route('profile.edit') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    {{ __('Completar perfil') }}
                </a>
            </div>
        </div>
    @endif

     <!-- Tarjetas de Reservas en Carousel -->
     <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($reservas->count() > 0)
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Carousel Container -->
                        <div class="owl-carousel owl-theme">
                            @foreach ($reservas as $reserva)
                                @if (auth()->user()->id !== $reserva->user_id)
                                    <div x-data="{ activeImage: 0, open: false }" class="card relative rounded overflow-hidden shadow-lg">
                                        
                                        <!-- Carousel de Imágenes -->
                                        @foreach($reserva->images as $index => $image)
                                            <img src="{{ asset('images/' . $image->image_path) }}" alt="Reserva Image {{ $index + 1 }}" class="absolute top-0 left-0 w-full h-full object-cover" x-show="activeImage === {{ $index }}">
                                        @endforeach

                                        <!-- Botones para controlar el carrusel de imágenes -->
                                        <button x-show="activeImage !== 0" @click="activeImage--" class="absolute z-10 top-1/2 transform -translate-y-1/2 left-2 bg-black bg-opacity-50 text-white rounded-full p-2 focus:outline-none">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button x-show="activeImage !== {{ $reserva->images->count() - 1 }}" @click="activeImage++" class="absolute z-10 top-1/2 transform -translate-y-1/2 right-2 bg-black bg-opacity-50 text-white rounded-full p-2 focus:outline-none">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>

                                        <!-- Overlay con información de la tarjeta -->
                                        <div class="relative p-6 bg-black bg-opacity-50">
                                            <!-- Contenido de la tarjeta -->
                                            <h3 class="font-bold text-xl text-white mb-4">{{ $reserva->title }}</h3>
                                            <p class="text-white mb-4">{{ Str::limit($reserva->description, 100) }}</p>
                                            <p class="text-sm text-white mb-2">Location: {{ $reserva->location }}</p>
                                            <p class="text-sm text-white mb-2">Start Date: {{ $reserva->start_date }}</p>
                                            <p class="text-sm text-white mb-2">End Date: {{ $reserva->end_date }}</p>
                                            <p class="text-sm text-white mb-4">Status: {{ $reserva->status }}</p>
                                        </div>
                                        <!-- Botón absoluto en la parte inferior de la tarjeta -->
                                        <br>
                                        <br>

                                        <form method="POST" action="{{ route('reservas.solicitar', $reserva->id) }}" class="absolute left-0 bottom-0 w-full p-4 bg-blue-500 hover:bg-blue-600 text-center text-white font-bold transition duration-300 ease-in-out transform hover:scale-105">
                                            @csrf
                                            <button type="submit">¡SleepIn Now!</button>
                                        </form>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Mensaje cuando no hay solicitudes -->
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <i class="fas fa-bed fa-3x mb-2 text-gray-400"></i>
                        <p class="text-gray-500">No hay nada por el momento.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Script para inicializar Owl Carousel -->
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

    <script>

        window.onload = function() {
            axios.get('{{ route('dashboard') }}') // Usamos la helper function de Blade para obtener la URL
                .then(response => {
                    const reservas = response.data; // Suponiendo que tu endpoint devuelve un array de cupones
                    console.log(reservas); // Muestra los cupones en la consola
                })
                .catch(error => {
                    console.error('Hubo un error:', error);
                });
        };

    </script>

</x-app-layout>
