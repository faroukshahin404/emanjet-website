@extends('layouts.master')

@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <i class="fas fa-arrow-right fs-25 text-black" onclick="window.history.back()"></i>
        <p class="m-0 fs-25 text-black">{{ __('Choose your seat') }}</p>
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
                <span>{{ __('Tap to scroll down') }}</span>
            </div>
        </div>

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
            const outboundLimitTemplate = @json(__('You cannot select more than :count seats for outbound'));
            const returnLimitTemplate = @json(__('You cannot select more than :count seats for return'));
            const egpLabel = @json(__('EGP'));
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
                const isSeatsComplete = totalSelectedSeats === (maxSeats * 2);
                
                confirmButton.disabled = !isSeatsComplete;
                
                if (confirmButton.disabled) {
                    confirmButton.classList.remove('btn-pay');
                    confirmButton.classList.add('btn-pay-disabled');
                } else {
                    confirmButton.classList.add('btn-pay');
                    confirmButton.classList.remove('btn-pay-disabled');
                }
            }


            function showSeatLimitAlert(message) {
                Swal.fire({
                    title: @json(__('Sorry')),
                    text: message,
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
                totalPriceElement.textContent = totalPrice + ' ' + egpLabel;
                
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
                                showSeatLimitAlert(outboundLimitTemplate.replace(':count', String(maxSeats)));
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
                                showSeatLimitAlert(returnLimitTemplate.replace(':count', String(maxSeats)));
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
