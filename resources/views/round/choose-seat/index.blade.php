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
                <div class="col-md-5">
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

                        <div class="booking-summary-card">
                            <h4 class="text-black mb-4 fw-bold">{{ __('Round Trip Summary') }}</h4>

                            <!-- Departure Route -->
                            <div class="summary-route mb-3">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <div class="route-dot"></div>
                                    <div style="width: 2px; height: 20px; background: #ddd;"></div>
                                    <div class="route-dot" style="border-color: #333;"></div>
                                </div>
                                <div class="d-flex flex-column gap-2 flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 text-black fw-bold">{{ $fromCity->name }} <i class="fa fa-long-arrow-right mx-1 small text-muted"></i> {{ $toCity->name }}</h6>
                                        <span class="badge bg-main small">{{ $tripTime->format('h:i a') }}</span>
                                    </div>
                                    <small class="text-muted">{{ $fromStation->name }} → {{ $toStation->name }}</small>
                                </div>
                            </div>

                            <!-- Return Route -->
                            <div class="summary-route mb-4" style="background: #fdfae6; border-left: 3px solid var(--main-color);">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <div class="route-dot" style="border-color: #333;"></div>
                                    <div style="width: 2px; height: 20px; background: #ddd;"></div>
                                    <div class="route-dot"></div>
                                </div>
                                <div class="d-flex flex-column gap-2 flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 text-black fw-bold">{{ $toCity->name }} <i class="fa fa-long-arrow-right mx-1 small text-muted"></i> {{ $fromCity->name }}</h6>
                                        <span class="badge bg-dark small">{{ \Carbon\Carbon::parse(request()->back_date)->format('h:i a') }}</span>
                                    </div>
                                    <small class="text-muted">{{ $toStation->name }} → {{ $fromStation->name }}</small>
                                </div>
                            </div>

                            <input type="hidden" id="number-of-seats-go" value="{{ request()->seats }}">
                            <input type="hidden" id="number-of-seats-return" value="{{ request()->seats }}">

                            <!-- Departure Seats Section -->
                            <div class="selected-seats-container mb-3">
                                <h6 class="text-black fw-bold mb-2 small"><i class="fa fa-ticket text-main me-1"></i>{{ __('DEPARTURE SEATS') }}</h6>
                                <table id="selectedGoSeatsTable" class="table table-borderless table-sm">
                                    <tbody class="border-top">
                                        {{-- Populated by JS --}}
                                    </tbody>
                                </table>
                            </div>

                            <!-- Return Seats Section -->
                            <div class="selected-seats-container mb-4">
                                <h6 class="text-black fw-bold mb-2 small"><i class="fa fa-ticket text-dark me-1"></i>{{ __('RETURN SEATS') }}</h6>
                                <table id="selectedReturnSeatsTable" class="table table-borderless table-sm">
                                    <tbody class="border-top">
                                        {{-- Populated by JS --}}
                                    </tbody>
                                </table>
                            </div>

                            <!-- Total -->
                            <div class="d-flex justify-content-between align-items-center py-3 mb-4 border-top border-bottom">
                                <span class="text-black fw-bold fs-5">{{ __('Total Amount') }}</span>
                                <span class="text-main fw-bold fs-4" id="totalPrice">0.00 {{ __('EGP') }}</span>
                            </div>

                            <!-- Payment Methods -->
                            <div class="mb-4">
                                <h6 class="text-black fw-bold mb-3">{{ __('Payment Method') }}</h6>
                                <div class="payment-methods-grid">
                                    <label class="payment-method-card active" for="qnb">
                                        <input type="radio" name="payment_method" value="qnb" id="qnb" checked>
                                        <div class="custom-radio"></div>
                                        <div class="flex-grow-1">
                                            <span class="d-block fw-bold text-black">{{ __('Credit / Debit Card') }}</span>
                                            <div class="d-flex gap-2 mt-1">
                                                <img src="{{ asset('images/pay/master.png') }}" height="20" alt="Mastercard">
                                                <img src="{{ asset('images/pay/visa.png') }}" height="20" alt="Visa">
                                            </div>
                                        </div>
                                    </label>

                                    <label class="payment-method-card" for="fawry">
                                        <input type="radio" name="payment_method" value="fawry" id="fawry">
                                        <div class="custom-radio"></div>
                                        <div class="flex-grow-1">
                                            <span class="d-block fw-bold text-black">{{ __('Fawry Pay') }}</span>
                                            <div class="mt-1">
                                                <img src="{{ asset('images/pay/fawry.svg') }}" height="20" alt="Fawry">
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Terms -->
                            <div class="mb-4">
                                <div class="form-check custom-checkbox">
                                    <input class="form-check-input" type="checkbox" checked id="flexCheckDefault">
                                    <label class="form-check-label text-muted small" for="flexCheckDefault">
                                        {{ __('I agree to the terms and conditions') }} 
                                        <a href="{{ route('usage-terms') }}" class="text-main text-decoration-underline">{{ __('terms and conditions') }}</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Pay Button -->
                            <div class="mt-4">
                                <button type="submit" class="btn-pay-disabled" id="btn-pay">
                                    <span>{{ __('Choose Seats') }}</span>
                                    <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
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
