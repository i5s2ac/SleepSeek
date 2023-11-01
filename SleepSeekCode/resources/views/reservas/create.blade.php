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
            {{ __('Add New Job') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200 space-y-6">

                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Add New Job</h2>
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

                    <form action="{{ route('reservas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">

                            <div class="space-y-2 col-span-full">
                                <label class="block text-gray-700 font-medium" for="images">Images:</label>
                                <div class="flex items-center space-x-3">
                                    <label for="images" class="cursor-pointer bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-all duration-300">Upload Images</label>
                                    <input type="file" name="images[]" id="images" class="hidden" multiple>
                                    <span id="file-chosen" class="ml-4">No se ha seleccionado ningún archivo</span>
                                </div>
                                <div id="preview" class="mt-4 flex space-x-3"></div> <!-- Contenedor para las imágenes previsualizadas -->
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="title">Title:</label>
                                <input class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" id="title" name="title" type="text" placeholder="Title">
                            </div>

                            <div class="space-y-1">
                                <label class="block text-gray-700 font-medium" for="description">Description:</label>
                                <textarea class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" id="description" name="description" rows="3" placeholder="Description"></textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="location">Location:</label>
                                <input class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" id="location" name="location" type="text" placeholder="Location">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="start_date">Start Date:</label>
                                <input class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" id="date_start" name="start_date" type="date">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="end_date">End Date:</label>
                                <input class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" id="date_end" name="end_date" type="date">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="status">Status:</label>
                                <select class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" id="status" name="status">
                                    <option value="disponible">Disponible</option>
                                    <option value="no disponible">No Disponible</option>
                                </select>
                            </div>

                            <div class="col-span-full text-center">
                                <button type="submit" id="createBtnReserva" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Submit
                                </button>
                            </div>


                        </div>
                    </form>

                    <script>
                            document.getElementById('createBtnReserva').addEventListener('click', function(event) {
                            event.preventDefault();

                            const formData = new FormData();
                            formData.append('title', document.getElementById('title').value);
                            formData.append('description', document.getElementById('description').value);
                            formData.append('location', document.getElementById('location').value);
                            formData.append('status', document.getElementById('status').value);
                            formData.append('start_date', document.getElementById('date_start').value);
                            formData.append('end_date', document.getElementById('date_end').value);

                            const images = document.getElementById('images').files;
                            for (let i = 0; i < images.length; i++) {
                                formData.append('images[]', images[i]);
                            }

                            axios({
                                method: 'post',
                                url: '{{ route('reservas.store') }}',
                                data: formData,
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            .then(response => {
                                console.log('Datos enviados exitosamente:', response.data);
                            })
                            .catch(error => {
                                console.error('Hubo un error al enviar los datos:', error);
                            });
                        });

                    </script>
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
                    wrapper.className = 'image-wrapper mr-2 mb-2';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Selected image";
                    img.className = "w-24 h-24 object-cover rounded";
                    
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

</x-app-layout>
