<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('assets/css/vendors_css.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/horizontal-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skin_color.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customize_erp.css') }}">

    @stack('css')

</head>

<body class="layout-top-nav light-skin theme-fruit fixed rtl">
    <div class="wrapper">


        @include('admin.layouts.main-header')



        <div class="content-wrapper">
            @yield('breadcrumb')
            <div class="container-full">
                <section class="content-header">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </section>

                <section class="content">
                    @yield('content')
                </section>

            </div>
        </div>

    </div>





    @include('admin.layouts.footer-scripts')

    @stack('scripts')

    <script>
        function showToast(message, type) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                showCloseButton: true,
                backdrop: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: message,
            });
        }

        @if (session('success'))
            showToast("{{ session('success') }}", "success");
        @endif

        @if (session('error'))
            showToast("{{ session('error') }}", "danger");
        @endif

        @if (session('warning'))
            showToast("{{ session('warning') }}", "warning");
        @endif

        @if (session('info'))
            showToast("{{ session('info') }}", "info");
        @endif
    </script>

</body>

</html>
