@extends('layouts.master')

@section('mobile-content')
    @php
        $isRtl = app()->getLocale() === 'ar';
        $journeyDirIcon = $isRtl ? 'fa-chevron-left' : 'fa-chevron-right';
        $navBackIcon = $isRtl ? 'fa-chevron-right' : 'fa-chevron-left';
    @endphp
    <div class="row g-3">
        <!-- Modernized Journey Summary Card -->
        <div class="col-12 px-0">
            <div class="mobile-journey-card text-center position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button type="button" onclick="window.history.back()"
                        class="btn btn-link text-dark p-0 border-0"
                        aria-label="{{ __('Back') }}">
                        <i class="fas {{ $navBackIcon }} fs-4" aria-hidden="true"></i>
                    </button>
                    <span class="badge bg-main-light text-main rounded-pill px-3 py-2 fw-bold small">
                        {{ __('Return Trip') }}
                    </span>
                    <button class="btn btn-sm btn-light rounded-circle shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#searchModal">
                        <i class="fas fa-pencil-alt text-main"></i>
                    </button>
                </div>

                <div class="row align-items-center g-0">
                    <div class="col-5">
                        <span class="city d-block fw-900 fs-18 mb-1">{{ $search['from']->name }}</span>
                        <span class="station text-muted small text-truncate d-block">{{ $search['fromStation']->name ?? __('All Stations') }}</span>
                    </div>
                    <div class="col-2 journey-arrow">
                        <div class="position-relative w-100 d-flex align-items-center justify-content-center">
                            <div class="arrow-line"></div>
                            <div class="arrow-head" aria-hidden="true"><i
                                    class="fas {{ $journeyDirIcon }} text-main small"></i></div>
                        </div>
                    </div>
                    <div class="col-5">
                        <span class="city d-block fw-900 fs-18 mb-1">{{ $search['to']->name }}</span>
                        <span class="station text-muted small text-truncate d-block">{{ $search['toStation']->name ?? __('All Stations') }}</span>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-3 pt-3 border-top border-light-subtle">
                    <div class="date-badge px-2 py-1">
                        <span class="label d-block text-muted text-uppercase mb-1">{{ __('Departure') }}</span>
                        <span class="value d-block text-dark fw-bold small">{{ \Carbon\Carbon::parse(request()->go_date)->format('d M, Y') }}</span>
                    </div>
                    <div class="vr opacity-10"></div>
                    <div class="date-badge px-2 py-1">
                        <span class="label d-block text-muted text-uppercase mb-1">{{ __('Return') }}</span>
                        <span class="value d-block text-dark fw-bold small">{{ \Carbon\Carbon::parse(request()->back_date)->format('d M, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Date scrollers: departure (re-search outbound) + return -->
        <div class="col-12 px-0 mb-2">
            <div class="px-2 mb-1">
                <span class="mo-trip-date-section-label">{{ __('Travel Date') }}</span>
            </div>
            <div class="tabs-container">
                <div class="tabs-wrapper px-2" id="date-slider-go" data-date-slider>
                    <div class="d-flex gap-2">
                        @foreach ($goDates as $date)
                            @php
                                $carbonDate = \Carbon\Carbon::parse($date);
                                $dayName = $carbonDate->isToday() ? __('Today') : (app()->getLocale() == 'ar' ? $carbonDate->locale('ar')->dayName : $carbonDate->format('l'));
                                $dayNum = $carbonDate->format('d');
                                $monthName = app()->getLocale() == 'ar' ? $carbonDate->locale('ar')->monthName : $carbonDate->format('M');
                                $isActive = request()->go_date == $date;
                            @endphp

                            <form action="{{ route('mobile.round.trips') }}" method="get" class="m-0">
                                <input type="hidden" name="tripType" value="{{ request()->tripType }}" />
                                <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
                                <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
                                <input type="hidden" name="station_from_id" value="{{ request()->station_from_id }}" />
                                <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />
                                <input type="hidden" name="seats" value="{{ request()->seats }}" />
                                <input type="hidden" name="back_date" value="{{ request()->back_date }}" />
                                <input type="hidden" name="go_date" value="{{ $date }}" />
                                <button type="submit"
                                    class="date-pill {{ $isActive ? 'active' : '' }} d-flex flex-column align-items-center justify-content-center">
                                    <span class="day-name">{{ $dayName }}</span>
                                    <span class="day-num">{{ $dayNum }}</span>
                                    <span class="month-name">{{ $monthName }}</span>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 px-0 mb-2">
            <div class="px-2 mb-1">
                <span class="mo-trip-date-section-label">{{ __('Back Date') }}</span>
            </div>
            <div class="tabs-container">
                <div class="tabs-wrapper px-2" id="date-slider-back" data-date-slider>
                    <div class="d-flex gap-2">
                        @foreach ($dates as $date)
                            @php
                                $carbonDate = \Carbon\Carbon::parse($date);
                                $dayName = $carbonDate->isToday() ? __('Today') : (app()->getLocale() == 'ar' ? $carbonDate->locale('ar')->dayName : $carbonDate->format('l'));
                                $dayNum = $carbonDate->format('d');
                                $monthName = app()->getLocale() == 'ar' ? $carbonDate->locale('ar')->monthName : $carbonDate->format('M');
                                $isActive = request()->back_date == $date;
                            @endphp

                            <form action="{{ route('mobile.round.back-trips') }}" method="get" class="m-0">
                                <input type="hidden" name="tripType" value="{{ request()->tripType }}" />
                                <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
                                <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
                                <input type="hidden" name="station_from_id" value="{{ request()->station_from_id }}" />
                                <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />
                                <input type="hidden" name="seats" value="{{ request()->seats }}" />
                                <input type="hidden" name="go_date" value="{{ request()->go_date }}" />
                                <input type="hidden" name="go_trip_id" value="{{ request()->go_trip_id }}" />
                                <input type="hidden" name="back_date" value="{{ $date }}" />
                                <button type="submit"
                                    class="date-pill {{ $isActive ? 'active' : '' }} d-flex flex-column align-items-center justify-content-center">
                                    <span class="day-name">{{ $dayName }}</span>
                                    <span class="day-num">{{ $dayNum }}</span>
                                    <span class="month-name">{{ $monthName }}</span>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Trip List -->
        <div class="col-12 px-0">
            <div class="px-1">
                @if ($trips->count() > 0)
                    @foreach ($trips as $trip)
                        @php
                            $time = \Carbon\Carbon::parse($trip->tripTime)->format('h:i a');
                        @endphp
                        <a href="{{ route('mobile.round.choose-seat', array_merge(request()->all(), ['back_trip_id' => $trip->id])) }}"
                            class="text-decoration-none">
                            <div class="bus-card premium-trip-card mb-4 overflow-hidden border-0 shadow-sm p-3">
                                <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                    <div class="d-flex gap-3">
                                        <div class="bus-icon-wrapper rounded-4 shadow-sm">
                                            <i class="fas fa-bus text-main"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold text-black mb-1 fs-16">{{ $time }}</h5>
                                            <span class="badge bg-main-light text-main rounded-pill px-2 py-1 fs-10">
                                                {{ $trip->degree }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-black text-main fs-18">{{ $trip->price }}</div>
                                        <div class="text-muted fs-10">{{ __('EGP') }} / {{ __('per seat') }}</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="journey-track d-flex align-items-center gap-3">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="dot-start shadow-sm"></span>
                                            <span class="dot-line"></span>
                                            <span class="dot-end shadow-sm"></span>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <span class="text-dark fw-semibold fs-12 text-truncate"
                                                style="max-width: 140px;">{{ $trip->fromStation }}</span>
                                            <span class="text-muted fs-12 text-truncate"
                                                style="max-width: 140px;">{{ $trip->toStation }}</span>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <span class="d-block text-success fw-bold fs-11 mb-2">
                                            <i class="fas fa-chair me-1"></i> {{ $trip->available_seats }} {{ __('Available') }}
                                        </span>
                                        <button class="btn btn-main btn-sm rounded-pill px-4 py-2 fs-12 fw-bold shadow-sm">
                                            {{ __('Book') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="empty-state-card mt-4 rounded-5 bg-white shadow-sm border p-5">
                        <div class="empty-state-icon-wrapper">
                            <i class="fas fa-bus-alt"></i>
                        </div>
                        <h4 class="fw-bold text-black mb-2">{{ __('No Trips Found') }}</h4>
                        <p class="text-muted mb-4">{{ __('We couldn\'t find any trips for this date. Try another date or reach out to us.') }}</p>
                        
                        <div class="d-grid gap-3">
                            <button class="hero-btn w-100 py-3" data-bs-toggle="modal" data-bs-target="#searchModal">
                                <i class="fas fa-search-plus me-2"></i> {{ __('Modify Search') }}
                            </button>
                            
                            <a href="tel:{{ @$contactUs['phone'] ?? '16123' }}" class="btn btn-outline-dark rounded-pill py-2">
                                <i class="fas fa-phone-alt me-2"></i> {{ __('Call For Support') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Search Modal Mobile -->
    <div class="modal fade trip-search-modal" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel"
        aria-hidden="true" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content trip-search-modal__shell shadow-lg rounded-5 overflow-hidden border-0">
                <div class="modal-header trip-search-modal__header bg-white border-bottom py-3 px-4">
                    <h5 class="modal-title trip-search-modal__title fw-bold text-black mb-0" id="searchModalLabel">{{ __('Edit Search') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>

                <div class="modal-body trip-search-modal__body p-3 bg-light">
                    <form action="">
                        <input type="hidden" value="{{ request()->tripType ?? 'oneway' }}" name="tripType" />
                        <input type="hidden" id="selected_station_from" value="{{ request()->station_from_id }}">
                        <input type="hidden" id="selected_station_to" value="{{ request()->station_to_id }}">

                        <div class="row g-0">
                            <!-- From Section -->
                            <div class="col-12">
                                <div class="premium-mobile-input-card">
                                    <label for="city_from_id">
                                        <i class="fas fa-map-marker-alt"></i> {{ __('Travel From') }}
                                    </label>
                                    <select class="form-select trip-search-select" name="city_from_id" id="city_from_id">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ request()->city_from_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="premium-mobile-input-card">
                                    <label for="station_from_id">
                                        <i class="fas fa-bus"></i> {{ __('From Station') }}
                                    </label>
                                    <select class="form-select trip-search-select" name="station_from_id" id="station_from_id"></select>
                                </div>
                            </div>

                            <!-- To Section -->
                            <div class="col-12">
                                <div class="premium-mobile-input-card">
                                    <label for="city_to_id">
                                        <i class="fas fa-location-arrow"></i> {{ __('Travel To') }}
                                    </label>
                                    <select class="form-select trip-search-select" name="city_to_id" id="city_to_id">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ request()->city_to_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="premium-mobile-input-card">
                                    <label for="station_to_id">
                                        <i class="fas fa-flag-checkered"></i> {{ __('To Station') }}
                                    </label>
                                    <select class="form-select trip-search-select" name="station_to_id" id="station_to_id"></select>
                                </div>
                            </div>

                            <!-- Date and Seats -->
                            <div class="col-6 pe-2">
                                <div class="premium-mobile-input-card">
                                    <label for="search_modal_go_date">
                                        <i class="fas fa-calendar-day"></i> {{ __('Date') }}
                                    </label>
                                    <input type="date" id="search_modal_go_date" class="form-control" value="{{ request()->go_date }}" name="go_date">
                                </div>
                            </div>
                            <div class="col-6 ps-2">
                                <div class="premium-mobile-input-card">
                                    <label for="search_modal_seats">
                                        <i class="fas fa-users"></i> {{ __('Passengers') }}
                                    </label>
                                    <input type="number" id="search_modal_seats" value="{{ request()->seats }}" class="form-control" name="seats" required min="1">
                                </div>
                            </div>
                            <!-- Back Date for Round Trip -->
                            <div class="col-12 mt-2">
                                <div class="premium-mobile-input-card">
                                    <label for="search_modal_back_date">
                                        <i class="fas fa-history"></i> {{ __('Return Date') }}
                                    </label>
                                    <input type="date" id="search_modal_back_date" class="form-control" value="{{ request()->back_date }}" name="back_date">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <button type="submit" class="hero-btn w-100 py-3 rounded-pill fw-bold shadow-lg">
                                <i class="fas fa-search me-2"></i> {{ __('Search') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('[data-date-slider]').forEach(function(slider) {
                const activePill = slider.querySelector('.date-pill.active');
                if (activePill) {
                    const targetLeft = activePill.offsetLeft - (slider.clientWidth / 2) + (activePill
                        .clientWidth / 2);
                    slider.scrollTo({
                        left: Math.max(0, targetLeft),
                        behavior: 'smooth'
                    });
                }

                let isDown = false;
                let startX;
                let scrollLeft0;

                slider.addEventListener('mousedown', (e) => {
                    isDown = true;
                    slider.classList.add('active');
                    startX = e.pageX - slider.offsetLeft;
                    scrollLeft0 = slider.scrollLeft;
                });
                slider.addEventListener('mouseleave', () => {
                    isDown = false;
                    slider.classList.remove('active');
                });
                slider.addEventListener('mouseup', () => {
                    isDown = false;
                    slider.classList.remove('active');
                });
                slider.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - slider.offsetLeft;
                    const walk = (x - startX) * 2;
                    slider.scrollLeft = scrollLeft0 - walk;
                });

                slider.querySelectorAll('button').forEach(link => {
                    link.addEventListener('click', (e) => {
                        if (isDown) e.preventDefault();
                    });
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof jQuery === 'undefined' || !jQuery.fn.select2) {
                return;
            }
            const $ = jQuery;
            const $modal = $('#searchModal');
            if (!$modal.length) {
                return;
            }

            const selectStationPh = @json(__('Select a station'));
            const selectSearchPh = @json(__('Search...'));
            const isRtl = document.documentElement.getAttribute('dir') === 'rtl';

            function tripSelect2Options() {
                return {
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownParent: $modal,
                    minimumResultsForSearch: 0,
                    allowClear: false,
                    dir: isRtl ? 'rtl' : 'ltr',
                    dropdownCssClass: 'trip-s2-dropdown-mobile',
                };
            }

            $modal.on('select2:open', function() {
                requestAnimationFrame(function() {
                    const input = document.querySelector('.select2-search__field');
                    if (input) {
                        input.setAttribute('placeholder', selectSearchPh);
                    }
                });
            });

            function bindStationSelect2($select) {
                if ($select.hasClass('select2-hidden-accessible')) {
                    $select.select2('destroy');
                }
                $select.select2(tripSelect2Options());
            }

            function fetchStations(cityId, stationSelect, selectedStationId = null) {
                const $station = $(stationSelect);
                if ($station.hasClass('select2-hidden-accessible')) {
                    $station.select2('destroy');
                }
                if (!cityId) {
                    stationSelect.innerHTML = '<option value="">' + selectStationPh + '</option>';
                    bindStationSelect2($station);
                    return;
                }

                fetch('/get-stations/' + encodeURIComponent(cityId))
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">' + selectStationPh + '</option>';
                        data.forEach(station => {
                            const selected = String(station.id) === String(selectedStationId ?? '') ? ' selected' : '';
                            options += '<option value="' + station.id + '"' + selected + '>' + station.name +
                                '</option>';
                        });
                        stationSelect.innerHTML = options;
                        bindStationSelect2($station);
                    })
                    .catch(error => {
                        console.error('Error fetching stations:', error);
                    });
            }

            const cityFromSelect = document.getElementById('city_from_id');
            const stationFromSelect = document.getElementById('station_from_id');
            const cityToSelect = document.getElementById('city_to_id');
            const stationToSelect = document.getElementById('station_to_id');

            if (!cityFromSelect || !stationFromSelect || !cityToSelect || !stationToSelect) {
                return;
            }

            const selectedStationFrom = document.getElementById('selected_station_from')?.value;
            const selectedStationTo = document.getElementById('selected_station_to')?.value;

            $(cityFromSelect).select2(tripSelect2Options());
            $(cityToSelect).select2(tripSelect2Options());

            $(cityFromSelect).on('change', function() {
                fetchStations(this.value, stationFromSelect);
            });
            $(cityToSelect).on('change', function() {
                fetchStations(this.value, stationToSelect);
            });

            if (cityFromSelect.value) {
                fetchStations(cityFromSelect.value, stationFromSelect, selectedStationFrom);
            } else {
                stationFromSelect.innerHTML = '<option value="">' + selectStationPh + '</option>';
                bindStationSelect2($(stationFromSelect));
            }

            if (cityToSelect.value) {
                fetchStations(cityToSelect.value, stationToSelect, selectedStationTo);
            } else {
                stationToSelect.innerHTML = '<option value="">' + selectStationPh + '</option>';
                bindStationSelect2($(stationToSelect));
            }
        });
    </script>
@endpush
