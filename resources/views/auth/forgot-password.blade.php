@extends('layouts.master')

@section('content')
    <!-- Desktop View -->
    <div class="register-desktop d-none d-lg-block">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow pb-3">
                <div class="col-md-6">
                    <h2 class="text-center text-black mb-3">{{ __('Forgot Password') }}</h2>

                    <form action="{{ route('auth.resetPassword') }}" method="POST" class="w-75 m-auto d-flex flex-column">
                        @csrf

                        {{-- Phone Number --}}
                        <div class="position-relative mb-3">
                            <i class="fa fa-phone position-absolute top-50 translate-middle-y px-2"></i>
                            <input class="phoneInput" type="text" name="phone" id="phone"
                                placeholder="{{ __('Phone Number') }}" required>
                        </div>

                        {{-- Instructional Message --}}
                        <p class="text-center text-muted">
                            {{ __('Enter the registered phone number to reset your password.') }}</p>
                        <p class="text-center text-muted">{{ __('A verification code will be sent to your phone number.') }}
                        </p>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="submitBtn mt-3">{{ __('Send Verification Code') }}</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <img class="img-fluid" src="../images/hero-section.png" alt="forgot password">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('mobile-content')
    @include('mobile.auth.forgot-password')
@endsection
