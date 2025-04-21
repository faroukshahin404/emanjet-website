@extends('layouts.master')

@section('content')
    <!-- Desktop View -->
    <div class="register-desktop d-none d-lg-block">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow pb-3">
                <div class="col-md-6">
                    <h2 class="text-center text-black mb-3">إعادة تعيين كلمة المرور</h2>

                    <form action="{{ route('auth.updatePassword') }}" method="POST" class="w-75 m-auto d-flex flex-column">
                        @csrf

                        {{-- رمز التحقق OTP --}}
                        <div class="mb-3">
                            <label class="form-label">رمز التحقق</label>
                            <div class="d-flex gap-2 justify-content-center">
                                @for ($i = 0; $i < 4; $i++)
                                    <input type="text" name="otp[]" class="form-control text-center" maxlength="1"
                                        pattern="[0-9]" inputmode="numeric" required style="width: 50px;">
                                @endfor
                            </div>
                            <div class="mt-3 text-center">
                                <p id="timer-section" class="text-main">
                                    <span id="countdown">00:00</span>
                                </p>
                                <div id="resend-section" class="d-none">
                                    <p>
                                        لم يصلك الرمز؟
                                        <a class="text-main" href="javascript:void(0)" onclick="resendOtp()">هل تريد إعادة إرساله؟</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- كلمة المرور الجديدة --}}
                        <div class="position-relative mb-3">
                            <i class="fa fa-key position-absolute top-50 translate-middle-y px-2"></i>
                            <input class="passwordInput" type="password" name="password" id="password"
                                placeholder="كلمة المرور الجديدة" required>
                        </div>

                        {{-- تأكيد كلمة المرور --}}
                        <div class="position-relative mb-3">
                            <i class="fa fa-key position-absolute top-50 translate-middle-y px-2"></i>
                            <input class="passwordInput" type="password" name="password_confirmation"
                                id="password_confirmation" placeholder="تأكيد كلمة المرور" required>
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

                        {{-- رسالة توضيحية --}}
                        <p class="text-center text-muted">تم إرسال رمز التحقق إلى رقم {{ $phone }}</p>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="submitBtn mt-3">إعادة تعيين كلمة المرور</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <img class="img-fluid" src="../images/hero-section.png" alt="reset password">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('mobile-content')
    @include('mobile.auth.show-reset-password')
@endsection

@push('styles')
    <style>
        .text-main {
            color: #ffc107;
        }

        .fs-18 {
            font-size: 18px;
        }

        .fs-25 {
            font-size: 25px;
        }

        .form-control {
            height: 45px;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
        }

        .otp-inputs input {
            width: 50px;
            height: 50px;
            font-size: 24px;
            padding: 0;
        }

        .login {
            background: #ffc107;
            color: white;
            border: none;
            padding: 10px 40px;
            border-radius: 8px;
            font-weight: 500;
        }

        .login:hover {
            background: #e0a800;
        }

        .btn-link {
            color: #ffc107;
        }

        .btn-link:hover {
            color: #e0a800;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let timerInterval;

        const startTimer = (initialSeconds) => {
            const timerSection = document.getElementById('timer-section');
            const resendSection = document.getElementById('resend-section');
            const countdownElement = document.getElementById('countdown');
            let timeLeft = parseInt(initialSeconds);

            if (timeLeft <= 0) {
                timerSection.classList.add('d-none');
                resendSection.classList.remove('d-none');
                return;
            }

            timerSection.classList.remove('d-none');
            resendSection.classList.add('d-none');

            clearInterval(timerInterval);
            timerInterval = setInterval(function() {
                if (timeLeft > 0) {
                    timeLeft--;
                    countdownElement.textContent = `00:${timeLeft.toString().padStart(2, '0')}`;
                } else {
                    clearInterval(timerInterval);
                    timerSection.classList.add('d-none');
                    resendSection.classList.remove('d-none');
                }
            }, 1000);
        };

        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[name="otp[]"]');
            const initialTime = 30; // Default 30 seconds

            // Start timer with initial value
            startTimer(initialTime);

            // Handle input for each box
            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    // Remove any non-numeric characters
                    this.value = this.value.replace(/[^0-9]/g, '');

                    if (this.value.length === 1) {
                        // Move to next input if available
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    }
                });

                // Handle backspace
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });

            // Handle paste for OTP
            document.querySelector('input[name="otp[]"]').addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = (e.clipboardData || window.clipboardData)
                    .getData('text')
                    .replace(/[^0-9]/g, '')
                    .substring(0, 4)
                    .split('');

                inputs.forEach((input, index) => {
                    if (pastedData[index]) {
                        input.value = pastedData[index];
                    }
                });

                if (pastedData.length < 4) {
                    inputs[pastedData.length].focus();
                } else {
                    inputs[3].focus();
                }
            });
        });

        function resendOtp() {
            fetch('{{ route('auth.resetPassword') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    phone: '{{ $phone }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Start timer with new value from backend response
                    startTimer(30);
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء إعادة إرسال الرمز');
            });
        }
    </script>
@endpush
