<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Trabajos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Botón "Create New Product" -->
                    <div class="mb-6">
                        <a style="background-color: #007BFF; color: white; padding: 10px 24px; border-radius: 50px; text-decoration: none; display: inline-block;" href="{{ route('jobs.create') }}">
                            <i class="fas fa-plus mr-2"></i> Create New Product
                        </a>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success bg-green-100 border-l-4 border-green-400 text-green-600 px-4 py-3 rounded relative" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <table class="min-w-full table-auto bg-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Titulo</th>
                                <th class="px-4 py-2 border">Descripción</th>
                                <th class="px-4 py-2 border">Location</th>
                                <th class="px-4 py-2 border">Start Date</th>
                                <th class="px-4 py-2 border">End Date</th>
                                <th class="px-4 py-2 border">Salario</th>
                                <th class="px-4 py-2 border">Compañia</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                                <tr>
                                    <td class="border px-4 py-2">{{ ++$i }}</td>
                                    <td class="border px-4 py-2">{{ $job->title }}</td>
                                    <td class="border px-4 py-2">{{ $job->description }}</td>
                                    <td class="border px-4 py-2">{{ $job->location }}</td>
                                    <td class="border px-4 py-2">{{ $job->start_date }}</td>
                                    <td class="border px-4 py-2">{{ $job->end_date }}</td>
                                    <td class="border px-4 py-2">{{ $job->salary }}</td>
                                    <td class="border px-4 py-2">{{ $job->company }}</td>
                                    <td class="border px-4 py-2">{{ $job->status }}</td>
                                    <td class="border px-4 py-2">
                                        <div class="flex justify-around">
                                            <a class="text-blue-500 hover:underline hover:text-blue-700" href="{{ route('jobs.show',$job->id) }}">Show</a>
                                            <a class="text-yellow-500 hover:underline hover:text-yellow-700" href="{{ route('jobs.edit',$job->id) }}">Edit</a>
                                            <form action="{{ route('jobs.destroy',$job->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline hover:text-red-700" onclick="return confirm('¿Estás seguro de eliminar este trabajo?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {!! $jobs->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
