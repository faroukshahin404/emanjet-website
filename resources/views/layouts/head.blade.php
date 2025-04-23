<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
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
    <link rel="shortcut icon" href="{{ asset('/images/logo.png') }}" type="image/x-icon">
    <!-- apple-touch-icon -->
    <link rel="apple-touch-icon" href="{{ asset('/images/logo.png') }}">
    {{-- vendors styles  --}}
    <link rel="stylesheet" href="{{asset('/css/vendors_css.css')  }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/mobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-toastr.css') }}">

    {{-- Start Seo --}}
    @if (isset($seo) && !empty($seo))
        <title>{{ $seo['meta_title'] }}</title>
        <meta name="description" content="{{ $seo['meta_description'] }}">
        <meta name="keywords" content="{{ $seo['meta_keywords'] }}">
        <meta property="og:title" content="{{ $seo['og_title'] }}">
        <meta property="og:description" content="{{ $seo['og_description'] }}">
        <meta property="og:image" content="{{ $seo['og_image'] }}">
    @endif

    {{-- end Seo --}}
    @stack('styles')
    <title>Super Jet</title>
</head>
