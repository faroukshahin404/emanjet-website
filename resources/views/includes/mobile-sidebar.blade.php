<div class="offcanvas offcanvas-bottom h-auto" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="border-top-left-radius: 28px; border-top-right-radius: 28px; max-height: 85vh;">
    <!-- Drag Handle for Mobile feel -->
    <div class="d-lg-none w-100 d-flex justify-content-center py-3">
        <div style="width: 40px; height: 5px; background: #e0e0e0; border-radius: 10px;"></div>
    </div>
    <div class="offcanvas-header border-bottom py-3">
        <h5 class="offcanvas-title fw-bold" id="offcanvasNavbarLabel">{{ __('Menu') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav mb-4 text-center">
            <li class="nav-item mb-2">
                <a class="nav-link d-flex flex-column align-items-center gap-2 py-3 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    <i class="fas fa-home text-main fs-4"></i>
                    <span class="fs-5 fw-bold">{{ __('Home') }}</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex flex-column align-items-center gap-2 py-3 {{ request()->routeIs('destinations') ? 'active' : '' }}" href="{{ route('destinations') }}">
                    <i class="fas fa-map-marker-alt text-main fs-4"></i>
                    <span class="fs-5 fw-bold">{{ __('Destinations') }}</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex flex-column align-items-center gap-2 py-3 {{ request()->routeIs('blogs') ? 'active' : '' }}" href="{{ route('blogs') }}">
                    <i class="fas fa-newspaper text-main fs-4"></i>
                    <span class="fs-5 fw-bold">{{ __('Bus Blogs') }}</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex flex-column align-items-center gap-2 py-3 {{ request()->routeIs('about-us') ? 'active' : '' }}" href="{{ route('about-us') }}">
                    <i class="fas fa-info-circle text-main fs-4"></i>
                    <span class="fs-5 fw-bold">{{ __('About Us') }}</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex flex-column align-items-center gap-2 py-3 {{ request()->routeIs('contact-us') ? 'active' : '' }}" href="{{ route('contact-us') }}">
                    <i class="fas fa-envelope text-main fs-4"></i>
                    <span class="fs-5 fw-bold">{{ __('Contact Us') }}</span>
                </a>
            </li>
        </ul>

        <hr class="my-4 opacity-10">

        <h6 class="text-muted small text-uppercase fw-bold mb-3 text-center">{{ __('Language') }}</h6>
        <div class="d-flex justify-content-center gap-3 mb-4">
            <a class="btn {{ session('locale') != 'en' ? 'btn-main' : 'btn-light' }} d-flex flex-column align-items-center gap-1 px-4 py-2 rounded-3 text-decoration-none" href="{{ route('lang.switch', ['locale' => 'ar']) }}">
                <span class="fw-bold">العربية</span>
                @if (session('locale') != 'en') <i class="fas fa-check small"></i> @endif
            </a>
            <a class="btn {{ session('locale') == 'en' ? 'btn-main' : 'btn-light' }} d-flex flex-column align-items-center gap-1 px-4 py-2 rounded-3 text-decoration-none" href="{{ route('lang.switch', ['locale' => 'en']) }}">
                <span class="fw-bold">English</span>
                @if (session('locale') == 'en') <i class="fas fa-check small"></i> @endif
            </a>
        </div>

        @auth
            <hr class="my-4 opacity-10">
            <h6 class="text-muted small text-uppercase fw-bold mb-3 text-center">{{ __('Account') }}</h6>
            <div class="d-flex flex-column align-items-center gap-2">
                <a class="nav-link d-flex flex-column align-items-center gap-2 py-2" href="{{ route('auth.profile', ['tap' => 'profile']) }}">
                    <i class="fas fa-user-circle text-main fs-4"></i>
                    <span class="fs-5 fw-bold">{{ __('Profile') }}</span>
                </a>
                <a class="nav-link d-flex flex-column align-items-center gap-2 py-2 text-danger" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fs-4"></i>
                    <span class="fs-5 fw-bold">{{ __('Logout') }}</span>
                </a>
            </div>
        @endauth

        @guest
            <div class="mt-4 px-4">
                <a href="{{ route('auth.login') }}" class="btn btn-main w-100 py-3 rounded-pill d-flex align-items-center justify-content-center gap-3 fs-5 shadow-sm">
                    <i class="fas fa-unlock"></i>
                    <span class="fw-bold">{{ __('Login') }}</span>
                </a>
            </div>
        @endguest
    </div>
</div>
