@extends('layouts.master')

@section('mobile-content')
    <div class="mobile d-lg-none d-block" dir='rtl'>
        <div class="container mo-view mb-5 mt-3 px-4">
            <div class="row">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('auth.login') }}">
                        <i class="fas fa-arrow-right fs-18 text-black"></i>
                    </a>
                    <p class="m-0 fs-25 text-black">إعادة تعيين كلمة المرور</p>
                    <div></div>
                </div>

                <div class="mt-3 text-center">
                    <p class="m-0">
                        قم بإدخال كلمة المرور الجديدة
                    </p>
                </div>

                <div class="mt-5 d-flex justify-content-center align-items-center my-5">
                    <img src="{{ asset('images/mobile/phone-chat.png') }}" alt="phone">
                </div>

                <form action="{{ route('auth.updatePassword') }}" method="POST" class="login-form">
                    @csrf
                    <input type="hidden" name="otp" value="{{ $otp }}">

                    <div class="form-group mt-3">
                        <label for="password" class="form-label">كلمة المرور الجديدة</label>
                        <div class="position-relative">
                            <input type="password"
                                   class="form-control rounded-6 @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="أدخل كلمة المرور الجديدة"
                                   required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword(this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                        <div class="position-relative">
                            <input type="password"
                                   class="form-control rounded-6"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="أدخل كلمة المرور مرة أخرى"
                                   required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword(this)"
                               style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                        </div>
                    </div>


                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-main w-100 rounded-6">تحديث كلمة المرور</button>
                    </div>
                </form>
            </div>
        </div>
        @include('mobile.layouts.footer')
    </div>

    @push('scripts')
        <script>
            function togglePassword(icon) {
                const input = icon.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>
    @endpush
@endsection
