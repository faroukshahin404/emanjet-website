{{-- Included from show-reset-password; do not use @extends here --}}
    <!-- start reset password verification -->
    <div class="otp-desktop">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow">
                <div class="col-md-6">
                    <div class="mb-4">
                        <div class="d-flex justify-content-center gap-5 align-items-center">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <p class="m-0 fs-25 text-black">{{ __('Confirm Password Reset Code') }}</p>
                            <div></div>
                            <div></div>
                            <div></div>
                            <a href="javascript:history.back()">
                                <i class="fas fa-arrow-left fs-25 text-black"></i>
                            </a>
                        </div>
                        <p class="text-black text-center fs-14 text-gray">
                            {{ __('We have sent the verification code to your number ending with') }}
                            {{ substr($phone, -4) }}
                        </p>
                    </div>

                    <form action="{{ route('auth.verifyResetOtp') }}" method="POST">
                        @csrf
                        <input type="hidden" name="phone" value="{{ $phone }}">

                        <div class="d-flex justify-content-center align-items-center gap-3" dir="ltr">
                            @for ($i = 0; $i < 4; $i++)
                                <input type="text" maxlength="1" pattern="[0-9]*" inputmode="numeric"
                                    class="otp-box text-center" id="otp{{ $i + 1 }}" name="otp[{{ $i }}]"
                                    style="width: 62px; padding: 10px;" />
                            @endfor
                        </div>

                        <p class="mt-3 text-center text-main" id="timer"></p>

                        <div class="mt-4 d-flex justify-content-center">
                            <p>
                                {{ __("Didn't receive the code?") }}
                                <a class="text-main" href="javascript:void(0);"
                                    id="resendOtpLink">{{ __('Do you want to resend it?') }}</a>
                            </p>
                        </div>

                        <div class="col-md-12 d-flex justify-content-center align-items-center mt-5">
                            <button type="submit" class="submitBtn" id="submitOtpBtn">{{ __('Confirm') }}</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <img class="img-fluid" src="../images/hero-section.png" alt="verify reset code">
                </div>
            </div>
        </div>
    </div>
    <!-- end reset password verification -->

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const timerElement = document.getElementById('timer');
            const resendOtpLink = document.getElementById('resendOtpLink');

            const initialTime = 120;
            let timeLeft = initialTime;

            const waitPrefix = @json(__('Please wait'));
            const waitSuffix = @json(__('before resending'));
            const waitingLabel = @json(__('waiting...'));
            const resendLabel = @json(__('Would you like to resend it?'));

            const startTimer = () => {
                const interval = setInterval(() => {
                    if (timeLeft > 0) {
                        const minutes = Math.floor(timeLeft / 60);
                        const seconds = timeLeft % 60;
                        const clock = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
                        if (timerElement) {
                            timerElement.textContent = waitPrefix + ' ' + clock + ' ' + waitSuffix;
                        }
                        if (resendOtpLink) {
                            resendOtpLink.style.pointerEvents = 'none';
                            resendOtpLink.style.color = '#aaa';
                            resendOtpLink.textContent = waitingLabel;
                        }

                        timeLeft--;
                    } else {
                        clearInterval(interval);
                        if (timerElement) {
                            timerElement.textContent = '';
                        }
                        if (resendOtpLink) {
                            resendOtpLink.style.pointerEvents = 'auto';
                            resendOtpLink.style.color = '';
                            resendOtpLink.textContent = resendLabel;
                        }
                    }
                }, 1000);
            };

            if (timerElement && resendOtpLink) {
                startTimer();
            }

            const inputs = document.querySelectorAll('.otp-box');
            inputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === "Backspace" && input.value === "" && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                // paste event
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = (e.clipboardData || window.clipboardData)
                        .getData('text')
                        .replace(/[^0-9]/g, '')
                        .substring(0, 4)
                        .split('');

                    inputs.forEach((inp, idx) => {
                        inp.value = pastedData[idx] ?? '';
                    });

                    const filled = pastedData.length;
                    if (filled < 4) {
                        inputs[filled].focus();
                    } else {
                        inputs[3].focus();
                    }
                });
            });

            if (resendOtpLink) {
                resendOtpLink.addEventListener('click', function() {
                    fetch("{{ route('auth.resendOtp') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                phone: "{{ $phone }}"
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showAlert('success', data.message, @json(__('Success')));
                                timeLeft = initialTime;
                                startTimer();
                            } else {
                                showAlert('error', data.message, @json(__('Error')));
                            }
                        })
                        .catch(() => {
                            showAlert('error', @json(__('Error occurred while resending OTP')), @json(__('Error')));
                        });
                });
            }
        });
    </script>
@endpush
