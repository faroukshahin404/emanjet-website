@php
$url = url()->current();
$isTickets = str_contains($url, '/mobile/tickets');
$isSettings = str_contains($url, '/settings');
$isLogin = str_contains($url, '/login');
@endphp
<!-- start bottom navbar  -->
<div class="bottom-navbar fixed-bottom">
    <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="fa fa-home"></i>
        <p>{{__('Home')}}</p>
    </a>

{{-- 
14:     @auth
15:         <a href="{{route('mobile.tickets')}}" class="nav-item {{ $isTickets ? 'active' : '' }}">
16:             <i class="fas fa-ticket-alt"></i>
17:             <p>{{__('Tickets')}}</p>
18:         </a>
19:         <a href="{{route('mobile.settings')}}" class="nav-item {{ $isSettings ? 'active' : '' }}">
20:             <i class="fas fa-user-cog"></i>
21:             <p>{{__('Settings')}}</p>
22:         </a>
23:     @endauth
--}}
    <a href="{{ route('contact-us') }}" class="nav-item {{ request()->routeIs('contact-us') ? 'active' : '' }}">
        <i class="fas fa-headset"></i>
        <p>{{__('Contact Us')}}</p>
    </a>

{{-- 
25:     @guest
26:         <a href="{{route('auth.login')}}" class="nav-item {{ $isLogin ? 'active' : '' }}">
27:             <i class="fas fa-sign-in-alt"></i>
28:             <p>{{__('Login')}}</p>
29:         </a>
30:     @endguest
--}}
    <a href="{{ route('destinations') }}" class="nav-item {{ request()->routeIs('destinations') ? 'active' : '' }}">
        <i class="fas fa-map-marker-alt"></i>
        <p>{{__('Destinations')}}</p>
    </a>

    <a href="{{ route('blogs') }}" class="nav-item {{ request()->routeIs('blogs') ? 'active' : '' }}">
        <i class="fas fa-newspaper"></i>
        <p>{{__('Blogs')}}</p>
    </a>

    <a href="javascript:void(0)" class="nav-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
        <i class="fas fa-bars"></i>
        <p>{{__('Menu')}}</p>
    </a>
</div>
