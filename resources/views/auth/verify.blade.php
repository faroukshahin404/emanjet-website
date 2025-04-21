<!-- resources/views/auth/verify.blade.php -->
@extends('layouts.master')

@section('content')
    <div class="verify-desktop" style="margin-top: 200px; margin-bottom: 200px;">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 ">
                <div class="col-md-12 text-center">
                    <h2 class="text-black mb-4">حسابك غير مفعل</h2>
                    <p class="text-gray">
                        لم تقم بتفعيل حسابك بعد. يجب عليك التحقق من بريدك الإلكتروني ورقم هاتفك قبل متابعة استخدام الموقع.
                    </p>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('auth.otp') }}" class="btn-search">إعادة إرسال رمز التحقق</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
