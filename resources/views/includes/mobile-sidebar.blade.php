<div class="offcanvas offcanvas-bottom shadow-premium" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="border-top-left-radius: 30px; border-top-right-radius: 30px; max-height: 85vh; border-top: none;">
    <!-- Drag Handle for Mobile feel -->
    <div class="d-lg-none w-100 d-flex justify-content-center py-3 pb-2 pt-4">
        <div class="bg-light rounded-pill" style="width: 40px; height: 5px;"></div>
    </div>
    
    <div class="offcanvas-header px-4 py-2">
        <h5 class="offcanvas-title fw-900 text-black" id="offcanvasNavbarLabel">{{ __('Menu') }}</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    
    <div class="offcanvas-body px-4 pb-5 pt-3">
        <ul class="navbar-nav mb-4 text-center">
            <li class="nav-item mb-2">
                <a class="nav-link d-flex flex-column align-items-center justify-content-center gap-2 py-3 rounded-4 {{ request()->routeIs('home') ? 'bg-main-light text-main' : 'text-muted hover-bg-light' }}" href="{{ route('home') }}" style="transition: all 0.3s ease;">
                    <i class="fas fa-home fs-4"></i>
                    <span class="fs-6 fw-800">{{ __('Home') }}</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex flex-column align-items-center justify-content-center gap-2 py-3 rounded-4 {{ request()->routeIs('destinations') ? 'bg-main-light text-main' : 'text-muted hover-bg-light' }}" href="{{ route('destinations') }}" style="transition: all 0.3s ease;">
                    <i class="fas fa-map-marker-alt fs-4"></i>
                    <span class="fs-6 fw-800">{{ __('Destinations') }}</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex flex-column align-items-center justify-content-center gap-2 py-3 rounded-4 {{ request()->routeIs('blogs') ? 'bg-main-light text-main' : 'text-muted hover-bg-light' }}" href="{{ route('blogs') }}" style="transition: all 0.3s ease;">
                    <i class="fas fa-newspaper fs-4"></i>
                    <span class="fs-6 fw-800">{{ __('Bus Blogs') }}</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex flex-column align-items-center justify-content-center gap-2 py-3 rounded-4 {{ request()->routeIs('about-us') ? 'bg-main-light text-main' : 'text-muted hover-bg-light' }}" href="{{ route('about-us') }}" style="transition: all 0.3s ease;">
                    <i class="fas fa-info-circle fs-4"></i>
                    <span class="fs-6 fw-800">{{ __('About Us') }}</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex flex-column align-items-center justify-content-center gap-2 py-3 rounded-4 {{ request()->routeIs('contact-us') ? 'bg-main-light text-main' : 'text-muted hover-bg-light' }}" href="{{ route('contact-us') }}" style="transition: all 0.3s ease;">
                    <i class="fas fa-envelope fs-4"></i>
                    <span class="fs-6 fw-800">{{ __('Contact Us') }}</span>
                </a>
            </li>
        </ul>

        <div class="px-2">
            <hr class="my-4 opacity-10">
        </div>

        <h6 class="text-muted small text-uppercase fw-900 mb-3 text-center px-1" style="font-size: 10px;">{{ __('Language') }}</h6>
        <div class="d-flex justify-content-center gap-3 mb-4">
            <a class="flex-fill btn {{ session('locale') != 'en' ? 'btn-main shadow-premium' : 'btn-light border-light-subtle' }} py-3 rounded-4 text-decoration-none d-flex flex-column align-items-center gap-2" href="{{ route('lang.switch', ['locale' => 'ar']) }}" style="transition: all 0.3s ease;">
                <span class="fw-800">{{ __('Arabic') }}</span>
                @if (session('locale') != 'en') <i class="fas fa-check-circle small"></i> @endif
            </a>
            <a class="flex-fill btn {{ session('locale') == 'en' ? 'btn-main shadow-premium' : 'btn-light border-light-subtle' }} py-3 rounded-4 text-decoration-none d-flex flex-column align-items-center gap-2" href="{{ route('lang.switch', ['locale' => 'en']) }}" style="transition: all 0.3s ease;">
                <span class="fw-800">{{ __('English') }}</span>
                @if (session('locale') == 'en') <i class="fas fa-check-circle small"></i> @endif
            </a>
        </div>

{{-- 
        @auth
            <div class="px-2">
                <hr class="my-4 opacity-10">
            </div>
            
            <h6 class="text-muted small text-uppercase fw-900 mb-3 text-center px-1" style="font-size: 10px;">{{ __('Account') }}</h6>
            <div class="d-flex flex-column gap-2 mb-4">
                <a class="nav-link d-flex align-items-center gap-3 p-3 rounded-4 hover-bg-light border border-light-subtle" href="{{ route('auth.profile', ['tap' => 'profile']) }}">
                    <div class="bg-main-light text-main rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="fs-6 fw-800 text-black">{{ __('Profile Settings') }}</span>
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-muted ms-auto fs-12"></i>
                </a>
                
                <a class="nav-link d-flex align-items-center gap-3 p-3 rounded-4 hover-bg-light border border-light-subtle" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <span class="fs-6 fw-800 text-danger">{{ __('Secure Logout') }}</span>
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-muted ms-auto fs-12"></i>
                </a>
            </div>
        @endauth

        @guest
            <div class="mt-4 pb-2">
                <a href="{{ route('auth.login') }}" class="btn btn-main w-100 py-3 rounded-pill d-flex align-items-center justify-content-center gap-2 fs-6 shadow-premium fw-800">
                    <i class="fas fa-unlock me-1"></i>
                    {{ __('Login to :brand', ['brand' => __('Eman Jet')]) }}
                </a>
            </div>
        @endguest
--}}
    </div>
</div>
