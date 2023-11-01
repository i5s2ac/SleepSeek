<x-app-layout>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">

    <style>
        #file-chosen {
            font-style: italic;
            color: #aaa;
        }

        .image-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .image-wrapper img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .image-wrapper .delete {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: rgba(0,0,0,0.6);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
            line-height: 20px;
            display: none;
            cursor: pointer;
        }
        
        .image-wrapper:hover .delete {
            display: block;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200 space-y-6">

                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Edit Job</h2>
                        <a href="{{ route('reservas.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-full">
                            Back
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops!</strong>
                            <span class="block sm:inline">There were some problems with your input.</span>
                            <ul class="mt-3 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reservas.update', $reserva->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            <div class="space-y-2 col-span-full">
                                <label class="block text-gray-700 font-medium" for="images">Images:</label>
                                <div class="flex items-center space-x-3">
                                    <label for="images" class="cursor-pointer bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-all duration-300">Upload Images</label>
                                    <input type="file" name="images[]" id="images" class="hidden" multiple>
                                    <span id="file-chosen" class="ml-4">No se ha seleccionado ningún archivo</span>
                                </div>
                                <div id="preview" class="mt-4 flex space-x-3">
                                    @foreach ($reserva->images as $image)
                                        <div class="image-wrapper">
                                            <img src="{{ asset('images/' . $image->image_path) }}" alt="Reserva Image">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="title">Title:</label>
                                <input class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" name="title" type="text" placeholder="Title" value="{{ $reserva->title }}">
                            </div>

                            <div class="space-y-1">
                                <label class="block text-gray-700 font-medium" for="description">Description:</label>
                                <textarea class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" name="description" rows="3" placeholder="Description">{{ $reserva->description }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="location">Location:</label>
                                <input class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" name="location" type="text" placeholder="Location" value="{{ $reserva->location }}">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="start_date">Start Date:</label>
                                <input class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" name="start_date" type="date" value="{{ $reserva->start_date }}">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="end_date">End Date:</label>
                                <input class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" name="end_date" type="date" value="{{ $reserva->end_date }}">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="status">Status:</label>
                                <select class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" name="status">
                                    <option value="disponible" @if ($reserva->status == 'disponible') selected @endif>Disponible</option>
                                    <option value="no disponible" @if ($reserva->status == 'no disponible') selected @endif>No Disponible</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="boost">Boost:</label>
                                <select class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" name="boost">
                                    <option value="0" @if ($reserva->boost == 0) selected @endif>Desactivado</option>
                                    <option value="1" @if ($reserva->boost == 1) selected @endif>Activado</option>
                                </select>
                            </div>


                            <div class="col-span-full text-center">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function updateFileLabel() {
            const chosenFiles = document.getElementById('images').files;
            const fileLabel = document.getElementById('file-chosen');

            if (chosenFiles.length === 1) {
                fileLabel.textContent = chosenFiles[0].name;
            } else if (chosenFiles.length > 1) {
                fileLabel.textContent = chosenFiles.length + ' archivos seleccionados';
            } else {
                fileLabel.textContent = 'No se ha seleccionado ningún archivo';
            }
        }

        document.getElementById('images').addEventListener('change', function() {
            const chosenFiles = this.files;
            const previewContainer = document.getElementById('preview');

            // Limpiar el contenedor de previsualización
            while (previewContainer.firstChild) {
                previewContainer.removeChild(previewContainer.firstChild);
            }

            // Previsualizar cada imagen seleccionada
            Array.from(chosenFiles).forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'image-wrapper';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Selected image";
                    img.className = "image-wrapper-img";

                    const deleteIcon = document.createElement('span');
                    deleteIcon.innerHTML = '&times;';
                    deleteIcon.className = 'delete';
                    deleteIcon.onclick = function() {
                        // Eliminar el archivo del input de archivos
                        const newFiles = Array.from(document.getElementById('images').files).filter((_, idx) => idx !== index);
                        const dataTransfer = new DataTransfer();
                        newFiles.forEach(file => dataTransfer.items.add(file));

                        document.getElementById('images').files = dataTransfer.files;

                        // Actualizar el mensaje de archivos seleccionados
                        updateFileLabel();

                        // Eliminar la imagen de la previsualización
                        previewContainer.removeChild(wrapper);
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(deleteIcon);
                    previewContainer.appendChild(wrapper);
                };

                reader.readAsDataURL(file);
            });

            // Actualizar el mensaje de archivos seleccionados después de seleccionar archivos
            updateFileLabel();
        });
    </script>

    <script>
        window.onload = function() {
            const reservaUrl = '{{ route('reservas.index', $reserva->id) }}';

            axios.get(reservaUrl) 
                .then(response => {
                    const reserva = response.data;
                    console.log(reserva); 
                })
                .catch(error => {
                    console.error('Hubo un error:', error);
                });
        };
    </script>
    
</x-app-layout>
