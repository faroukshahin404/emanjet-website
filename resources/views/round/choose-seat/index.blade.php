@extends('layouts.master')
@section('content')
    <div class="chairs mb-5">
        <div class="container mb-5">
            <div class="row">
                <div class="col-md-12 my-3 text-center">
                    <h2 class="text-black">اختر مقاعد الذهاب والعودة</h2>
                </div>

                @include('round.choose-seat.seats')

                <!-- تفاصيل الرحلة والدفع -->
                <div class="col-md-12 col-lg-4 mx-auto" style="position: sticky; top: 120px; height: fit-content; z-index: 100;">

                    <form action="{{ route('round.confirm-booking') }}" method="post">
                        @csrf
                        <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
                        <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
                        <input type="hidden" name="go_date" value="{{ request()->go_date }}" />
                        <input type="hidden" name="back_date" value="{{ request()->back_date }}" />
                        <input type="hidden" name="seats" value="{{ request()->seats }}" />
                        <input type="hidden" name="station_from_id" value="{{ request()->station_from_id }}" />
                        <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />
                        <input type="hidden" name="go_trip_id" value="{{request()->selected_go_trip_id}}">
                        <input type="hidden" name="back_trip_id"  value="{{request()->selected_back_trip_id}}">
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
                                <p class="m-0 text-black">موعد التحرك:</p>
                                <p class="m-0">{{ $tripTime->format('Y-m-d h:i a') }}</p>
                            </div>

                            <input type="hidden" id="number-of-seats-go" value="{{ request()->seats }}">
                            <input type="hidden" id="number-of-seats-return" value="{{ request()->seats }}">

                            <div class="go-seats-table mb-3">
                                <h5 class="text-black mb-2">مقاعد الذهاب</h5>
                                <table id="selectedGoSeatsTable" class="table">
                                    <tbody></tbody>
                                </table>
                            </div>

                            <div class="return-seats-table">
                                <h5 class="text-black mb-2">مقاعد العودة</h5>
                                <table id="selectedReturnSeatsTable" class="table">
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="total-price rounded-8 px-3 py-3">
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="text-black">الاجمالي:</span>
                                <p class="m-0" id="totalPrice">اختر المقاعد</p>
                            </div>
                        </div>

                        <div class="border rounded-8 px-3 py-3 mt-2">
                            <h4 class="text-black">أختر وسيلة الدفع</h4>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="fawry" checked>
                                <label class="form-check-label" for="fawry">
                                    <img class="fawry-label-img" src="{{ asset('/images/pay/fawry.png') }}" alt="fawry">
                                </label>
                            </div>
                        </div>

                        <div class="mt-2 checkbox-rules">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" checked id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    أوافق على <a href="#">الشروط والاحكام</a>
                                </label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn-pay-disabled" id="btn-pay">
                                <div class="d-flex justify-content-around align-items-center">
                                    <p class="m-0">اختر المقاعد</p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
                // تحديث جدول مقاعد الذهاب
                goTableBody.innerHTML = '';
                selectedGoSeats.forEach(seat => {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td>مقعد رقم: ${seat.name}</td>
                    <input type="hidden" class="seat-id" name="go_seat_id[]" value="${seat.id}"/>
                    <td>${seat.price.toFixed(2)} جنيه</td>`;
                    goTableBody.appendChild(row);
                });

                // تحديث جدول مقاعد العودة
                returnTableBody.innerHTML = '';
                selectedReturnSeats.forEach(seat => {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td>مقعد رقم: ${seat.name}</td>
                    <input type="hidden" class="seat-id" name="round_seat_id[]" value="${seat.id}"/>
                    <td>${seat.price.toFixed(2)} جنيه</td>`;
                    returnTableBody.appendChild(row);
                });

                // حساب الإجمالي
                total = [...selectedGoSeats, ...selectedReturnSeats].reduce((sum, seat) => sum + seat.price, 0);

                // تحديث عرض السعر
                if (total > 0 && selectedGoSeats.length === numOfSeats && selectedReturnSeats.length === numOfSeats) {
                    totalDisplay.textContent = total.toFixed(2) + ' جنيه';
                    btnPay.className = "btn-pay";
                    btnPay.innerHTML = `<div class="d-flex justify-content-around align-items-center">
                        <p class="m-0">احجز ${selectedGoSeats.length + selectedReturnSeats.length} مقاعد مقابل ${total.toFixed(2)} جنيه</p>
                    </div>`;
                    btnPay.disabled = false;
                } else {
                    totalDisplay.textContent = 'اختر المقاعد';
                    btnPay.className = "btn-pay-disabled";
                    btnPay.innerHTML = `<div class="d-flex justify-content-around align-items-center">
                        <p class="m-0">اختر المقاعد</p>
                    </div>`;
                    btnPay.disabled = true;
                }
            }

            // أحداث مقاعد الذهاب
            goCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const seatName = this.getAttribute('data-name');
                    const seatPrice = parseFloat(this.getAttribute('data-price'));
                    const seatId = this.id;

                    if (this.checked) {
                        if (selectedGoSeats.length >= numOfSeats) {
                            alert(`لا يمكنك اختيار أكثر من ${numOfSeats} مقعد للذهاب`);
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

            // أحداث مقاعد العودة
            returnCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const seatName = this.getAttribute('data-name');
                    const seatPrice = parseFloat(this.getAttribute('data-price'));
                    const seatId = this.id;

                    if (this.checked) {
                        if (selectedReturnSeats.length >= numOfSeats) {
                            alert(`لا يمكنك اختيار أكثر من ${numOfSeats} مقعد للعودة`);
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
            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();

                if (selectedGoSeats.length !== numOfSeats || selectedReturnSeats.length !== numOfSeats) {
                    Swal.fire({
                        title: 'تنبيه!',
                        text: `يجب اختيار ${numOfSeats} مقاعد للذهاب و ${numOfSeats} مقاعد للعودة`,
                        icon: 'warning',
                        confirmButtonText: 'حسناً',
                        confirmButtonColor: '#3085d6',
                        customClass: {
                            title: 'swal-title',
                            content: 'swal-text',
                            confirmButton: 'swal-button'
                        }
                    });
                    return false;
                }

                // If validation passes, submit the form
                this.submit();
            });
        });
    </script>
@endpush
