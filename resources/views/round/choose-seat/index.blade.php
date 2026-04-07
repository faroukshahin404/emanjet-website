@extends('layouts.master')
@section('content')
    <div class="chairs mb-5">
        <div class="container mb-5">
            <div class="row">
                <div class="col-md-12 my-3 text-center">
                    <h2 class="text-black">{{ __('Pick your seats for the round trip') }}</h2>
                </div>

                @include('round.choose-seat.seats')

                <!-- Trip details and payment -->
                <div class="col-md-12 col-lg-4 mx-auto"
                    style="position: sticky; top: 120px; height: fit-content; z-index: 100;">

                    <form id="bookingForm" action="{{ route('round.confirm-booking') }}" method="post">
                        @csrf
                        <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
                        <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
                        <input type="hidden" name="go_date" value="{{ request()->go_date }}" />
                        <input type="hidden" name="back_date" value="{{ request()->back_date }}" />
                        <input type="hidden" name="seats" value="{{ request()->seats }}" />
                        <input type="hidden" name="station_from_id" value="{{ request()->station_from_id }}" />
                        <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />
                        <input type="hidden" name="go_trip_id" value="{{ request()->selected_go_trip_id }}">
                        <input type="hidden" name="back_trip_id" value="{{ request()->selected_back_trip_id }}">
                        <input type="hidden" name="tripType" value="round">
                        <div class="trip-desc rounded-8 px-3 py-3">
                            <div class="d-flex justify-content-center align-items-center gap-4 my-4">
                                <div class="d-flex align-items-center gap-2 travel-direction-box">
                                    <i class="fa fa-bus text-black"></i>
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <h6 class="m-0 text-black">{{ $fromCity->name }}</h6>
                                            <i class="fa fa-arrow-left text-black"></i>
                                        </div>
                                        <p class="m-0">{{ $fromStation->name }}</p>
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-center travel-direction-box">
                                    <h6 class="m-0 text-black">{{ $toCity->name }}</h6>
                                    <p class="m-0">{{ $toStation->name }}</p>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-2">
                                <p class="m-0 text-black">{{ __('Departure time') }}:</p>
                                <p class="m-0">{{ $tripTime->format('Y-m-d h:i a') }}</p>
                            </div>

                            <input type="hidden" id="number-of-seats-go" value="{{ request()->seats }}">
                            <input type="hidden" id="number-of-seats-return" value="{{ request()->seats }}">

                            <div class="go-seats-table mb-3">
                                <h5 class="text-black mb-2">{{ __('Outbound Seats') }}</h5>
                                <table id="selectedGoSeatsTable" class="table">
                                    <tbody></tbody>
                                </table>
                            </div>

                            <div class="return-seats-table">
                                <h5 class="text-black mb-2">{{ __('Return Seats') }}</h5>
                                <table id="selectedReturnSeatsTable" class="table">
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="total-price rounded-8 px-3 py-3">
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="text-black">{{ __('Total') }}:</span>
                                <p class="m-0" id="totalPrice">{{ __('Choose Seats') }}</p>
                            </div>
                        </div>

                        <div class="border rounded-8 px-3 py-3 mt-2">
                            <h4 class="text-black">{{ __('Choose Payment Method') }}</h4>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="qnb" id="qnb" checked>
                                <label class="form-check-label" for="qnb">
                                    Debit/Credit card
                                    <img src="{{ asset('images/pay/master.png') }}" alt="Mastercard" style="height: 30px;">
                                    <img src="{{ asset('images/pay/visa.png') }}" alt="Mastercard" style="height: 30px;">
                                
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="fawry"  id="fawry">
                                <label class="form-check-label" for="fawry">
                                    Fawry
                                    <img src="{{ asset('images/pay/fawry.svg') }}" alt="Fawry" style="height: 30px;">

                                </label>
                            </div>

                        </div>

                        <div class="mt-2 checkbox-rules">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" checked id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ __('I Agree To The') }} <a
                                        href="{{ route('usage-terms') }}">{{ __('Terms And Conditions') }}</a>

                                </label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn-pay-disabled" id="btn-pay">
                                <div class="d-flex justify-content-around align-items-center">
                                    <p class="m-0">{{ __('Choose Seats') }}</p>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const outboundSeatLimitMsg = @json(__('You cannot select more than :num seats for the outbound trip'));
        const returnSeatLimitMsg = @json(__('You cannot select more than :num seats for the return trip'));
        const seatRowLabel = @json(__('Seat :number'));
        const egpShort = @json(__('EGP short'));
        const chooseSeatsLabel = @json(__('Choose Seats'));
        const bookSeatsTemplate = @json(__('Book :count seats for :total'));
        const alertTitle = @json(__('Alert!'));
        const termsMustAcceptMsg = @json(__('You must accept the terms and conditions before completing the booking.'));
        const pickSeatsMsg = @json(__('You must select :count seats for outbound and :count seats for return.'));
        const okayLabel = @json(__('Okay'));

        document.addEventListener("DOMContentLoaded", function() {
            const bookingForm = document.getElementById('bookingForm');
            const goCheckboxes = document.querySelectorAll('.chair-checkbox.go');
            const returnCheckboxes = document.querySelectorAll('.chair-checkbox.return');
            const goTableBody = document.querySelector('#selectedGoSeatsTable tbody');
            const returnTableBody = document.querySelector('#selectedReturnSeatsTable tbody');
            const totalDisplay = document.querySelector('#totalPrice');
            const btnPay = document.getElementById("btn-pay");
            const numOfSeats = parseInt(document.getElementById("number-of-seats-go").value);

            let total = 0;
            let selectedGoSeats = [];
            let selectedReturnSeats = [];

            function updateUI() {
                // Update outbound seats table
                goTableBody.innerHTML = '';
                selectedGoSeats.forEach(seat => {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td>${seatRowLabel.replace(':number', seat.name)}</td>
                    <input type="hidden" class="seat-id" name="go_seat_id[]" value="${seat.id}"/>
                    <td>${seat.price.toFixed(2)} ${egpShort}</td>`;
                    goTableBody.appendChild(row);
                });

                // Update return seats table
                returnTableBody.innerHTML = '';
                selectedReturnSeats.forEach(seat => {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td>${seatRowLabel.replace(':number', seat.name)}</td>
                    <input type="hidden" class="seat-id" name="round_seat_id[]" value="${seat.id}"/>
                    <td>${seat.price.toFixed(2)} ${egpShort}</td>`;
                    returnTableBody.appendChild(row);
                });

                // Total price
                total = [...selectedGoSeats, ...selectedReturnSeats].reduce((sum, seat) => sum + seat.price, 0);

                // Update price display and pay button
                if (total > 0 && selectedGoSeats.length === numOfSeats && selectedReturnSeats.length ===
                    numOfSeats) {
                    totalDisplay.textContent = total.toFixed(2) + ' ' + egpShort;
                    btnPay.className = "btn-pay";
                    const seatCount = selectedGoSeats.length + selectedReturnSeats.length;
                    btnPay.innerHTML = `<div class="d-flex justify-content-around align-items-center">
                        <p class="m-0">${bookSeatsTemplate.replace(':count', String(seatCount)).replace(':total', total.toFixed(2))}</p>
                    </div>`;
                    btnPay.disabled = false;
                } else {
                    totalDisplay.textContent = chooseSeatsLabel;
                    btnPay.className = "btn-pay-disabled";
                    btnPay.innerHTML = `<div class="d-flex justify-content-around align-items-center">
                        <p class="m-0">${chooseSeatsLabel}</p>
                    </div>`;
                    btnPay.disabled = true;
                }
            }

            // Outbound seat checkbox handlers
            goCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const seatName = this.getAttribute('data-name');
                    const seatPrice = parseFloat(this.getAttribute('data-price'));
                    const seatId = this.id;

                    if (this.checked) {
                        if (selectedGoSeats.length >= numOfSeats) {
                            showAlert('warning', outboundSeatLimitMsg.replace(':num', numOfSeats), @json(__('Warning')));
                            this.checked = false;
                            return;
                        }

                        selectedGoSeats.push({
                            id: seatId,
                            name: seatName,
                            price: seatPrice
                        });
                    } else {
                        selectedGoSeats = selectedGoSeats.filter(seat => seat.id !== seatId);
                    }

                    updateUI();
                });
            });

            // Return seat checkbox handlers
            returnCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const seatName = this.getAttribute('data-name');
                    const seatPrice = parseFloat(this.getAttribute('data-price'));
                    const seatId = this.id;

                    if (this.checked) {
                        if (selectedReturnSeats.length >= numOfSeats) {
                            showAlert('warning', returnSeatLimitMsg.replace(':num', numOfSeats), @json(__('Warning')));
                            this.checked = false;
                            return;
                        }

                        selectedReturnSeats.push({
                            id: seatId,
                            name: seatName,
                            price: seatPrice
                        });
                    } else {
                        selectedReturnSeats = selectedReturnSeats.filter(seat => seat.id !==
                            seatId);
                    }

                    updateUI();
                });
            });

            // Form submission handler
            // Form submission handler
            bookingForm.addEventListener('submit', function(e) {
    // Always prevent the default form submission first
    e.preventDefault();

    const termsCheckbox = document.getElementById('flexCheckDefault');
    let isValid = true;

    // Check terms and conditions
    if (!termsCheckbox.checked) {
        Swal.fire({
            title: alertTitle,
            text: termsMustAcceptMsg,
            icon: 'warning',
            confirmButtonText: okayLabel,
            confirmButtonColor: '#3085d6',
            customClass: {
                title: 'swal-title',
                content: 'swal-text',
                confirmButton: 'swal-button'
            }
        });
        isValid = false;
    }

    // Check seat selection
    else if (selectedGoSeats.length !== numOfSeats || selectedReturnSeats.length !== numOfSeats) {
        Swal.fire({
            title: alertTitle,
            text: pickSeatsMsg.replaceAll(':count', String(numOfSeats)),
            icon: 'warning',
            confirmButtonText: okayLabel,
            confirmButtonColor: '#3085d6',
            customClass: {
                title: 'swal-title',
                content: 'swal-text',
                confirmButton: 'swal-button'
            }
        });
        isValid = false;
    }

    // Only submit the form if all validations pass
    if (isValid) {
        // Use a timeout to ensure the SweetAlert has time to close if it was open
        setTimeout(function() {
            // Create and submit a new form instead of using the original
            const formData = new FormData(bookingForm);
            const submitForm = document.createElement('form');
            submitForm.method = bookingForm.method;
            submitForm.action = bookingForm.action;

            for(const [key, value] of formData.entries()) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                submitForm.appendChild(input);
            }

            document.body.appendChild(submitForm);
            submitForm.submit();
            document.body.removeChild(submitForm);
        }, 100);
    }
});
        });
    </script>
@endpush
