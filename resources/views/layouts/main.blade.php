<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    
    @yield('styles')
</head>
<body>

    <header class="header">
        @include('partials.navbar') 
    </header>

    <main>
        @yield('content')
    </main>

    <!-- <footer>
        @include('partials.footer')
    </footer> -->

    <!-- <script src="{{ asset('js/app.js') }}"></script> -->

    @yield('scripts')

</body>
</html>