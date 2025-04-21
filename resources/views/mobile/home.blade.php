

@section('mobile-content')
    <div class="search-trip">
        <form action="{{ route('mobile.one-way.trips') }}" method="get">
            <!-- start trip type -->
            <div class="trip-type bg-white  mt-3 d-flex justify-content-between align-items-center p-3">
                <div class="form-check">
                    <input class="form-check-input form-check-input-pay" type="radio" name="tripType" id="oneWayRadio"
                        value="oneway" checked>
                    <label class="form-check-label" for="oneWayRadio">
                        ذهاب فقط
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input form-check-input-pay" type="radio" name="tripType" id="roundTripRadio"
                        value="round">
                    <label class="form-check-label" for="roundTripRadio">
                        ذهاب وعودة
                    </label>
                </div>
                <div class="special-offer">
                    عرض خاص
                </div>
            </div>
            <!-- End trip type -->

            <!-- start from to  -->
            <div class="form-to border rounded-7 px-3 py-3 mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center gap-2" id="from-container">
                            <i class="fas fa-location-dot from-icon"></i>
                            <label for="from-input">من</label>
                            <input type="hidden" id="from-input" class="from-input">
                            <span class="selected-location" id="from-location">
                                {{ $cities[0]->stations[0]->name }}
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center gap-2" id="to-container">
                            <i class="fas fa-circle-dot to-icon"></i>
                            <label for="to-input">الي</label>
                            <input type="hidden" id="to-input" class="to-input">
                            <span class="selected-location" id="to-location">
                                {{ $cities[1]->stations[0]->name }}
                            </span>
                        </div>
                    </div>
                    <button type="button" class="swap-btn bg-transparent border-0" aria-label="تبديل الوجهات">
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
                            <span>تاريخ السفر</span>
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
                                <span>الركاب</span>
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
                                <span>تاريخ العودة</span>
                                <i class="fa fa-calendar mx-1"></i>
                            </label>
                            <input class="form-control rounded-6" type="date" name="return_date" id="returnDate"
                                value="{{ $return_date }}">
                        </div>
                    </div>

                    <div class="col-12 d-none" id="passengersColBottom">
                        <div class="d-flex flex-column w-100">
                            <label>
                                <span>الركاب</span>
                                <i class="fa fa-user mx-1"></i>
                            </label>
                            <div class="d-flex justify-content-center align-items-center border rounded-6 p-1">
                                <button type="button" class="border passenger-btn" onclick="decrementPassengers2()">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <span class="mx-3" id="passengerCount2">1</span>
                                <input type="hidden" id="passenger-count" name="seats" value="1">
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
                    البحث عن الرحلات
                </button>
            </div>

        </form>
    </div>
    <!-- Start Search  -->

    <!-- start last search  -->
    <div class="last-search">

        <div class="d-flex justify-content-between align-items-center my-3">
            <p class="m-0">البحث الاخير</p>
            <a href="last-search.html">عرض الكل</a>
        </div>

        <div class="swiper mySwiper2">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="border rounded-7 px-3 py-4">
                        <div class="d-flex justify-content-start gap-3 align-items-center text-black fw-bold">
                            <p class="m-0 fs-18">القاهرة</p>
                            <i class="fas fa-arrow-left-long fs-18"></i>
                            <p class="m-0 fs-18">الاسكندرية</p>
                        </div>
                        <div class="mt-3">
                            <p class="m-0 text-gray">
                                24 فبراير 2023 . 1 راكب . درجة اولي
                            </p>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">

                    <div class="border rounded-6 px-3 py-4">
                        <div class="d-flex justify-content-start gap-3 align-items-center text-black fw-bold">
                            <p class="m-0 fs-18">القاهرة</p>
                            <i class="fas fa-arrow-left-long fs-18"></i>
                            <p class="m-0 fs-18">الاسكندرية</p>
                        </div>
                        <div class="mt-3">
                            <p class="m-0 text-gray">
                                24 فبراير 2023 . 1 راكب . درجة اولي
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End last search  -->

    <!-- start promo  -->
    <div class="promo mt-3">
        <h2 class="text-black mb-2">احصل على عروض ترويجية</h2>
        <div class="swiper mySwiper3">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="position-relative rounded-7 promo-box">
                        <div class="m-0 position-absolute promo-caption">
                            <p class="m-0">خصم</p>
                            <span class="fs-20">30%</span>
                            <p class="m-0">للمستخدمين الجدد</p>
                        </div>
                        <img class="promo-img rounded-7" src="{{ asset('images/mobile/promo.png') }}" alt="promo">
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="position-relative rounded-7 promo-box">
                        <div class="m-0 position-absolute promo-caption">
                            <p class="m-0">خصم</p>
                            <span class="fs-20">30%</span>
                            <p class="m-0">للمستخدمين الجدد</p>
                        </div>
                        <img class="promo-img rounded-7" src="{{ asset('images/mobile/promo.png') }}" alt="promo">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End promo  -->

    <!-- start new places  -->
    <div class="new-places mt-3">
        <h2 class="text-black mb-1">استكشف اماكن جديدة</h2>
        <div class="swiper mySwiper4">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div>
                        <img class="promo-img" src="{{ asset('images/mobile/new-places.png') }}" alt="new-places">
                        <p class="text-black">الاسكندرية</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div>
                        <img class="promo-img" src="{{ asset('images/mobile/new-places.png') }}" alt="new-places">
                        <p class="text-black">الاسكندرية</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div>
                        <img class="promo-img" src="{{ asset('images/mobile/new-places.png') }}" alt="new-places">
                        <p class="text-black">الاسكندرية</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div>
                        <img class="promo-img" src="{{ asset('images/mobile/new-places.png') }}" alt="new-places">
                        <p class="text-black">الاسكندرية</p>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div>
                        <img class="promo-img" src="{{ asset('images/mobile/new-places.png') }}" alt="new-places">
                        <p class="text-black">الاسكندرية</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('includes')
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
            let activeInput = null;
            let activeLocationSpan = null;
            let currentSubStations = null;
            let isFromSelection = false;

            // Input elements for city and station IDs
            const fromCityInput = document.getElementById('from-city');
            const toCityInput = document.getElementById('to-city');
            const fromStationInput = document.getElementById('from-station');
            const toStationInput = document.getElementById('to-station');

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
