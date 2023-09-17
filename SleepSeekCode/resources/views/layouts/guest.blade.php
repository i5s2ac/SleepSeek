<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans text-gray-900 antialiased bg-cover bg-center relative" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)), url('https://img.freepik.com/free-photo/room-interior-hotel-bedroom_23-2150683427.jpg?t=st=1694911465~exp=1694915065~hmac=2012a749c54337c93376ec32e4e9dccb9dd2936f92c78e25348b153a17473ab3&w=1480');">
        <div class="min-h-screen flex flex-col justify-center items-center">
            <div>
            <a href="/">
                <img src="https://drive.google.com/uc?export=view&id=1AYm6YXAWB1CeNyL130UpajZSunomJA5G" style="width:500px;height:150px;" alt="Logo de mi aplicación" class="mb-3">
            </a>

            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" style="background-color: rgba(255, 255, 255, 0.8);">
                {{ $slot }}
            </div>
        </div>
    </body>

</html>
