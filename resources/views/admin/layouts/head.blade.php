<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="{{ url('front/assests/logo.png') }}" />

<title>iNote - ERP</title>

<link rel="stylesheet" href="{{ asset('admin_new/css/vendors_css.css') }}">
<!-- Bootstrap 4.0-->
<link rel="stylesheet" href="{{ asset('admin_new/assets/vendor_components/bootstrap/dist/css/bootstrap.css') }}">

<!-- daterange picker -->
<link rel="stylesheet"
    href="{{ asset('admin_new/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.css') }}">

<!-- Morris charts -->
<link rel="stylesheet" href="{{ asset('admin_new/assets/vendor_components/morris.js/morris.css') }}">

<!-- theme style -->
<link rel="stylesheet" href="{{ asset('admin_new/css/horizontal-menu.css') }}">

<!-- theme style -->
<link rel="stylesheet" href="{{ asset('admin_new/css/style.css') }}">

<!-- CrmX Admin skins -->
<link rel="stylesheet" href="{{ asset('admin_new/css/skin_color.css') }}">



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Toastr CSS -->

<link rel="stylesheet" href="{{ asset('js/jquery.min.js') }}">

<link rel="stylesheet" href="{{ asset('admin_new/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('admin_new/css/skin_color.css') }}">
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<link rel="stylesheet" href="{{ asset('css/customize_erp.css') }}">

@yield('css')
@yield('style')
@livewireStyles
