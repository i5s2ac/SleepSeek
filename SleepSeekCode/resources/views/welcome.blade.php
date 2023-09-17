<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Chamba</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Estilos de Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts de jQuery y Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .hero-section {
            position: relative;
            height: 100vh;
            display: flex;
            justify-content: start;
            align-items: center;
            padding-left: 10%;
            background-color: #f5f5f5;
            background-image: url("https://img.freepik.com/free-photo/indoor-design-luxury-resort_23-2150497283.jpg?t=st=1694911509~exp=1694915109~hmac=c7e0e4ab4444e1c7bb47503b6386a59f064991f44a39715af134cfab8baa00fd&w=1480");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6); /* Fondo negro con opacidad al 50% */
            z-index: 0;
        }

        .hero-copy {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 2.5em;
            font-weight: 600;
            margin-bottom: 20px;
            color: #ffffff; /* Color blanco para el título */
        }

        .hero-paragraph {
            font-size: 1.2em;
            max-width: 600px;
            margin-bottom: 30px;
            color: #ffffff; /* Color blanco para el párrafo */
        }

        .btn-login {
            margin-right: 10px;
            background-color: #007BFF;
            color: #fff;
        }

        .btn-login:hover {
            color: #fff; /* Color blanco en hover para el texto del botón Login */
        }

        .btn-register {
            margin-right: 10px;
            border: 2px solid #007BFF;
            background-color: transparent;
            color: #007BFF;
        }

        .btn-register:hover {
            color: #fff; /* Color blanco en hover para el texto del botón Register */
        }

        .white-text {
            color: white;
        }

        .elevated {
            position: relative;
            z-index: 2;
        }

        .btn-login {
            background-color: #00BF63; 
            color: #fff;              
        }

        .btn-login:hover {
            background-color: #00BF63; /* Un verde más oscuro para el hover */
            color: #fff;               /* Color de texto blanco al pasar el cursor */
        }

        .btn-register {
            border: 2px solid #00BF63;     /* Borde naranja */
            background-color: transparent; /* Sin fondo */
            color: #ffffff;                /* Texto naranja */
        }

        .btn-register:hover {
            background-color: #00BF63;    /* Fondo naranja al pasar el cursor */
            color: #fff;                  /* Texto blanco al pasar el cursor */
        }




    </style>
</head>

<body class="antialiased">
    <div class="hero-section">
        <div class="hero-copy">
            <div class="text-left mb-3">
                <img src="https://drive.google.com/uc?export=view&id=1AYm6YXAWB1CeNyL130UpajZSunomJA5G" style="width:500px;height:170px;" alt="Logo de mi aplicación" class="mb-0">
            </div>

            <h2 class="white-text">
                ¡Bienvenido a SleepSeek!
            </h2>

            <p class="hero-paragraph">Un software innovador para encontrar o ofrecer la estadía perfecta.</p>
            <div class="hero-cta">
                <a class="btn btn-login" href="{{ route('login') }}">Ingresa a tu cuenta</a>
                <a class="btn btn-register" href="{{ route('register') }}">¡Registrate ahora!</a>
            </div>

        </div>
        
    </div>
    
</body>

</html>
