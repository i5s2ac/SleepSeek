<x-app-layout>

    <!-- Estilos de Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-semibold leading-tight">
                {{ __('Show Job') }}
            </h2>
            <!-- Back Button - Styled blue and moved to the top-right corner -->
            <a href="{{ route('reservas.index') }}" class="text-white bg-blue-500 hover:bg-blue-600 font-semibold py-2 px-4 rounded-lg shadow-md">
                ← Go Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow-md">

                <!-- Title -->
                <h1 class="text-4xl font-semibold mb-4">{{ $reserva->title }}</h1>

                <!-- Description -->
                <p class="text-lg text-gray-600 mb-8">{{ $reserva->description }}</p>

                <!-- Location -->
                <p class="text-lg text-gray-700 mb-8">
                    <strong>Location:</strong> {{ $reserva->location }}
                </p>
                
                <!-- Images Section -->
                <section class="mb-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($reserva->images as $image)
                            <div class="image-container hover:shadow-lg transition-shadow duration-300">
                                <img src="{{ asset('images/' . $image->image_path) }}" alt="{{ $reserva->title }}" class="w-full h-48 object-cover rounded-lg">
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Date Subheading -->
                <h3 class="text-2xl font-medium mb-4">¡Conoce las fechas que ofrece el SleepCreator!</h3>

                <!-- Date Details -->
                <div class="flex justify-between mb-8">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Start Date</h4>
                        <p class="text-lg text-gray-800">{{ $reserva->start_date }}</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">End Date</h4>
                        <p class="text-lg text-gray-800">{{ $reserva->end_date }}</p>
                    </div>
                </div>

                <!-- Status Subheading -->
                <h3 class="text-2xl font-medium mb-4">¡Conoce el estado de la reserva!</h3>

                <!-- Status Details -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Status</h4>
                    <p class="text-lg text-gray-800">{{ $reserva->status }}</p>
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts de Owl Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</x-app-layout>
