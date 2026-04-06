@extends('layouts.master')

<style>
    input[type=text]::-webkit-inner-spin-button,
    input[type=text]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=text] {
        -moz-appearance: textfield;
    }
</style>

@section('content')
    @include('auth.reset-password-otp', ['phone' => $phone])
@endsection

@section('mobile-content')
    @include('mobile.auth.reset-password-otp')
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const timerElement = document.getElementById('timer');
            const resendOtpLink = document.getElementById('resendOtpLink');

            const initialTime = 120;
            let timeLeft = initialTime;

            const startTimer = () => {
                const interval = setInterval(() => {
                    if (timeLeft > 0) {
                        const minutes = Math.floor(timeLeft / 60);
                        const seconds = timeLeft % 60;
                        timerElement.textContent =
                            `يرجى الانتظار ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')} قبل إعادة الإرسال`;

                        resendOtpLink.style.pointerEvents = 'none';
                        resendOtpLink.style.color = '#aaa';
                        resendOtpLink.textContent = 'جاري الانتظار...';

                        timeLeft--;
                    } else {
                        clearInterval(interval);
                        timerElement.textContent = '';
                        resendOtpLink.style.pointerEvents = 'auto';
                        resendOtpLink.style.color = '';
                        resendOtpLink.textContent = 'هل تريد إعادة إرساله؟';
                    }
                }, 1000);
            };

            startTimer();

            const inputs = document.querySelectorAll('.otp-box');
            inputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });

            // Handle paste event
            document.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').slice(0, 4);
                const digits = pastedData.split('');

                inputs.forEach((input, index) => {
                    if (digits[index]) {
                        input.value = digits[index];
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    }
                });
            });

            // Handle resend OTP
            resendOtpLink.addEventListener('click', function() {
                if (timeLeft > 0) return;

                fetch('{{ route("auth.resendOtp") }}', {
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
                        timeLeft = initialTime;
                        startTimer();
                        showAlert('success', data.message, @json(__('Success')));
                    } else {
                        showAlert('error', data.message, @json(__('Error')));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', @json(__('Error occurred while resending OTP')), @json(__('Error')));
                });
            });
        });
    </script>
@endpush
