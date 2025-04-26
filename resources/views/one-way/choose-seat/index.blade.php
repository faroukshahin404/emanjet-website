@extends('layouts.master')
@section('content')
    <div class="chairs mb-5">
        <div class="container mb-5">
            <div class="row">
                <div class="col-md-12 my-3 text-center">
                    <h2 class="text-black">{{ __('Choose Your Seat') }}</h2>
                </div>
                @include('one-way.choose-seat.seats')
                <div class="col-md-4">
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
                        <div class="d-flex flex-column">
                            <div class="trip-desc rounded-8 px-3 py-3">
                                <div class="d-flex justify-content-center align-items-center gap-4 my-4">
                                    <div class="d-flex align-items-center gap-2 travel-direction-box">
                                        <div>
                                            <i class="fa fa-bus text-black"></i>
                                        </div>
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="d-flex align-items-center gap-2">
                                                <h6 class="m-0 text-black">{{ $fromCity->name }}</h6>
                                                <i class="fa fa-arrow-left text-black"></i>
                                            </div>
                                            <div>
                                                <p class="m-0">
                                                    {{ $fromStation->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-center travel-direction-box">
                                        <div class="d-flex align-items-center gap-2">
                                            <h6 class="m-0 text-black">{{ $toCity->name }}</h6>
                                        </div>
                                        <div>
                                            <p class="m-0">
                                                {{ $toStation->name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-2">
                                    <p class="m-0 text-black">{{ __('Departure Time:') }}</p>
                                    <p class="m-0">{{ $tripTime->format('Y-m-d h:i a') }}</p>
                                </div>
                                <input type="hidden" id="number-of-seats" value="{{ request()->seats }}" />
                                <table id="selectedSeatsTable" class="table">
                                    <tbody></tbody>
                                </table>

                            </div>

                            <div class="total-price rounded-8 px-3 py-3">
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        <span class="text-black">{{ __('Total:') }}</span>
                                    </div>
                                    <p class="m-0" id="totalPrice">{{ __('Choose seats') }}</p>
                                </div>
                            </div>

                            <div class="border rounded-8 px-3 py-3 mt-2">
                                <h4 class="text-black">{{ __('Choose Payment Method') }}</h4>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input form-check-input-pay" type="radio"
                                            name="payment_method" id="flexRadioDefault1" checked value="fawry">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            <img class="fawry-label-img" src="{{ asset('/images/pay/fawry.svg') }}"
                                                alt="fawry">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2 checkbox-rules">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked value=""
                                        id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ __('I agree to the terms and conditions') }} <a
                                            href="!#">{{ __('terms and conditions') }}</a>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn-pay-disabled" id="btn-pay">
                                    <div class="d-flex justify-content-around align-items-center">
                                        <p class="m-0">{{ __('Choose seats') }}</p>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            alert('لا يمكنك اختيار عدد مقاعد اكبر من ' + numberOfSeats.value);
                            this.checked = false;
                            return;
                        }
                        // Add row
                        const row = document.createElement('tr');
                        row.setAttribute('id', rowId);
                        row.innerHTML = `<td>مقعد رقم:${seatName}</td>
                        <input type="hidden" value="${seatId}" name="seat_id[]"/>
                        <td>${seatPrice}جنيه</td>`;
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
                        totalDisplay.textContent = total.toFixed(2) + ' جنيه ';
                        btnPay.className = "btn-pay";
                        btnPay.textContent = `احجز ${count} مقاعد مقابل ${total} جنيه`;
                        btnPay.disabled = false;
                    } else {
                        totalDisplay.textContent = 'من فضلك اختر المقاعد';
                        btnPay.className = "btn-pay-disabled";
                        btnPay.textContent = "اختر المقاعد";
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
                    e.preventDefault(); // تمنع الإرسال
                    Swal.fire({
                        icon: 'warning',
                        title: 'تنبيه',
                        text: 'يجب الموافقة على الشروط والأحكام قبل المتابعة.',
                        confirmButtonText: 'موافق'
                    });
                }
            });
        });
    </script>
@endpush
