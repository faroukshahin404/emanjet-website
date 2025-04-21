@extends('layouts.master')

@section('content')
    <div class="register-desktop py-5">
        <div class="container">
            <div class="row justify-content-center bg-white shadow rounded-4 overflow-hidden">
                <div class="col-lg-6 col-md-8 p-5">
                    <h3 class="text-center text-black mb-4">إعادة تعيين كلمة المرور</h3>

                    <form action="{{ route('auth.updatePassword') }}" method="POST" class="d-flex flex-column gap-3">
                        @csrf

                        <div>
                            <label class="form-label text-center w-100">رمز التحقق</label>
                            <div class="d-flex justify-content-center gap-2">
                                @for ($i = 0; $i < 4; $i++)
                                    <input type="text" name="otp[]" class="form-control text-center otp-input"
                                        maxlength="1" required>
                                @endfor
                            </div>
                            <div class="text-center mt-2">
                                <button type="button" id="resendOtp" class="btn btn-link" disabled>
                                    إعادة إرسال الرمز (<span id="countdown">5:00</span>)
                                </button>
                            </div>
                        </div>

                        <div class="position-relative">
                            <i class="fa fa-key position-absolute top-50 translate-middle-y px-2 text-muted"></i>
                            <input type="password" name="password" class="form-control ps-5"
                                placeholder="كلمة المرور الجديدة" required>
                        </div>

                        <div class="position-relative">
                            <i class="fa fa-key position-absolute top-50 translate-middle-y px-2 text-muted"></i>
                            <input type="password" name="password_confirmation" class="form-control ps-5"
                                placeholder="تأكيد كلمة المرور" required>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <p class="text-center text-muted">
                            تم إرسال رمز التحقق إلى رقم <strong>{{ $phone }}</strong>
                        </p>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-4 mt-3">إعادة تعيين كلمة المرور</button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-6 d-none d-lg-block p-0">
                    <img src="{{ asset('images/hero-section.png') }}" alt="reset"
                         class="img-fluid h-100 w-100" style="object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .otp-input {
            width: 55px;
            height: 55px;
            font-size: 22px;
            direction: ltr;
        }

        @media (max-width: 576px) {
            .otp-input {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        const otpInputs = document.querySelectorAll('input[name="otp[]"]');

        otpInputs.forEach((input, idx) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && idx < otpInputs.length - 1) {
                    otpInputs[idx + 1].focus();
                }
            });

            input.addEventListener('keydown', e => {
                if (e.key === "Backspace" && input.value === '' && idx > 0) {
                    otpInputs[idx - 1].focus();
                }
            });
        });

        let timeLeft = 300;
        const countdownEl = document.getElementById('countdown');
        const resendBtn = document.getElementById('resendOtp');

        function updateCountdown() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            countdownEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft > 0) {
                timeLeft--;
                setTimeout(updateCountdown, 1000);
            } else {
                resendBtn.disabled = false;
                resendBtn.textContent = 'إعادة إرسال الرمز';
            }
        }

        updateCountdown();

        resendBtn.addEventListener('click', () => {
            resendBtn.disabled = true;
            resendBtn.textContent = 'جاري الإرسال...';
            timeLeft = 300;
            updateCountdown();

            fetch('{{ route('auth.resendOtp') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (!data.success && data.remainingMinutes) {
                    timeLeft = data.remainingMinutes * 60;
                    updateCountdown();
                }
            })
            .catch(err => {
                alert("حدث خطأ أثناء إعادة الإرسال");
                console.error(err);
            });
        });
    </script>
@endpush
