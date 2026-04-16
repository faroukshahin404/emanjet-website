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
        $goSeats = [];
        foreach (request()->go_seat_id as $key => $seat_id) {
            $goSeats[] = getSeatInfo(
                $seat_id,
                request()->station_from_id,
                request()->station_to_id,
                request()->go_trip_id,
                'go',
            );
        }
        $backSeats = [];
        foreach (request()->back_seat_id as $key => $seat_id) {
            $backSeats[] = getSeatInfo(
                $seat_id,
                request()->station_to_id,
                request()->station_from_id,
                request()->back_trip_id,
                'back',
            );
        }
    @endphp

    <!-- Outbound Trip Card -->
    <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-3 mb-4 wow animate__animated animate__fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted fw-800 overline-text" style="font-size: 9px;">{{ __('OUTBOUND TRIP') }}</span>
            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 fw-800" style="font-size: 8px;">{{ __('CONFIRMED') }}</span>
        </div>
        <div class="mb-3 pb-3 border-bottom border-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex flex-column align-items-center">
                    <div class="bg-success rounded-circle" style="width: 8px; height: 8px;"></div>
                    <div class="bg-light" style="width: 2px; height: 20px;"></div>
                    <div class="bg-main rounded-circle" style="width: 8px; height: 8px;"></div>
                </div>
                <div class="d-flex flex-column gap-1">
                    <span class="fw-800 text-black small" style="font-size: 11px;">{{ $fromStation->name }}</span>
                    <span class="fw-800 text-black small" style="font-size: 11px;">{{ $toStation->name }}</span>
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-6">
                <span class="text-muted fw-800 d-block mb-1" style="font-size: 8px;">{{ __('SEATS') }}</span>
                <span class="text-black fw-800 small d-block" style="font-size: 11px;">
                    @foreach ($goSeats as $seat)
                        {{ $seat['name'] }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </span>
            </div>
            <div class="col-6 text-end">
                <span class="text-muted fw-800 d-block mb-1" style="font-size: 8px;">{{ __('PRICE') }}</span>
                <span class="text-black fw-800 small d-block" style="font-size: 11px;">{{ array_sum(array_column($goSeats, 'price')) }} {{ __('EGP') }}</span>
            </div>
        </div>
    </div>

    <!-- Return Trip Card -->
    <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-3 mb-4 wow animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted fw-800 overline-text" style="font-size: 9px;">{{ __('RETURN TRIP') }}</span>
            <span class="badge bg-main-light text-main rounded-pill px-2 py-1 fw-800" style="font-size: 8px;">{{ __('CONFIRMED') }}</span>
        </div>
        <div class="mb-3 pb-3 border-bottom border-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex flex-column align-items-center">
                    <div class="bg-success rounded-circle" style="width: 8px; height: 8px;"></div>
                    <div class="bg-light" style="width: 2px; height: 20px;"></div>
                    <div class="bg-main rounded-circle" style="width: 8px; height: 8px;"></div>
                </div>
                <div class="d-flex flex-column gap-1">
                    <span class="fw-800 text-black small" style="font-size: 11px;">{{ $toStation->name }}</span>
                    <span class="fw-800 text-black small" style="font-size: 11px;">{{ $fromStation->name }}</span>
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-6">
                <span class="text-muted fw-800 d-block mb-1" style="font-size: 8px;">{{ __('SEATS') }}</span>
                <span class="text-black fw-800 small d-block" style="font-size: 11px;">
                    @foreach ($backSeats as $seat)
                        {{ $seat['name'] }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </span>
            </div>
            <div class="col-6 text-end">
                <span class="text-muted fw-800 d-block mb-1" style="font-size: 8px;">{{ __('PRICE') }}</span>
                <span class="text-black fw-800 small d-block" style="font-size: 11px;">{{ array_sum(array_column($backSeats, 'price')) }} {{ __('EGP') }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Details -->
    <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-3 mb-4 wow animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <span class="text-muted fw-800 overline-text d-block mb-3" style="font-size: 9px;">{{ __('PAYMENT BREAKDOWN') }}</span>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted fw-800 small">{{ __('Outbound trip total') }}</span>
            <span class="text-black fw-800 small">{{ array_sum(array_column($goSeats, 'price')) }} {{ __('EGP') }}</span>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted fw-800 small">{{ __('Return trip total') }}</span>
            <span class="text-black fw-800 small">{{ array_sum(array_column($backSeats, 'price')) }} {{ __('EGP') }}</span>
        </div>
        <div class="d-flex justify-content-between align-items-center pt-2 mt-2 border-top border-light-subtle">
            <span class="text-black fw-800">{{ __('Final Total') }}</span>
            <span class="text-main fw-900 fs-18">{{ array_sum(array_column($goSeats, 'price')) + array_sum(array_column($backSeats, 'price')) }} {{ __('EGP') }}</span>
        </div>
    </div>

    <form action="{{ route('round.confirm-booking') }}" method="POST" class="wow animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
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
            <input type="hidden" name="go_trip_id" value="{{ request()->go_trip_id }}" />
            <input type="hidden" name="back_trip_id" value="{{ request()->back_trip_id }}" />
            @foreach (request()->go_seat_id as $key => $seat_id)
                <input type="hidden" name="go_seat_id[]" value="{{ $seat_id }}" />
            @endforeach
            @foreach (request()->back_seat_id as $key => $seat_id)
                <input type="hidden" name="round_seat_id[]" value="{{ $seat_id }}" />
            @endforeach
            <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium">
                {{ __('Confirm & Pay') }}
            </button>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.querySelector('form[action="{{ route('round.confirm-booking') }}"]');
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
@push('scripts')
@endpush
