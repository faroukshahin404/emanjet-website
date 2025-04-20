@extends('layouts.master')
@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center">
        <a href="index.html">
            <i class="fas fa-arrow-right fs-18 text-black"></i>
        </a>
        <p class="m-0 fs-25 text-black">ملخص</p>
        <div></div>
    </div>
    @php
        $selectedSeats = json_decode(request()->selected_seats);
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

            <div class="summary-circle">
                <h6 class="text-black">
                    نقاط الصعود والنزول
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
            </div>

            <div class="mt-2">
                <h6 class="text-black">
                    رقم المقعد
                </h6>
                <p>
                    @foreach ($selectedSeats as $seat)
                        {{ $seat->name }}
                    @endforeach
                </p>
            </div>

            <div class="mt-2">
                <h6 class="text-black">
                    الركاب
                </h6>
                <p>
                    {{ count($selectedSeats) }}
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
                <p>{{ count($selectedSeats) }} مقاعد </p>
                <p>{{ array_sum(array_column($selectedSeats, 'price')) }}</p>
            </div>

            <div class="d-flex justify-content-between align-items-center text-black">
                <p>المجموع</p>
                <p>{{ array_sum(array_column($selectedSeats, 'price')) }}</p>
            </div>
        </div>

    </div>
    <form action="{{ route('one-way.confirm-booking') }}" method="POST">

        <div class="mt-3">

            <div class="border rounded-8 px-3 py-3 mt-2">
                <h4 class="text-black">أختر وسيلة الدفع</h4>
                <div class="d-flex flex-column justify-content-end align-items-end gap-2">

                    <div class="form-check">
                        <input class="form-check-input form-check-input-pay" type="radio" name="payment_method"
                            value="fawry" id="flexRadioDefault1" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            <img class="fawry-label-img" src="{{ asset('images/pay/fawry.png') }}" alt="fawry">
                        </label>
                    </div>

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
                <input type="hidden" name="selected_trip_id" value="{{ request()->selected_trip_id }}" />
                <input type="hidden" id="num-of-seats" name="seats" value="{{ request()->seats }}" />
                @foreach (array_column($selectedSeats, 'id') as $seatId)
                    <input type="hidden" name="seat_id[]" value="{{ $seatId }}">
                @endforeach
                <button type="submit" class="login">
                    دفع
                </button>
            </div>

        </div>
    </form>
@endsection
