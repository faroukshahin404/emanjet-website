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
                <h5 class="m-0 fw-800 text-black">{{ __('Login') }}</h5>
                <div style="width: 40px;"></div>
            </div>

            <div class="text-center mt-3 mb-5 wow animate__animated animate__fadeIn">
                <img src="{{ asset('images/logo.png') }}" alt="logo" class="mb-4" style="height: 50px; width: auto;">
                <h4 class="fw-900 text-black mb-1">{{ __('Welcome Back!') }}</h4>
                <p class="text-muted fw-800 small">{{ __('Sign in to continue your journey') }}</p>
            </div>

            <form action="{{ route('auth.postLogin') }}" method="POST" class="wow animate__animated animate__fadeInUp">
                @csrf
                <div class="mb-4">
                    <label for="mobile" class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('PHONE NUMBER') }}</label>
                    <div class="input-group-premium">
                        <i class="fa fa-phone icon"></i>
                        <input type="text" class="form-control-premium @error('mobile') is-invalid @enderror"
                            id="mobile" name="mobile" placeholder="{{ __('01xxxxxxxxx') }}"
                            value="{{ old('mobile') }}" required>
                        @error('mobile')
                            <div class="invalid-feedback px-1" style="font-size: 10px; font-weight: 800;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('PASSWORD') }}</label>
                    <div class="input-group-premium">
                        <i class="fa fa-key icon"></i>
                        <input type="password"
                            class="form-control-premium @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="{{ __('••••••••') }}" required>
                        @error('password')
                            <div class="invalid-feedback px-1" style="font-size: 10px; font-weight: 800;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end mb-4">
                    <a href="{{ route('auth.forgotPassword') }}" class="text-main fw-800 text-decoration-none small">{{ __('Forget Password?') }}</a>
                </div>

                <div class="mb-4 pt-2">
                    <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium">
                        {{ __('Sign In') }}
                    </button>
                </div>

                <div class="text-center mt-5">
                    <p class="text-muted fw-800 small mb-2">{{ __("Don't have an account?") }}</p>
                    <a href="{{ route('auth.register') }}" class="text-main fw-900 text-decoration-none">{{ __('Create New Account') }}</a>
                </div>
            </form>
        </div>
    </div>
    @include('mobile.layouts.footer')
</div>
