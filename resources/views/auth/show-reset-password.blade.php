@extends('layouts.master')

<style>
    input[type=text]::-webkit-inner-spin-button,
    input[type=text]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=text] {
        -moz-appearance: textfield;
    }
</style>

@section('content')
    @include('auth.reset-password-otp', ['phone' => $phone])
@endsection

@section('mobile-content')
    @include('mobile.auth.reset-password-otp')
@endsection
