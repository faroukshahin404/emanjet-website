@extends('layouts.master')

@section('mobile-content')
    <div class="mobile d-lg-none d-block" dir='{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}'>
        <div class="container mo-view mb-5 mt-3 px-4">
            <div class="row">
                <div class="d-flex justify-content-between align-items-center mb-4 wow animate__animated animate__fadeIn">
                    <button type="button" onclick="window.history.back()" class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center border-light-subtle" style="width: 40px; height: 40px; border: 1px solid #eee;">
                        @if (app()->getLocale() == 'ar')
                            <i class="fas fa-arrow-right fs-16 text-black"></i>
                        @else
                            <i class="fas fa-arrow-left fs-16 text-black"></i>
                        @endif
                    </button>
                    <h5 class="m-0 fw-800 text-black">{{ __('Verify Number') }}</h5>
                    <div style="width: 40px;"></div>
                </div>

                <div class="text-center mt-3 mb-5 wow animate__animated animate__fadeIn">
                    <div class="bg-main-light text-main rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-key fs-30"></i>
                    </div>
                    <h4 class="fw-900 text-black mb-1">{{ __('Enter OTP Code') }}</h4>
                    <p class="text-muted fw-800 small mb-0 px-3">
                        {{ __('Enter the code sent to your number') }}
                        <span class="text-black fw-900 d-block mt-1">{{ $phone }}</span>
                    </p>
                </div>

                <form action="{{ route('auth.verifyResetOtp') }}" method="POST" class="wow animate__animated animate__fadeInUp">
                    @csrf
                    <input type="hidden" name="phone" value="{{ $phone }}">
                    <input type="hidden" id="initial-time" value="{{ $remainingTime ?? 0 }}">
                    
                    <div class="d-flex justify-content-center align-items-center gap-3 mb-4" dir="ltr">
                        @for ($i = 0; $i < 4; $i++)
                        <input type="text"
                               class="form-control text-center otp-box-premium @error('otp') is-invalid @enderror"
                               name="otp[]"
                               maxlength="1"
                               pattern="[0-9]"
                               inputmode="numeric"
                               required>
                        @endfor
                    </div>
                    
                    @error('otp')
                        <div class="text-danger text-center fw-800 mb-3" style="font-size: 11px;">{{ $message }}</div>
                    @enderror

                    <div class="text-center mb-5">
                        <div id="timer-section" class="{{ $remainingTime > 0 ? '' : 'd-none' }}">
                            <p class="text-main fw-800 mb-0" style="font-size: 11px;">
                                <i class="fas fa-clock fs-11 me-1"></i>
                                <span id="countdown">00:00</span>
                            </p>
                        </div>
                        <div id="resend-section" class="{{ $remainingTime > 0 ? 'd-none' : '' }}">
                            <p class="text-muted fw-800 small mb-1">
                                {{ __('Didn\'t receive the code?') }}
                            </p>
                            <a class="text-main fw-900 text-decoration-none" href="javascript:void(0)" onclick="resendOtp()">
                                {{ __('Resend Code') }}
                            </a>
                        </div>
                    </div>

                    <div class="mb-5 pt-2">
                        <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium">
                            {{ __('Verify & Reset') }}
                        </button>
                        <div class="text-center mt-4">
                            <a href="{{ route('auth.login') }}" class="text-muted fw-800 text-decoration-none small">
                                <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} me-1" style="font-size: 8px;"></i>
                                {{ __('Cancel Recovery') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @include('mobile.layouts.footer')
    </div>

    @push('styles')
    <style>
        .otp-box-premium {
            width: 60px;
            height: 60px;
            font-size: 24px;
            font-weight: 900;
            color: #000;
            background-color: #f8f9fa;
            border: 2px solid #eee;
            border-radius: 16px;
            transition: all 0.3s ease;
            padding: 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }
        .otp-box-premium:focus {
            background-color: #fff;
            border-color: var(--main-color);
            box-shadow: var(--shadow-premium);
            transform: translateY(-2px);
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
                let timeLeft = initialSeconds;

                if (!timerSection || !resendSection || !countdownElement) return;

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
                        const min = String(Math.floor(timeLeft / 60)).padStart(2, '0');
                        const sec = String(timeLeft % 60).padStart(2, '0');
                        countdownElement.textContent = `${min}:${sec}`;
                    } else {
                        clearInterval(timerInterval);
                        timerSection.classList.add('d-none');
                        resendSection.classList.remove('d-none');
                    }
                }, 1000);
            };

            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('input[name="otp[]"]');
                const initialTimeElement = document.getElementById('initial-time');
                const initialTime = initialTimeElement ? initialTimeElement.value : 120;

                // Start timer with initial value
                startTimer(parseInt(initialTime));

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
                const firstInput = document.querySelector('input[name="otp[]"]');
                if(firstInput) {
                    firstInput.addEventListener('paste', function(e) {
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
                }
            });

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
                        startTimer(120);
                        showAlert('success', data.message, @json(__('Success')));
                    } else {
                        if (data.remainingTime) {
                            startTimer(data.remainingTime);
                        }
                        showAlert('error', data.message, @json(__('Error')));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', @json(__('Error occurred while resending OTP')), @json(__('Error')));
                });
            }
        </script>
    @endpush
@endsection
