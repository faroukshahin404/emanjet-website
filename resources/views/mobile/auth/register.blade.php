<div class="mobile d-lg-none d-block" dir='rtl'>
    <div class="container mo-view mb-5 mt-3 px-4">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center">
                <div></div>
                <p class="m-0 fs-25 text-black">التسجيل</p>
                <div></div>
            </div>

            <div class="mt-5 d-flex justify-content-center align-items-center my-5">
                <img src="{{ asset('images/hero-section.png') }}" alt="register" class="welcome-img">
            </div>

            <form action="{{ route('auth.postRegister') }}" method="POST" class="login-form">
                @csrf
                <div class="form-group mb-3">
                    <label for="name" class="form-label">الاسم</label>
                    <div class="position-relative">
                        <i class="fa fa-user position-absolute top-50 translate-middle-y px-2"></i>
                        <input type="text"
                               class="form-control rounded-6 ps-4 @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               placeholder="أدخل الاسم"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

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

                <div class="form-group mb-3">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <div class="position-relative">
                        <i class="fa fa-key position-absolute top-50 translate-middle-y px-2"></i>
                        <input type="password"
                               class="form-control rounded-6 ps-4 @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="أدخل كلمة المرور"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                    <div class="position-relative">
                        <i class="fa fa-key position-absolute top-50 translate-middle-y px-2"></i>
                        <input type="password"
                               class="form-control rounded-6 ps-4"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="أدخل كلمة المرور مرة أخرى"
                               required>
                    </div>
                </div>

                <p class="text-center text-muted mb-3">
                    سنقوم بإرسال رمز تحقق إلى رقم هاتفك للتأكد من أنك صاحب الحساب وإتمام عملية
                    التأكيد بنجاح
                </p>

                <div class="form-group">
                    <button type="submit" class="btn btn-main w-100 rounded-6">تسجيل</button>
                </div>

                <div class="text-center mt-3">
                    <p class="text-muted mb-0">لديك حساب بالفعل؟</p>
                    <a href="{{ route('auth.login') }}" class="text-main">تسجيل الدخول</a>
                </div>
            </form>
        </div>
    </div>
    @include('mobile.layouts.footer')
</div>
