@extends('layouts.master')
@push('styles')
    <style>
        .reservation-header {
            padding-bottom: 3rem;
        }
        .reservation-travel-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            box-shadow: var(--premium-shadow);
            padding: 1.5rem 2rem !important;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .reservation-travel-box i {
            color: var(--main-color) !important;
            margin-bottom: 5px;
        }
        .search-edit-btn {
            background: transparent;
            color: var(--main-color);
            border: 2px solid var(--main-color);
            border-radius: 50px;
            padding: 0.6rem 1.8rem;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .search-edit-btn:hover {
            background: var(--main-color);
            color: #fff;
            box-shadow: 0 8px 20px rgba(var(--main-color-rgb), 0.2);
            transform: translateY(-2px);
        }
        .trip-card {
            border: 1px solid rgba(0,0,0,0.03) !important;
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--soft-shadow);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            padding: 1.5rem !important;
        }
        .trip-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--premium-shadow), 0 0 0 2px rgba(var(--main-color-rgb), 0.1);
        }
        .trip-choose-btn {
            background: var(--main-color);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 10px;
        }
        .trip-choose-btn.selected-trip-button, .trip-choose-btn:hover {
            background: var(--main-hover) !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(var(--main-color-rgb), 0.3);
        }
        .filter-card, .trip-details-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--soft-shadow);
            padding: 1.5rem;
            border: 1px solid rgba(0,0,0,0.03);
            position: sticky;
            top: 20px;
        }
        .btn-search {
            width: 100%;
            background: var(--main-color);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.8rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-search:hover {
            background: var(--main-hover);
            box-shadow: 0 8px 20px rgba(var(--main-color-rgb), 0.3);
            transform: translateY(-2px);
        }
        .reserve-btn {
            background: var(--main-color) !important;
            color: #fff !important;
            border: none;
            border-radius: 50px !important;
            padding: 0.8rem 2rem !important;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(var(--main-color-rgb), 0.2);
        }
        .reserve-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(var(--main-color-rgb), 0.3);
        }
        .bus-box {
            background: rgba(var(--main-color-rgb), 0.1);
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .bus-box i {
            font-size: 1.4rem;
            color: var(--main-color) !important;
        }
        .green-circle {
            background: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.2);
        }
        .vip {
            border-radius: 50px !important;
            padding: 4px 12px !important;
            font-weight: 600;
            font-size: 0.85rem;
        }
        .text-black { color: #333 !important; font-weight: 600; }
        .text-success { color: #28a745 !important; font-weight: 600; }

        /* Trip search modal — layout & shell */
        #searchModal .trip-search-modal__shell {
            border: none;
            border-radius: 20px;
            box-shadow:
                0 28px 80px rgba(15, 23, 42, 0.14),
                0 0 0 1px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }
        #searchModal .trip-search-modal__header {
            padding: 1rem 1.5rem;
            background: #fff;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08) !important;
        }
        #searchModal .trip-search-modal__title {
            font-size: 1.125rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #0f172a;
        }
        #searchModal .trip-search-modal__body {
            padding: 1.25rem 1.5rem 1.5rem;
            background: #fff;
        }
        #searchModal .trip-search-modal__fields {
            margin-bottom: 0;
        }
        #searchModal .trip-search-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.45rem;
            line-height: 1.25;
        }
        #searchModal .trip-search-label__icon {
            color: var(--main-color, #f37021);
            font-size: 0.8rem;
            width: 1.1em;
            flex-shrink: 0;
            opacity: 0.95;
        }
        #searchModal .trip-search-input {
            height: 48px;
            border-radius: 12px !important;
            border: 1px solid rgba(15, 23, 42, 0.1) !important;
            background: #fff !important;
            padding: 0.5rem 0.9rem;
            font-weight: 500;
            color: #0f172a;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        #searchModal .trip-search-input:focus {
            border-color: var(--main-color, #f37021) !important;
            box-shadow: 0 0 0 3px rgba(var(--main-color-rgb), 0.2);
            outline: none;
        }
        #searchModal .trip-search-submit {
            min-width: 200px;
            padding: 0.7rem 2.25rem;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            border-radius: 999px;
            color: #fff !important;
            background: linear-gradient(135deg, var(--main-color, #f37021) 0%, var(--main-hover, #e85f10) 100%);
            box-shadow: 0 10px 28px rgba(var(--main-color-rgb), 0.35);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        #searchModal .trip-search-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 36px rgba(var(--main-color-rgb), 0.42);
            color: #fff !important;
        }
        #searchModal .trip-search-submit:focus-visible {
            outline: 2px solid var(--main-color, #f37021);
            outline-offset: 3px;
        }

        /* Select2 — trip search modal */
        #searchModal .select2-container {
            width: 100% !important;
        }
        #searchModal .select2-container--bootstrap-5 .select2-selection {
            min-height: 48px;
            border-radius: 12px !important;
            border: 1px solid rgba(15, 23, 42, 0.1) !important;
            background-color: #fff !important;
            align-items: center;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        #searchModal .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            line-height: 46px;
            padding-inline: 0.9rem 2.65rem;
            font-weight: 500;
            color: #0f172a;
        }
        #searchModal .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 46px;
            width: 2.35rem;
        }
        #searchModal .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow b {
            border-color: #64748b transparent transparent transparent;
        }
        #searchModal .select2-container--bootstrap-5.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent var(--main-color, #f37021) transparent;
        }
        #searchModal .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        #searchModal .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border-color: var(--main-color, #f37021) !important;
            box-shadow: 0 0 0 3px rgba(var(--main-color-rgb), 0.2);
        }
        #searchModal .trip-s2-dropdown,
        #searchModal .select2-dropdown {
            z-index: 1060 !important;
        }
        #searchModal .trip-s2-dropdown {
            border-radius: 14px !important;
            border: 1px solid rgba(15, 23, 42, 0.08) !important;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.16) !important;
            padding: 4px 0;
            overflow: hidden;
        }
        #searchModal .trip-s2-dropdown .select2-search--dropdown {
            padding: 10px 12px;
            background: #f8fafc;
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        }
        #searchModal .trip-s2-dropdown .select2-search__field {
            border-radius: 10px !important;
            border: 1px solid rgba(15, 23, 42, 0.1) !important;
            padding: 0.55rem 0.75rem !important;
            font-weight: 500;
        }
        #searchModal .trip-s2-dropdown .select2-search__field:focus {
            border-color: var(--main-color, #f37021) !important;
            outline: none;
            box-shadow: 0 0 0 2px rgba(var(--main-color-rgb), 0.15);
        }
        #searchModal .trip-s2-dropdown .select2-results__option {
            padding: 0.65rem 1rem;
            font-weight: 500;
            color: #334155;
        }
        #searchModal .trip-s2-dropdown .select2-results__option--highlighted {
            background-color: var(--main-color, #f37021) !important;
            color: #fff !important;
        }
        #searchModal .trip-s2-dropdown .select2-results__option[aria-selected="true"] {
            background-color: rgba(var(--main-color-rgb), 0.12);
            color: #0f172a;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="reservation-header">
        <div class="container">
            <div class="row">


                <div class="reservation-travel-box px-5 d-flex justify-content-between align-items-center">

                    <div class="reservation-container d-flex justify-content-between align-items-center w-50">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div>
                                <i class="fas fa-location-dot"></i>
                                <span class="text-black">{{ __('Travel From') }}</span>
                            </div>
                            <div>
                                {{ $fromCity->name }}
                            </div>
                        </div>

                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div>
                                <i class="fas fa-location-dot"></i>
                                <span class="text-black">{{ __('Travel To') }}</span>
                            </div>
                            <div>
                                {{ $toCity->name }}
                            </div>
                        </div>

                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div>
                                <i class="fas fa-calendar-alt"></i>
                                <span class="text-black">{{ __('Travel Date') }}</span>
                            </div>
                            <div>
                                {{ request()->go_date }}
                            </div>
                        </div>

                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div>
                                <i class="fas fa-user"></i>
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

                </div>
            </div>
        </div>
        <div class="px-3">
            <div class="container-fluid">
                <div class="row">
                    <!-- left  -->
                    <div class="col-lg-3 col-md-12 mb-3 trip-details">
                        <div class="trip-details-card">

                            <div class="d-flex justify-content-center align-items-center gap-4 my-4" style="direction: rtl;">
                                <div class="d-flex align-items-center gap-2 travel-direction-box">
                                    <div class="bus-box" style="width: 40px; height: 40px;">
                                        <i class="fa fa-bus" style="font-size: 1rem;"></i>
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
                                            <p class="m-0 fw-bold text-muted">
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
                                            <p class="m-0 fw-bold text-muted">
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
                                            <h5 class="m-0 text-black">
                                                {{ __('Total') }}
                                            </h5>
                                        </div>
                                        <div>
                                            <h5 id="total-p" class="m-0 text-black">
                                                {{ __('EGP') }}
                                            </h5>
                                        </div>
                                    </div>

