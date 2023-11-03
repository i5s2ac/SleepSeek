<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200 space-y-6">

                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Add New Post</h2>
                        <a href="{{ route('posts.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-full">
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

                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="PostName">Title:</label>
                                <input class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" id="PostNameX" name="title" type="text" placeholder="Title">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-medium" for="PostInfo">Content:</label>
                                <textarea class="w-full p-2 border rounded focus:border-blue-500 focus:outline-none" id="PostInfoX" name="content" placeholder="Content"></textarea>
                            </div>

                            <div class="col-span-full text-center">
                                <button type="submit" id="createBtnPost" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>

                    <script>
                        document.getElementById('createBtnPost').addEventListener('click', function() {
                            event.preventDefault();
                            const PostName = document.getElementById('PostNameX').value;
                            const PostInfo = document.getElementById('PostInfoX').value;

                            // Define the data to send
                            const postData = {
                                PostName,
                                PostInfo
                            };

                            // Send the POST request with Axios
                            axios.post('{{ route('posts.store') }}', postData)
                                .then(response => {
                                    console.log('Data sent successfully:', response.data);

                                })
                                .catch(error => {
                                    console.error('There was an error sending the data:', error);
                                });
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
