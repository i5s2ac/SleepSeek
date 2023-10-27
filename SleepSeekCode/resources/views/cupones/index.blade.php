<x-app-layout>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Cupones') }}
        </h2>
    </x-slot>

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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200 space-y-6">

                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Cupones</h2>
                        <a href="{{ route('cupones.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-full">
                            Agregar Cupon
                        </a>
                    </div>

                    <table class="min-w-full table-auto">
                        <thead class="justify-between">
                            <tr class="bg-gray-100">
                                <th class="px-2 py-2">ID</th>
                                <th class="px-2 py-2">Codigo</th>
                                <th class="px-2 py-2">Descuento</th>
                                <th class="px-2 py-2">Fecha Expiración</th>
                                <th class="px-2 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-200">
                            @foreach($cupones as $cupon)
                                <tr class="bg-white border-2 border-gray-200 hover:bg-gray-100">
                                    <td class="px-2 py-2 text-center">{{ $cupon->id }}</td>
                                    <td class="px-2 py-2 text-center">{{ $cupon->codigo }}</td>
                                    <td class="px-2 py-2 text-center">{{ $cupon->descuento }}</td>
                                    <td class="px-2 py-2 text-center">{{ $cupon->fecha_expiracion }}</td>
                                    <td class="px-2 py-2 text-center">
                                        <a href="{{ route('cupones.edit', $cupon->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded-full">Editar</a>
                                        <form action="{{ route('cupones.destroy', $cupon->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-full">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
