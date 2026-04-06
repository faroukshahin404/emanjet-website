@extends('layouts.master')

@push('styles')
    <style>
        .input-wrapper {
            position: relative;
        }
        .input-wrapper input {
            padding-inline-end: 40px;
        }
        html:dir(rtl) .input-wrapper .toggle-password {
            left: 10px;
            right: auto;
        }
        html:dir(ltr) .input-wrapper .toggle-password {
            right: 10px;
            left: auto;
        }
    </style>
@endpush

@section('content')
    <div class="register-desktop">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow pb-3">
                <div class="col-md-6">
                    <h2 class="text-center text-black mb-3">{{ __('Login') }}</h2>

                    <form action="{{ route('auth.postLogin') }}" method="POST" class="w-75 m-auto d-flex flex-column">
                        @csrf

                        <div class="position-relative mb-3">
                            <i
                                class="fa fa-phone position-absolute top-50 translate-middle-y {{ app()->getLocale() == 'ar' ? 'end-0' : 'start-0' }} px-2"></i>
                            <input
                                class="phoneInput {{ app()->getLocale() == 'ar' ? 'text-end pe-5' : 'text-start ps-5' }} @error('mobile') is-invalid @enderror"
                                type="text" name="mobile" id="mobile"
                                placeholder="{{ __('Enter your phone number') }}" value="{{ old('mobile') }}" required
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};">
                            @error('mobile')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="position-relative mb-3 input-wrapper">
                            <i
                                class="fa fa-key position-absolute top-50 translate-middle-y {{ app()->getLocale() == 'ar' ? 'end-0' : 'start-0' }} px-2"></i>
                            <input
                                class="passwordInput {{ app()->getLocale() == 'ar' ? 'text-end pe-5' : 'text-start ps-5' }} @error('password') is-invalid @enderror"
                                type="password" name="password" id="password"
                                placeholder="{{ __('Enter your password') }}" required
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};">
                            <i class="fa fa-eye toggle-password" toggle="#password"></i>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <p class="text-end mb-3">
                            <a href="{{ route('auth.forgotPassword') }}" class="text-primary">{{ __('Forget Password?') }}</a>
                        </p>

                        <p class="text-center text-muted">
                            {{ __("Don't have an account?") }}
                            <a href="{{ route('auth.register') }}" class="text-primary">{{ __('Register') }}</a>
                        </p>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="submitBtn mt-3">{{ __('Login') }}</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <img class="img-fluid" src="{{ asset('images/hero-section.png') }}" alt="{{ __('Login') }}">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('mobile-content')
    @include('mobile.auth.login')
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(element) {
            element.addEventListener('click', function() {
                const input = document.querySelector(this.getAttribute('toggle'));
                if (!input) return;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });
    </script>
@endpush
