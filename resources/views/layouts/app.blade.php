<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('user/img/favicon.png')}}" />

    <title>{{ config('app.name', 'APP_NAME') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <link href="{{asset('assets/css/global-style-rtd-it-zone.css')}}" rel="stylesheet">
    @yield('styles')
    
</head>
<body>
    <div id="main">
        <div id="app">
            <div class="overlay">


            <main class="py-4">
                @yield('content')
            </main>
        </div>
        </div>
    @yield('scripts')

        <div class="col-md-8 offset-md-2">
            <div class="card footer-bg fixed-bottom">
                <x-copyright/>
            </div>
        </div>
    </div>
</body>
</html>
