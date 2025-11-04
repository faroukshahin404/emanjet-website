@section('mobile-content')
    @include('mobile.layouts.header')

    <div class="search-trip">
        <form action="{{ route('mobile.one-way.trips') }}" method="get" id="search-form">
            <!-- start trip type -->
            <div class="trip-type bg-white  mt-3 d-flex justify-content-between align-items-center p-3">
                <div class="form-check">
                    <input class="form-check-input form-check-input-pay" type="radio" name="tripType" id="oneWayRadio"
                        value="oneway" checked>
                    <label class="form-check-label" for="oneWayRadio">
                        {{ __('One Way Trip') }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input form-check-input-pay" type="radio" name="tripType" id="roundTripRadio"
                        value="round">
                    <label class="form-check-label" for="roundTripRadio">
                        {{ __(key: 'Round Trip') }}
                    </label>
                </div>
                <div class="special-offer">
                    {{ __(key: 'Special Discount') }}
                </div>
            </div>
            <!-- End trip type -->

            <!-- start from to  -->
            <div class="form-to border rounded-7 px-3 py-3 mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center gap-2" id="from-container">
                            <i class="fas fa-location-dot from-icon"></i>
                            <label for="from-input">{{ __('From') }}</label>
                            <input type="hidden" id="from-input" class="from-input">
                            <span class="selected-location" id="from-location">
                                {{ $cities[0]->stations[0]->name }}
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center gap-2" id="to-container">
                            <i class="fas fa-circle-dot to-icon"></i>
                            <label for="to-input">{{ __('To') }}</label>
                            <input type="hidden" id="to-input" class="to-input">
                            <span class="selected-location" id="to-location">
                                {{ $cities[1]->stations[0]->name }}
                            </span>
                        </div>
                    </div>
                    <button type="button" class="swap-btn bg-transparent border-0" aria-label="تبديل الوجهات"
                        id="swap-btn">
                        <img src="{{ asset('images/mobile/swap.png') }}" alt="swap">
                    </button>
                </div>
            </div>
            <input type="hidden" id="from-city" name="city_from_id" value="{{ $cities[0]->id }}">
            <input type="hidden" id="to-city" name="city_to_id" value="{{ $cities[1]->id }}">
            <input type="hidden" id="from-station" name="station_from_id" value="{{ $cities[0]->stations[0]->id }}">
            <input type="hidden" id="to-station" name="station_to_id" value="{{ $cities[1]->stations[0]->id }}">
            <!-- Start date and passenger numer -->
            <div class="date-passenger mt-3">
                <div class="row g-2" id="tripLayoutContainer">
                    <div class="col-md-6 d-flex flex-column" id="departureDateCol">
                        <label>
                            <span>{{ __('Date') }}</span>
                            <i class="fa fa-calendar mx-1"></i>
                        </label>
                        @php
                            $go_date = date('Y-m-d');
                            $return_date = date('Y-m-d', strtotime('+1 day'));
                        @endphp
                        <input class="form-control rounded-6" type="date" name="go_date" id="departureDate"
                            value="{{ $go_date }}">
                    </div>

                    <div class="col-md-6" id="passengersColSide">
                        <div class="d-flex flex-column w-100 h-100 justify-content-end">
                            <label>
                                <span>{{ __('Passengers') }}</span>
                                <i class="fa fa-user mx-1"></i>
                            </label>
                            <div class="d-flex justify-content-center align-items-center border rounded-6 p-1">
                                <button type="button" class="border passenger-btn plus-btn"
                                    onclick="decrementPassengers()">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <span class="mx-3" id="passengerCount">1</span>
                                <input type="hidden" id="passenger-count" name="seats" value="1">
                                <button type="button" class="passenger-btn minus-btn" onclick="incrementPassengers()">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 d-none" id="returnDateCol">
                        <div class="d-flex flex-column">
                            <label>
                                <span> {{ __('Return Date') }}</span>
                                <i class="fa fa-calendar mx-1"></i>
                            </label>
                            <input class="form-control rounded-6" type="date" name="back_date" id="returnDate"
                                value="{{ $return_date }}">
                        </div>
                    </div>

                    <div class="col-12 d-none" id="passengersColBottom">
                        <div class="d-flex flex-column w-100">
                            <label>
                                <span>{{ __('Passengers') }}</span>
                                <i class="fa fa-user mx-1"></i>
                            </label>
                            <div class="d-flex justify-content-center align-items-center border rounded-6 p-1">
                                <button type="button" class="border passenger-btn" onclick="decrementPassengers2()">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <span class="mx-3" id="passengerCount2">1</span>
                                <input type="hidden" id="passenger-count2" name="seats" value="1">
                                <button type="button" class="passenger-btn" onclick="incrementPassengers2()">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End date and passenger numer -->

            <div class=" d-flex justify-content-center align-items-center mt-3">
                <button class="search-btn">
                    <span>{{ __('Search For Trips') }}</span>
                </button>
            </div>

        </form>
    </div>

    <!-- End promo  -->

    <!-- start new places  -->
    <div class="new-places mt-3">
        <h2 class="text-black mb-1">
            {{ __('Explore the Most Popular Destinations ') }}
        </h2>
        <div class="swiper mySwiper4">
            <div class="swiper-wrapper">

                @foreach ($cities as $city)
                    <div class="swiper-slide">
                        <a href="{{ route('home', ['city_to_id' => $city->id]) }}#heroSection" class="reserve">
                            <img src="{{ $city->image }}" alt="city" style="border-radius: 10px;"
                                onerror="this.src='https://www.touristegypt.com/wp-content/uploads/2023/05/Sharm-el-Sheikh2.jpg'">
                        </a>
                        <h4 class="text-truncate">{{ $city->getTranslation('name', app()->getLocale()) }}</h4>

                    </div>
                @endforeach


            </div>
        </div>
    </div>
@endsection
@section('includes')
    <!-- App Download Modal -->
    <div class="modal fade" id="appDownloadModal" tabindex="-1" aria-labelledby="appDownloadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appDownloadModalLabel">{{ __('Download Our App') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-tags text-warning fa-2x mb-3"></i>
                        <h4>{{ __('Get Exclusive Discounts!') }}</h4>
                        <p>{{ __('Download the SuperJet app now and enjoy special offers on your trips') }}</p>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mb-3">
                        <a href="{{ $apps['android'] }}" target="_blank"
                            class="google-play-box rounded-5 text-decoration-none">
                            <div class="d-flex justify-content-center align-items-center gap-3 py-2 px-3">
                                <div class="google-play">
                                    <p>{{ __('Get It On') }}</p>
                                    <h6>{{ __('Google Play') }}</h6>
                                </div>
                                <img src="{{ asset('images/google-play-icon.png') }}" alt="google-play">
                            </div>
                        </a>

                        {{-- Uncomment when iOS app is available --}}
                        <a href="{{ $apps['ios'] }}" target="_blank"
                            class="google-play-box rounded-5 text-decoration-none">
                            <div class="d-flex justify-content-center align-items-center gap-3 py-2 px-3">
                                <div class="google-play">
                                    <p>{{ __('Download On The') }}</p>
                                    <h6>{{ __('App Store') }}</h6>
                                </div>
                                <i class="fa-brands fa-apple"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                        data-bs-dismiss="modal">{{ __('Maybe Later') }}</button>
                </div>
            </div>
        </div>
    </div>
    @include('mobile.components.location-bottom-sheet')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fromContainer = document.getElementById('from-container');
            const toContainer = document.getElementById('to-container');
            const bottomSheet = document.getElementById('locationBottomSheet');
            const locationSearch = document.getElementById('locationSearch');
            const cityHeaders = bottomSheet.querySelectorAll('.city-header');
            const subStations = bottomSheet.querySelectorAll('.sub-stations');
            const swapBtn = document.getElementById('swap-btn');
            const searchForm = document.getElementById('search-form');
            const oneWayRadio = document.getElementById('oneWayRadio');
            const roundTripRadio = document.getElementById('roundTripRadio');

            const departureDateCol = document.getElementById('departureDateCol');
            const returnDateCol = document.getElementById('returnDateCol');
            const passengersColSide = document.getElementById('passengersColSide');
            const passengersColBottom = document.getElementById('passengersColBottom');

            const passengerCount = document.getElementById('passengerCount');
            const passengerCount2 = document.getElementById('passengerCount2');
            const passengerCountInput = document.getElementById('passenger-count');
            const passengerCountInput2 = document.getElementById('passenger-count2');

            let activeInput = null;
            let activeLocationSpan = null;
            let currentSubStations = null;
            let isFromSelection = false;

            // Input elements for city and station IDs
            const fromCityInput = document.getElementById('from-city');
            const toCityInput = document.getElementById('to-city');
            const fromStationInput = document.getElementById('from-station');
            const toStationInput = document.getElementById('to-station');
            const fromLocationSpan = document.getElementById('from-location');
            const toLocationSpan = document.getElementById('to-location');

            // Function to update form layout based on trip type
            function updateTripLayout() {
                if (oneWayRadio.checked) {
                    // One way trip layout
                    departureDateCol.classList.remove('col-md-6');
                    departureDateCol.classList.add('col-md-6');
                    returnDateCol.classList.add('d-none');
                    passengersColSide.classList.remove('d-none');
                    passengersColBottom.classList.add('d-none');

                    // Sync passenger counts between the two UI elements
                    passengerCount2.textContent = passengerCount.textContent;
                    passengerCountInput2.value = passengerCountInput.value;
                } else if (roundTripRadio.checked) {
                    // Round trip layout
                    departureDateCol.classList.remove('col-md-6');
                    departureDateCol.classList.add('col-md-6');
                    returnDateCol.classList.remove('d-none');
                    passengersColSide.classList.add('d-none');
                    passengersColBottom.classList.remove('d-none');

                    // Sync passenger counts between the two UI elements
                    passengerCount.textContent = passengerCount2.textContent;
                    passengerCountInput.value = passengerCountInput2.value;
                }
            }

            // Function to update form action based on trip type
            function updateFormAction() {
                if (oneWayRadio.checked) {
                    searchForm.action = oneWayRoute;
                } else if (roundTripRadio.checked) {
                    searchForm.action = roundRoute;
                }

                // Update layout when trip type changes
                updateTripLayout();
            }

            // Function to keep passenger counts in sync across both UIs
            function syncPassengerCounts(value) {
                // Update both displays
                passengerCount.textContent = value;
                passengerCount2.textContent = value;

                // Update both hidden inputs
                passengerCountInput.value = value;
                passengerCountInput2.value = value;
            }

            // Passenger increment/decrement functions - now with syncing
            window.incrementPassengers = function() {
                let count = parseInt(passengerCount.textContent);
                if (count < 9) {
                    count++;
                    syncPassengerCounts(count);
                }
            };

            window.decrementPassengers = function() {
                let count = parseInt(passengerCount.textContent);
                if (count > 1) {
                    count--;
                    syncPassengerCounts(count);
                }
            };

            window.incrementPassengers2 = function() {
                let count = parseInt(passengerCount2.textContent);
                if (count < 9) {
                    count++;
                    syncPassengerCounts(count);
                }
            };

            window.decrementPassengers2 = function() {
                let count = parseInt(passengerCount2.textContent);
                if (count > 1) {
                    count--;
                    syncPassengerCounts(count);
                }
            };

            // Add event listeners for trip type radio buttons
            oneWayRadio.addEventListener('change', updateFormAction);
            roundTripRadio.addEventListener('change', updateFormAction);

            // Initialize the layout based on the default selection
            updateTripLayout();

            // Define your routes here (replace with your actual route values)
            const oneWayRoute = "{{ route('mobile.one-way.trips') }}";
            const roundRoute = "{{ route('mobile.round.trips') }}";

            // Function to swap locations
            function swapLocations() {
                // Swap city IDs
                const tempCityId = fromCityInput.value;
                fromCityInput.value = toCityInput.value;
                toCityInput.value = tempCityId;

                // Swap station IDs
                const tempStationId = fromStationInput.value;
                fromStationInput.value = toStationInput.value;
                toStationInput.value = tempStationId;

                // Swap location display text
                const tempLocation = fromLocationSpan.textContent;
                fromLocationSpan.textContent = toLocationSpan.textContent;
                toLocationSpan.textContent = tempLocation;
            }

            // Add click event listener to swap button
            swapBtn.addEventListener('click', function(e) {
                e.preventDefault();
                swapLocations();
            });

            // Bottom sheet functionality continues...
            function showBottomSheet() {
                bottomSheet.classList.add('show');
                document.body.style.overflow = 'hidden';
                // Hide any open sub-stations
                subStations.forEach(subStation => subStation.classList.remove('show'));
            }

            function hideBottomSheet() {
                bottomSheet.classList.remove('show');
                document.body.style.overflow = '';
                locationSearch.value = '';
                filterLocations('');
                // Hide any open sub-stations
                subStations.forEach(subStation => subStation.classList.remove('show'));
            }

            function filterLocations(searchTerm) {
                const searchLower = searchTerm.toLowerCase();

                // If a sub-station list is open, only search within it
                if (currentSubStations && currentSubStations.classList.contains('show')) {
                    const stations = currentSubStations.querySelectorAll('.station-item');
                    stations.forEach(station => {
                        const text = station.querySelector('span').textContent.toLowerCase();
                        station.style.display = text.includes(searchLower) ? '' : 'none';
                    });
                } else {
                    // Search in cities and their stations
                    cityHeaders.forEach(header => {
                        const cityItem = header.closest('.location-item');
                        const cityText = header.querySelector('span').textContent.toLowerCase();
                        const stations = cityItem.querySelectorAll('.station-item span');
                        const stationsText = Array.from(stations).map(s => s.textContent.toLowerCase())
                            .join(' ');

                        if (cityText.includes(searchLower) || stationsText.includes(searchLower)) {
                            cityItem.style.display = '';
                            if (stationsText.includes(searchLower)) {
                                // Show the sub-stations if any match
                                const subStation = cityItem.querySelector('.sub-stations');
                                if (subStation) subStation.classList.add('show');

                                // Filter the stations
                                stations.forEach(station => {
                                    const stationItem = station.closest('.station-item');
                                    stationItem.style.display = station.textContent.toLowerCase()
                                        .includes(searchLower) ? '' : 'none';
                                });
                            }
                        } else {
                            cityItem.style.display = 'none';
                        }
                    });
                }
            }

            fromContainer.addEventListener('click', function() {
                activeInput = fromContainer.querySelector('#from-input');
                activeLocationSpan = fromContainer.querySelector('#from-location');
                isFromSelection = true;
                showBottomSheet();
            });

            toContainer.addEventListener('click', function() {
                activeInput = toContainer.querySelector('#to-input');
                activeLocationSpan = toContainer.querySelector('#to-location');
                isFromSelection = false;
                showBottomSheet();
            });

            // Handle city header clicks
            cityHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const cityItem = this.closest('.location-item');
                    const cityId = cityItem.getAttribute('data-city');
                    const subStation = cityItem.querySelector('.sub-stations');

                    // Update city ID
                    if (isFromSelection) {
                        fromCityInput.value = cityId;
                    } else {
                        toCityInput.value = cityId;
                    }

                    // Hide all other sub-stations
                    subStations.forEach(s => {
                        if (s !== subStation) s.classList.remove('show');
                    });

                    // Toggle current sub-station
                    subStation.classList.toggle('show');
                    currentSubStations = subStation;
                });
            });

            // Handle station selection
            bottomSheet.addEventListener('click', function(e) {
                const stationItem = e.target.closest('.station-item');
                if (stationItem) {
                    const stationId = stationItem.getAttribute('data-location');
                    const location = stationItem.querySelector('span').textContent;
                    const cityItem = stationItem.closest('.location-item');
                    const cityId = cityItem.getAttribute('data-city');

                    if (activeInput && activeLocationSpan) {
                        // Update display
                        activeInput.value = location;
                        activeLocationSpan.textContent = location;

                        // Update hidden inputs
                        if (isFromSelection) {
                            fromCityInput.value = cityId;
                            fromStationInput.value = stationId;
                        } else {
                            toCityInput.value = cityId;
                            toStationInput.value = stationId;
                        }

                        hideBottomSheet();
                    }
                }
            });

            locationSearch.addEventListener('input', function(e) {
                filterLocations(e.target.value);
            });

            // Close bottom sheet when clicking outside
            document.addEventListener('click', function(e) {
                if (bottomSheet.classList.contains('show') &&
                    !bottomSheet.contains(e.target) &&
                    !fromContainer.contains(e.target) &&
                    !toContainer.contains(e.target)) {
                    hideBottomSheet();
                }
            });
        });
    </script>
@endpush
