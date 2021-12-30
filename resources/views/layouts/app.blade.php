<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SISTEMA INTEGRAL DE COLAS PARA EL FOVIPOL, ELABORADO EN LA UTIC">
    <meta name="author" content="Ing. Yoel Coronel A.">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="urlBase" content="{{ env('APP_URL')}}">
    <meta name="timerProgressBarCall" content="{{ env('TIMER_PROGREE_BAR_CALL','60000')}}">
    <meta name="speak_enable" content="{{ config('app.speak_enable') }}">
    <meta name="speak_time_reload" content="{{ config('app.speak_time_reload') }}">

    <meta name="nameApp" content="{{ config('app.name', 'Laravel') }}">
    <link rel="shortcut icon" href="{{asset('img/icon.png')}}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <!--<link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->
    <!-- Styles -->

    <link href="{{ asset('css/ycoronelui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.plyr.io/3.2.4/plyr.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Amaranth&display=swap" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div id="app" class="wrapper">

        <!-- Entrada Preloader -->
        @guest
            <div class="preloader flex-column justify-content-center
            align-items-center">
                <img class="animation__shake" src="./img/icon.png" alt="FOVIPOL" height="60" width="60">
            </div>
        @endguest
        @auth

            @include('layouts.includes.navbar')

            @include('layouts.includes.side')

            @include('layouts.includes.content')

            @include('layouts.includes.footer')

        @endauth

        @guest
            <main class="py-4">
                @yield('content')
            </main>
        @endauth
        <notifications group="notification" />

        <notifications group="errores" />


    </div>

    <!-- Scripts -->

    <script src="{{ asset('js/ycoronelui.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!--<script src="https://cdn.plyr.io/3.2.4/plyr.js"></script> -->
    <script src="{{ asset('js/responsivevoice.js') }}"></script>

    <script>



    </script>

</body>
</html>
