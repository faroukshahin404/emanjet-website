@extends('layouts.app')

@section('content')
    <div class="container h-100 py-4">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header text-center bg-white border-0 pt-4">
                        <h4 class="mb-0">{{ __('Phone Number Verification') }}</h4>
                    </div>

                    <div class="card-body px-4">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="text-center mb-4">
                            <div class="otp-icon-wrapper mb-3">
                                <img src="{{ asset('images/otp-icon.png') }}" alt="OTP" class="otp-icon">
                            </div>
                            <p class="text-muted">{{ __('Enter the code sent to your number') }}
                                {{ substr(session('phone'), 0, 4) }}*****{{ substr(session('phone'), -2) }}</p>
                        </div>

                        <form method="POST" action="{{ route('verifyOtp') }}" id="otpForm">
                            @csrf
                            <input type="hidden" name="phone" value="{{ session('phone') }}">
                            @include('auth.partials.otp-inputs') <!-- Include the component here -->

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100 mb-3 py-2">
                                    {{ __('Verify') }}
                                </button>

                                <form method="POST" action="{{ route('resendOtp') }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="phone" value="{{ session('phone') }}">
                                    <button type="submit" class="btn btn-link text-decoration-none" id="resendOtp"
                                        disabled>
                                        {{ __('Didn’t receive the code? Resend') }}
                                    </button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
