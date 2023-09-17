<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Job') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-6 flex justify-between">
                        <h2>Add New Job</h2>
                        <a style="background-color: #007BFF; color: white; padding: 10px 24px; border-radius: 50px; text-decoration: none; display: inline-block;" href="{{ route('jobs.index') }}">
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

                    <form action="{{ route('jobs.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <strong>Title:</strong>
                                <input type="text" name="title" class="form-control" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <strong>Description:</strong>
                                <textarea class="form-control" style="height:150px" name="description" placeholder="Description"></textarea>
                            </div>
                            <div class="form-group">
                                <strong>Location:</strong>
                                <input type="text" name="location" class="form-control" placeholder="Location">
                            </div>
                            <div class="form-group">
                                <strong>Start Date:</strong>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <strong>End Date:</strong>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <strong>Status:</strong>
                                <select name="status" class="form-control">
                                    <option value="disponible">Disponible</option>
                                    <option value="no disponible">No Disponible</option>
                                </select>
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
