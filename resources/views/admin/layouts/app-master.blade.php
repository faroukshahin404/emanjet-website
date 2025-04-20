<!DOCTYPE html>
<html lang="en">

<head>
    <title>Scaled Games</title>
    @include('layouts.head')
    @livewireStyles
</head>

<body class="light-skin theme-primary fixed  h-100" style="padding: 20px;">
    <!--<div class="wrapper">-->
    @yield('content')

    
   <!--</div>-->
@livewireScripts
@stack('scripts')
</body>

</html>