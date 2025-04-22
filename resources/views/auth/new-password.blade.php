@extends('layouts.master')

@section('content')
    <div class="reset-password-page d-flex justify-content-center align-items-center py-5">
        <div class="w-50">
            <h3 class="text-center mb-4">{{ __('Reset Password') }}</h3>

            <form action="{{ route('auth.updatePassword') }}" method="POST">
                @csrf

                <input type="hidden" name="phone" value="{{ session('reset_password_phone') }}">
                <input type="hidden" name="otp" value="{{ session('reset_password_otp') }}">

                <div class="mb-3">
                    <label for="password">{{ __('New Password') }}</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">{{ __('Save Password') }}</button>
            </form>
        </div>
    </div>
@endsection

@section('mobile-content')
    @include('mobile.auth.reset-password-new')
@endsection
