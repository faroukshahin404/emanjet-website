@if (@$isHome)
    <nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    @else
        <nav class="navbar navbar-white navbar-expand-lg navbar-light">
@endif
<div class="container">
    <a class="navbar-brand mx-4" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', __('Eman Jet')) }}" class="d-inline-block" style="max-height: 48px; width: auto; height: auto;">
    </a>

    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="{{ __('Open navigation menu') }}">
        <i class="fas fa-bars" aria-hidden="true"></i>
    </button>

    <!-- Desktop Menu (Inline) -->
    <div class="collapse navbar-collapse d-none d-lg-flex" id="desktopNavbar">
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('destinations') ? 'active' : '' }}" href="{{ route('destinations') }}">{{ __('Destinations') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('blogs') ? 'active' : '' }}" href="{{ route('blogs') }}">{{ __('Bus Blogs') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('about-us') ? 'active' : '' }}" href="{{ route('about-us') }}">{{ __('About Us') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('contact-us') ? 'active' : '' }}" href="{{ route('contact-us') }}">{{ __('Contact Us') }}</a>
            </li>
        </ul>

        <div class="d-flex align-items-center ms-lg-3 gap-3">
            <!-- Desktop Language Switcher -->
            <div class="dropdown lang-dropdown">
                <button class="lang-btn dropdown-toggle d-flex align-items-center gap-2" type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-globe"></i>
                    <span>{{ session('locale') == 'en' ? __('English') : __('Arabic') }}</span>
                </button>
                <ul class="dropdown-menu lang-menu" aria-labelledby="langDropdown">
                    <li><a class="dropdown-item {{ session('locale') != 'en' ? 'active-lang' : '' }}" href="{{ route('lang.switch', ['locale' => 'ar']) }}">{{ __('Arabic') }}</a></li>
                    <li><a class="dropdown-item {{ session('locale') == 'en' ? 'active-lang' : '' }}" href="{{ route('lang.switch', ['locale' => 'en']) }}">English</a></li>
                </ul>
            </div>

{{-- 
            @guest
                <a class="loginBtn" href="{{ route('auth.login') }}">
                    <i class="fas fa-unlock"></i>
                    <span>{{ __('Login') }}</span>
                </a>
            @endguest

            @auth
                <div class="dropdown">
                    <button class="dropdown-toggle d-flex align-items-center gap-2 auth-btn" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <span>{{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 1)) }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('auth.profile', ['tap' => 'trips']) }}">{{ __('My Trips') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('auth.profile', ['tap' => 'profile']) }}">{{ __('Profile') }}</a></li>
                        <li><button class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">{{ __('Logout') }}</button></li>
                    </ul>
                </div>
            @endauth
--}}
        </div>
    </div>
</div>
</nav>

<style>
    /* General Navbar */
    .navbar {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        padding: 1rem 0;
        background: rgba(255, 255, 255, 0.98) !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(0,0,0,0.03);
    }
    
    @if(@$isHome)
    /* If the home navbar is meant to be transparent initially, this code handles the scroll effect */
    .navbar#navbar:not(.scrolled) {
        background: transparent !important;
        box-shadow: none;
        backdrop-filter: none;
        border-bottom: none;
    }
    @endif

    /* Nav Links */
    .navbar-nav .nav-link {
        font-weight: 600;
        color: #666; /* Default for non-home or scrolled */
        position: relative;
        padding: 0.5rem 1rem !important;
        margin: 0 0.5rem;
        transition: all 0.3s ease;
        letter-spacing: 0.3px;
        font-size: 1.05rem;
    }

    @if(@$isHome)
    .navbar#navbar:not(.scrolled) .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.9) !important;
    }
    .navbar#navbar:not(.scrolled) .navbar-nav .nav-link:hover,
    .navbar#navbar:not(.scrolled) .navbar-nav .nav-link.active {
        color: #fff !important;
    }
    /* White underline when transparent */
    .navbar#navbar:not(.scrolled) .navbar-nav .nav-link::after {
        background-color: #fff !important;
    }
    @endif

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
        color: var(--main-color) !important;
    }

    /* Premium animated underline */
    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0px;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: var(--main-color);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        transform: translateX(-50%);
        border-radius: 2px;
        opacity: 0;
    }

    .navbar-nav .nav-link:hover::after,
    .navbar-nav .nav-link.active::after {
        width: 80%;
        opacity: 1;
    }

    /* Premium Buttons */
    .loginBtn {
        background: var(--main-color);
        color: #fff !important;
        padding: 0.6rem 1.8rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: 2px solid var(--main-color);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 1rem;
    }
    
    .loginBtn:hover {
        background: transparent;
        color: var(--main-color) !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(var(--main-color-rgb), 0.15);
    }
    
    .loginBtn:hover i {
        color: var(--main-color) !important;
    }
    
    .loginBtn p {
        margin: 0;
    }

    /* Language dropdown */
    .lang-btn {
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        border: 1px solid #eaeaea;
        background-color: #fcfcfc;
        color: #333;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
    }
    
    .lang-btn:hover, .lang-btn:focus, .lang-btn[aria-expanded="true"] {
        border-color: var(--main-color);
        outline: none;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(var(--main-color-rgb), 0.1);
    }
    
    .active-lang {
        background-color: rgba(var(--main-color-rgb), 0.08) !important;
        color: var(--main-color) !important;
        font-weight: bold;
    }

    @if(@$isHome)
    .navbar#navbar:not(.scrolled) .lang-btn {
        background-color: rgba(255, 255, 255, 0.15) !important;
        border-color: rgba(255, 255, 255, 0.3) !important;
        color: #fff !important;
        backdrop-filter: blur(4px);
    }
    .navbar#navbar:not(.scrolled) .lang-btn:hover {
        background-color: rgba(255, 255, 255, 0.25) !important;
    }
    @endif

    /* Authenticated Dropdown */
    .dropdown-toggle {
        background: #fff;
        border: 1px solid #eaeaea;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        color: var(--main-color);
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .dropdown-toggle:hover, .dropdown-toggle:focus {
        border-color: var(--main-color);
        box-shadow: 0 4px 12px rgba(var(--main-color-rgb), 0.1);
    }

    .dropdown-menu {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        padding: 0.5rem;
        animation: fadeInDown 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        min-width: 200px;
        margin-top: 15px !important;
    }
    
    .lang-menu {
        min-width: 140px;
    }

    .dropdown-item {
        border-radius: 10px;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        color: #555;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .dropdown-item:hover {
        background-color: rgba(var(--main-color-rgb), 0.08);
        color: var(--main-color);
        transform: translateX(4px);
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Offcanvas sidebar styling */
    .offcanvas {
        border-radius: 24px 0 0 24px;
        border-left: none;
        box-shadow: -10px 0 40px rgba(0,0,0,0.08);
    }
    .offcanvas-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 1.5rem;
    }
    .offcanvas-title {
        font-weight: 700;
        font-size: 1.2rem;
    }
    
    /* Hamburger Menu Button */
    .navbar-toggler {
        border: none;
        padding: 0.5rem;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .navbar-toggler:focus {
        box-shadow: 0 0 0 3px rgba(var(--main-color-rgb), 0.1);
    }
    

</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navbar = document.getElementById("navbar");
        if (navbar) {
            window.addEventListener("scroll", () => {
                if (window.scrollY > 50) {
                    navbar.classList.add("scrolled");
                } else {
                    navbar.classList.remove("scrolled");
                }
            });
        }
    });
</script>