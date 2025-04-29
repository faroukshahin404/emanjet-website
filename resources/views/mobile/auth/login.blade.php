<div class="mobile d-lg-none d-block" dir='{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}'>
    <div class="container mo-view mb-5 mt-3 px-4">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center">
                <div></div>
                <p class="m-0 fs-25 text-black">{{ __('Login') }}</p>
                <div></div>
            </div>
            <div class="mt-5 d-flex justify-content-center align-items-center my-5">
                <img src="{{ asset('images/hero-section.png') }}" alt="login" class="welcome-img">
            </div>
            <form action="{{ route('auth.postLogin') }}" method="POST" class="login-form">
                @csrf
                <div class="form-group mb-3">
                    <label for="mobile" class="form-label">{{ __('Phone Number') }} </label>
                    <div class="position-relative">
                        <i class="fa fa-phone position-absolute top-50 translate-middle-y px-2" style="left: 10px;"></i>
                        <input type="text" class="form-control rounded-6 ps-4 @error('mobile') is-invalid @enderror"
                            id="mobile" name="mobile" placeholder="{{ __('Enter your phone number') }}"
                            value="{{ old('mobile') }}" required>
                        @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="position-relative">
                        <i class="fa fa-key position-absolute top-50 translate-middle-y px-2"></i>
                        <input type="password"
                            class="form-control rounded-6 ps-4 @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="{{ __('Enter your password') }}" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="text-end mb-3">
                    <a href="{{ route('auth.forgotPassword') }}" class="text-main"> {{ __('Forget Password?') }}</a>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-main w-100 rounded-6">{{ __('Login') }}</button>
                </div>
                <div class="text-center mt-3">
                    <p class="text-muted mb-0">{{ __("Don't have an account?") }}</p>
                    <a href="{{ route('auth.register') }}" class="text-main">{{ __('Register') }}</a>
                </div>
            </form>
        </div>
    </div>
    @include('mobile.layouts.footer')
</div>
