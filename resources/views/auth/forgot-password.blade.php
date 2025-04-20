@extends('layouts.master')

@section('content')
    <!-- Desktop View -->
    <div class="register-desktop d-none d-lg-block">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow pb-3">
                <div class="col-md-6">
                    <h2 class="text-center text-black mb-3">نسيت كلمة المرور</h2>

                    <form action="{{ route('auth.resetPassword') }}" method="POST" class="w-75 m-auto d-flex flex-column">
                        @csrf

                        {{-- رقم الهاتف --}}
                        <div class="position-relative mb-3">
                            <i class="fa fa-phone position-absolute top-50 translate-middle-y px-2"></i>
                            <input class="phoneInput" type="text" name="phone" id="phone" placeholder="رقم الهاتف"
                                required>
                        </div>

                        {{-- رسالة توضيحية --}}
                        <p class="text-center text-muted">أدخل رقم الهاتف المسجل لديك لإعادة تعيين كلمة المرور.</p>
                        <p class="text-center text-muted">سيتم إرسال رمز التحقق إلى رقم هاتفك.</p>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="submitBtn mt-3">إرسال رمز التحقق</button>
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


