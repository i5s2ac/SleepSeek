<div id="app-content">

    <x-app-layout>

        <head>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
            <!-- Font Awesome y Alpine.js (tomados del index) -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
            <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        </head>

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('SleepCoupons') }}
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
                        <h2 class="text-2xl font-bold">Mis Cupones</h2>

                        <div class="mb-0">
                            <a class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-6 rounded text-decoration-none inline-flex items-center" href="{{ route('cupones.create') }}">
                                <i class="fas fa-plus mr-2"></i> ¡Agregar SleepCoupon!
                            </a>
                        </div>
                    </div>

                        @if($cupones->count() > 0) 

                            <table class="min-w-full table-auto">
                                <thead class="justify-between">
                                    <tr class="bg-gray-100">
                                        <th class="px-2 py-2">Codigo</th>
                                        <th class="px-2 py-2">Descuento</th>
                                        <th class="px-2 py-2">Fecha Expiración</th>
                                        <th class="px-2 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-200">
                                    
                                    @foreach($cupones as $cupon)
                                        @if ($cupon->user_id === auth()->id())

                                            <tr class="bg-white border-2 border-gray-200 hover:bg-gray-100">
                                                <td class="px-2 py-2 text-center">{{ $cupon->codigo }}</td>
                                                <td class="px-2 py-2 text-center">${{ $cupon->descuento }}</td>
                                                <td class="px-2 py-2 text-center">{{ $cupon->fecha_expiracion }}</td>
                                                <td class="px-2 py-2 flex items-center justify-center"> <!-- Añadimos justify-center aquí -->
                                                    <div class="flex items-center space-x-2">
                                                        <div class="mb-0">
                                                            <a class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-6 rounded text-decoration-none inline-flex items-center" href="{{ route('cupones.edit', $cupon->id) }}">
                                                                <i class="fas fa-cog mr-2"></i> Editar
                                                            </a>
                                                        </div>
                                                        <button 
                                                            data-cupon-id="{{ $cupon->id }}" 
                                                            class="deleteCuponBtn bg-red-500 hover:bg-red-700 text-white py-2 px-6 rounded inline-flex items-center">
                                                            <i class="fas fa-trash mr-2"></i> 
                                                            Eliminar
                                                        </button>

                        
                                                    </div>
                                                </td>

                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <!-- Mensaje cuando no hay solicitudes -->
                            <div class="p-6 bg-white text-center">
                                <i class="fas fa-bed fa-3x mb-2 text-gray-400"></i>
                                <p class="text-gray-500">No hay nada por el momento.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>


<script>
    window.onload = function() {
        axios.get('{{ route('cupones.index') }}') 
            .then(response => {
                const cupones = response.data; 
                console.log(cupones); 
            })
            .catch(error => {
                console.error('Hubo un error:', error);
            });
    };

</script>

<script>

    document.querySelectorAll('.deleteCuponBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.disabled = true;  // Deshabilitar el botón

            const cuponId = this.getAttribute('data-cupon-id');

            axios.delete(`{{ route('cupones.destroy', '') }}/${cuponId}`)
                .then(response => {
                    console.log('Cupón eliminado exitosamente:', response.data);
                })
                .catch(error => {
                    console.error('Hubo un error al eliminar el cupón:', error);
                })
             
        });
    });

</script>



