@section('mobile-content')
    @include('mobile.layouts.header')

    <div class="search-trip px-3 mt-3">
        <form action="{{ route('mobile.one-way.trips') }}" method="get" id="search-form"
            class="bg-white rounded-5 shadow-sm p-3">
            <!-- start trip type -->
            <div class="text-center mb-4">
                <div class="trip-type-tabs nav nav-pills d-inline-flex w-100 p-1 mo-trip-type-container">
                    <div class="nav-item flex-fill" role="presentation">
                        <button class="nav-link active w-100 py-2 fw-bold mo-trip-type-nav-link" id="pills-oneway-tab-mo"
                            data-bs-toggle="pill" type="button" role="tab"
                            onclick="document.getElementById('oneWayRadio').click()">{{ __('One Way Trip') }}</button>
                    </div>
                    <div class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100 py-2 fw-bold mo-trip-type-nav-link" id="pills-round-tab-mo"
                            data-bs-toggle="pill" type="button" role="tab"
                            onclick="document.getElementById('roundTripRadio').click()">{{ __('Round Trip') }}</button>
                    </div>
                    <!-- Hidden radios for JS compatibility -->
                    <input class="d-none" type="radio" name="tripType" id="oneWayRadio" value="oneway" checked>
                    <input class="d-none" type="radio" name="tripType" id="roundTripRadio" value="round">
                </div>
            </div>
            <!-- End trip type -->

            <!-- start from to  -->
            <div class="station-group mb-4">
                <div class="form-to border-0 rounded-4 px-3 py-3 mo-station-group-bg">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-4 py-3" id="from-container" style="cursor: pointer;">
                                <div
                                    class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center mo-location-icon-box">
                                    <i class="fas fa-location-dot text-main"></i>
                                </div>
                                <div>
                                    <div class="text-muted small mb-1">{{ __('From') }}</div>
                                    <span class="selected-location fw-bold fs-6" id="from-location">
                                        {{ $cities->get(0)?->stations?->first()?->name ?? '' }}
                                    </span>
                                </div>
                            </div>
                            <hr class="my-0 opacity-10">
                            <div class="d-flex align-items-center gap-4 py-3" id="to-container" style="cursor: pointer;">
                                <div
                                    class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center mo-location-icon-box">
                                    <i class="fas fa-circle-dot text-success"></i>
                                </div>
                                <div>
                                    <div class="text-muted small mb-1">{{ __('To') }}</div>
                                    <span class="selected-location fw-bold fs-6" id="to-location">
                                        {{ $cities->get(1)?->stations?->first()?->name ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="swap-btn"
                            class="mo-swap-btn bg-white shadow-sm border rounded-circle d-flex align-items-center justify-content-center ms-3">
                            <i class="fas fa-exchange-alt fa-rotate-90"></i>
                        </button>
                    </div>
                </div>
            </div>

            <input type="hidden" id="from-input" class="from-input">
            <input type="hidden" id="to-input" class="to-input">
            <input type="hidden" id="from-city" name="city_from_id" value="{{ $cities->get(0)?->id ?? '' }}">
            <input type="hidden" id="to-city" name="city_to_id" value="{{ $cities->get(1)?->id ?? '' }}">
            <input type="hidden" id="from-station" name="station_from_id" value="{{ $cities->get(0)?->stations?->first()?->id ?? '' }}">
            <input type="hidden" id="to-station" name="station_to_id" value="{{ $cities->get(1)?->stations?->first()?->id ?? '' }}">

            <!-- Start date and passenger number (must stay inside one .row for Bootstrap grid) -->
            <div class="date-passenger mt-3">
                <div class="row g-3 align-items-end" id="tripLayoutContainer">
                    <div class="col-12" id="departureDateCol">
                        <label class="small text-muted mb-1 d-block" for="departureDateDisplay">{{ __('Departure date') }}</label>
                        <input class="form-control border-0 rounded-4 py-2 mo-bg-gray" type="text" readonly
                            id="departureDateDisplay" value="{{ date('d / m / Y') }}"
                            onclick="openDateWheelPicker('departureDateDisplay', 'departureDate')">
                        <input type="hidden" name="go_date" id="departureDate" value="{{ date('Y-m-d') }}">
                    </div>

            <div class="col-12 col-sm-6" id="passengersColSide">
                <label class="small text-muted mb-1">{{ __('Passengers') }}</label>
                <div class="d-flex justify-content-between align-items-center rounded-4 py-1 px-2 mo-bg-gray">
                    <button type="button" class="btn btn-sm btn-white shadow-sm rounded-circle p-0 mo-passenger-count-btn"
                        onclick="decrementPassengers()"
                        aria-label="{{ __('Decrease number of travelers') }}">
                        <i class="fa fa-minus x-small" aria-hidden="true"></i>
                    </button>
                    <span class="fw-bold" id="passengerCount">1</span>
                    <input type="hidden" id="passenger-count" name="seats" value="1">
                    <button type="button"
                        class="btn btn-sm btn-white shadow-sm rounded-circle p-0 mo-passenger-count-btn"
                        onclick="incrementPassengers()"
                        aria-label="{{ __('Increase number of travelers') }}">
                        <i class="fa fa-plus x-small" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="col-12 col-sm-6 d-none" id="returnDateCol">
                <label class="small text-muted mb-1 d-block" for="returnDateDisplay">{{ __('Return Date') }}</label>
                <input class="form-control border-0 rounded-4 py-2 mo-bg-gray" type="text" readonly
                    id="returnDateDisplay" value="{{ date('d / m / Y', strtotime('+1 day')) }}"
                    onclick="openDateWheelPicker('returnDateDisplay', 'returnDate')">
                <input type="hidden" name="back_date" id="returnDate"
                    value="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>

            <div class="col-12 d-none" id="passengersColBottom">
                <label class="small text-muted mb-1">{{ __('Passengers') }}</label>
                <div class="d-flex justify-content-between align-items-center rounded-4 py-2 px-3 mo-bg-gray">
                    <button type="button" class="btn btn-white shadow-sm rounded-circle mo-btn-32"
                        onclick="decrementPassengers2()"
                        aria-label="{{ __('Decrease number of travelers') }}">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                    <span class="fw-bold fs-5" id="passengerCount2">1</span>
                    <input type="hidden" id="passenger-count2" name="seats" value="1">
                    <button type="button" class="btn btn-white shadow-sm rounded-circle mo-btn-32"
                        onclick="incrementPassengers2()"
                        aria-label="{{ __('Increase number of travelers') }}">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

                </div>
            </div>

    <div class="mt-4">
        <button type="submit" class="hero-btn w-100 rounded-4 py-3 border-0">
            <i class="fas fa-search me-2"></i>
            {{ __('Search For Trips') }}
        </button>
    </div>
    </form>
    </div>

    <!-- End promo  -->

    <!-- start new places (Explore the Most Popular Destinations) -->
    <div class="new-places new-places-mobile mt-3 pb-5 mb-5">
        <h2 class="new-places-title text-black mb-3">
            {{ $popularDestinationsSection['title'] }}
        </h2>
        <div class="swiper new-places-swiper" id="newPlacesSwiperMobile">
            <div class="swiper-wrapper">
                @foreach ($cities as $city)
                    @php
                        $cityPhoto = $city->getRawOriginal('image');
                        $hasCityPhoto =
                            filled($cityPhoto) && is_file(public_path('uploads/city/' . $cityPhoto));
                        $cityName = $city->getTranslation('name', app()->getLocale());
                    @endphp
                    <div class="swiper-slide">
                        <a href="{{ route('home', ['city_to_id' => $city->id]) }}#heroSection"
                            class="popular-dest-card popular-dest-card--mobile d-block text-decoration-none">
                            <div class="popular-dest-card__inner shadow-sm">
                                <div class="popular-dest-card__media popular-dest-card__media--mobile popular-destination-thumb">
                                    @if ($hasCityPhoto)
                                        <img src="{{ asset('uploads/city/' . $cityPhoto) }}"
                                            class="popular-dest-card__img object-fit-cover" alt="{{ $cityName }}"
                                            loading="lazy">
                                    @else
                                        <div class="popular-dest-card__img popular-destination-placeholder"
                                            role="img" aria-label="{{ $cityName }}">
                                            <span class="popular-destination-placeholder__pattern" aria-hidden="true"></span>
                                            <i class="fas fa-map-marked-alt popular-destination-placeholder__icon" aria-hidden="true"></i>
                                            <span class="popular-destination-placeholder__label">{{ __('Destination') }}</span>
                                        </div>
                                    @endif
                                    <div class="popular-dest-card__overlay popular-dest-card__overlay--mobile">
                                        <span class="popular-dest-card__name">{{ $cityName }}</span>
                                        <span class="popular-dest-card__glass-badge">
                                            <i class="fas fa-ticket-alt" aria-hidden="true"></i>
                                            <span>{{ __('Book Now') }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Wheel Picker HTML Structure -->
    <div class="wheel-picker-backdrop" id="wheelBackdrop" role="button" tabindex="0"
        aria-label="{{ __('Close') }}"></div>
    <div class="wheel-picker-container" id="wheelPicker">
        <div class="wheel-picker-header">
            <button type="button" class="btn btn-light rounded-4 px-4 wheel-picker-cancel">{{ __('Cancel') }}</button>
            <h5 class="mb-0 fw-bold">{{ __('Select Date') }}</h5>
            <button type="button"
                class="btn btn-main rounded-4 px-4 text-white wheel-picker-confirm">{{ __('Confirm') }}</button>
        </div>
        <div class="wheel-picker-content text-center">
            <div class="wheel-selection-indicator"></div>
            <div class="wheel-column" id="dayColumn"></div>
            <div class="wheel-column" id="monthColumn"></div>
            <div class="wheel-column" id="yearColumn"></div>
        </div>
    </div>
@endsection
@section('includes')
    @if (!empty($apps['android']) || !empty($apps['ios']))
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
                            <i class="fas fa-tags text-main fa-2x mb-3"></i>
                            <h4>{{ __('Get Exclusive Discounts!') }}</h4>
                            <p>{{ __('Download the HighBus app now and enjoy special offers on your trips') }}</p>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mb-3">
                            @if (!empty($apps['android']))
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
                            @endif
                            @if (!empty($apps['ios']))
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
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary"
                            data-bs-dismiss="modal">{{ __('Maybe Later') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
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

            // Mobile Tab Buttons
            const onewayTabMo = document.getElementById('pills-oneway-tab-mo');
            const roundTabMo = document.getElementById('pills-round-tab-mo');

            // Function to update form layout based on trip type
            function updateTripLayout() {
                if (departureDateCol) {
                    if (oneWayRadio.checked) {
                        departureDateCol.classList.remove('col-md-6');
                        departureDateCol.classList.add('col-12');
                    } else {
                        departureDateCol.classList.add('col-12', 'col-md-6');
                    }
                }
                if (returnDateCol) {
                    if (oneWayRadio.checked) returnDateCol.classList.add('d-none');
                    else returnDateCol.classList.remove('d-none');
                }
                if (passengersColSide) {
                    if (oneWayRadio.checked) passengersColSide.classList.remove('d-none');
                    else passengersColSide.classList.add('d-none');
                }
                if (passengersColBottom) {
                    if (oneWayRadio.checked) passengersColBottom.classList.add('d-none');
                    else passengersColBottom.classList.remove('d-none');
                }

                // Sync passenger counts between the two UI elements
                if (passengerCount && passengerCount2) {
                    if (oneWayRadio.checked) {
                        passengerCount2.textContent = passengerCount.textContent;
                        if (passengerCountInput2) passengerCountInput2.value = passengerCountInput.value;
                    } else {
                        passengerCount.textContent = passengerCount2.textContent;
                        if (passengerCountInput) passengerCountInput.value = passengerCountInput2.value;
                    }
                }

                // Sync tabs
                if (onewayTabMo) {
                    if (oneWayRadio.checked) onewayTabMo.classList.add('active');
                    else onewayTabMo.classList.remove('active');
                }
                if (roundTabMo) {
                    if (roundTripRadio.checked) roundTabMo.classList.add('active');
                    else roundTabMo.classList.remove('active');
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

            // Swap button is handled by event delegation in home/index.blade.php
            // so it works consistently for both desktop and mobile forms.

            // Bottom sheet functionality continues...
            function showBottomSheet() {
                if (!bottomSheet) return;
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

            if (fromContainer) {
                fromContainer.addEventListener('click', function() {
                    activeInput = fromContainer.querySelector('#from-input');
                    activeLocationSpan = fromContainer.querySelector('#from-location');
                    isFromSelection = true;
                    showBottomSheet();
                });
            }
            if (toContainer) {
                toContainer.addEventListener('click', function() {
                    activeInput = toContainer.querySelector('#to-input');
                    activeLocationSpan = toContainer.querySelector('#to-location');
                    isFromSelection = false;
                    showBottomSheet();
                });
            }

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


    <script>
        // Wheel Picker JS Logic
        let currentTargetInput = null;
        let currentTargetHidden = null;

        @php
            $wheelMonthsLocalized = [
                __('January'),
                __('February'),
                __('March'),
                __('April'),
                __('May'),
                __('June'),
                __('July'),
                __('August'),
                __('September'),
                __('October'),
                __('November'),
                __('December'),
            ];
        @endphp
        const monthsLocalized = @json($wheelMonthsLocalized);
        const monthsEn = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        function initWheelColumns() {
            const dayCol = document.getElementById('dayColumn');
            const monthCol = document.getElementById('monthColumn');
            const yearCol = document.getElementById('yearColumn');
            const isRTL = document.documentElement.dir === 'rtl';
            const months = isRTL ? monthsLocalized : monthsEn;

            const addSpacers = (col) => {
                col.innerHTML += '<div class="wheel-item spacer"></div><div class="wheel-item spacer"></div>';
            };

            // Days 1-31
            dayCol.innerHTML = '';
            addSpacers(dayCol);
            for (let i = 1; i <= 31; i++) {
                dayCol.innerHTML += `<div class="wheel-item" data-value="${i}">${i}</div>`;
            }
            addSpacers(dayCol);

            // Months
            monthCol.innerHTML = '';
            addSpacers(monthCol);
            months.forEach((m, idx) => {
                monthCol.innerHTML += `<div class="wheel-item" data-value="${idx+1}">${m}</div>`;
            });
            addSpacers(monthCol);

            // Years
            const curYear = new Date().getFullYear();
            yearCol.innerHTML = '';
            addSpacers(yearCol);
            for (let i = curYear; i <= curYear + 1; i++) {
                yearCol.innerHTML += `<div class="wheel-item" data-value="${i}">${i}</div>`;
            }
            addSpacers(yearCol);

            [dayCol, monthCol, yearCol].forEach(col => {
                col.addEventListener('scroll', () => {
                    const center = col.scrollTop + col.clientHeight / 2;
                    col.querySelectorAll('.wheel-item:not(.spacer)').forEach(item => {
                        const itemCenter = item.offsetTop + item.clientHeight / 2;
                        if (Math.abs(center - itemCenter) < 20) {
                            item.classList.add('selected');
                        } else {
                            item.classList.remove('selected');
                        }
                    });
                });
            });
        }

        function openDateWheelPicker(targetId, hiddenId) {
            currentTargetInput = document.getElementById(targetId);
            currentTargetHidden = document.getElementById(hiddenId);

            document.getElementById('wheelBackdrop').style.display = 'block';
            document.getElementById('wheelPicker').classList.add('active');

            const date = currentTargetHidden.value ? new Date(currentTargetHidden.value) : new Date();
            scrollToValue('dayColumn', date.getDate());
            scrollToValue('monthColumn', date.getMonth() + 1);
            scrollToValue('yearColumn', date.getFullYear());
        }

        function scrollToValue(colId, value) {
            const col = document.getElementById(colId);
            const item = col.querySelector(`.wheel-item[data-value="${value}"]`);
            if (item) {
                setTimeout(() => {
                    col.scrollTop = item.offsetTop - (col.clientHeight / 2) + (item.clientHeight / 2);
                }, 100);
            }
        }

        function closeWheelPicker() {
            const backdrop = document.getElementById('wheelBackdrop');
            const container = document.getElementById('wheelPicker');
            if (backdrop) backdrop.style.display = 'none';
            if (container) container.classList.remove('active');
        }

        function confirmWheelDate() {
            const dayCol = document.getElementById('dayColumn');
            const monthCol = document.getElementById('monthColumn');
            const yearCol = document.getElementById('yearColumn');
            const getSelectedValue = (col) => {
                if (!col) return null;
                const selected = col.querySelector('.wheel-item.selected');
                if (selected) return selected.getAttribute('data-value');
                const center = col.scrollTop + col.clientHeight / 2;
                let found = null;
                col.querySelectorAll('.wheel-item:not(.spacer)').forEach(item => {
                    const itemCenter = item.offsetTop + item.clientHeight / 2;
                    if (Math.abs(center - itemCenter) < 30) found = item.getAttribute('data-value');
                });
                return found || (col.querySelector('.wheel-item:not(.spacer)')?.getAttribute('data-value'));
            };
            const day = getSelectedValue(dayCol);
            const month = getSelectedValue(monthCol);
            const year = getSelectedValue(yearCol);
            if (!day || !month || !year || !currentTargetHidden || !currentTargetInput) {
                closeWheelPicker();
                return;
            }
            const dateStr = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const displayStr = `${String(day).padStart(2, '0')} / ${String(month).padStart(2, '0')} / ${year}`;
            currentTargetHidden.value = dateStr;
            currentTargetInput.value = displayStr;
            closeWheelPicker();
        }

        window.closeWheelPicker = closeWheelPicker;
        window.confirmWheelDate = confirmWheelDate;

        document.addEventListener('DOMContentLoaded', () => {
            initWheelColumns();
            const cancelBtn = document.querySelector('#wheelPicker .wheel-picker-cancel');
            const confirmBtn = document.querySelector('#wheelPicker .wheel-picker-confirm');
            const backdrop = document.getElementById('wheelBackdrop');
            if (cancelBtn) cancelBtn.addEventListener('click', closeWheelPicker);
            if (confirmBtn) confirmBtn.addEventListener('click', confirmWheelDate);
            if (backdrop) backdrop.addEventListener('click', closeWheelPicker);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.querySelector('#newPlacesSwiperMobile');
            if (el && typeof Swiper !== 'undefined') {
                const isRTL = document.documentElement.dir === 'rtl';
                new Swiper('#newPlacesSwiperMobile', {
                    slidesPerView: 2.2,
                    spaceBetween: 12,
                    loop: false,
                    rtl: isRTL,
                    freeMode: true,
                    breakpoints: {
                        375: {
                            slidesPerView: 2.3,
                            spaceBetween: 12
                        },
                        480: {
                            slidesPerView: 2.8,
                            spaceBetween: 14
                        },
                        576: {
                            slidesPerView: 3.2,
                            spaceBetween: 14
                        },
                        768: {
                            slidesPerView: 4,
                            spaceBetween: 16
                        },
                    },
                });
            }
        });
    </script>
@endpush
