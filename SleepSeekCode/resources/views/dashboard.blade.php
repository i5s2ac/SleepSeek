<x-app-layout>
    <head>
        <!-- ... otros enlaces y scripts ... -->

        <!-- Estilos de Owl Carousel -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

        <!-- Script de Owl Carousel y jQuery (necesario para Owl Carousel) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    </head>

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

    <!-- Tarjetas de Reservas -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($reservas->count() > 0)  <!-- Añadido: Comprobación para renderizar solo si hay reservas -->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Carousel Container -->
                        <div class="owl-carousel owl-theme">
                            @foreach ($reservas as $reserva)
                                @if (auth()->user()->id !== $reserva->user_id) <!-- Validación de usuario -->
                                    <div class="card relative rounded overflow-hidden shadow-lg bg-white p-6">
                                        <!-- Contenido de la tarjeta -->
                                        <h3 class="font-bold text-xl mb-4">{{ $reserva->title }}</h3>
                                        <p class="text-gray-700 mb-4">{{ Str::limit($reserva->description, 100) }}</p>
                                        <p class="text-sm mb-2">Location: {{ $reserva->location }}</p>
                                        <p class="text-sm mb-2">Start Date: {{ $reserva->start_date }}</p>
                                        <p class="text-sm mb-2">End Date: {{ $reserva->end_date }}</p>
                                        <p class="text-sm mb-4">Status: {{ $reserva->status }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif <!-- Cierre de la comprobación -->
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
</x-app-layout>