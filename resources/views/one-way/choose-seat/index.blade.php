@extends('layouts.master')
@section('content')
    <div class="chairs mb-5 mt-5">
        <div class="container mb-5">
            <div class="row">
                <div class="col-md-12 my-3 text-center">
                    <h2 class="text-black">{{ __('Choose Your Seat') }}</h2>
                </div>
                @include('one-way.choose-seat.seats')
                <div class="col-md-5">
                    <form action="{{ route('one-way.confirm-booking') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tripType" value="{{ request()->tripType }}" />
                        <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
                        <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
                        <input type="hidden" name="go_date" value="{{ request()->go_date }}" />
                        <input type="hidden" name="back_date" value="{{ request()->back_date }}" />
                        <input type="hidden" name="seats" value="{{ request()->seats }}" />
                        <input type="hidden" name="station_from_id" value="{{ request()->station_from_id }}" />
                        <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />
                        <input type="hidden" name="selected_trip_id" id="selected-trip-id"
                            value="{{ request()->selected_trip_id }}">
                        <input type="hidden" id="num-of-seats" value="{{ request()->seats }}" />
                        
                        <div class="booking-summary-card">
                            <h4 class="text-black mb-4 fw-bold">{{ __('Booking Summary') }}</h4>
                            
                            <!-- Route Visualization -->
                            <div class="summary-route">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <div class="route-dot"></div>
                                    <div style="width: 2px; height: 30px; background: #ddd;"></div>
                                    <div class="route-dot" style="border-color: #333;"></div>
                                </div>
                                <div class="d-flex flex-column gap-3 flex-grow-1">
                                    <div>
                                        <h6 class="m-0 text-black fw-bold">{{ $fromCity->name }}</h6>
                                        <small class="text-muted">{{ $fromStation->name }}</small>
                                    </div>
                                    <div>
                                        <h6 class="m-0 text-black fw-bold">{{ $toCity->name }}</h6>
                                        <small class="text-muted">{{ $toStation->name }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <i class="fa fa-clock-o text-main mb-1 d-block"></i>
                                    <span class="badge bg-main">{{ $tripTime->format('h:i a') }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="fa fa-calendar text-muted"></i>
                                    <span class="text-dark fw-medium">{{ $tripTime->format('Y-M-d') }}</span>
                                </div>
                            </div>

                            <!-- Selected Seats Table -->
                            <div class="selected-seats-container mb-4">
                                <table id="selectedSeatsTable" class="table table-borderless">
                                    <thead class="border-bottom">
                                        <tr>
                                            <th class="ps-0 py-2"><small class="text-muted fw-bold">{{ __('ITEM') }}</small></th>
                                            <th class="pe-0 py-2 text-end"><small class="text-muted fw-bold">{{ __('PRICE') }}</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                    <!-- QNB Card -->
                                    <label class="payment-method-card active" for="pay-card">
                                        <input type="radio" name="payment_method" id="pay-card" value="qnb" checked>
                                        <div class="custom-radio"></div>
                                        <div class="flex-grow-1">
                                            <span class="d-block fw-bold text-black">{{ __('Credit / Debit Card') }}</span>
                                            <div class="d-flex gap-2 mt-1">
                                                <img src="{{ asset('images/pay/master.png') }}" height="20" alt="Mastercard">
                                                <img src="{{ asset('images/pay/visa.png') }}" height="20" alt="Visa">
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Fawry -->
                                    <label class="payment-method-card" for="pay-fawry">
                                        <input type="radio" name="payment_method" id="pay-fawry" value="fawry">
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
                                    <span>{{ __('Choose seats') }}</span>
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
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('.chair-checkbox');
            const tableBody = document.querySelector('#selectedSeatsTable tbody');
            const totalDisplay = document.querySelector('#totalPrice');
            const numberOfSeats = document.getElementById("number-of-seats");
            const btnPay = document.getElementById("btn-pay");
            let total = 0;
            let count = 0;

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const seatName = this.getAttribute('data-name');
                    const seatId = this.getAttribute('data-seat-id');
                    const seatPrice = parseFloat(this.getAttribute('data-price'));
                    const rowId = `row-${seatName.replace(/\s+/g, '-')}`;

                    if (this.checked) {
                        if ((count + 1) > numberOfSeats.value) {
                            showAlert(
                                'warning',
                                `{{ __('You cannot select more seats than') }} ${numberOfSeats.value}`,
                                @json(__('Warning'))
                            );
                            this.checked = false;
                            return;
                        }
                        // Add row
                        const row = document.createElement('tr');
                        row.setAttribute('id', rowId);
                        row.innerHTML = `<td>{{ __('Seat') }}: ${seatName}</td>
                <input type="hidden" value="${seatId}" name="seat_id[]"/>
                <td>${seatPrice} {{ __('EGP') }}</td>`;
                        tableBody.appendChild(row);
                        total += seatPrice;
                        count++;
                    } else {
                        // Remove row
                        const row = document.getElementById(rowId);
                        if (row) row.remove();
                        total -= seatPrice;
                        count--;
                    }
                    if (total > 0) {
                        totalDisplay.textContent = total.toFixed(2) + ' {{ __('EGP') }} ';
                        btnPay.className = "btn-pay";
                        btnPay.textContent =
                            `{{ __('Book') }} ${count} {{ __('seats for') }} ${total} {{ __('EGP') }}`;
                        btnPay.disabled = false;
                    } else {
                        totalDisplay.textContent = '{{ __('Choose seats') }}';
                        btnPay.className = "btn-pay-disabled";
                        btnPay.textContent = '{{ __('Choose seats') }}';
                        btnPay.disabled = true;
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('form');
            const termsCheckbox = document.getElementById('flexCheckDefault');

            form.addEventListener('submit', function(e) {
                if (!termsCheckbox.checked) {
                    e.preventDefault(); // prevent submit
                    Swal.fire({
                        icon: 'warning',
                        title: '{{ __('Warning') }}',
                        text: '{{ __('You must agree to the terms and conditions') }}',
                        confirmButtonText: '{{ __('OK') }}',
                    });
                }
            });
        });
    </script>
@endpush
