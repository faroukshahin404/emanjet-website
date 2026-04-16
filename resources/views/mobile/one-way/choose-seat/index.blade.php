@extends('layouts.master')

@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center mb-4 wow animate__animated animate__fadeIn">
        <a href="javascript:history.back()" class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center border-light-subtle" style="width: 40px; height: 40px; border: 1px solid #eee;">
            @if (app()->getLocale() == 'ar')
                <i class="fas fa-arrow-right fs-16 text-black"></i>
            @else
                <i class="fas fa-arrow-left fs-16 text-black"></i>
            @endif
        </a>
        <h5 class="m-0 fw-800 text-black">{{ __('Choose Seat') }}</h5>
        <div style="width: 40px;"></div>
    </div>

    <div class="wow animate__animated animate__fadeInUp">
        @include('mobile.one-way.choose-seat.seat')
    </div>

    <form id="seat-booking-form" method="GET" action="{{ route('mobile.one-way.booking-summary') }}" class="wow animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        @csrf
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
        <input type="hidden" name="selected_seats" id="selected-seats-input">
        
        <div class="fixed-bottom p-3 bg-white border-top border-light-subtle shadow-premium rounded-top-5" style="z-index: 1000;">
            <div class="container-fluid p-0">
                <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                    <div>
                        <span class="text-muted fw-800 overline-text d-block" style="font-size: 9px;">{{ __('SELECTED') }}</span>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-800 text-black fs-20" id="selected-seats-count">0</span>
                            <span class="text-muted fw-800 small">{{ __('Seats') }}</span>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="text-muted fw-800 overline-text d-block" style="font-size: 9px;">{{ __('TOTAL PRICE') }}</span>
                        <div class="d-flex align-items-center gap-1 justify-content-end">
                            <span class="fw-800 text-main fs-20" id="total-price">0</span>
                            <span class="text-main fw-800 small">{{ __('EGP') }}</span>
                        </div>
                    </div>
                </div>
                <button type="submit" id="confirm-booking" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium d-flex align-items-center justify-content-center gap-2" disabled>
                    <i class="fa-solid fa-check-double"></i>
                    {{ __('Confirm Selection') }}
                </button>
            </div>
        </div>
        <!-- Spacer to prevent content overlap -->
        <div style="height: 140px;"></div>
    </form>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const seatLimitTemplate = @json(__('You cannot select more than :count seats'));
        const egpLabel = @json(__('EGP'));
        const checkboxes = document.querySelectorAll('.chair-checkbox');
        const selectedSeatsInput = document.getElementById('selected-seats-input');
        const seatsCountElement = document.getElementById('selected-seats-count');
        const totalPriceElement = document.getElementById('total-price');
        const confirmButton = document.getElementById('confirm-booking');
        const numOfSeatsInput = document.getElementById('num-of-seats');
        const maxSeats = parseInt("{{ request()->seats }}");
        let selectedSeats = [];
        let totalPrice = 0;

        function updateButtonState() {
            confirmButton.disabled = selectedSeats.length === 0 || totalPrice === 0;
            if (confirmButton.disabled) {
                confirmButton.classList.remove('btn-pay');
                confirmButton.classList.add('btn-pay-disabled');
            } else {
                confirmButton.classList.add('btn-pay');
                confirmButton.classList.remove('btn-pay-disabled');
            }
        }


        function showSeatLimitAlert() {
            Swal.fire({
                title: @json(__('Sorry')),
                text: seatLimitTemplate.replace(':count', String(maxSeats)),
                icon: 'warning',
                confirmButtonText: @json(__('OK')),
                confirmButtonColor: '#F3B12B',
                customClass: {
                    title: 'swal-title',
                    content: 'swal-text',
                    confirmButton: 'swal-button'
                }
            });
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const seatId = this.dataset.seatId;
                const seatName = this.dataset.name;
                const seatPrice = parseFloat(this.dataset.price);

                if (this.checked) {
                    if (selectedSeats.length >= maxSeats) {
                        this.checked = false;
                        showSeatLimitAlert();
                        return;
                    }
                    
                    selectedSeats.push({
                        id: seatId,
                        name: seatName,
                        price: seatPrice
                    });
                    totalPrice += seatPrice;
                } else {
                    selectedSeats = selectedSeats.filter(seat => seat.id !== seatId);
                    totalPrice -= seatPrice;
                }

                // Update the hidden input with selected seats
                selectedSeatsInput.value = JSON.stringify(selectedSeats);
                
                // Update the number of seats input
                numOfSeatsInput.value = selectedSeats.length;
                
                // Update the UI
                seatsCountElement.textContent = selectedSeats.length;
                totalPriceElement.textContent = totalPrice + ' ' + egpLabel;
                
                // Update button state
                updateButtonState();
            });
        });

        // Initial button state
        updateButtonState();
    });
</script>
@endpush
