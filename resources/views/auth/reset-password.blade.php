@extends('layouts.master')

@section('content')
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
                            <p class="m-0 fs-25 text-black">{{ __('Phone Number Verification') }}</p>
                            <div></div>
                            <div></div>
                            <div></div>
                            <a href="{{ route('auth.login') }}">
                                <i class="fas fa-arrow-left fs-25 text-black"></i>
                            </a>
                        </div>
                        <p class="text-black text-center fs-14 text-gray">
                            {{ __('Enter the code we sent to your number') }} {{ $phone }}
                        </p>
                    </div>

                    <form class="login-form" action="{{ config('auth.otp_enabled', true) ? route('auth.verifyResetOtp') : route('auth.updatePassword') }}" method="POST">
                        @csrf
                        @if (config('auth.otp_enabled', true))
                            @include('auth.partials.otp-inputs')
                        @endif

                        @if (config('auth.otp_enabled', true))
                            <p class="mt-3 text-center text-main">
                                <span id="timer">02:00</span>
                            </p>
                        @endif

                        @if (config('auth.otp_enabled', true))
                            <div class="mt-4 d-flex justify-content-center">
                                <p>
                                    {{ __("Didn't receive the code?") }}
                                    <a class="text-main" href="javascript:void(0)" onclick="resendOtp()" id="resendOtp">
                                        {{ __('Do you want to resend it?') }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        <div class="col-md-12 d-flex justify-content-center align-items-center mt-5">
                            <button type="submit" class="submitBtn">
                                {{ config('auth.otp_enabled', true) ? __('Verify') : __('Update Password') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 p-0">
                    <img class="img-fluid h-100 w-100" src="{{ asset('images/hero-section.png') }}" alt="otp verification"
                        style="object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        if (!@json(config('auth.otp_enabled', true))) {
            return;
        }

        // Timer functionality
        let timeLeft = 120;
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
                        timeLeft = 120;
                        clearInterval(timerInterval);
                        timerInterval = setInterval(updateTimer, 1000);
                        updateTimer();

                        // Disable resend link
                        resendLink.style.pointerEvents = 'none';
                        resendLink.style.opacity = '0.5';

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
