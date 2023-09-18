<x-app-layout>

    <head>
        <!-- Estilos de Owl Carousel -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

        <!-- Scripts de Owl Carousel -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Job') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-6 flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Show Job</h2>
                        <a href="{{ route('reservas.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                            Back
                        </a>
                    </div>

                    <!-- Images Section -->
                    <div class="mt-12">
                        <h3 class="text-xl font-semibold mb-4">Related Images:</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            @foreach ($reserva->images as $image)
                                <img src="{{ asset('images/' . $image->image_path) }}" alt="{{ $reserva->title }}" class="w-full h-48 object-cover rounded-lg shadow-md">
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <strong class="block mb-2">Title:</strong>
                            <span class="text-gray-700">{{ $reserva->title }}</span>
                        </div>
                        <div class="form-group">
                            <strong class="block mb-2">Description:</strong>
                            <span class="text-gray-700">{{ $reserva->description }}</span>
                        </div>
                        <div class="form-group">
                            <strong class="block mb-2">Location:</strong>
                            <span class="text-gray-700">{{ $reserva->location }}</span>
                        </div>
                        <div class="form-group">
                            <strong class="block mb-2">Start Date:</strong>
                            <span class="text-gray-700">{{ $reserva->start_date }}</span>
                        </div>
                        <div class="form-group">
                            <strong class="block mb-2">End Date:</strong>
                            <span class="text-gray-700">{{ $reserva->end_date }}</span>
                        </div>
                        <div class="form-group">
                            <strong class="block mb-2">Status:</strong>
                            <span class="text-gray-700">{{ $reserva->status }}</span>
                        </div>
                    </div>

                    

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
