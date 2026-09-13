<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'AI Prompt Hub - Discover & Share Prompts')</title>

    <!-- CSS Partials -->
    @include('layouts.partials.css')
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- Header / Navbar -->
    @include('layouts.partials.nav.blade.php', ['fallback' => 'layouts.partials.header'])

    <!-- Main Content Dynamic Render Area -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer Partial -->
    @include('layouts.partials.footer')

    <!-- JS Scripts Partial -->
    @include('layouts.partials.js')

    @stack('scripts')
</body>
</html>