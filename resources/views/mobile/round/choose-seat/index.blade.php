@extends('layouts.master')

@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <a href="bus.html">
            <i class="fas fa-arrow-right fs-25 text-black"></i>
        </a>
        <p class="m-0 fs-25 text-black">اختر مقعدك</p>
        <div></div>
    </div>

    @include('mobile.round.choose-seat.seat')
    <form id="seat-booking-form" method="GET" action="{{ route('mobile.round.booking-summary') }}">
        @csrf
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
        <input type="hidden" id="num-of-seats" name="seats" value="{{ request()->seats }}" />
        <div id="go-seats-container"></div>
        <div id="back-seats-container"></div>
        
        <!-- Scroll Indicator -->
        <div id="scroll-indicator" class="scroll-indicator">
            <div class="scroll-indicator-content">
                <i class="fas fa-chevron-down"></i>
                <span>اضغط هنا للانتقال للأسفل</span>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" id="confirm-booking" class="disabled-button" disabled>
                <div class="d-flex justify-content-around align-items-center">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="chair-number-pay">
                            <p class="m-0" id="selected-seats-count">0</p>
                        </div>
                        <p class="m-0 fs-20">احجز الان</p>
                    </div>
                    <div class="money-account" id="total-price">
                        0 جنية مصري
                    </div>
                </div>
            </button>
        </div>
    </form>

    <style>
        .scroll-indicator {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            z-index: 1000;
            animation: bounce 2s infinite;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .scroll-indicator i {
            animation: bounce 2s infinite;
        }

        .scroll-indicator span {
            font-size: 14px;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        .scroll-indicator.hidden {
            display: none;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.chair-checkbox');
            const goSeatsContainer = document.getElementById('go-seats-container');
            const backSeatsContainer = document.getElementById('back-seats-container');
            const seatsCountElement = document.getElementById('selected-seats-count');
            const totalPriceElement = document.getElementById('total-price');
            const confirmButton = document.getElementById('confirm-booking');
            const numOfSeatsInput = document.getElementById('num-of-seats');
            const scrollIndicator = document.getElementById('scroll-indicator');
            const maxSeats = parseInt("{{ request()->seats }}");
            let goSeats = [];
            let backSeats = [];
            let totalPrice = 0;

            // Handle scroll indicator click
            scrollIndicator.addEventListener('click', function() {
                confirmButton.scrollIntoView({ behavior: 'smooth' });
            });

            // Hide scroll indicator when button is in view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        scrollIndicator.classList.add('hidden');
                    } else {
                        scrollIndicator.classList.remove('hidden');
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(confirmButton);

            function updateButtonState() {
                const totalSelectedSeats = goSeats.length + backSeats.length;
                const isSeatsComplete = totalSelectedSeats === (maxSeats *2);
                
                confirmButton.disabled = !isSeatsComplete;
                
                if (confirmButton.disabled) {
                    confirmButton.classList.remove('login');
                    confirmButton.classList.add('disabled-button');
                } else {
                    confirmButton.classList.add('login');
                    confirmButton.classList.remove('disabled-button');
                }
            }

            function showSeatLimitAlert(message) {
                Swal.fire({
                    title: 'عذراً',
                    text: message,
                    icon: 'warning',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#F3B12B',
                    customClass: {
                        title: 'swal-title',
                        content: 'swal-text',
                        confirmButton: 'swal-button'
                    }
                });
            }

            function updateSeatsInputs() {
                // Clear existing inputs
                goSeatsContainer.innerHTML = '';
                backSeatsContainer.innerHTML = '';

                // Add go seats inputs
                goSeats.forEach(seat => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'go_seat_id[]';
                    input.value = seat.id;
                    goSeatsContainer.appendChild(input);
                });

                // Add back seats inputs
                backSeats.forEach(seat => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'back_seat_id[]';
                    input.value = seat.id;
                    backSeatsContainer.appendChild(input);
                });
            }

            function calculateTotalPrice() {
                return [...goSeats, ...backSeats].reduce((total, seat) => total + seat.price, 0);
            }

            function updateUI() {
                const totalSelectedSeats = goSeats.length + backSeats.length;
                totalPrice = calculateTotalPrice();
                
                seatsCountElement.textContent = totalSelectedSeats;
                totalPriceElement.textContent = totalPrice + ' جنية مصري';
                
                updateButtonState();
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const seatId = this.dataset.seatId;
                    const seatName = this.dataset.name;
                    const seatPrice = parseFloat(this.dataset.price);
                    const isGoSeat = this.dataset.type === 'go';
                    
                    if (isGoSeat) {
                        if (this.checked) {
                            if (goSeats.length >= maxSeats) {
                                this.checked = false;
                                showSeatLimitAlert(`لا يمكنك اختيار أكثر من ${maxSeats} مقاعد للذهاب`);
                                return;
                            }
                            const seat = {
                                id: seatId,
                                name: seatName,
                                price: seatPrice
                            };
                            goSeats.push(seat);
                        } else {
                            goSeats = goSeats.filter(seat => seat.id !== seatId);
                        }
                    } else {
                        if (this.checked) {
                            if (backSeats.length >= maxSeats) {
                                this.checked = false;
                                showSeatLimitAlert(`لا يمكنك اختيار أكثر من ${maxSeats} مقاعد للعودة`);
                                return;
                            }
                            const seat = {
                                id: seatId,
                                name: seatName,
                                price: seatPrice
                            };
                            backSeats.push(seat);
                        } else {
                            backSeats = backSeats.filter(seat => seat.id !== seatId);
                        }
                    }

                    // Update the hidden inputs
                    updateSeatsInputs();
                    
                    // Update the UI
                    updateUI();
                });
            });

            // Initial button state
            updateButtonState();
        });
    </script>
@endpush
