<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'SLEA')</title>
    <link rel="icon" href="{{ asset('images/osas-logo-removebg.png') }}?v={{ filemtime(public_path('images/osas-logo-removebg.png')) }}" type="image/">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Global CSS -->
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">

    @yield('head')
</head>
<body class="d-flex flex-column min-vh-100 {{ session('dark_mode', false) ? 'dark-mode' : '' }}">

    {{-- Include Header --}}
    @include('partials.header')

    {{-- Sidebar Overlay (must be inside <body>) --}}
    <div class="sidebar-overlay"></div>

    {{-- Page Content --}}
    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- Include Footer --}}
    @include('partials.footer')

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/admin_profile.js') }}"></script>
    @yield('scripts')
</body>
</html>
