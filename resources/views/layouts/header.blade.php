@if (@$isHome)
    <nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    @else
        <nav class="navbar navbar-white navbar-expand-lg navbar-light">
@endif
<div class="container">
    <a class="navbar-brand mx-4" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Super Jet') }}" class="d-inline-block" style="max-height: 48px; width: auto; height: auto;">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="{{ __('Open navigation menu') }}">
        <i class="fas fa-bars" aria-hidden="true"></i>
    </button>

    <!-- Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">{{ __('Menu') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"
                        data-lang='{"en": "Home", "ar": "الرئيسية"}'>{{ __('Home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('destinations') ? 'active' : '' }}"
                        href="{{ route('destinations') }}"
                        data-lang='{"en": "Destinations", "ar": "وجهات السفر"}'>{{ __('Destinations') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blogs') ? 'active' : '' }}" href="{{ route('blogs') }}"
                        data-lang='{"en": "Bus Blogs", "ar": "حكايات الباص"}'>{{ __('Bus Blogs') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about-us') ? 'active' : '' }}"
                        href="{{ route('about-us') }}"
                        data-lang='{"en": "About Us", "ar": "عنا"}'>{{ __('About Us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact-us') ? 'active' : '' }}"
                        href="{{ route('contact-us') }}"
                        data-lang='{"en": "Contact Us", "ar": "تواصل معنا"}'>{{ __('Contact Us') }}</a>
                </li>
            </ul>

            <select id="languageSelect" class="form-select w-auto mx-3 select-lang"
                onchange="window.location.href=this.value">
                <option value="{{ route('lang.switch', ['locale' => 'ar']) }}"
                    @if (session('locale') == 'ar') selected @endif>العربية</option>
                <option value="{{ route('lang.switch', ['locale' => 'en']) }}"
                    @if (session('locale') == 'en') selected @endif>English</option>
            </select>

            @guest
                <a class="loginBtn d-flex align-items-center" href="{{ route('auth.login') }}">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-unlock"></i>
                        <p class="m-0" data-lang='{"en": "Login", "ar": "تسجيل الدخول"}'>{{ __('Login') }}</p>
                    </div>
                </a>
            @endguest

            @auth
                <div class="dropdown mx-2 px-2 " style="width:fit-content;">
                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ __('Welcome') }}, {{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2)) }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item"
                                href="{{ route('auth.profile', ['tap' => 'trips']) }}">{{ __('My Trips') }}</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('auth.profile', ['tap' => 'profile']) }}">{{ __('Profile') }}</a>
                        </li>
                        <li>
                            <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                data-bs-target="#logoutModal">
                                {{ __('Logout') }}
                            </button>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</div>
</nav>

<style>
    .nav-link.active {
        color: #000 !important;
        font-weight: bold;
        position: relative;
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #000;
    }
</style>