@extends('layouts.master')

@section('mobile-content')
    @php
        $isRtl = app()->getLocale() === 'ar';
        $navBackIcon = $isRtl ? 'fa-arrow-right' : 'fa-arrow-left';
    @endphp
    <div class="wow animate__animated animate__fadeIn">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <button type="button" onclick="window.history.back()" class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center border-light-subtle" style="width: 40px; height: 40px; border: 1px solid #eee;">
                <i class="fas {{ $navBackIcon }} fs-16 text-black"></i>
            </button>
            <div class="text-center">
                <h5 class="m-0 fw-800 text-black">{{ __('Return Trip') }}</h5>
                <span class="text-muted fw-800" style="font-size: 10px; opacity: 0.7;">{{ __('Round Trip') }}</span>
            </div>
            <button class="btn btn-white shadow-premium rounded-circle d-flex align-items-center justify-content-center border-light-subtle" style="width: 40px; height: 40px; border: 1px solid #eee;" data-bs-toggle="modal" data-bs-target="#searchModal">
                <i class="fa-solid fa-sliders text-main"></i>
            </button>
        </div>

        <!-- Journey Summary Card -->
        <div class="bg-white rounded-5 shadow-premium p-3 mb-4 border border-light-subtle position-relative overflow-hidden">
            <div class="row align-items-center g-0">
                <div class="col-5 text-center">
                    <span class="text-muted overline-text d-block mb-1" style="font-size: 9px; font-weight: 800;">{{ __('FROM') }}</span>
                    <span class="fw-800 text-black d-block text-truncate small">{{ $search['from']->name }}</span>
                </div>
                <div class="col-2 text-center">
                    <i class="fa-solid fa-plane-up text-main opacity-25 fs-14"></i>
                </div>
                <div class="col-5 text-center">
                    <span class="text-muted overline-text d-block mb-1" style="font-size: 9px; font-weight: 800;">{{ __('TO') }}</span>
                    <span class="fw-800 text-black d-block text-truncate small">{{ $search['to']->name }}</span>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-4 mt-3 pt-3 border-top border-light-subtle">
                <div class="text-center">
                    <span class="text-muted fw-800 d-block mb-1" style="font-size: 9px;">{{ __('OUTBOUND') }}</span>
                    <span class="text-black fw-800 small">{{ \Carbon\Carbon::parse(request()->go_date)->format('d M, Y') }}</span>
                </div>
                <div class="vr opacity-10"></div>
                <div class="text-center">
                    <span class="text-muted fw-800 d-block mb-1" style="font-size: 9px;">{{ __('RETURN') }}</span>
                    <span class="text-black fw-800 small">{{ \Carbon\Carbon::parse(request()->back_date)->format('d M, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Travel Date Selector -->
        <div class="mb-4 wow animate__animated animate__fadeInUp">
            <div class="px-1 mb-2">
                <h6 class="fw-800 text-black mb-0">{{ __('Departure Date') }}</h6>
            </div>
            <div class="tabs-wrapper" id="date-slider-go" data-date-slider style="background: rgba(255,255,255,0.5); padding: 5px 0;">
                <div class="d-flex gap-2">
                    @foreach ($goDates as $date)
                        @php
                            $carbonDate = \Carbon\Carbon::parse($date);
                            $dayName = $carbonDate->isToday() ? __('Today') : (app()->getLocale() == 'ar' ? $carbonDate->locale('ar')->dayName : $carbonDate->format('D'));
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
                                class="nav-link border-0 text-nowrap rounded-4 px-3 py-2 d-flex flex-column align-items-center {{ $isActive ? 'active btn-main shadow-premium' : 'bg-light text-muted opacity-75' }}"
                                style="min-width: 75px; transition: all 0.3s ease;">
                                <span class="fw-800" style="font-size: 10px;">{{ $dayName }}</span>
                                <span class="fw-800" style="font-size: 14px;">{{ $dayNum }} {{ $monthName }}</span>
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mb-4 wow animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
            <div class="px-1 mb-2">
                <h6 class="fw-800 text-black mb-0">{{ __('Back Date') }}</h6>
            </div>
            <div class="tabs-wrapper" id="date-slider-back" data-date-slider style="background: rgba(255,255,255,0.5); padding: 5px 0;">
                <div class="d-flex gap-2">
                    @foreach ($dates as $date)
                        @php
                            $carbonDate = \Carbon\Carbon::parse($date);
                            $dayName = $carbonDate->isToday() ? __('Today') : (app()->getLocale() == 'ar' ? $carbonDate->locale('ar')->dayName : $carbonDate->format('D'));
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
                                class="nav-link border-0 text-nowrap rounded-4 px-3 py-2 d-flex flex-column align-items-center {{ $isActive ? 'active btn-main shadow-premium' : 'bg-light text-muted opacity-75' }}"
                                style="min-width: 75px; transition: all 0.3s ease;">
                                <span class="fw-800" style="font-size: 10px;">{{ $dayName }}</span>
                                <span class="fw-800" style="font-size: 14px;">{{ $dayNum }} {{ $monthName }}</span>
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Trip List -->
        <div class="mt-2">
            @if ($trips->count() > 0)
                @foreach ($trips as $trip)
                    @php
                        $time = \Carbon\Carbon::parse($trip->tripTime)->format('h:i a');
                    @endphp
                    <a href="{{ route('mobile.round.choose-seat', array_merge(request()->all(), ['back_trip_id' => $trip->id])) }}"
                        class="text-decoration-none d-block wow animate__animated animate__fadeInUp">
                        <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-3 mb-3 position-relative overflow-hidden">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-light text-main rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-bus-simple fs-20"></i>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="fw-800 text-black fs-18">{{ $time }}</span>
                                            <span class="bg-main-light text-main text-uppercase fw-800 px-2 rounded-pill" style="font-size: 10px; padding-top: 2px;">{{ $trip->degree }}</span>
                                        </div>
                                        <p class="text-muted fw-800 mb-0" style="font-size: 11px;">
                                            <i class="fa-solid fa-circle-dot text-main me-1 opacity-50"></i> {{ $trip->fromStation }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="mb-0">
                                        <span class="fs-18 fw-800 text-black">{{ $trip->price }}</span>
                                        <span class="text-muted fw-800" style="font-size: 10px;">{{ __('EGP') }}</span>
                                    </div>
                                    <span class="text-success fw-800 d-block" style="font-size: 10px;">
                                        <i class="fa-solid fa-chair me-1"></i> {{ $trip->available_seats }} {{ __('Seats') }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted fw-800" style="font-size: 11px;">{{ __('Arrival') }}:</span>
                                    <span class="text-black fw-800 text-truncate" style="font-size: 11px; max-width: 150px;">{{ $trip->toStation }}</span>
                                </div>
                                <span class="text-main fw-800" style="font-size: 12px;">{{ __('Confirm Selection') }} <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} small ms-1"></i></span>
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="empty-state bg-white rounded-5 shadow-premium p-5 text-center mt-5 border border-light-subtle wow animate__animated animate__zoomIn">
                    <div class="bg-light text-main rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fa-solid fa-bus-simple fa-3x opacity-25"></i>
                    </div>
                    <h4 class="fw-800 text-black mb-2">{{ __('No Trips Found') }}</h4>
                    <p class="text-muted fw-800 small mb-4 opacity-75">{{ __('We couldn\'t find any trips for this date. Try another date or reach out to us.') }}</p>
                    
                    <div class="d-grid gap-3">
                        <button class="btn btn-main py-3 rounded-pill fw-800 shadow-premium" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="fa-solid fa-rotate me-2"></i> {{ __('Modify Search') }}
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Search Modal Mobile -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true" data-bs-backdrop="false">
        <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-5 overflow-hidden">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div class="text-center mb-4">
                        <div class="bg-light text-main rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-sliders fa-xl"></i>
                        </div>
                        <h4 class="fw-800 text-black mb-1">{{ __('Adjust Trip') }}</h4>
                        <p class="text-muted small fw-800">{{ __('Modify your search criteria') }}</p>
                    </div>

                    <form action="">
                        <input type="hidden" value="{{ request()->tripType ?? 'oneway' }}" name="tripType" />
                        <input type="hidden" id="selected_station_from" value="{{ request()->station_from_id }}">
                        <input type="hidden" id="selected_station_to" value="{{ request()->station_to_id }}">

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="bg-light rounded-4 p-3 border border-light-subtle">
                                    <label class="text-muted overline-text d-block mb-1" style="font-size: 10px; font-weight: 800;">{{ __('FROM') }}</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-location-arrow text-main opacity-50"></i>
                                        <select class="form-select border-0 bg-transparent p-0 fw-800 text-black shadow-none" name="city_from_id" id="city_from_id" style="font-size: 14px;">
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" {{ request()->city_from_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="bg-light rounded-4 p-3 border border-light-subtle">
                                    <label class="text-muted overline-text d-block mb-1" style="font-size: 10px; font-weight: 800;">{{ __('STATION') }}</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-bus text-main opacity-50"></i>
                                        <select class="form-select border-0 bg-transparent p-0 fw-800 text-black shadow-none" name="station_from_id" id="station_from_id" style="font-size: 14px;"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="bg-light rounded-4 p-3 border border-light-subtle">
                                    <label class="text-muted overline-text d-block mb-1" style="font-size: 10px; font-weight: 800;">{{ __('TO') }}</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-location-dot text-success opacity-50"></i>
                                        <select class="form-select border-0 bg-transparent p-0 fw-800 text-black shadow-none" name="city_to_id" id="city_to_id" style="font-size: 14px;">
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" {{ request()->city_to_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="bg-light rounded-4 p-3 border border-light-subtle">
                                    <label class="text-muted overline-text d-block mb-1" style="font-size: 10px; font-weight: 800;">{{ __('DESTINATION STATION') }}</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-flag-checkered text-success opacity-50"></i>
                                        <select class="form-select border-0 bg-transparent p-0 fw-800 text-black shadow-none" name="station_to_id" id="station_to_id" style="font-size: 14px;"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="bg-light rounded-4 p-3 border border-light-subtle">
                                    <label class="text-muted overline-text d-block mb-1" style="font-size: 10px; font-weight: 800;">{{ __('OUTBOUND') }}</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-calendar text-main opacity-50"></i>
                                        <input type="date" class="form-control border-0 bg-transparent p-0 fw-800 text-black shadow-none" value="{{ request()->go_date }}" name="go_date" style="font-size: 13px;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="bg-light rounded-4 p-3 border border-light-subtle">
                                    <label class="text-muted overline-text d-block mb-1" style="font-size: 10px; font-weight: 800;">{{ __('RETURN') }}</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-history text-success opacity-50"></i>
                                        <input type="date" class="form-control border-0 bg-transparent p-0 fw-800 text-black shadow-none" value="{{ request()->back_date }}" name="back_date" style="font-size: 13px;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="bg-light rounded-4 p-3 border border-light-subtle">
                                    <label class="text-muted overline-text d-block mb-1" style="font-size: 10px; font-weight: 800;">{{ __('PASSENGERS') }}</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-users text-main opacity-50"></i>
                                        <input type="number" value="{{ request()->seats }}" class="form-control border-0 bg-transparent p-0 fw-800 text-black shadow-none" name="seats" required min="1" style="font-size: 14px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium">
                                <i class="fa-solid fa-magnifying-glass me-2"></i> {{ __('Apply Changes') }}
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
