<div class="mobile d-block" dir='rtl'>
    <div class="container mo-view mb-5 mt-3 px-4">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('auth.register') }}">
                    <i class="fas fa-arrow-right fs-18 text-black"></i>
                </a>
                <p class="m-0 fs-25 text-black">تأكيد رقم الهاتف</p>
                <div></div>
            </div>

            <div class="mt-3 text-center">
                <p class="m-0">
                    قم بادخال الرمز الذي أرسلناه إلى رقمك {{ $phone }}
                </p>
            </div>

            <div class="mt-5 d-flex justify-content-center align-items-center my-5">
                <img src="{{ asset('images/mobile/phone-chat.png') }}" alt="phone">
            </div>

            <form action="{{ route('auth.postOtp') }}" method="POST" class="login-form">
                @csrf
                <div class="d-flex justify-content-center align-items-center gap-3" dir="ltr">
                    @for ($i = 0; $i < 4; $i++)
                        <input type="text"
                            class="form-control text-center otp-box @error('otp') is-invalid @enderror" name="otp[]"
                            maxlength="1" pattern="[0-9]" inputmode="numeric"
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

                <div class="text-center mt-3">
                    <p class="m-0 text-center">
                        لم يصلك الرمز؟
                        <a id="resendOtpLink" class="text-main" href="javascript:void(0)" onclick="resendOtp()"></a>
                    </p>
                    <p class="mt-2 text-center text-main" id="mobile-timer"></p>

                </div>


                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-main w-100 rounded-6">تحقق</button>
                </div>
            </form>
        </div>
    </div>
    @include('mobile.layouts.footer')
</div>

@push('scripts')
<script>
    const otpExpiresAt = {{ $otp->expires_at->timestamp }} * 1000;
</script>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input[name="otp[]"]');
        const now = Date.now();
        const remainingSeconds = Math.max(0, Math.floor((otpExpiresAt - now) / 1000));
           // بدء العداد بالوقت المتبقي
    startTimer(remainingSeconds);

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

        function startTimer(duration) {
            let timer = duration;
            const resendOtpLink = document.getElementById('resendOtpLink');
            const timerElement = document.getElementById('mobile-timer');

            const countdown = setInterval(function() {
                const minutes = String(Math.floor(timer / 60)).padStart(2, '0');
                const seconds = String(timer % 60).padStart(2, '0');

                // عرض الوقت في عنصر منفصل
                timerElement.textContent = `يرجى الانتظار ${minutes}:${seconds} قبل إعادة الإرسال`;

                // تعطيل رابط إعادة الإرسال
                resendOtpLink.textContent = '';
                resendOtpLink.style.pointerEvents = 'none';
                resendOtpLink.style.color = '#aaa';

                if (--timer < 0) {
                    clearInterval(countdown);
                    timerElement.textContent = ''; // إخفاء نص العداد
                    resendOtpLink.textContent = 'هل تريد إعادة إرساله؟';
                    resendOtpLink.style.pointerEvents = 'auto';
                    resendOtpLink.style.color = '';
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
