@extends('layouts.master')

@section('content')
    <!-- start login -->
    <div class="register-desktop">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow pb-3">
                <div class="col-md-6">
                    <h2 class="text-center text-black mb-3">تسجيل الدخول</h2>

                    <form action="{{ route('auth.postLogin') }}" method="POST" class="w-75 m-auto d-flex flex-column">
                        @csrf

                        {{-- رقم الهاتف --}}
                        <div class="position-relative mb-3">
                            <i class="fa fa-phone position-absolute top-50 translate-middle-y px-2"></i>
                            <input class="phoneInput" type="text" name="mobile" id="mobile" placeholder="رقم الهاتف"
                                value="{{ old('mobile') }}" required>
                        </div>

                        {{-- كلمة المرور --}}
                        <div class="position-relative mb-3">
                            <i class="fa fa-key position-absolute top-50 translate-middle-y px-2"></i>
                            <input class="passwordInput" type="password" name="password" id="password"
                                placeholder="كلمة المرور" required>
                        </div>

                        {{-- رابط نسيت كلمة المرور --}}
                        <div class="text-end mb-3">
                            <a href="{{ route('auth.forgotPassword') }}" class="text-primary">نسيت كلمة المرور؟</a>
                        </div>

                        {{-- رسالة توضيحية --}}
                        <p class="text-center text-muted">أدخل رقم الهاتف وكلمة المرور لتسجيل الدخول إلى حسابك.</p>
                        <p class="text-center text-muted">إذا كنت لا تمتلك حسابًا، يمكنك التسجيل من خلال الضغط على
                            <a href="{{ route('auth.register') }}" class="text-primary">تسجيل جديد</a>
                        </p>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="submitBtn mt-3">دخول</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <img class="img-fluid" src="../images/hero-section.png" alt="login">
                </div>
            </div>
        </div>
    </div>
    <!-- end login -->
@endsection

@section('mobile-content')
    @include('mobile.auth.login')
@endsection
