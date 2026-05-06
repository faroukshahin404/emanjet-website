<!-- resources/views/auth/verify.blade.php -->
@extends('layouts.master')

@section('content')
    <div class="verify-desktop" style="margin-top: 200px; margin-bottom: 200px;">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 ">
                <div class="col-md-12 text-center">
                    <h2 class="text-black mb-4">{{ __('Your account is not verified') }}</h2>
                    <p class="text-gray">
                        {{ __('You have not verified your account yet. Please verify your phone number to continue using the site.') }}
                    </p>
                    @if (config('auth.otp_enabled', true))
                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('auth.otp') }}" class="btn-search">
                                {{ __('Resend verification code') }}
                            </a>
                        </div>
                    @else
                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('home') }}" class="btn-search">
                                {{ __('Go to Home') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
