<div class="mobile d-lg-none d-block" dir='{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}'>
    <div class="container mo-view mb-5 mt-3 px-4">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-4 wow animate__animated animate__fadeIn">
                <button type="button" onclick="window.history.back()" class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center border-light-subtle" style="width: 40px; height: 40px; border: 1px solid #eee;">
                    @if (app()->getLocale() == 'ar')
                        <i class="fas fa-arrow-right fs-16 text-black"></i>
                    @else
                        <i class="fas fa-arrow-left fs-16 text-black"></i>
                    @endif
                </button>
                <h5 class="m-0 fw-800 text-black">{{ __('Register') }}</h5>
                <div style="width: 40px;"></div>
            </div>

            <div class="text-center mt-3 mb-5 wow animate__animated animate__fadeIn">
                <img src="{{ asset('images/logo.png') }}" alt="logo" class="mb-4" style="height: 50px; width: auto;">
                <h4 class="fw-900 text-black mb-1">{{ __('Create Account') }}</h4>
                <p class="text-muted fw-800 small">{{ __('Join us for a premium travel experience') }}</p>
            </div>

            <form action="{{ route('auth.postRegister') }}" method="POST" class="wow animate__animated animate__fadeInUp">
                @csrf
                <div class="mb-4">
                    <label for="name" class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('FULL NAME') }}</label>
                    <div class="input-group-premium">
                        <i class="fa fa-user icon"></i>
                        <input type="text"
                               class="form-control-premium @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               placeholder="{{ __('Enter your name') }}"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback px-1" style="font-size: 10px; font-weight: 800;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="phone" class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('PHONE NUMBER') }}</label>
                    <div class="input-group-premium">
                        <i class="fa fa-phone icon"></i>
                        <input type="text"
                               class="form-control-premium @error('phone') is-invalid @enderror"
                               id="phone"
                               name="phone"
                               placeholder="{{ __('01xxxxxxxxx') }}"
                               value="{{ old('phone') }}"
                               required>
                        @error('phone')
                            <div class="invalid-feedback px-1" style="font-size: 10px; font-weight: 800;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('PASSWORD') }}</label>
                    <div class="input-group-premium">
                        <i class="fa fa-key icon"></i>
                        <input type="password"
                               class="form-control-premium @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="{{ __('••••••••') }}"
                               required>
                        @error('password')
                            <div class="invalid-feedback px-1" style="font-size: 10px; font-weight: 800;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('CONFIRM PASSWORD') }}</label>
                    <div class="input-group-premium">
                        <i class="fa fa-key icon"></i>
                        <input type="password"
                               class="form-control-premium"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="{{ __('••••••••') }}"
                               required>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-4 border border-light-subtle mb-4">
                    <p class="text-muted fw-800 mb-0" style="font-size: 10px; line-height: 1.5;">
                        <i class="fas fa-info-circle text-main me-1"></i>
                        {{ __('Registration verification notice') }}
                    </p>
                </div>

                <div class="mb-4 pt-2">
                    <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium">
                        {{ __('Sign Up') }}
                    </button>
                </div>

                <div class="text-center mt-5">
                    <p class="text-muted fw-800 small mb-2">{{ __('Already have an account?') }}</p>
                    <a href="{{ route('auth.login') }}" class="text-main fw-900 text-decoration-none">{{ __('Login to Your Account') }}</a>
                </div>
            </form>
        </div>
    </div>
    @include('mobile.layouts.footer')
</div>
