@extends('layouts.master')

@push('styles')
<style>
   .input-wrapper {
    position: relative;
}
.input-wrapper input {
    padding-inline-end: 40px; /* logical inline padding for RTL/LTR */
}
.input-wrapper .toggle-password {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6c757d;
}

/* RTL layout */
html:dir(rtl) .input-wrapper .toggle-password {
    left: 10px;
    right: auto;
}

/* LTR layout */
html:dir(ltr) .input-wrapper .toggle-password {
    right: 10px;
    left: auto;
}

    </style>

@endpush
@section('content')
    <!-- start register  -->
    <div class="register-desktop">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow pb-3">
                <div class="col-md-6">
                    <h2 class="text-center text-black mb-3">{{ __('Register') }}</h2>

                    <form action="{{ route('auth.postRegister') }}" method="POST" class="w-75 m-auto d-flex flex-column">
                        @csrf

                        {{-- Name --}}
                        <div class="position-relative mb-3">
                            <i class="fa fa-user position-absolute top-50 translate-middle-y {{ app()->getLocale() == 'ar' ? 'end-0' : 'start-0' }} px-2"></i>
                            <input
                                class="phoneInput {{ app()->getLocale() == 'ar' ? 'text-end pe-5' : 'text-start ps-5' }}"
                                type="text"
                                name="name"
                                id="name"
                                placeholder="{{ __('Name') }}"
                                value="{{ old('name') }}"
                                required
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};"
                            >
                        </div>

                        {{-- Phone --}}
                        <div class="position-relative mb-3">
                            <i class="fa fa-phone position-absolute top-50 translate-middle-y {{ app()->getLocale() == 'ar' ? 'end-0' : 'start-0' }} px-2"></i>
                            <input
                                class="phoneInput {{ app()->getLocale() == 'ar' ? 'text-end pe-5' : 'text-start ps-5' }}"
                                type="text"
                                name="phone"
                                id="phone"
                                placeholder="{{ __('Phone Number') }}"
                                value="{{ old('phone') }}"
                                required
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};"
                            >
                        </div>

                       {{-- Password --}}
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

{{-- Confirm password --}}
<div class="position-relative mb-3 input-wrapper">
    <i class="fa fa-key position-absolute top-50 translate-middle-y {{ app()->getLocale() == 'ar' ? 'end-0' : 'start-0' }} px-2"></i>
    <input
        class="passwordInput {{ app()->getLocale() == 'ar' ? 'text-end pe-5' : 'text-start ps-5' }}"
        type="password"
        name="password_confirmation"
        id="password_confirmation"
        placeholder="{{ __('Confirm Password') }}"
        required
        style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};"
    >
    <i class="fa fa-eye toggle-password" toggle="#password_confirmation"></i>
</div>


                        <p>
                            {{ __('We will send a verification code to your phone number to confirm that you are the account owner and complete the verification successfully.') }}
                        </p>

                        <p class="text-center text-muted">
                            {{ __('If you already have an account, you can log in by clicking') }}
                            <a href="{{ route('auth.login') }}" class="text-primary">{{ __('Login') }}</a>
                        </p>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="submitBtn mt-3">{{ __('Send') }}</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <img class="img-fluid" src="{{ asset('images/hero-section.png') }}" alt="register">
                </div>
            </div>
        </div>
    </div>
    <!-- end register  -->
@endsection

@section('mobile-content')
    @include('mobile.auth.register')
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
