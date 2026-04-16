@extends('layouts.master')
@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center mb-4 wow animate__animated animate__fadeIn">
        <button type="button" onclick="window.history.back()" class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center border-light-subtle" style="width: 40px; height: 40px; border: 1px solid #eee;">
            @if (app()->getLocale() == 'ar')
                <i class="fas fa-arrow-right fs-16 text-black"></i>
            @else
                <i class="fas fa-arrow-left fs-16 text-black"></i>
            @endif
        </button>
        <h5 class="m-0 fw-800 text-black">{{ __('Booking Summary') }}</h5>
        <div style="width: 40px;"></div>
    </div>

    @php
        $selectedSeats = json_decode(request()->selected_seats);
    @endphp

    <!-- Trip Details Card -->
    <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-3 mb-4 wow animate__animated animate__fadeInUp">
        <div class="mb-3 pb-3 border-bottom border-light-subtle">
            <span class="text-muted fw-800 overline-text d-block mb-2" style="font-size: 9px;">{{ __('JOURNEY') }}</span>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex flex-column align-items-center">
                    <div class="bg-success rounded-circle" style="width: 10px; height: 10px;"></div>
                    <div class="bg-light" style="width: 2px; height: 30px; margin: 2px 0;"></div>
                    <div class="bg-main rounded-circle" style="width: 10px; height: 10px;"></div>
                </div>
                <div class="d-flex flex-column justify-content-between gap-2">
                    <span class="fw-800 text-black small">{{ $fromStation->name }}</span>
                    <span class="fw-800 text-black small">{{ $toStation->name }}</span>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-6">
                <span class="text-muted fw-800 d-block mb-1" style="font-size: 9px;">{{ __('DATE') }}</span>
                <span class="text-black fw-800 small d-block">{{ $tripDate }}</span>
            </div>
            <div class="col-6 text-end">
                <span class="text-muted fw-800 d-block mb-1" style="font-size: 9px;">{{ __('TIME') }}</span>
                <span class="text-black fw-800 small d-block">{{ $tripTime }}</span>
            </div>
            <div class="col-6">
                <span class="text-muted fw-800 d-block mb-1" style="font-size: 9px;">{{ __('SEATS') }}</span>
                <span class="text-black fw-800 small d-block">
                    @foreach ($selectedSeats as $seat)
                        {{ $seat->name }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </span>
            </div>
            <div class="col-6 text-end">
                <span class="text-muted fw-800 d-block mb-1" style="font-size: 9px;">{{ __('PASSENGERS') }}</span>
                <span class="text-black fw-800 small d-block">{{ count($selectedSeats) }}</span>
            </div>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-3 mb-4 wow animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <span class="text-muted fw-800 overline-text d-block mb-3" style="font-size: 9px;">{{ __('PERSONAL INFORMATION') }}</span>
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="bg-light text-main rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <span class="text-black fw-800 small d-block">{{ auth()->user()->name }}</span>
                <span class="text-muted fw-800 d-block" style="font-size: 11px;">{{ auth()->user()->mobile }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Breakdown -->
    <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-3 mb-4 wow animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <span class="text-muted fw-800 overline-text d-block mb-3" style="font-size: 9px;">{{ __('PAYMENT DETAILS') }}</span>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted fw-800 small">{{ count($selectedSeats) }} {{ __('seats') }}</span>
            <span class="text-black fw-800 small">{{ array_sum(array_column($selectedSeats, 'price')) }} {{ __('EGP') }}</span>
        </div>
        <div class="d-flex justify-content-between align-items-center pt-2 mt-2 border-top border-light-subtle">
            <span class="text-black fw-800">{{ __('Total Amount') }}</span>
            <span class="text-main fw-900 fs-18">{{ array_sum(array_column($selectedSeats, 'price')) }} {{ __('EGP') }}</span>
        </div>
    </div>

    <form action="{{ route('one-way.confirm-booking') }}" method="POST" class="wow animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
        @csrf
        <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-3 mb-4">
            <span class="text-muted fw-800 overline-text d-block mb-3" style="font-size: 9px;">{{ __('SELECT PAYMENT METHOD') }}</span>
            
            <div class="d-flex flex-column gap-3">
                <div class="payment-option">
                    <input class="form-check-input d-none" type="radio" name="payment_method" value="qnb" id="qnb" checked>
                    <label class="d-flex align-items-center justify-content-between p-3 rounded-4 border border-light-subtle w-100 mb-0" for="qnb" style="cursor: pointer; transition: all 0.3s ease;">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-credit-card text-main fs-20"></i>
                            <span class="fw-800 text-black small">Debit/Credit Card</span>
                        </div>
                        <div class="d-flex gap-1">
                            <img src="{{ asset('images/pay/visa.png') }}" alt="Visa" style="height: 18px;">
                            <img src="{{ asset('images/pay/master.png') }}" alt="Mastercard" style="height: 18px;">
                        </div>
                    </label>
                </div>

                <div class="payment-option">
                    <input class="form-check-input d-none" type="radio" name="payment_method" value="fawry" id="fawry">
                    <label class="d-flex align-items-center justify-content-between p-3 rounded-4 border border-light-subtle w-100 mb-0" for="fawry" style="cursor: pointer; transition: all 0.3s ease;">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-money-bill-transfer text-success fs-20"></i>
                            <span class="fw-800 text-black small">Fawry</span>
                        </div>
                        <img src="{{ asset('images/pay/fawry.svg') }}" alt="Fawry" style="height: 22px;">
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-4 mb-5">
            <input type="hidden" name="tripType" value="{{ request()->tripType }}" />
            <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
            <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
            <input type="hidden" name="go_date" value="{{ request()->go_date }}" />
            <input type="hidden" name="back_date" value="{{ request()->back_date }}" />
            <input type="hidden" name="seats" value="{{ request()->seats }}" />
            <input type="hidden" name="station_from_id" value="{{ request()->station_from_id }}" />
            <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />
            <input type="hidden" name="selected_trip_id" value="{{ request()->selected_trip_id }}" />
            <input type="hidden" id="num-of-seats" name="seats" value="{{ request()->seats }}" />
            @foreach (array_column($selectedSeats, 'id') as $seatId)
                <input type="hidden" name="seat_id[]" value="{{ $seatId }}">
            @endforeach
            <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium">
                {{ __('Confirm & Pay') }}
            </button>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.querySelector('form[action="{{ route('one-way.confirm-booking') }}"]');
            if (!form) return;
            form.addEventListener('submit', function () {
                var submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.classList.add('disabled');
                }
            });
        });
    </script>
@endsection
