<x-app-layout>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Posts') }}
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
                        <h2 class="text-2xl font-bold">Mis Posts</h2>
                        <div class="mb-0">
                            <a class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-6 rounded text-decoration-none inline-flex items-center" href="{{ route('posts.create') }}">
                                <i class="fas fa-plus mr-2"></i> ¡Agregar Post!
                            </a>
                        </div>
                    </div>

                    @if($posts->count() > 0) 
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($posts as $post)
                                @if ($post->user_id === auth()->id())
                                    <div class="bg-white shadow-lg rounded p-4">

                                    <div class="flex items-center">
                                    @if(Auth::user()->detalleUsuario && Auth::user()->detalleUsuario->avatar)
                                        @php
                                            $isExternalAvatar = preg_match('/^https?:\/\//', Auth::user()->detalleUsuario->avatar);
                                            $avatarUrl = $isExternalAvatar ? Auth::user()->detalleUsuario->avatar : asset('storage/' . Auth::user()->detalleUsuario->avatar);
                                        @endphp

                                        <img src="{{ $avatarUrl }}" alt="{{ __('User Avatar') }}" class="rounded-full w-12 h-12 mr-0">
                                    @endif
                                        <div class="px-4">
                                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                        </div>
                                    </div>

                                        <br>
                                        <h3 class="font-bold mb-2">{{ $post->PostName }}</h3>
                                        <p>{{ $post->PostInfo }}</p>
                                        <div class="mt-4 flex justify-end">
                                            <a href="{{ route('posts.edit', $post->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded mr-2">Editar</a>
                                            <button 
                                            data-post-id="{{ $post->id }}" 
                                            class="deletePostBtn bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">
                                            Eliminar
                                        </button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 bg-white text-center">
                            <i class="fas fa-pen fa-3x mb-2 text-gray-400"></i>
                            <p class="text-gray-500">No tienes posts publicados aún.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
    window.onload = function() {
        axios.get('{{ route('posts.index') }}') 
            .then(response => {
                const posts = response.data; 
                console.log(posts); 
            })
            .catch(error => {
                console.error('Hubo un error:', error);
            });
    };

</script>

    <script>

    document.querySelectorAll('.deletePostBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.disabled = true;  // Deshabilitar el botón

            const PostId = this.getAttribute('data-post-id');

            axios.delete(`{{ route('posts.destroy', '') }}/${PostId}`)
                .then(response => {
                    console.log('Post eliminado exitosamente:', response.data);
                })
                .catch(error => {
                    console.error('Hubo un error al eliminar el Post:', error);
                })
             
        });
    });

</script>
</x-app-layout>

