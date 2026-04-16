@extends('layouts.master')

@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <a href="javascript:history.back()">
            <i class="fas fa-arrow-right fs-25 text-black"></i>
        </a>
        <p class="m-0 fs-25 text-black">{{ __('Choose your seat') }}</p>
        <div></div>
    </div>
    @include('mobile.one-way.choose-seat.seat')
    <form id="seat-booking-form" method="GET" action="{{ route('mobile.one-way.booking-summary') }}">
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
        <div class="mt-4">
            <button type="submit" id="confirm-booking" class="btn-pay-disabled" disabled>
                <div class="d-flex justify-content-between align-items-center w-100 px-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                            <span class="fw-bold small" id="selected-seats-count">0</span>
                        </div>
                        <span class="fw-bold">{{ __('Book now') }}</span>
                    </div>
                    <div class="fw-bold fs-5" id="total-price">
                        0 {{ __('EGP') }}
                    </div>
                </div>
            </button>
        </div>
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
