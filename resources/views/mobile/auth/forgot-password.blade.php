@extends('layouts.master')

@section('mobile-content')
<div class="mobile d-lg-none d-block" dir='rtl'>
    <div class="container mo-view mb-5 mt-3 px-4">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('auth.login') }}">
                    <i class="fas fa-arrow-right fs-18 text-black"></i>
                </a>
                <p class="m-0 fs-25 text-black">نسيت كلمة المرور</p>
                <div></div>
            </div>

            <div class="mt-5 d-flex justify-content-center align-items-center my-5">
                <img src="{{ asset('images/hero-section.png') }}" alt="forgot password" class="welcome-img">
            </div>

            <form action="{{ route('auth.resetPassword') }}" method="POST" class="login-form">
                @csrf
                <div class="form-group mb-3">
                    <label for="phone" class="form-label">رقم الهاتف</label>
                    <div class="position-relative">
                        <i class="fa fa-phone position-absolute top-50 translate-middle-y px-2"></i>
                        <input type="text"
                               class="form-control rounded-6 ps-4 @error('phone') is-invalid @enderror"
                               id="phone"
                               name="phone"
                               placeholder="أدخل رقم الهاتف"
                               value="{{ old('phone') }}"
                               required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <p class="mt-2">
                    سوف نرسل لك رمز التحقق على رقمك للتأكيد على أنه أنت
                </p>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-main w-100 rounded-6">إرسال رمز التحقق</button>
                </div>
            </form>
        </div>
    </div>
    @include('mobile.layouts.footer')
</div>
@endsection
