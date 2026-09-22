<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fetching Global SEO Settings from Database -->
    @php
        $seo = \App\Models\SeoSetting::first();
    @endphp

    <!-- Standard Meta Tags -->
    <title>{{ $seo->meta_title ?? 'AI Prompt Hub - Default Title' }}</title>
    <meta name="description" content="{{ $seo->meta_description ?? 'Find the best AI prompts for ChatGPT, Midjourney, and more.' }}">
    <meta name="keywords" content="{{ $seo->meta_keywords ?? 'ai prompts, chatgpt prompts, midjourney prompts' }}">

    <!-- Open Graph / Social Share Tags (WhatsApp, Facebook, Twitter, etc.) -->
    <meta property="og:title" content="{{ $seo->meta_title ?? 'AI Prompt Hub' }}">
    <meta property="og:description" content="{{ $seo->meta_description ?? 'Find the best AI prompts.' }}">
    @if(isset($seo->og_image) && $seo->og_image)
        <meta property="og:image" content="{{ asset('storage/' . $seo->og_image) }}">
    @else
        <meta property="og:image" content="{{ asset('images/default-og.png') }}"> <!-- Fallback image agar admin ne upload na ki ho -->
    @endif
    <meta property="og:type" content="website">

    <!-- Baaki aapki stylesheets aur links yahan aayengi -->
    ...
</head>
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