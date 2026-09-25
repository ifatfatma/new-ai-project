<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >


    {{-- =====================================================
         CSRF TOKEN
    ====================================================== --}}

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >


    {{-- =====================================================
         SEO SETTINGS
    ====================================================== --}}

    @php
        $seo = \App\Models\SeoSetting::first();
    @endphp


    <title>
        @yield(
            'title',
            $seo->meta_title ?? 'AI Prompt Hub - Discover & Share Prompts'
        )
    </title>


    <meta
        name="description"
        content="{{ $seo->meta_description ?? 'Find the best AI prompts for ChatGPT, Midjourney, and more.' }}"
    >


    <meta
        name="keywords"
        content="{{ $seo->meta_keywords ?? 'ai prompts, chatgpt prompts, midjourney prompts' }}"
    >


    {{-- =====================================================
         OPEN GRAPH
    ====================================================== --}}

    <meta
        property="og:title"
        content="{{ $seo->meta_title ?? 'AI Prompt Hub' }}"
    >


    <meta
        property="og:description"
        content="{{ $seo->meta_description ?? 'Find the best AI prompts.' }}"
    >


    @if(!empty($seo?->og_image))

        <meta
            property="og:image"
            content="{{ asset('storage/' . $seo->og_image) }}"
        >

    @else

        <meta
            property="og:image"
            content="{{ asset('images/default-og.png') }}"
        >

    @endif


    <meta
        property="og:type"
        content="website"
    >


    {{-- =====================================================
         COMMON FRONTEND CSS
    ====================================================== --}}

    @include('layouts.partials.css')


    {{-- =====================================================
         FONT AWESOME
    ====================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >


    {{-- =====================================================
         PAGE SPECIFIC CSS
    ====================================================== --}}

    @stack('styles')

</head>


<body class="d-flex flex-column min-vh-100 bg-light">


    {{-- =====================================================
         NAVBAR
         Hide navbar when $hideNavbar = true
    ====================================================== --}}

    @if(!isset($hideNavbar) || !$hideNavbar)

        @include('layouts.partials.nav', [
            'fallback' => 'layouts.partials.header'
        ])

    @endif


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <main class="flex-grow-1">

        @yield('content')

    </main>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    @include('layouts.partials.footer')


    {{-- =====================================================
         COMMON FRONTEND JS
    ====================================================== --}}

    @include('layouts.partials.js')


    {{-- =====================================================
         PAGE SPECIFIC JS
    ====================================================== --}}

    @stack('scripts')


</body>

</html>