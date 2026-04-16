@extends('layouts.master')

@section('mobile-content')
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
                <h5 class="m-0 fw-800 text-black">{{ __('Forgot Password') }}</h5>
                <div style="width: 40px;"></div>
            </div>

            <div class="text-center mt-3 mb-5 wow animate__animated animate__fadeIn">
                <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                    <i class="fas fa-lock-open fs-30"></i>
                </div>
                <h4 class="fw-900 text-black mb-1">{{ __('Recover Account') }}</h4>
                <p class="text-muted fw-800 small mb-0 px-3">
                    {{ __('Enter your phone number to receive a verification code') }}
                </p>
            </div>

            <form action="{{ route('auth.resetPassword') }}" method="POST" class="wow animate__animated animate__fadeInUp">
                @csrf
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

                <div class="p-3 bg-light rounded-4 border border-light-subtle mb-5">
                    <p class="text-muted fw-800 mb-0" style="font-size: 10px; line-height: 1.5;">
                        <i class="fas fa-info-circle text-main me-1"></i>
                        {{ __('We will send a verification code to your number to confirm it is you.') }}
                    </p>
                </div>

                <div class="mb-5 pt-2">
                    <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium">
                        {{ __('Send Verification Code') }}
                    </button>
                    <div class="text-center mt-4">
                        <a href="{{ route('auth.login') }}" class="text-muted fw-800 text-decoration-none small">
                            <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} me-1" style="font-size: 8px;"></i>
                            {{ __('Back to Login') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('mobile.layouts.footer')
</div>
@endsection
