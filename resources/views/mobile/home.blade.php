@section('mobile-content')
    <div class="row align-items-center mb-4 wow animate__animated animate__fadeIn">
        <div class="col-8">
            @if (auth()->check())
                <span class="text-muted small fw-bold d-block">{{ __('Hello') }}</span>
                <h5 class="fw-800 text-black mb-0">{{ auth()->user()->name }}</h5>
            @else
                <span class="text-muted small fw-bold d-block">{{ __('Welcome to') }}</span>
                <h5 class="fw-800 text-black mb-0">{{ __('Eman Jet') }}</h5>
            @endif
        </div>
        </div>
    </div>

    <div class="search-trip mt-3 wow animate__animated animate__fadeInUp">
        <form action="{{ route('mobile.one-way.trips') }}" method="get" id="search-form"
            class="bg-white rounded-5 shadow-premium p-4 border border-light-subtle">
            <!-- start trip type -->
            <div class="text-center mb-4">
                <div class="nav nav-pills d-flex p-1 bg-light rounded-pill" style="border: 1px solid #eee;">
                    <button class="nav-link active flex-fill py-2 rounded-pill fw-800 fs-13 mo-trip-type-nav-link" id="pills-oneway-tab-mo"
                        data-bs-toggle="pill" type="button" role="tab"
                        onclick="document.getElementById('oneWayRadio').click()">{{ __('One Way') }}</button>
                    <button class="nav-link flex-fill py-2 rounded-pill fw-800 fs-13 mo-trip-type-nav-link" id="pills-round-tab-mo"
                        data-bs-toggle="pill" type="button" role="tab"
                        onclick="document.getElementById('roundTripRadio').click()">{{ __('Round Trip') }}</button>
                    
                    <input class="d-none" type="radio" name="tripType" id="oneWayRadio" value="oneway" checked>
                    <input class="d-none" type="radio" name="tripType" id="roundTripRadio" value="round">
                </div>
            </div>

            <!-- start from to  -->
            <div class="station-group mb-4 position-relative">
                <div class="p-3 bg-light rounded-5 border border-light-subtle">
                    <div class="d-flex align-items-center gap-3 py-2 px-1" id="from-container" style="cursor: pointer;">
                        <div class="bg-white rounded-circle shadow-premium d-flex align-items-center justify-content-center border-main-subtle" style="min-width: 40px; height: 40px; border: 2px solid rgba(var(--main-color-rgb), 0.2);">
                            <i class="fa-solid fa-location-arrow text-main small"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <label class="text-muted overline-text mb-0" style="font-size: 10px; font-weight: 800; opacity: 0.7;">{{ __('DEPARTURE FROM') }}</label>
                            <div class="selected-location fw-800 text-black text-truncate" id="from-location" style="font-size: 14px;">
                                {{ $cities->get(0)?->stations?->first()?->name ?? __('Select Station') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="position-relative py-1">
                        <hr class="my-0 opacity-10">
                        <button type="button" id="swap-btn"
                            class="position-absolute top-50 start-50 translate-middle bg-white shadow-premium border-light-subtle rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px; z-index: 5; border: 1px solid #eee;">
                            <i class="fa-solid fa-right-left fa-rotate-90 text-main" style="font-size: 10px;"></i>
                        </button>
                    </div>

                    <div class="d-flex align-items-center gap-3 py-2 px-1" id="to-container" style="cursor: pointer;">
                        <div class="bg-white rounded-circle shadow-premium d-flex align-items-center justify-content-center" style="min-width: 40px; height: 40px; border: 2px solid rgba(40, 167, 69, 0.2);">
                            <i class="fa-solid fa-location-dot text-success small"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <label class="text-muted overline-text mb-0" style="font-size: 10px; font-weight: 800; opacity: 0.7;">{{ __('ARRIVAL AT') }}</label>
                            <div class="selected-location fw-800 text-black text-truncate" id="to-location" style="font-size: 14px;">
                                {{ $cities->get(1)?->stations?->first()?->name ?? __('Select Station') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="from-input" class="from-input">
            <input type="hidden" id="to-input" class="to-input">
            <input type="hidden" id="from-city" name="city_from_id" value="{{ $cities->get(0)?->id ?? '' }}">
            <input type="hidden" id="to-city" name="city_to_id" value="{{ $cities->get(1)?->id ?? '' }}">
            <input type="hidden" id="from-station" name="station_from_id" value="{{ $cities->get(0)?->stations?->first()?->id ?? '' }}">
            <input type="hidden" id="to-station" name="station_to_id" value="{{ $cities->get(1)?->station_to_id ?? $cities->get(1)?->stations?->first()?->id ?? '' }}">

            <!-- Start date and passenger number -->
            <div class="row g-3">
                <div class="col-12" id="departureDateCol">
                    <div class="bg-light rounded-4 p-3 border border-light-subtle" onclick="openDateWheelPicker('departureDateDisplay', 'departureDate')">
                        <label class="text-muted overline-text d-block mb-1" style="font-size: 10px; font-weight: 800;">{{ __('DATE') }}</label>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-calendar-days text-main opacity-50"></i>
                            <input class="form-control border-0 bg-transparent p-0 fw-800 text-black shadow-none" type="text" readonly
                                id="departureDateDisplay" value="{{ date('d / m / Y') }}" style="font-size: 14px;">
                        </div>
                        <input type="hidden" name="go_date" id="departureDate" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="col-12 d-none" id="returnDateCol">
                    <div class="bg-light rounded-4 p-3 border border-light-subtle" onclick="openDateWheelPicker('returnDateDisplay', 'returnDate')">
                        <label class="text-muted overline-text d-block mb-1" style="font-size: 10px; font-weight: 800;">{{ __('RETURN DATE') }}</label>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-calendar-check text-success opacity-50"></i>
                            <input class="form-control border-0 bg-transparent p-0 fw-800 text-black shadow-none" type="text" readonly
                                id="returnDateDisplay" value="{{ date('d / m / Y', strtotime('+1 day')) }}" style="font-size: 14px;">
                        </div>
                        <input type="hidden" name="back_date" id="returnDate"
                            value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>
                </div>

                <div class="col-12">
                    <div class="bg-light rounded-4 p-3 border border-light-subtle">
                        <label class="text-muted overline-text d-block mb-2" style="font-size: 10px; font-weight: 800;">{{ __('PASSENGERS') }}</label>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-user-group text-main opacity-50"></i>
                                <span class="fw-800 text-black" style="font-size: 14px;" id="passengerDisplay">1 {{ __('Person') }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <button type="button" class="btn btn-white shadow-premium rounded-circle d-flex align-items-center justify-content-center p-0"
                                    style="width:32px; height:32px;" onclick="decrementPassengers()">
                                    <i class="fa-solid fa-minus text-main small"></i>
                                </button>
                                <span class="fw-800 fs-5 mx-1" id="passengerCount">1</span>
                                <input type="hidden" id="passenger-count" name="seats" value="1">
                                <button type="button" class="btn btn-white shadow-premium rounded-circle d-flex align-items-center justify-content-center p-0"
                                    style="width:32px; height:32px;" onclick="incrementPassengers()">
                                    <i class="fa-solid fa-plus text-main small"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-main w-100 rounded-pill py-3 fw-800 shadow-premium">
                    <i class="fa-solid fa-magnifying-glass me-2"></i>
                    {{ __('Find Your Trip') }}
                </button>
            </div>
        </form>
    </div>

    <!-- End promo  -->

    <!-- start popular destinations -->
    <div class="new-places px-2 mt-4 wow animate__animated animate__fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-3 px-1">
            <h5 class="fw-800 text-black mb-0">{{ $popularDestinationsSection['title'] }}</h5>
            <a href="{{ route('destinations') }}" class="text-main small fw-800 text-decoration-none">{{ __('View All') }}</a>
        </div>
        
        <div class="swiper new-places-swiper" id="newPlacesSwiperMobile">
            <div class="swiper-wrapper">
                @foreach ($cities as $city)
                    @php
                        $cityPhoto = $city->getRawOriginal('image');
                        $hasCityPhoto = filled($cityPhoto) && is_file(public_path('uploads/city/' . $cityPhoto));
                        $cityName = $city->getTranslation('name', app()->getLocale());
                    @endphp
                    <div class="swiper-slide h-auto">
                        <a href="{{ route('home', ['city_to_id' => $city->id]) }}#heroSection"
                            class="d-block text-decoration-none h-100">
                            <div class="bg-white rounded-5 shadow-sm border border-light-subtle overflow-hidden h-100 p-2">
                                <div class="position-relative rounded-4 overflow-hidden mb-2" style="height: 140px;">
                                    @if ($hasCityPhoto)
                                        <img src="{{ asset('uploads/city/' . $cityPhoto) }}"
                                            class="w-100 h-100 object-fit-cover" alt="{{ $cityName }}"
                                            loading="lazy">
                                    @else
                                        <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-mountain-sun text-muted opacity-50"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute bottom-0 start-0 w-100 p-2" style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
                                        <span class="text-white fw-800 fs-12">{{ $cityName }}</span>
                                    </div>
                                </div>
                                <div class="px-1 pb-1">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="bg-main-light text-main rounded-pill px-2 py-0 fw-800 fs-10" style="font-size: 9px;">
                                            <i class="fa-solid fa-ticket-simple me-1"></i> {{ __('BOOK NOW') }}
                                        </div>
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
                            <p>{{ __('Download the Eman Jet app now and enjoy special offers on your trips') }}</p>
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
                    activeInput = document.getElementById('from-input');
                    activeLocationSpan = document.getElementById('from-location');
                    isFromSelection = true;
                    showBottomSheet();
                });
            }
            if (toContainer) {
                toContainer.addEventListener('click', function() {
                    activeInput = document.getElementById('to-input');
                    activeLocationSpan = document.getElementById('to-location');
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
        const monthsEn = ["FROM": "من",
    "FROM": "من",
    "Faq": "الأسئلة الشائعة", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

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
                    "Apply Filters": "تطبيق الفلاتر",
    "Arrival": "الوصول",
    "ARRIVAL AT": "الوصول إلى",
    "Available Trips": "الرحلات المتاحة",
    "Account Settings": "إعدادات الحساب",
    "Round Trip": "ذهاب وعودة",
    "Select Station": "اختر المحطة",
    "TO": "إلى",
    "Run merge": "تشغيل الدمج",
    "OTP must be 4 digits": "رمز التحقق يجب أن يكون 4 أرقام",                  freeMode: true,
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
