<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('assets/css/vendors_css.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/horizontal-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skin_color.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customize_erp.css') }}">
    @stack('css')
    <title>Dashboard</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

    <div class="wrapper">
        <div id="loader"></div>
        @include('admin.layouts.header')

        @include('admin.layouts.side-bar')

        <div class="content-wrapper">
            <div class="container-full">
                <section class="content">
                    @yield('content')
                </section>
            </div>
        </div>
    </div>
    @include('admin.layouts.footer-scripts')
</body>

</html>
