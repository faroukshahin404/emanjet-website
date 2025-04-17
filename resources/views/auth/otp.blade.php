@extends('layouts.master')
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
</style>

@section('content')
    <!-- start otp verification -->
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
                            <p class="m-0 fs-25 text-black">تأكيد رقم الهاتف</p>
                            <div></div>
                            <div></div>
                            <div></div>
                            <a href="register-Page.html">
                                <i class="fas fa-arrow-left fs-25 text-black"></i>
                            </a>
                        </div>
                        <p class="text-black text-center fs-14 text-gray">
                            لقد أرسلنا رمز التحقق إلى رقمك المنتهي بـ {{ substr($phone, -4) }}
                        </p>
                    </div>

                    <!-- Update Form -->
                    <form action="{{ route('auth.postOtp') }}" method="POST">
                        @csrf <!-- Laravel CSRF token for protection -->

                        <div class="d-flex justify-content-center align-items-center gap-3" dir="ltr">
                            <input type="number" maxlength="1" class="otp-box text-center" id="otp1" name="otp[0]"
                                style="width: 62px; padding: 10px;" />
                            <input type="number" maxlength="1" class="otp-box text-center" id="otp2" name="otp[1]"
                                style="width: 62px; padding: 10px;" />
                            <input type="number" maxlength="1" class="otp-box text-center" id="otp3" name="otp[2]"
                                style="width: 62px; padding: 10px;" />
                            <input type="number" maxlength="1" class="otp-box text-center" id="otp4" name="otp[3]"
                                style="width: 62px; padding: 10px;" />
                        </div>
                        <p class="mt-3 text-center text-main" id="timer"></p>

                        <div class="mt-4 d-flex justify-content-center">
                            <p>
                                لم يصلك الرمز؟
                                <a class="text-main" href="javascript:void(0);" id="resendOtpLink">هل تريد إعادة
                                    إرساله؟</a>
                            </p>
                        </div>

                        <div class="col-md-12 d-flex justify-content-center align-items-center mt-5">
                            <button type="submit" class="submitBtn" id="submitOtpBtn">ارسال</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid" src="../images/hero-section.png" alt="register">
                </div>
            </div>
        </div>
    </div>
    <!-- end otp verification -->
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const otpFields = document.querySelectorAll('.otp-box');
            const timerElement = document.getElementById('timer');
            const resendOtpLink = document.getElementById('resendOtpLink');
            const RESEND_WAIT_SECONDS = 60;

            let timerInterval;

            // تشغيل العداد
            function startTimer() {
                let endTime = Date.now() + (RESEND_WAIT_SECONDS * 1000);
                localStorage.setItem('otp_resend_timer', endTime);

                updateTimer(); // أول تحديث فوري
                timerInterval = setInterval(updateTimer, 1000);
            }

            // تحديث التايمر
            function updateTimer() {
                const endTime = parseInt(localStorage.getItem('otp_resend_timer') || 0);
                const now = Date.now();
                const remainingTime = Math.floor((endTime - now) / 1000);

                if (remainingTime > 0) {
                    const minutes = Math.floor(remainingTime / 60);
                    const seconds = remainingTime % 60;
                    timerElement.textContent =
                        `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                } else {
                    clearInterval(timerInterval);
                    timerElement.textContent = '';
                    resendOtpLink.style.display = 'block';
                    localStorage.removeItem('otp_resend_timer');
                }
            }

            // لما يضغط على "إعادة الإرسال"
            resendOtpLink.addEventListener('click', function(e) {
                e.preventDefault();

                const endTime = parseInt(localStorage.getItem('otp_resend_timer') || 0);
                if (Date.now() < endTime) {
                    alert("من فضلك انتظر حتى ينتهي العداد قبل المحاولة مجددًا.");
                    return;
                }

                resendOtpLink.style.display = 'none';
                timerElement.textContent = '';

                // إرسال الطلب باستخدام Fetch API
                fetch('{{ route('auth.resendOtp') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log(data.success); // تقدر تعرض رسالة نجاح هنا
                            startTimer();
                        } else if (data.error) {
                            alert(data.error);
                            resendOtpLink.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resendOtpLink.style.display = 'block';
                        alert("حدث خطأ أثناء إرسال الرمز.");
                    });
            });

            // في حالة كان في عداد شغال من جلسة سابقة
            const savedTime = parseInt(localStorage.getItem('otp_resend_timer') || 0);
            if (savedTime > Date.now()) {
                resendOtpLink.style.display = 'none';
                startTimer();
            } else {
                resendOtpLink.style.display = 'block';
                timerElement.textContent = '';
            }

            // إعدادات الإدخال والفوكس
            const firstOtpField = document.getElementById('otp1');
            firstOtpField.focus();

            otpFields.forEach((field, index) => {
                field.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 1);
                    if (this.value && index < otpFields.length - 1) {
                        otpFields[index + 1].focus();
                    }
                });

                field.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        otpFields[index - 1].focus();
                    }

                    if (["ArrowUp", "ArrowDown"].includes(e.key)) {
                        e.preventDefault();
                    }
                });
            });

            firstOtpField.addEventListener('paste', function(e) {
                const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                if (paste.length === otpFields.length) {
                    otpFields.forEach((field, i) => {
                        field.value = paste[i];
                    });
                    otpFields[otpFields.length - 1].focus();
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush
