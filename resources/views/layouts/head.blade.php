<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Fonts -->
    <!-- Favicon: place files in public/images/favicon/ (see site.webmanifest for PWA icons) -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon/favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MDB CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <!-- Favicon -->
    {{-- <link rel="shortcut icon" href="{{ asset('/images/logo.png') }}" type="image/x-icon"> --}}
    <!-- apple-touch-icon -->
    {{-- vendors styles  --}}
    <link rel="stylesheet" href="{{ asset('/css/vendors_css.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/mobile.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Google Tag Manager -->
    <meta name="google-site-verification" content="J0IOSNc26_xIWUUhWfg8hvPd19qlI_-Dews37H_qhB0" />
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-N3NL6Z9H');
    </script>
    <!-- End Google Tag Manager -->
    {{-- Single document title: SEO payload or default / per-page override --}}
    @if (isset($seo) && !empty($seo))
        <title>{{ $seo['meta_title'] }}</title>
        <meta name="description" content="{{ $seo['meta_description'] }}">
        <meta name="keywords" content="{{ $seo['meta_keywords'] }}">
        <meta property="og:title" content="{{ $seo['og_title'] }}">
        <meta property="og:description" content="{{ $seo['og_description'] }}">
        <meta property="og:image" content="{{ $seo['og_image'] }}">
    @else
        <title>@yield('meta_title', 'Super Jet')</title>
    @endif

    @stack('styles')
    <style>
        #site-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 99999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.4s ease;
        }
    
        #site-loader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
    
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #ddd;
            border-top-color: var(--main-color); /* your primary color */
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
    
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    
</head>
