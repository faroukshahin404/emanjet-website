@extends('layouts.master')

@section('content')
    <div class="reservation-header">
        <div class="container">
            <div class="row">


                <div class="reservation-travel-box px-5 d-flex justify-content-between align-items-center">

                    <div class="reservation-container d-flex justify-content-between align-items-center w-50">
                        <div class="d-flex flex-column justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-location-dot text-black"></i>
                                <span class="text-black">{{ __('Travel From') }}</span>
                            </div>
                            <div>
                                {{ $fromCity->name }}
                            </div>
                        </div>

                        <div class="d-flex flex-column justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-location-dot text-black"></i>
                                <span class="text-black">{{ __('Travel To') }}</span>
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
                                <span class="text-black">{{ __('Number Of Passengers') }}</span>
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

                <div class="d-flex justify-content-center align-items-center gap-4 my-4" style="direction: rtl;">
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
            </div>
        </div>
        <div class="px-3">
            <div class="container-fluid">
                <div class="row">
                    <!-- left  -->
                    <div class="col-lg-3 col-md-12 mb-3 trip-details">
                        <div class="border rounded-9 px-3">

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

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="m-0 text-black">
                                        {{ request()->go_date }}
                                    </p>
                                </div>

                            </div>
                            <div id="trip-details" style="display: none;">
                                <form action="{{ route('one-way.choose-seat') }}">
                                    <input type="hidden" name="tripType" value="{{ request()->tripType }}" />
                                    <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
                                    <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
                                    <input type="hidden" name="go_date" value="{{ request()->go_date }}" />
                                    <input type="hidden" name="back_date" value="{{ request()->back_date }}" />
                                    <input type="hidden" name="seats" value="{{ request()->seats }}" />
                                    <input type="hidden" name="station_from_id"
                                        value="{{ request()->station_from_id }}" />
                                    <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />
                                    <input type="hidden" id="selected-trip-price" value="" />
                                    <input type="hidden" name="selected_trip_id" id="selected-trip-id">
                                    <input type="hidden" id="num-of-seats" value="{{ request()->seats }}" />
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="m-0 text-black">
                                                {{ __('Ticket Price') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p id="selected-trip-price-p" class="m-0 text-black">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">



                                        <div>
                                            <p class="m-0 text-black">
                                                {{ __('Number Of Passengers') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="m-0 text-black">
                                                {{ request()->seats }} {{ __('Tickets') }}
                                            </p>


                                        </div>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="m-0 text-black">
                                                {{ __('Total') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p id="total-p" class="m-0 text-black">
                                                {{ __('EGP') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-4 pb-4 d-flex justify-content-center">
                                        <button class="reserve-btn">
                                            {{ __('Book') }} {{ request()->seats }} {{ __('Seats') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div id="no-selected-trip" style="text-align: center;">
                                <i class="fas fa-ticket-alt" style="font-size: 50px;"></i>
                                <br>
                                <label>
                                    {{ __('Choose Your Trip From the Trip Table') }}
                                </label>

                            </div>


                        </div>
                    </div>

                    <!-- center  -->
                    <div class="col-lg-7 col-md-12 VIP">
                        @foreach ($trips as $trip)
                            <div class="border rounded-9 px-3 py-3 mb-3">
                                <div class="row ">
                                    <div class="col-lg-8 col-md-12 ">
                                        <div class="d-flex justify-content-start align-items-center gap-3  mo-view">
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
                                            <input type="hidden" class="trip-price" value="{{ $trip->price }}" />
                                            <button class="trip-choose-btn">
                                                {{ __('Choose The Trip') }}
                                            </button>

                                            <div class="d-flex flex-column">
                                                <h6 class="text-black m-0">
                                                    {{ $trip->price }}
                                                </h6>
                                                <p class="text-black m-0">
                                                    {{ __('For Seat') }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-success m-0">
                                                    {{ __('Remaining') }} {{ $trip->available_seats }}
                                                    {{ __('Seat') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- right -->
                    <div class="col-md-2">
                        <form>
                            <input type="hidden" name="tripType" value="{{ request()->tripType }}" />
                            <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
                            <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
                            <input type="hidden" name="go_date" value="{{ request()->go_date }}" />
                            <input type="hidden" name="back_date" value="{{ request()->back_date }}" />
                            <input type="hidden" name="seats" value="{{ request()->seats }}" />
                            <input type="hidden" name="station_from_id" value="{{ request()->station_from_id }}" />
                            <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />

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
                                {{ __('Departure Time From') }} {{ $fromCity->name }}
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
                            <button class="bg-main text-white btn w-100" type="submit">
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
                                            <span class="text-black">{{ __('Travel From') }}</span>
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
                                            {{ __('Number Of Passengers') }}
                                        </label>
                                        <div class="d-flex align-items-center rounded px-3 border bg-white py-1">
                                            <input type="number" value="{{ request()->seats }}" class="form-control"
                                                name="seats" required />


                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <button class="bg-main text-white btn">{{ __('Search') }}</button>
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
                    // 1. Remove border from all buttons
                    chooseButtons.forEach(btn => btn.classList.remove('selected-trip-button'));

                    // 2. Add border to the clicked button
                    this.classList.add('selected-trip-button');

                    // 3. Get the trip id from hidden input in the same container
                    const tripId = this.closest('.col-lg-4').querySelector('.trip-id').value;
                    const tripPrice = this.closest('.col-lg-4').querySelector('.trip-price').value;

                    // 4. Show trip-details, hide no-selected-trip
                    document.getElementById('trip-details').style.display = 'block';
                    document.getElementById('no-selected-trip').style.display = 'none';

                    // 5. Set selected trip id in hidden input
                    document.getElementById('selected-trip-id').value = tripId;
                    document.getElementById('selected-trip-price').value = tripPrice;
                    document.getElementById('selected-trip-price-p').textContent = tripPrice + ' ' +
                        ' جنيه';
                    var numOfSeats = document.getElementById('num-of-seats').value;
                    document.getElementById('total-p').textContent = (numOfSeats * tripPrice) +
                        ' ' + ' جنيه';

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
                    stationSelect.innerHTML = '<option value="">اختر محطة</option>';
                    return;
                }

                fetch(`/get-stations/${cityId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">اختر محطة</option>';
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
