<meta charset="utf-8" />
<meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', dashboard_project_name())</title>

<script>
    (function() {
        try {
            var stored = localStorage.getItem('planx-theme');
            var dbDefault = @json(dashboard_setting('theme.default', 'light'));
            var theme = stored || dbDefault;
            document.documentElement.setAttribute('data-theme', theme);
            if (theme === 'dark') {
                document.documentElement.style.backgroundColor = '#020617';
                document.documentElement.style.color = '#f8fafc';
            }
        } catch (e) {}
    })();
</script>

<meta name="description" content="" />

<link rel="icon" type="image/svg+xml" href="{{ dashboard_favicon() }}" />

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<link rel="stylesheet" href="{{ asset('vendor/fonts/iconify-icons.css') }}" />

<link rel="stylesheet" href="{{ asset('vendor/css/core.css') }}" />

<link rel="stylesheet" href="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

<link rel="stylesheet" href="{{ asset('css/planx-theme.css') }}" />
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}" />

@if (isRTL())
    <link rel="stylesheet" href="{{ asset('css/planx-rtl.css') }}" />
@endif

<style>
    :root {
        --primary: {{ dashboard_color('primary') }};
        --nav-active-bg: color-mix(in srgb, var(--primary) 10%, transparent);
    }

    .btn-primary,
    .bg-primary,
    .badge.bg-primary {
        background-color: {{ dashboard_color('primary') }} !important;
        border-color: {{ dashboard_color('primary') }} !important;
    }

    .text-primary {
        color: {{ dashboard_color('primary') }} !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: {{ dashboard_color('primary') }} !important;
    }
</style>

<script src="{{ asset('vendor/js/helpers.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>

@stack('styles')
@stack('css')
