@extends('layouts.app')

@section('content')
<div class="container h-100 py-4">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header text-center bg-white border-0 pt-4">
                    <h4 class="mb-0">{{ __('التحقق من رقمك') }}</h4>
                </div>

                <div class="card-body px-4">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <div class="otp-icon-wrapper mb-3">
                            <img src="{{ asset('images/otp-icon.png') }}" alt="OTP" class="otp-icon">
                        </div>
                        <p class="text-muted">أدخل الرمز الذي تم إرساله إلى رقمك {{ substr(session('phone'), 0, 4) }}*****{{ substr(session('phone'), -2) }}</p>
                    </div>

                    <form method="POST" action="{{ route('verifyOtp') }}" id="otpForm">
                        @csrf
                        <input type="hidden" name="phone" value="{{ session('phone') }}">

                        <div class="otp-inputs text-center mb-4">
                            <div class="otp-grid">
                                @for ($i = 3; $i >= 0; $i--)
                                    <input type="text"
                                           name="otp[]"
                                           class="form-control otp-input text-center"
                                           maxlength="1"
                                           pattern="[0-9]"
                                           inputmode="numeric"
                                           autocomplete="one-time-code"
                                           required>
                                @endfor
                            </div>
                            <div class="countdown text-center mt-3">
                                <span id="timer" class="text-muted">00:30</span>
                            </div>
                            @error('otp')
                                <div class="text-danger mt-2">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100 mb-3 py-2">
                                {{ __('تحقق') }}
                            </button>

                            <form method="POST" action="{{ route('resendOtp') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="phone" value="{{ session('phone') }}">
                                <button type="submit" class="btn btn-link text-decoration-none" id="resendOtp" disabled>
                                    {{ __('لم يصلك الرمز؟ إعادة إرسال') }}
                                </button>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
html, body {
    height: 100%;
}

.container {
    min-height: calc(100vh - 60px); /* Adjust based on your navbar height */
    padding-bottom: 60px; /* Height of your bottom navigation */
}

/* تصميم متجاوب */
.card {
    margin: 0;
    border-radius: 15px;
    background: white;
}

@media (max-width: 768px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .card-body {
        padding: 1.5rem;
    }
}

/* أيقونة OTP */
.otp-icon-wrapper {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background-color: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.otp-icon {
    width: 40px;
    height: 40px;
    object-fit: contain;
}

/* حقول OTP */
.otp-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    max-width: 280px;
    margin: 0 auto;
}

.otp-input {
    width: 100%;
    height: 50px;
    font-size: 24px;
    border-radius: 8px;
    border: 1px solid #ced4da;
    background: #fff;
}

@media (max-width: 380px) {
    .otp-grid {
        gap: 5px;
    }
    .otp-input {
        height: 45px;
        font-size: 20px;
    }
}

.otp-input:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

/* العد التنازلي */
.countdown {
    font-size: 14px;
}

/* الأزرار */
.btn-primary {
    border-radius: 8px;
    font-weight: 500;
}

.btn-link {
    color: #6c757d;
}

.btn-link:hover {
    color: #ffc107;
}

/* التحميل والحالات */
.alert {
    border-radius: 8px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    const form = document.getElementById('otpForm');
    const resendButton = document.getElementById('resendOtp');
    const timerDisplay = document.getElementById('timer');
    let countdown = calculateRemainingTime();
    let timer;

    // دالة لحساب الوقت المتبقي
    function calculateRemainingTime() {
        const expiresAt = new Date('{{ session("otp_expires_at") }}');
        const now = new Date();
        const diff = Math.floor((expiresAt - now) / 1000);
        return Math.max(0, diff);
    }

    // التنقل التلقائي بين حقول OTP
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            if (e.target.value.length === 1) {
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            }
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });

        // معالجة اللصق
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').slice(0, 4);
            if (/^\d+$/.test(pastedData)) {
                pastedData.split('').forEach((digit, i) => {
                    if (i < otpInputs.length) {
                        otpInputs[i].value = digit;
                        if (i < otpInputs.length - 1) {
                            otpInputs[i + 1].focus();
                        }
                    }
                });
            }
        });
    });

    // منع إدخال غير الأرقام
    otpInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    function updateTimer() {
        if (countdown > 0) {
            const minutes = Math.floor(countdown / 60);
            const seconds = countdown % 60;
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            resendButton.disabled = true;
            countdown--;
            timer = setTimeout(updateTimer, 1000);
        } else {
            timerDisplay.textContent = '00:00';
            resendButton.disabled = false;
        }
    }

    // بدء العد التنازلي
    updateTimer();

    // التركيز على أول حقل عند تحميل الصفحة
    otpInputs[0].focus();
});
</script>
@endpush
@endsection
