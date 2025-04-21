@extends('layouts.master')

@push('styles')
<style>
    /* لإخفاء الأسهم في Chrome و Safari */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* لإخفاء الأسهم في Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .otp-desktop {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
    }

    .box-shadow {
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .otp-box {
        border: 1px solid #ddd;
        border-radius: 8px;
        text-align: center;
        font-size: 24px;
    }

    .otp-box:focus {
        border-color: #0d6efd;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
    }

    .submitBtn {
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 10px 30px;
        border-radius: 8px;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .submitBtn:hover {
        background-color: #0b5ed7;
    }

    .text-main {
        color: #0d6efd;
    }

    .text-gray {
        color: #6c757d;
    }

    .text-red {
        color: #dc3545;
    }
</style>
@endpush

@section('content')
    <!-- start OTP verification -->
    <div class="otp-desktop">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow bg-white">
                <div class="col-md-6 p-4">
                    <div class="mb-4">
                        <div class="d-flex justify-content-center gap-5 align-items-center">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <p class="m-0 fs-25 text-black">تأكيد رقم الهاتف</p>
                            <div></div>
                            <div></div>
                            <div></div>
                            <a href="{{ route('auth.login') }}">
                                <i class="fas fa-arrow-left fs-25 text-black"></i>
                            </a>
                        </div>
                        <p class="text-black text-center fs-14 text-gray">
                            قم بادخال الرمز الذي أرسلناه إلى رقمك {{ $phone }}
                        </p>
                    </div>

                    <form class="login-form" action="{{ route('auth.postOtp') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-center align-items-center gap-3">
                            <input type="number" maxlength="1" name="otp[]" class="otp-box" style="width: 62px; padding: 10px;" required />
                            <input type="number" maxlength="1" name="otp[]" class="otp-box" style="width: 62px; padding: 10px;" required />
                            <input type="number" maxlength="1" name="otp[]" class="otp-box" style="width: 62px; padding: 10px;" required />
                            <input type="number" maxlength="1" name="otp[]" class="otp-box" style="width: 62px; padding: 10px;" required />
                        </div>

                        @if($errors->has('otp'))
                            <p class="text-red fs-14 text-center">
                                {{ $errors->first('otp') }}
                            </p>
                        @endif

                        <p class="mt-3 text-center text-main">
                            <span id="timer">00:30</span>
                        </p>

                        <div class="mt-4 d-flex justify-content-center">
                            <p>
                                لم يصلك الرمز؟
                                <a class="text-main" href="javascript:void(0)" onclick="resendOtp()" id="resendOtp"> هل تريد إعادة إرساله؟</a>
                            </p>
                        </div>

                        <div class="col-md-12 d-flex justify-content-center align-items-center mt-5">
                            <button type="submit" class="submitBtn">ارسال</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 p-0">
                    <img class="img-fluid h-100 w-100" src="{{ asset('images/hero-section.png') }}" alt="otp verification" style="object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
    <!-- end OTP verification -->
@endsection

@section('mobile-content')
    @include('mobile.auth.otp')
@endsection

@push('scripts')
<script>
    // Auto-focus next input in OTP fields
    document.addEventListener('DOMContentLoaded', function() {
        const otpInputs = document.querySelectorAll('.otp-box');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });
    });

    // Timer functionality
    let timeLeft = 30;
    const timerElement = document.getElementById('timer');
    const resendLink = document.getElementById('resendOtp');

    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            resendLink.style.pointerEvents = 'auto';
            resendLink.style.opacity = '1';
        } else {
            timeLeft--;
        }
    }

    let timerInterval = setInterval(updateTimer, 1000);
    updateTimer();

    // Disable resend link initially
    resendLink.style.pointerEvents = 'none';
    resendLink.style.opacity = '0.5';

    // Resend OTP function
    function resendOtp() {
        fetch('{{ route('auth.resendOtp') }}', {
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
                // Reset timer
                timeLeft = 30;
                clearInterval(timerInterval);
                timerInterval = setInterval(updateTimer, 1000);
                updateTimer();

                // Disable resend link
                resendLink.style.pointerEvents = 'none';
                resendLink.style.opacity = '0.5';

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
