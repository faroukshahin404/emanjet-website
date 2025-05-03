@extends('layouts.master')

@section('content')
    <div class="reservation-header">
        <div class="container mb-5">
            <div class="row">
                <div class="reservation-travel-box px-5 d-flex justify-content-between align-items-center">

                    <div class="reservation-container d-flex justify-content-between align-items-center w-50">
                        <div class="d-flex flex-column justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-location-dot text-black"></i>
                                <span class="text-black">{{ __('From City') }}</span>
                            </div>
                            <div>
                                {{ $fromCity->name }}
                            </div>
                        </div>

                        <div class="d-flex flex-column justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-location-dot text-black"></i>
                                <span class="text-black">{{ __('To City') }}</span>
                            </div>
                            <div>
                                {{ $toCity->name }}
                            </div>
                        </div>

                        <div class="d-flex flex-column justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calendar text-black"></i>
                                <span class="text-black">{{ __('Travel Date') }}</span>
                            </div>
                            <div>
                                {{ request()->go_date }}
                            </div>
                        </div>

                        <div class="d-flex flex-column justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-user text-black"></i>
                                <span class="text-black">{{ __('Travelars Number') }}</span>
                            </div>
                            <div>
                                {{ request()->seats }}
                            </div>
                        </div>
                    </div>
                    <button class="search-edit-btn" data-bs-toggle="modal" data-bs-target="#searchModal">
                        {{ __('Edit Search') }}
                    </button>
                </div>

            </div>
        </div>
        <div class="px-3">
            <div class="container-fluid">
                <div class="row">
                    <!-- left  -->
                    <div class="col-lg-3 col-md-12 mb-3 trip-details"
                        style="position: sticky; top: 120px; height: fit-content; z-index: 100;">
                        <div class="border rounded-9 px-3">

                            {{-- المدن والمحطات --}}
                            <div class="d-flex justify-content-center align-items-center gap-4 my-4" style="direction: rtl;">
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
                                            <p class="m-0">{{ $fromStation->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-center travel-direction-box">
                                    <div class="d-flex align-items-center gap-2">
                                        <h6 class="m-0 text-black">{{ $toCity->name }}</h6>
                                    </div>
                                    <div>
                                        <p class="m-0">{{ $toStation->name }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- التاريخ --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="m-0 text-black">{{ request()->go_date }}</p>
                            </div>

                            {{-- في حالة عدم اختيار الرحلات --}}
                            <div id="no-selected-trip" style="text-align: center;">
                                <i class="fas fa-ticket-alt" style="font-size: 50px;"></i>
                                <br>
                                <label>{{ __('Choose Your Trip From the Trip Table') }}</label>
                            </div>

                            {{-- تفاصيل الرحلة بعد الاختيار --}}
                            <div id="trip-details" style="display: none;">
                                <form action="{{ route('round.choose-seat') }}">
                                    {{-- بيانات الرحلة --}}
                                    <input type="hidden" name="tripType" value="{{ request()->tripType }}" />
                                    <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
                                    <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
                                    <input type="hidden" name="go_date" value="{{ request()->go_date }}" />
                                    <input type="hidden" name="back_date" value="{{ request()->back_date }}" />
                                    <input type="hidden" name="seats" value="{{ request()->seats }}" />
                                    <input type="hidden" name="station_from_id"
                                        value="{{ request()->station_from_id }}" />
                                    <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />
                                    <input type="hidden" id="num-of-seats" value="{{ request()->seats }}" />

                                    {{-- NEW: Hidden trip IDs & prices --}}
                                    <input type="hidden" name="selected_go_trip_id" id="selected-go-trip-id">
                                    <input type="hidden" id="selected-go-trip-price" value="">
                                    <input type="hidden" name="selected_back_trip_id" id="selected-back-trip-id">
                                    <input type="hidden" id="selected-back-trip-price" value="">

                                    {{-- أسعار الرحلات --}}
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="m-0 text-black">{{ __('Outbound Ticket Price') }}</p>
                                        <p id="selected-go-trip-price-p" class="m-0 text-black">--</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="m-0 text-black">{{ __('Return Ticket Price') }}</p>
                                        <p id="selected-back-trip-price-p" class="m-0 text-black">--</p>
                                    </div>

                                    {{-- عدد التذاكر --}}
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="m-0 text-black">{{ __('Number of Travelers') }}</p>
                                        <p class="m-0 text-black">{{ request()->seats }} {{ __('Tickets') }}</p>
                                    </div>

                                    <hr>

                                    {{-- الإجمالي --}}
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="m-0 text-black">{{ __('Total') }}</p>
                                        <p id="total-p" class="m-0 text-black">-- {{ __('EGP') }}</p>
                                    </div>

                                    {{-- زر الحجز --}}
                                    <div class="mt-4 pb-4 d-flex justify-content-center">
                                        <button class="reserve-btn">{{ __('Book') }} {{ request()->seats }}
                                            {{ __('Seat') }}</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>


                    <!-- center  -->
                    <div class="col-lg-7 col-md-12 VIP">

                        <div class="d-flex justify-content-center align-items-center gap-4 my-4">
                            <div class="d-flex align-items-center gap-2 travel-direction">
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
                            <div class="d-flex flex-column align-items-center travel-direction">
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
                        @forelse ($goTrips as $trip)
                            <div class="border rounded-9 px-3 py-3 mb-3">
                                <div class="row ">
                                    <div class="col-lg-8 col-md-12 ">
                                        <div class="d-flex justify-content-start align-items-center gap-3 mo-view">
                                            <!-- bus icon  -->
                                            <div class="bus-box">
                                                <i class="fa fa-bus text-main"></i>
                                            </div>

                                            <!-- from -->
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="d-flex align-items-center gap-2">
                                                    <h6 class="m-0 text-black">{{ $trip->fromCity }}</h6>
                                                </div>
                                                <div>
                                                    <p class="m-0">
                                                        {{ $trip->fromStation }}
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- circle -->
                                            <div>
                                                <div class="d-flex justify-content-center align-items-center ">
                                                    <div class="green-circle"></div>
                                                    <div class="line"></div>
                                                    <div class="red-circle"></div>
                                                </div>
                                                @php
                                                $time = \Carbon\Carbon::parse($trip->tripTime);
                                                $formattedTime = $time->format('h:i');
                                                $meridiem = app()->getLocale() == 'ar' ? ($time->format('a') == 'am' ? 'ص' : 'م') : $time->format('a');
                                            @endphp

                                            <h6>{{ $formattedTime }} {{ $meridiem }}</h6>

                                            </div>
                                            <!-- to  -->
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="d-flex align-items-center gap-2">
                                                    <h6 class="m-0 text-black">{{ $trip->toCity }}</h6>
                                                </div>
                                                <div>
                                                    <p class="m-0">
                                                        {{ $trip->toStation }}
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- vip -->
                                            <div>
                                                <p class="m-0 text-white bg-main text-center vip">{{ $trip->degree }}</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="d-flex flex-column justify-content-center align-items-center gap-2 ">
                                            <input type="hidden" class="trip-id" value="{{ $trip->id }}" />
                                            <input type="hidden" class="trip-price" value="{{ $trip->price }}" />
                                            <button class="trip-choose-btn"
                                                data-trip-type="go">{{ __('Choose Go Trip') }}</button>

                                            <div class="d-flex flex-column">
                                                <h6 class="text-black m-0">
                                                    {{ $trip->price }} {{ __('LE') }}
                                                </h6>
                                                <p class="text-black m-0">
                                                    {{ __('For Seat') }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-success m-0">
                                                    {{ __('Remains') }} {{ $trip->available_seats }} {{ __('Seat') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-danger">{{ __('No outbound trips available at the moment') }}
                                .</p>
                        @endforelse



                        <div class="d-flex justify-content-center align-items-center gap-4 my-4">
                            <div class="d-flex align-items-center gap-2 travel-direction">
                                <div>
                                    <i class="fa fa-bus text-black"></i>
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <h6 class="m-0 text-black">{{ $toCity->name }}</h6>
                                        <i class="fa fa-arrow-left text-black"></i>
                                    </div>
                                    <div>
                                        <p class="m-0">
                                            {{ $toStation->name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-center travel-direction">
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="m-0 text-black">{{ $fromCity->name }}</h6>
                                </div>
                                <div>
                                    <p class="m-0">
                                        {{ $fromStation->name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @forelse ($backTrips as $trip)
                            <div class="border rounded-9 px-3 py-3 mb-3">
                                <div class="row ">
                                    <div class="col-lg-8 col-md-12 ">
                                        <div class="d-flex justify-content-start align-items-center gap-3 mo-view">
                                            <!-- bus icon  -->
                                            <div class="bus-box">
                                                <i class="fa fa-bus text-main"></i>
                                            </div>

                                            <!-- from -->
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="d-flex align-items-center gap-2">
                                                    <h6 class="m-0 text-black">{{ $trip->fromCity }}</h6>
                                                </div>
                                                <div>
                                                    <p class="m-0">
                                                        {{ $trip->fromStation }}
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- circle -->
                                            <div>
                                                <div class="d-flex justify-content-center align-items-center ">
                                                    <div class="green-circle"></div>
                                                    <div class="line"></div>
                                                    <div class="red-circle"></div>
                                                </div>
                                                <h6>{{ \Carbon\Carbon::parse($trip->tripTime)->format('h:i a ') }}</h6>
                                            </div>
                                            <!-- to  -->
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="d-flex align-items-center gap-2">
                                                    <h6 class="m-0 text-black">{{ $trip->toCity }}</h6>
                                                </div>
                                                <div>
                                                    <p class="m-0">
                                                        {{ $trip->toStation }}
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- vip -->
                                            <div>
                                                <p class="m-0 text-white bg-main text-center vip">{{ $trip->degree }}</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="d-flex flex-column justify-content-center align-items-center gap-2 ">
                                            <input type="hidden" class="trip-id" value="{{ $trip->id }}" />
                                            <input type="hidden" class="trip-price"
                                                value="{{ $trip->round_price - $trip->price }}" />
                                            <button class="trip-choose-btn"
                                                data-trip-type="return">{{ __('Choose Return Trip') }}</button>

                                            <div class="d-flex flex-column">
                                                <h6 class="text-black m-0">
                                                    {{ $trip->round_price - $trip->price }}
                                                </h6>
                                                <p class="text-black m-0">
                                                    {{ __('For Seat') }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-success m-0">
                                                    {{ __('Remains') }} {{ $trip->available_seats }} {{ __('Seat') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-danger">{{ __('No outbound trips available at the moment') }}</p>
                        @endforelse


                    </div>

                    <!-- right -->
                    <div class="col-md-2" style="position: sticky; top: 120px; height: fit-content; z-index: 100;">
                        <form>
                            <input type="hidden" name="tripType" value="{{ request()->tripType }}" />
                            <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
                            <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
                            <input type="hidden" name="go_date" value="{{ request()->go_date }}" />
                            <input type="hidden" name="back_date" value="{{ request()->back_date }}" />
                            <input type="hidden" name="seats" value="{{ request()->seats }}" />
                            <input type="hidden" name="station_from_id" value="{{ request()->station_from_id }}" />
                            <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />
                            <input type="hidden" id="num-of-seats" value="{{ request()->seats }}" />




                            <h2 class="text-black">{{ __('Arrange By') }}</h2>
                            <h6 class="mt-4 mb-3 text-black">{{ __('Bus Degree') }}</h6>

                            @foreach ($degrees as $degree)
                                <div class="form-check d-flex align-items-center mb-3">
                                    <input class="form-check-input ms-2" name="degrees[]" type="checkbox"
                                        value="{{ $degree->id }}"
                                        {{ in_array($degree->id, request()->degrees ?? []) ? 'checked' : '' }}
                                        id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ $degree->name }}
                                    </label>
                                </div>
                            @endforeach



                            <h6 class="mt-5 mb-3 text-black">
                                {{ __('Departure time from') }} {{ $fromCity->name }}
                            </h6>

                            <div class="form-check d-flex align-items-center mb-3">
                                <input class="form-check-input ms-2" type="checkbox" value="am" name="times[]"
                                    id="flexCheckDefault" {{ in_array('am', request()->times ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ __('Morning') }}
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center mb-3">
                                <input class="form-check-input ms-2" type="checkbox" value="pm" name="times[]"
                                    id="flexCheckDefault" {{ in_array('pm', request()->times ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ __('Evening') }}
                                </label>
                            </div>
                            <br>
                            <button class="btn-search" type="submit">
                                {{ __('Search') }}
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true"
        data-bs-backdrop="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="">
                        <input type="hidden" value="{{ request()->tripType ?? 'oneway' }}" name="tripType" />
                        <div class="container-fluid">
                            <div class="row gy-3">
                                <input type="hidden" id="selected_station_from"
                                    value="{{ request()->station_from_id }}">
                                <input type="hidden" id="selected_station_to" value="{{ request()->station_to_id }}">

                                <div class="col-lg-3 col-md-12 travel-box">
                                    <div class="d-flex flex-column align-items-start">
                                        <div>
                                            <i class="fas fa-location-dot text-black"></i>
                                            <span class="text-black">{{ __('Travel From') }}</span>
                                        </div>
                                        <select class="form-select" name="city_from_id" id="city_from_id">
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ request()->city_from_id == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 travel-box">
                                    <div class="d-flex flex-column align-items-start">
                                        <div>
                                            <i class="fas fa-location-dot text-black"></i>
                                            <span class="text-black">{{ __('From Station') }}</span>
                                        </div>
                                        <select class="form-select" name="station_from_id" id="station_from_id">

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-12 travel-box">
                                    <div class="d-flex flex-column align-items-start">
                                        <div>
                                            <i class="fas fa-location-dot text-black"></i>
                                            <span class="text-black">{{ __('Travel To') }}</span>
                                        </div>
                                        <select class="form-select" name="city_to_id" id="city_to_id">
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ request()->city_to_id == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 travel-box">
                                    <div class="d-flex flex-column align-items-start">
                                        <div>
                                            <i class="fas fa-location-dot text-black"></i>
                                            <span class="text-black">{{ __('To Station') }}</span>
                                        </div>
                                        <select class="form-select" name="station_to_id" id="station_to_id">

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-12 travel-box">
                                    <div class="d-flex flex-column align-items-start">
                                        <div>
                                            <i class="fas fa-calendar-alt text-black"></i>
                                            <span class="text-black">{{ __('Date') }}</span>
                                        </div>
                                        <input type="date" class="form-control" value="{{ request()->go_date }}"
                                            name="go_date">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-12 travel-box">
                                    <div class="d-flex flex-column align-items-start">
                                        <label class="fw-bold text-black">
                                            <i class="fas fa-user mx-1"></i>
                                            {{ __('Number of Travelers') }}
                                        </label>
                                        <div class="d-flex align-items-center rounded px-3 border bg-white py-1">
                                            <input type="number" value="{{ request()->seats }}" class="form-control"
                                                name="seats" required />


                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <button class="btn search-trip-btn">{{ __('Search') }}</button>
                                </div>

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
        document.addEventListener('DOMContentLoaded', function() {
            const chooseButtons = document.querySelectorAll('.trip-choose-btn');

            chooseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tripType = this.dataset.tripType;

                    // إزالة التحديد من نفس نوع الرحلة فقط
                    chooseButtons.forEach(btn => {
                        if (btn.dataset.tripType === tripType) {
                            btn.classList.remove('selected-trip-button');
                        }
                    });

                    // تحديد الرحلة المختارة
                    this.classList.add('selected-trip-button');

                    // جلب البيانات
                    const tripId = this.closest('.col-lg-4').querySelector('.trip-id').value;
                    const tripPrice = this.closest('.col-lg-4').querySelector('.trip-price').value;

                    // عرض التفاصيل
                    document.getElementById('trip-details').style.display = 'block';
                    document.getElementById('no-selected-trip').style.display = 'none';

                    // تخزين القيم حسب نوع الرحلة
                    if (tripType === 'go') {
                        document.getElementById('selected-go-trip-id').value = tripId;
                        document.getElementById('selected-go-trip-price').value = tripPrice;
                        document.getElementById('selected-go-trip-price-p').textContent =
                            tripPrice + ' جنيه';
                    } else {
                        document.getElementById('selected-back-trip-id').value = tripId;
                        document.getElementById('selected-back-trip-price').value = tripPrice;
                        document.getElementById('selected-back-trip-price-p').textContent =
                            tripPrice + ' جنيه';
                    }

                    // حساب السعر الكلي
                    const numOfSeats = document.getElementById('num-of-seats').value || 1;
                    const goPrice = parseFloat(document.getElementById('selected-go-trip-price')
                        .value || 0);
                    const backPrice = parseFloat(document.getElementById('selected-back-trip-price')
                        .value || 0);
                    const total = (goPrice + backPrice) * numOfSeats;

                    document.getElementById('total-p').textContent = total + ' جنيه';
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cityFromSelect = document.getElementById('city_from_id');
            const stationFromSelect = document.getElementById('station_from_id');

            const cityToSelect = document.getElementById('city_to_id');
            const stationToSelect = document.getElementById('station_to_id');

            const selectedStationFrom = document.getElementById('selected_station_from')?.value;
            const selectedStationTo = document.getElementById('selected_station_to')?.value;

            function fetchStations(cityId, stationSelect, selectedStationId = null) {
                if (!cityId) {
                    stationSelect.innerHTML = '<option value="">{{ __('Select a station') }}</option>';
                    return;
                }

                fetch(`/get-stations/${cityId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">{{ __('Select a station') }}</option>';
                        data.forEach(station => {
                            const selected = station.id == selectedStationId ? 'selected' : '';
                            options +=
                                `<option value="${station.id}" ${selected}>${station.name}</option>`;
                        });
                        stationSelect.innerHTML = options;
                    })
                    .catch(error => {
                        console.error('Error fetching stations:', error);
                    });
            }

            cityFromSelect.addEventListener('change', function() {
                fetchStations(this.value, stationFromSelect);
            });

            cityToSelect.addEventListener('change', function() {
                fetchStations(this.value, stationToSelect);
            });

            if (cityFromSelect.value) {
                fetchStations(cityFromSelect.value, stationFromSelect, selectedStationFrom);
            }

            if (cityToSelect.value) {
                fetchStations(cityToSelect.value, stationToSelect, selectedStationTo);
            }
        });
    </script>
@endpush
