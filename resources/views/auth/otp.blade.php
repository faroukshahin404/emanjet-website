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
                            <p class="m-0 fs-25 text-black">{{ __('Phone Number Verification') }}</p>
                            <div></div>
                            <div></div>
                            <div></div>
                            {{-- <a href="{{  }}">
                                <i class="fas fa-arrow-left fs-25 text-black"></i>
                            </a> --}}
                        </div>
                        <p class="text-black text-center fs-14 text-gray">
                            {{ __('We have sent the verification code to your number ending with') }}
                            {{ substr($phone, -4) }}
                        </p>
                    </div>

                    <!-- Update Form -->
                    <form action="{{ route('auth.postOtp') }}" method="POST">
                        @csrf

                        <div class="d-flex justify-content-center align-items-center gap-3" dir="ltr">
                            @for ($i = 0; $i < 4; $i++)
                                <input type="text" maxlength="1" pattern="[0-9]*" inputmode="numeric"
                                    class="otp-box text-center" id="otp{{ $i + 1 }}" name="otp[{{ $i }}]"
                                    style="width: 62px; padding: 10px;" />
                            @endfor
                        </div>

                        <p class="mt-3 text-center text-main" id="timer"></p>

                        {{-- <div class="mt-4 d-flex justify-content-center">
                            <p>
                                {{ __('Didn't receive the code?') }}
                                <a class="text-main" href="javascript:void(0);" id="resendOtpLink">{{ __('Do you want to resend it?') }}</a>
                            </p>
                        </div> --}}

                        <div class="col-md-12 d-flex justify-content-center align-items-center mt-5">
                            <button type="submit" class="submitBtn" id="submitOtpBtn">{{ __('Send') }}</button>
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


@section('mobile-content')
    @include('mobile.auth.otp')
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
                    const timerElement = document.getElementById('timer');
                    const resendOtpLink = document.getElementById('resendOtpLink');

                    // تعيين الوقت الثابت (دقيقتين)
                    let remainingTime = 120; // 2 دقائق (120 ثانية)

                    const interval = setInterval(() => {
                            const minutes = Math.floor(remainingTime / 60);
                            const seconds = remainingTime % 60;

                            if (remainingTime > 0) {
                                timerElement.textContent =
                                    `{{ __('Please wait') }} ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')} {{ __('seconds') }}`;

                                if (resendOtpLink) {
                                    resendOtpLink.style.pointerEvents = 'none';
                                    resendOtpLink.style.color = '#aaa';
                                    resendOtpLink.textContent = '{{ __('waiting...') }}';
                                } else {
                                    clearInterval(interval);
                                    timerElement.textContent = '';
                                    if (resendOtpLink) {
                                        resendOtpLink.style.pointerEvents = 'auto';
                                        resendOtpLink.style.color = '';
                                        resendOtpLink.textContent = '{{ __('Do you want to resend it?') }}';
                                    }
                                }

                            }
                                remainingTime--; // تقليل الوقت المتبقي كل ثانية
                            }, 1000);

                        // Auto move to next input
                        const inputs = document.querySelectorAll('.otp-box'); inputs.forEach((input, index) => {
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
                        });

                        // Resend OTP AJAX
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
                                            alert(data.message);
                                            location.reload();
                                        } else {
                                            alert(data.message);
                                        }
                                    })
                                    .catch(() => {
                                        alert('{{ __('Error occurred while resending OTP') }}');
                                    });
                            });
                        }
                    });
    </script>
@endpush
