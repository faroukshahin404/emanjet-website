@extends('layouts.master')

@section('mobile-content')
    <div class="mobile d-lg-none d-block" dir='rtl'>
        <div class="container mo-view mb-5 mt-3 px-4">
            <div class="row">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('auth.login') }}">
                        <i class="fas fa-arrow-right fs-18 text-black"></i>
                    </a>
                    <p class="m-0 fs-25 text-black">{{ __('Verify your number') }}</p>
                    <div></div>
                </div>

                <div class="mt-3 text-center">
                    <p class="m-0">
                        {{ __('Enter the code sent to your number') }}{{ $phone }}
                    </p>
                </div>

                <div class="mt-5 d-flex justify-content-center align-items-center my-5">
                    <img src="{{ asset('images/mobile/phone-chat.png') }}" alt="phone">
                </div>

                <form action="{{ route('auth.resetPassword') }}" method="POST" class="login-form">
                    @csrf
                    <input type="hidden" name="phone" value="{{ $phone }}">
                    <input type="hidden" id="initial-time" value="{{ $remainingTime ?? 0 }}">
                    <div class="d-flex justify-content-center align-items-center gap-3" dir="ltr">
                        @for ($i = 0; $i < 4; $i++)
                        <input type="text"
                        class="form-control text-center otp-box @error('otp') is-invalid @enderror"
                        name="otp[]"
                        maxlength="1"
                        pattern="[0-9]"
                        inputmode="numeric"
                        style="
                            width: 50px;
                            height: 50px;
                            font-size: 24px;
                            background-color: #eee;
                            border-radius: 8px;
                            padding: 0;
                            text-align: center;
                            line-height: 50px;
                        "
                        required>
                        @endfor
                    </div>
                    @error('otp')
                        <div class="invalid-feedback text-center">{{ $message }}</div>
                    @enderror

                    <div class="mt-3 text-center">
                        <p id="timer-section" class="{{ $remainingTime > 0 ? '' : 'd-none' }} text-main">
                            <span id="countdown">00:00</span>
                        </p>
                        <div id="resend-section" class="{{ $remainingTime > 0 ? 'd-none' : '' }}">
                            <p>
                                {{ __('Didn\'t receive the code?') }}
                                <a class="text-main" href="javascript:void(0)" onclick="resendOtp()">{{ __('Would you like to resend it?') }}</a>
                            </p>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="password" class="form-label">{{ __('New Password') }}</label>
                        <input type="password"
                               class="form-control rounded-6 @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="{{ __('Enter new password') }}">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <input type="password"
                               class="form-control rounded-6"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="{{ __('Re-enter your password') }}">
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-main w-100 rounded-6">{{ __('Reset Password') }}</button>
                    </div>

                </form>
            </div>
        </div>
        @include('mobile.layouts.footer')
    </div>

    @push('scripts')
        <script>
            let timerInterval;

            const startTimer = (initialSeconds) => {
                const timerSection = document.getElementById('timer-section');
                const resendSection = document.getElementById('resend-section');
                const countdownElement = document.getElementById('countdown');
                let timeLeft = initialSeconds;

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
                const initialTime = document.getElementById('initial-time').value || 120;

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
                        startTimer(data.remainingTime);
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
