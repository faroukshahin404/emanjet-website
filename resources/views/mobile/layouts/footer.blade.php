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

    @auth
        <a href="{{route('mobile.tickets')}}" class="nav-item {{ $isTickets ? 'active' : '' }}">
            <i class="fas fa-ticket-alt"></i>
            <p>{{__('Tickets')}}</p>
        </a>
        <a href="{{route('mobile.settings')}}" class="nav-item {{ $isSettings ? 'active' : '' }}">
            <i class="fas fa-user-cog"></i>
            <p>{{__('Settings')}}</p>
        </a>
    @endauth

    @guest
        <a href="{{route('auth.login')}}" class="nav-item {{ $isLogin ? 'active' : '' }}">
            <i class="fas fa-sign-in-alt"></i>
            <p>{{__('Login')}}</p>
        </a>
    @endguest

    <a href="javascript:void(0)" class="nav-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
        <i class="fas fa-bars"></i>
        <p>{{__('Menu')}}</p>
    </a>
</div>
