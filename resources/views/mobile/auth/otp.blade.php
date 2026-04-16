<div class="mobile d-block" dir='{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}'>
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
                <h5 class="m-0 fw-800 text-black">{{ __('OTP Verification') }}</h5>
                <div style="width: 40px;"></div>
            </div>

            <div class="text-center mt-3 mb-5 wow animate__animated animate__fadeIn">
                <div class="bg-main-light text-main rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                    <i class="fas fa-mobile-alt fs-30"></i>
                </div>
                <h4 class="fw-900 text-black mb-1">{{ __('Verify Your Phone') }}</h4>
                <p class="text-muted fw-800 small mb-0 px-3">
                    {{ __('Enter the code sent to your number') }}
                    <span class="text-black fw-900 d-block mt-1">{{ $phone }}</span>
                </p>
            </div>

            <form action="{{ route('auth.postOtp') }}" method="POST" class="wow animate__animated animate__fadeInUp">
                @csrf
                <div class="d-flex justify-content-center align-items-center gap-3 mb-4" dir="ltr">
                    @for ($i = 0; $i < 4; $i++)
                        <input type="text"
                            class="form-control text-center otp-box-premium @error('otp') is-invalid @enderror" name="otp[]"
                            maxlength="1" pattern="[0-9]" inputmode="numeric"
                            required>
                    @endfor
                </div>
                
                @error('otp')
                    <div class="text-danger text-center fw-800 mb-3" style="font-size: 11px;">{{ $message }}</div>
                @enderror

                <div class="text-center mb-5">
                    <p class="text-muted fw-800 small mb-1">
                        {{ __('Didn\'t receive the code?') }}
                    </p>
                    <a id="resendOtpLink" class="text-main fw-900 text-decoration-none" href="javascript:void(0)" onclick="resendOtp()"></a>
                    <p class="mt-2 text-main fw-800" id="mobile-timer" style="font-size: 11px;"></p>
                </div>

                <div class="mb-5 pt-2">
                    <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium">
                        {{ __('Verify & Continue') }}
                    </button>
                    <div class="text-center mt-4">
                        <a href="{{ route('auth.register') }}" class="text-muted fw-800 text-decoration-none small">
                            <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} me-1" style="font-size: 8px;"></i>
                            {{ __('Back to Registration') }}
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
const otpExpiresAt = {{ $otp?->expires_at?->timestamp ?? 'null' }} * 1000;

</script>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input[name="otp[]"]');
        const now = Date.now();
        const remainingSeconds = Math.max(0, Math.floor((otpExpiresAt - now) / 1000));
           startTimer(remainingSeconds);

            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');

                    if (this.value.length === 1) {
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    }
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });

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

        function startTimer(duration) {
            let timer = duration;
            const resendOtpLink = document.getElementById('resendOtpLink');
            const timerElement = document.getElementById('mobile-timer');
            const waitPrefix = @json(__('Please wait'));
            const waitSuffix = @json(__('before resending'));

            const countdown = setInterval(function() {
                const minutes = String(Math.floor(timer / 60)).padStart(2, '0');
                const seconds = String(timer % 60).padStart(2, '0');

                if(timerElement) {
                    timerElement.textContent = `${waitPrefix} ${minutes}:${seconds} ${waitSuffix}`;
                }

                if(resendOtpLink) {
                    resendOtpLink.textContent = '';
                    resendOtpLink.style.pointerEvents = 'none';
                    resendOtpLink.style.color = '#aaa';
                }

                if (--timer < 0) {
                    clearInterval(countdown);
                    if(timerElement) timerElement.textContent = '';
                    if(resendOtpLink) {
                        resendOtpLink.textContent = @json(__('Resend Code'));
                        resendOtpLink.style.pointerEvents = 'auto';
                        resendOtpLink.style.color = '';
                    }
                }
            }, 1000);
        }


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
