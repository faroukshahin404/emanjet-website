<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="{{ asset('css/vendors_css.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/horizontal-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skin_color.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- @include('layouts.head') --}}
    <title>ERP</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body class="layout-top-nav light-skin theme-fruit fixed rtl">
    <div class="wrapper">


        @include('layouts.main-header')

        {{-- @include('layouts.main-sidebar') --}}

        <div class="content-wrapper">
            <div class="container-full">

                <section class="content" id="toast-container">
                    @yield('content')

                </section>

            </div>
        </div>

        @include('layouts.footer')

    </div>




    @include('layouts.footer-scripts')


    {{-- @livewireScripts --}}
    @stack('scripts')

</body>

</html>
