@extends('layouts.master')

@push('styles')
<style>
   .input-wrapper {
    position: relative;
}
.input-wrapper input {
    padding-inline-end: 40px; /* بدل padding-right علشان يدعم RTL و LTR تلقائي */
}
.input-wrapper .toggle-password {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6c757d;
}

/* لما تكون الصفحة RTL (عربي) */
html:dir(rtl) .input-wrapper .toggle-password {
    left: 10px;
    right: auto;
}

/* لما تكون الصفحة LTR (إنجليزي) */
html:dir(ltr) .input-wrapper .toggle-password {
    right: 10px;
    left: auto;
}

    </style>

@endpush
@section('content')
    <!-- start login -->
    <div class="register-desktop">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow pb-3">
                <div class="col-md-6">
                    <h2 class="text-center text-black mb-3">{{ __('Login') }}</h2>

                    <form action="{{ route('auth.postLogin') }}" method="POST" class="w-75 m-auto d-flex flex-column">
                        @csrf

                        {{-- رقم الهاتف --}}
                        <div class="position-relative mb-3">
                            <i class="fa fa-phone position-absolute top-50 translate-middle-y {{ app()->getLocale() == 'ar' ? 'end-0' : 'start-0' }} px-2"></i>
                            <input
                                class="phoneInput {{ app()->getLocale() == 'ar' ? 'text-end pe-5' : 'text-start ps-5' }}"
                                type="text" name="mobile" id="mobile"
                                placeholder="{{ __('Phone') }}"
                                value="{{ old('mobile') }}"
                                required
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};"
                            >
                        </div>

                        {{-- كلمة المرور --}}
                        <div class="position-relative mb-3 input-wrapper">
                            <i class="fa fa-key position-absolute top-50 translate-middle-y {{ app()->getLocale() == 'ar' ? 'end-0' : 'start-0' }} px-2"></i>

                            <input
                                class="passwordInput {{ app()->getLocale() == 'ar' ? 'text-end pe-5' : 'text-start ps-5' }}"
                                type="password"
                                name="password"
                                id="password"
                                placeholder="{{ __('Password') }}"
                                required
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};"
                            >

                            <i class="fa fa-eye toggle-password" toggle="#password"></i>
                        </div>


                        {{-- رابط نسيت كلمة المرور --}}
                        <div class="text-end mb-3">
                            <a href="{{ route('auth.forgotPassword') }}"
                               class="text-primary">{{ __('Forget Password?') }}</a>
                        </div>

                        {{-- رسالة توضيحية --}}
                        <p class="text-center text-muted">
                            {{ __('Enter your phone number and password to log into your account.') }}
                        </p>
                        <p class="text-center text-muted">
                            {{ __('If you don’t have an account, you can register by clicking on') }}
                            <a href="{{ route('auth.register') }}" class="text-primary">{{ __('Register') }}</a>
                        </p>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="submitBtn mt-3">{{ __('Login') }}</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <img class="img-fluid" src="{{ asset('images/hero-section.png') }}" alt="login">
                </div>
            </div>
        </div>
    </div>
    <!-- end login -->
@endsection

@section('mobile-content')
    @include('mobile.auth.login')
@endsection
@push('scripts')
<script>
    document.querySelectorAll('.toggle-password').forEach(function(element) {
        element.addEventListener('click', function() {
            const input = document.querySelector(this.getAttribute('toggle'));
            if (input.type === "password") {
                input.type = "text";
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
    </script>
@endpush