{{-- 
                                    <div class="mt-4 pb-4 d-flex justify-content-center">
                                        <button class="reserve-btn">
                                            {{ __('Book') }} {{ request()->seats }} {{ __('Seats') }}
                                        </button>
                                    </div>
--}}
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
                        @if ($trips->count())
                        @foreach ($trips as $trip)
                            <div class="trip-card mb-4">
                                <div class="row align-items-center">
                                    <div class="col-lg-8 col-md-12 ">
                                        <div class="d-flex flex-wrap justify-content-start align-items-center gap-3 mo-view">
                                            <!-- bus icon  -->
                                            <div class="bus-box">
                                                <i class="fa fa-bus"></i>
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
                                                $meridiem = strtolower($time->format('a')) === 'am' ? __('Time AM') : __('Time PM');
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
                                                <p class="m-0 text-white bg-accent text-center vip">{{ $trip->degree }}</p>
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
                                                    {{ $trip->price }} {{ __('LE') }}
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
                        @else
                        <div class="text-center p-5">
                            <h4 class="text-black">{{ __('We apologize, there are no available trips right now.') }}</h4>
                        </div>
                    @endif

                    </div>

                    <!-- right -->
                    <div class="col-md-2">
                        <div class="filter-card">
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
                            <button class="btn-search mt-3" type="submit">
                                <i class="fas fa-search me-2"></i> {{ __('Search') }}
                            </button>
                        </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Search Modal -->
    <div class="modal fade trip-search-modal" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel"
        aria-hidden="true" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content trip-search-modal__shell">
                <div class="modal-header trip-search-modal__header d-flex align-items-center">
                    <h5 class="modal-title trip-search-modal__title mb-0" id="searchModalLabel">{{ __('Edit Search') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ __('Close') }}"></button>
                </div>

                <div class="modal-body trip-search-modal__body">
                    <form action="">
                        <input type="hidden" value="{{ request()->tripType ?? 'oneway' }}" name="tripType" />
                        <input type="hidden" id="selected_station_from" value="{{ request()->station_from_id }}">
                        <input type="hidden" id="selected_station_to" value="{{ request()->station_to_id }}">

                        <div class="row g-3 trip-search-modal__fields align-items-end">
                                <div class="col-lg-3 col-md-6">
                                    <label class="trip-search-label w-100" for="city_from_id">
                                        <i class="fas fa-location-dot trip-search-label__icon" aria-hidden="true"></i>
                                        <span>{{ __('Travel From') }}</span>
                                    </label>
                                    <select class="form-select w-100 trip-search-select" name="city_from_id"
                                        id="city_from_id">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ request()->city_from_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="trip-search-label w-100" for="station_from_id">
                                        <i class="fas fa-bus trip-search-label__icon" aria-hidden="true"></i>
                                        <span>{{ __('From Station') }}</span>
                                    </label>
                                    <select class="form-select w-100 trip-search-select" name="station_from_id"
                                        id="station_from_id"></select>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="trip-search-label w-100" for="city_to_id">
                                        <i class="fas fa-location-dot trip-search-label__icon" aria-hidden="true"></i>
                                        <span>{{ __('Travel To') }}</span>
                                    </label>
                                    <select class="form-select w-100 trip-search-select" name="city_to_id"
                                        id="city_to_id">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ request()->city_to_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="trip-search-label w-100" for="station_to_id">
                                        <i class="fas fa-flag-checkered trip-search-label__icon" aria-hidden="true"></i>
                                        <span>{{ __('To Station') }}</span>
                                    </label>
                                    <select class="form-select w-100 trip-search-select" name="station_to_id"
                                        id="station_to_id"></select>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <label class="trip-search-label w-100" for="search_modal_go_date">
                                        <i class="fas fa-calendar-alt trip-search-label__icon" aria-hidden="true"></i>
                                        <span>{{ __('Date') }}</span>
                                    </label>
                                    <input type="date" id="search_modal_go_date"
                                        class="form-control trip-search-input w-100" value="{{ request()->go_date }}"
                                        name="go_date">
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <label class="trip-search-label w-100" for="search_modal_seats">
                                        <i class="fas fa-user trip-search-label__icon" aria-hidden="true"></i>
                                        <span>{{ __('Passengers') }}</span>
                                    </label>
                                    <input type="number" id="search_modal_seats" value="{{ request()->seats }}"
                                        class="form-control trip-search-input w-100" name="seats" required min="1">
                                </div>
                        </div>

                        <div class="text-center mt-4 pt-1">
                            <button type="submit" class="btn trip-search-submit">{{ __('Search') }}</button>
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
            const egpLabel = @json(__('EGP'));

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
                    document.getElementById('selected-trip-price-p').textContent = tripPrice + ' ' + egpLabel;
                    var numOfSeats = document.getElementById('num-of-seats').value;
                    document.getElementById('total-p').textContent = (numOfSeats * tripPrice) +
                        ' ' + egpLabel;

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
                    dropdownCssClass: 'trip-s2-dropdown',
                };
            }

            $modal.on('select2:open', function() {
                requestAnimationFrame(function() {
                    const input = document.querySelector('#searchModal .select2-search__field');
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
