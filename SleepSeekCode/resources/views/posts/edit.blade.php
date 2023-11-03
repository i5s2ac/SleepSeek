<x-app-layout>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200 space-y-6">

                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Edit Post</h2>
                        <div class="mb-0">
                            <a class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-6 rounded text-decoration-none inline-flex items-center" href="{{ route('posts.index') }}">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </a>
                        </div>
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

                    <form action="{{ route('posts.update', $post->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="PostName">Title:</label>
                                <input class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" name="PostName" type="text" placeholder="Title" value="{{ $post->PostName }}">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="PostInfo">Content:</label>
                                <textarea class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" name="PostInfo" placeholder="Content">{{ $post->PostInfo }}</textarea>
                            </div>

                            <div class="col-span-full text-center">
                                <button type="submit" class="w-full p-4 mt-4 bg-blue-500 hover:bg-blue-600 text-center text-white font-bold transition duration-300 ease-in-out transform hover:scale-105 rounded inline-flex items-center justify-center">
                                    <i class="fas fa-pencil-alt mr-2"></i> Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
