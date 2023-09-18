<x-app-layout>
    <head>
        <!-- ... otros enlaces y scripts que ya estén aquí ... -->

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

        <!-- Alpine.js -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <!-- ... cualquier otro contenido que ya esté dentro de <head> ... -->
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Trabajos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Botón "Create New Reserva" -->
                    <div class="mb-6">
                        <a class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-6 rounded text-decoration-none inline-flex items-center" href="{{ route('reservas.create') }}">
                            <i class="fas fa-plus mr-2"></i> Create New Reserva
                        </a>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success bg-green-100 border-l-4 border-green-400 text-green-600 px-4 py-3 rounded relative" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <!-- Tarjetas de Reservas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($reservas as $reserva)
                            <div x-data="{ activeImage: 0, open: false }" class="card relative rounded overflow-hidden shadow-lg">
                                
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

                                    <!-- Contenido de la tarjeta -->
                                    <h3 class="font-bold text-xl text-white mb-4">{{ $reserva->title }}</h3>
                                    <p class="text-white mb-4">{{ Str::limit($reserva->description, 100) }}</p>
                                    <p class="text-sm text-white mb-2">Location: {{ $reserva->location }}</p>
                                    <p class="text-sm text-white mb-2">Start Date: {{ $reserva->start_date }}</p>
                                    <p class="text-sm text-white mb-2">End Date: {{ $reserva->end_date }}</p>
                                    <p class="text-sm text-white mb-4">Status: {{ $reserva->status }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Paginación -->
                    <div class="mt-4">
                        {!! $reservas->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

