@extends('layouts.master')

@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center">
        <a href="/">
            @if (app()->getLocale() == 'ar')
                <i class="fas fa-arrow-right fs-25 text-black"></i>
            @else
                <i class="fas fa-arrow-left fs-25 text-black"></i>
            @endif
        </a>
        <p class="m-0 fs-25 text-black">{{ __('Available Buses') }}</p>
        <div></div>
    </div>

    <div class="mt-3">
            <div class="tabs-wrapper" style="position: sticky; top: 0; z-index: 100; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); padding: 10px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach ($dates as $date)
                        @php
                            $carbonDate = \Carbon\Carbon::parse($date);
                            $dayName = $carbonDate->isToday() ? __('Today') : (app()->getLocale() == 'ar' ? $carbonDate->locale('ar')->dayName : $carbonDate->format('l'));
                            $dayNum = $carbonDate->format('d');
                            $monthName = app()->getLocale() == 'ar' ? $carbonDate->locale('ar')->monthName : $carbonDate->format('M');
                        @endphp
                        <form>
                            <input type="hidden" name="tripType" value="{{ request()->tripType }}" />
                            <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
                            <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
                            <input type="hidden" name="back_date" value="{{ request()->back_date }}" />
                            <input type="hidden" name="seats" value="{{ request()->seats }}" />
                            <input type="hidden" name="station_from_id" value="{{ request()->station_from_id }}" />
                            <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />

                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ request()->go_date == $date ? 'active' : '' }}" 
                                    id="{{ $date }}-tab"
                                    type="submit" role="tab" name="go_date" value="{{ $date }}">
                                    <span class="day-name">{{ $dayName }}</span>
                                    <span>{{ $dayNum }} {{ $monthName }}</span>
                                </button>
                            </li>
                        </form>
                    @endforeach
                </ul>
            </div>
            <!-- <button class="scroll-btn right-btn" aria-label="Scroll right">&gt;</button> -->
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">

                <div class="mobile-journey-card d-flex align-items-center">
                    <div class="flex-grow-1 journey-node text-center">
                        <span class="city d-block">{{ $fromCity->name }}</span>
                        <span class="station d-block text-truncate small" style="max-width: 100px;">{{ $fromStation->name }}</span>
                    </div>
                    
                    <div class="mx-3 journey-arrow text-center" style="min-width: 60px;">
                        <i class="fas fa-long-arrow-alt-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} fs-18 text-main opacity-50"></i>
                        <span class="d-block" style="font-size: 9px; font-weight: 900; color: #ccc; letter-spacing: 1px;">SUPERJET</span>
                    </div>

                    <div class="flex-grow-1 journey-node text-center">
                        <span class="city d-block">{{ $toCity->name }}</span>
                        <span class="station d-block text-truncate small" style="max-width: 100px;">{{ $toStation->name }}</span>
                    </div>
                    
                    <button data-bs-toggle="modal" data-bs-target="#searchModal" class="btn-edit-search ms-3 text-main bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; border: 1px solid rgba(0,0,0,0.05);">
                        <i class="fas fa-pen fs-14"></i>
                    </button>
                </div>
                @if ($trips->count() > 0)
                    @foreach ($trips as $trip)
                        <a href="{{ route('mobile.one-way.choose-seat', array_merge(request()->all(), ['selected_trip_id' => $trip->id])) }}" class="text-decoration-none">
                            <div class="trip-card-mobile p-3 mb-3 border rounded-4 bg-white shadow-sm overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bus-icon-circle bg-light text-main rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="fa fa-bus fs-18"></i>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                @php
                                                    $time = \Carbon\Carbon::parse($trip->tripTime)->format('h:i a');
                                                @endphp
                                                <span class="fw-bold text-black fs-15">{{ $time }}</span>
                                                <span class="badge bg-main-light text-main fw-bold">{{ $trip->degree }}</span>
                                            </div>
                                            <div class="journey-track d-flex align-items-start gap-2">
                                                <div class="d-flex flex-column align-items-center mt-1">
                                                    <div class="dot-start"></div>
                                                    <div class="dot-line"></div>
                                                    <div class="dot-end"></div>
                                                </div>
                                                <div class="d-flex flex-column gap-1">
                                                    <span class="text-muted fs-12 fw-bold text-truncate" style="max-width: 150px;">{{ $trip->fromStation }}</span>
                                                    <span class="text-muted fs-12 fw-bold text-truncate" style="max-width: 150px;">{{ $trip->toStation }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="mb-1">
                                            <span class="fs-18 fw-bold text-black">{{ $trip->price }}</span>
                                            <span class="small text-muted">{{ __('EGP') }}</span>
                                        </div>
                                        <div class="text-success small fw-bold mb-2">
                                            {{ __('Available') }} {{ $trip->available_seats }}
                                        </div>
                                        <button class="btn btn-main btn-sm px-4 rounded-pill fw-bold">
                                            {{ __('Book') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="empty-state-card mt-5">
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Scroll active tab into view
            const activeTab = document.querySelector('.nav-link.active');
            const wrapper = document.querySelector('.tabs-wrapper');

            if (activeTab && wrapper) {
                const scrollLeft = activeTab.offsetLeft - (wrapper.offsetWidth / 2) + (activeTab.offsetWidth / 2);
                wrapper.scrollLeft = scrollLeft;
            }

            // 2. Mouse drag to scroll functionality
            let isDown = false;
            let startX;
            let scrollLeft;

            const slider = document.querySelector('.tabs-wrapper');

            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.classList.add('active-dragging');
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
                slider.style.cursor = 'grabbing';
            });

            slider.addEventListener('mouseleave', () => {
                isDown = false;
                slider.classList.remove('active-dragging');
                slider.style.cursor = 'grab';
            });

            slider.addEventListener('mouseup', () => {
                isDown = true; // Temporary keep it to block click if dragged
                setTimeout(() => isDown = false, 50); 
                slider.classList.remove('active-dragging');
                slider.style.cursor = 'grab';
            });

            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2; // scroll-fast
                slider.scrollLeft = scrollLeft - walk;
            });

            // Prevent link clicks if dragging
            const links = slider.querySelectorAll('button');
            links.forEach(link => {
                link.addEventListener('click', (e) => {
                    if (isDown) e.preventDefault();
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
