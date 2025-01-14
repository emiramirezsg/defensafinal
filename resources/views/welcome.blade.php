<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="css/welcome.css">
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="button-container">
                @if (Route::has('login'))
                    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                        @auth
                            <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">inicio</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Iniciar sesión</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Registrarse</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>


            <div class="content">
                <img src="{{ asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRhJCHravxCf_pGFdC_zF3jweoEKv1OjHkUkKgp3IbCPA&s') }}" alt="School Logo" class="logo">
                <div class="title m-b-md">
                    GESTOR DE HORARIOS DEL COLEGIO DON BOSCO
                </div>

                <div class="links">
                    <a href="http://www.epdb.edu.bo">EPDB</a>
                    <a href="https://trinidad.salesianos.edu/breve-historia-don-bosco/">¿Quien era San Juan Bosco?</a>
                </div>
            </div>
        </div>
    </body>
</html>
