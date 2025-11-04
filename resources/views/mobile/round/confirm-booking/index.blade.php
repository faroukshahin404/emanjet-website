@extends('layouts.master')

@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center">
        <i class="fas fa-arrow-right fs-25 text-black" onclick="window.history.back()"></i>
        <p class="m-0 fs-25 text-black">ملخص</p>
        <div></div>
    </div>

    @php
        $goSeats = [];
        foreach (request()->go_seat_id as $key => $seat_id) {
            $goSeats[] = getSeatInfo(
                $seat_id,
                request()->station_from_id,
                request()->station_to_id,
                request()->go_trip_id,
                'go',
            );
        }
        $backSeats = [];
        foreach (request()->back_seat_id as $key => $seat_id) {
            $backSeats[] = getSeatInfo(
                $seat_id,
                request()->station_to_id,
                request()->station_from_id,
                request()->back_trip_id,
                'back',
            );
        }

    @endphp

    <div class="mt-3">
        <div class="border rounded-7 p-3">
            <div>
                <h6 class="text-black">
                    الاسم
                </h6>
                <p>
                    {{ auth()->user()->name }}
                </p>
            </div>
            <div>
                <h6 class="text-black">
                    رقم الهاتف
                </h6>
                <p>
                    {{ auth()->user()->mobile }}
                </p>
            </div>
            <hr>
            <!-- Go Trip Details -->
            <div class="summary-circle mt-3">
                <h6 class="text-black">
                    رحلة الذهاب
                </h6>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex flex-column align-items-center">
                        <div class="green-circle-mobile"></div>
                        <div class="line-mobile"></div>
                        <div class="red-circle-mobile"></div>
                    </div>
                    <div class="d-flex flex-column justify-content-between">
                        <p class="m-0">{{ $fromStation->name }}</p>
                        <p class="m-0">{{ $toStation->name }}</p>
                    </div>
                </div>
                <div class="mt-2">
                    <h6 class="text-black">
                        رقم المقعد
                    </h6>
                    <p>
                        @foreach ($goSeats as $seat)
                            {{ $seat['name'] }}
                        @endforeach
                    </p>

                </div>
            </div>
            <hr>
            <!-- Back Trip Details -->
            <div class="summary-circle mt-3">
                <h6 class="text-black">
                    رحلة العودة
                </h6>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex flex-column align-items-center">
                        <div class="green-circle-mobile"></div>
                        <div class="line-mobile"></div>
                        <div class="red-circle-mobile"></div>
                    </div>
                    <div class="d-flex flex-column justify-content-between">
                        <p class="m-0">{{ $toStation->name }}</p>
                        <p class="m-0">{{ $fromStation->name }}</p>
                    </div>
                </div>
                <div class="mt-2">
                    <h6 class="text-black">
                        رقم المقعد
                    </h6>
                    <p>
                        @foreach ($backSeats as $seat)
                            {{ $seat['name'] }}
                        @endforeach
                    </p>
                </div>
            </div>
            <hr>
            <div class="mt-2">
                <h6 class="text-black">
                    اجمالي المقاعد
                </h6>
                <p>
                    {{ count($goSeats) + count($backSeats) }}
                </p>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <div class="border rounded-7 p-3">
            <div class="d-flex justify-content-between align-items-center text-black">
                <p>تفاصيل الدفع</p>
                <p>جنية مصري</p>
            </div>
            <div class="d-flex justify-content-between align-items-center text-half-gray">
                <p>{{ count($goSeats) }} مقاعد ذهاب </p>
                <p>{{ array_sum(array_column($goSeats, 'price')) }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center text-half-gray">
                <p>{{ count($backSeats) }} مقاعد عودة </p>
                <p>{{ array_sum(array_column($backSeats, 'price')) }}</p>
            </div>

            <div class="d-flex justify-content-between align-items-center text-black">
                <p>المجموع</p>
                <p>{{ array_sum(array_column($goSeats, 'price')) + array_sum(array_column($backSeats, 'price')) }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('round.confirm-booking') }}" method="POST">
        <div class="mt-3">
            <div class="border rounded-8 px-3 py-3 mt-2">
                <h4 class="text-black">أختر وسيلة الدفع</h4>
                <div class="form-check">
                    <input class="form-check-input form-check-input-pay" type="radio" name="payment_method"
                        value="qnb" id="qnb" checked>
                    <label class="form-check-label" for="qnb">
                        Debit/Credit card
                    </label>
                </div>
                <br>
                <div class="form-check">
                    <input class="form-check-input form-check-input-pay" type="radio" name="payment_method"
                        value="fawry" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Fawry
                    </label>
                </div>
                
            </div>

            <div class="mt-4">
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
                @foreach (request()->go_seat_id as $key => $seat_id)
                    <input type="hidden" name="go_seat_id[]" value="{{ $seat_id }}" />
                @endforeach
                @foreach (request()->back_seat_id as $key => $seat_id)
                    <input type="hidden" name="round_seat_id[]" value="{{ $seat_id }}" />
                @endforeach



                <button type="submit" class="login">
                    دفع
                </button>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.querySelector('form[action="{{ route('round.confirm-booking') }}"]');
            if (!form) return;
            form.addEventListener('submit', function () {
                var submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.classList.add('disabled');
                }
            });
        });
    </script>
@endsection
@push('scripts')
@endpush
