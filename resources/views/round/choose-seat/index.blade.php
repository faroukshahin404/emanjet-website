@extends('layouts.master')
@section('content')
    <div class="chairs mb-5">
        <div class="container mb-5">
            <form action="">
                <div class="row">
                    <div class="col-md-12 my-3 text-center">
                        <h2 class="text-black">اختر مقاعد الذهاب والعودة</h2>
                    </div>

                    @include('round.choose-seat.seats')

                    <!-- تفاصيل الرحلة والدفع -->
                    <div class="col-md-12 col-lg-4 mx-auto">
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

                            <table id="selectedSeatsTable" class="table">
                                <tbody></tbody>
                            </table>
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
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="fawry"
                                    checked>
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const goCheckboxes = document.querySelectorAll('.chair-checkbox.go');
            const returnCheckboxes = document.querySelectorAll('.chair-checkbox.return');
            const tableBody = document.querySelector('#selectedSeatsTable tbody');
            const totalDisplay = document.querySelector('#totalPrice');
            const btnPay = document.getElementById("btn-pay");

            const numberOfSeatsGo = parseInt(document.getElementById("number-of-seats-go").value);
            const numberOfSeatsReturn = parseInt(document.getElementById("number-of-seats-return").value);

            let total = 0;
            let selectedGoSeats = [];
            let selectedReturnSeats = [];

            function updateUI() {
                // تحديث الجدول
                tableBody.innerHTML = '';

                // إضافة مقاعد الذهاب
                selectedGoSeats.forEach(seat => {
                    const row = document.createElement('tr');
                    row.innerHTML =
                        `<td>مقعد ذهاب رقم: ${seat.name}</td><td>${seat.price.toFixed(2)} جنيه</td>`;
                    tableBody.appendChild(row);
                });

                // إضافة مقاعد العودة
                selectedReturnSeats.forEach(seat => {
                    const row = document.createElement('tr');
                    row.innerHTML =
                        `<td>مقعد عودة رقم: ${seat.name}</td><td>${seat.price.toFixed(2)} جنيه</td>`;
                    tableBody.appendChild(row);
                });

                // حساب الإجمالي
                total = [...selectedGoSeats, ...selectedReturnSeats].reduce((sum, seat) => sum + seat.price, 0);

                // تحديث عرض السعر
                if (total > 0 && selectedGoSeats.length === numberOfSeatsGo && selectedReturnSeats.length ===
                    numberOfSeatsReturn) {
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
                        if (selectedGoSeats.length >= numberOfSeatsGo) {
                            alert(`لا يمكنك اختيار أكثر من ${numberOfSeatsGo} مقعد للذهاب`);
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
                        if (selectedReturnSeats.length >= numberOfSeatsReturn) {
                            alert(`لا يمكنك اختيار أكثر من ${numberOfSeatsReturn} مقعد للعودة`);
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
        });
    </script>
@endpush
