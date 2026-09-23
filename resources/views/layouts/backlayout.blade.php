<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Admin Dashboard - AI Prompt Project</title>

    {{-- CSS --}}
    @include('layouts.partials.css')

</head>

<body>

    <div class="container-scroller">

        {{-- Header --}}
        @include('layouts.partials.header')


        <div class="container-fluid page-body-wrapper">

            {{-- Sidebar --}}
            @include('layouts.partials.nav')


            <div class="main-panel">

                {{-- Main Content --}}
                <div class="content-wrapper">

                    @yield('content')

                </div>
                {{-- content-wrapper ends --}}


                {{-- Footer --}}
                @include('layouts.partials.footer')

            </div>
            {{-- main-panel ends --}}

        </div>
        {{-- page-body-wrapper ends --}}

    </div>
    {{-- container-scroller --}}


    {{-- JavaScript --}}
    @include('layouts.partials.js')

</body>

</html>