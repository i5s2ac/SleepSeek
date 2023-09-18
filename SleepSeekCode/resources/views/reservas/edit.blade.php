<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-6 flex justify-between">
                        <h2>Edit Job</h2>
                        <a style="background-color: #007BFF; color: white; padding: 10px 24px; border-radius: 50px; text-decoration: none; display: inline-block;" href="{{ route('reservas.index') }}">
                            Back
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reservas.update',$reserva->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Other fields (Title, Description, etc.) here -->
                            <div class="form-group">
                                <strong>Title:</strong>
                                <input type="text" name="title" value="{{ $reserva->title }}" class="form-control" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <strong>Description:</strong>
                                <textarea class="form-control" style="height:150px" name="description" placeholder="Description">{{ $reserva->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <strong>Location:</strong>
                                <input type="text" name="location" value="{{ $reserva->location }}" class="form-control" placeholder="Location">
                            </div>
                            <div class="form-group">
                                <strong>Start Date:</strong>
                                <input type="date" name="start_date" value="{{ $reserva->start_date }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <strong>End Date:</strong>
                                <input type="date" name="end_date" value="{{ $reserva->end_date }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <strong>Status:</strong>
                                <select name="status" class="form-control">
                                    <option value="disponible" @if($reserva->status == 'disponible') selected @endif>Disponible</option>
                                    <option value="no disponible" @if($reserva->status == 'no disponible') selected @endif>No Disponible</option>
                                </select>
                            </div>
                            <div class="form-group col-span-full">
                                <strong>Current Images:</strong>
                                <div class="grid grid-cols-2 gap-4 mt-2">
                                    @foreach ($reserva->images as $image)
                                        <div class="relative group">
                                            <img src="{{ asset('images/' . $image->image_path) }}" alt="Reserva Image" class="w-full h-32 object-cover rounded-md">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group col-span-full">
                                <strong>Add/Replace Images:</strong>
                                <div class="mt-2">
                                    <label for="images" class="cursor-pointer bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-all duration-300">Upload Images</label>
                                    <input type="file" name="images[]" id="images" class="hidden" multiple>
                                    <span id="file-chosen" class="ml-4 text-gray-500">No se ha seleccionado ningún archivo</span>
                                </div>
                            </div>
                            <div class="col-span-full text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
