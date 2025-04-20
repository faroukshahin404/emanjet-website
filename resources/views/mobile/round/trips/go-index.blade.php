@extends('layouts.master')

@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center">
        <a href="/">
            <i class="fas fa-arrow-right fs-25 text-black"></i>
        </a>
        <p class="m-0 fs-25 text-black">رحلات الذهاب</p>
        <div></div>
    </div>

    <div class="mt-3">
        <div class="tabs-container">
            <!-- <button class="scroll-btn left-btn" aria-label="Scroll left">&lt;</button> -->
            <div class="tabs-wrapper">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach ($dates as $date)
                        <form>
                            <input type="hidden" name="tripType" value="{{ request()->tripType }}" />
                            <input type="hidden" name="city_from_id" value="{{ request()->city_from_id }}" />
                            <input type="hidden" name="city_to_id" value="{{ request()->city_to_id }}" />
                            <input type="hidden" name="back_date" value="{{ request()->back_date }}" />
                            <input type="hidden" name="seats" value="{{ request()->seats }}" />
                            <input type="hidden" name="station_from_id" value="{{ request()->station_from_id }}" />
                            <input type="hidden" name="station_to_id" value="{{ request()->station_to_id }}" />
                            <input type="hidden" id="selected-trip-price" value="" />
                            <input type="hidden" id="num-of-seats" value="{{ request()->seats }}" />

                            <li class="nav-item" role="presentation">

                                <button class="nav-link" id="{{ $date }}-tab" data-bs-toggle="tab"
                                    style="background-color: {{ request()->go_date == $date ? 'var(--main-color)' : 'white' }};"
                                    data-bs-target="#{{ $date }}" type="submit" role="tab" name="go_date"
                                    value="{{ $date }}" aria-controls="{{ $date }}"
                                    aria-selected="false">{{ $date }}</button>
                            </li>
                        </form>
                    @endforeach

                </ul>
            </div>
            <!-- <button class="scroll-btn right-btn" aria-label="Scroll right">&gt;</button> -->
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">

                <div class="d-flex justify-content-center align-items-center gap-4 my-4">
                    <div class="d-flex align-items-center gap-2 travel-direction-box">
                        <div>
                            <i class="fa fa-bus text-black"></i>
                        </div>
                        <div class="d-flex flex-column align-items-center">
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
                    <div>
                        <i class="fa fa-arrow-left text-black fs-20"></i>
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

                @foreach ($trips as $trip)
                    <a href="{{ route('mobile.round.back-trips', array_merge(request()->all(), ['go_trip_id' => $trip->id])) }}">
                        <div class="mt-3 border rounded-7 py-3 px-3 bus-card mb-3">
                            <div class="d-flex justify-content-between">

                                <div class="d-flex justify-content-between gap-2">
                                    <div class="bus-box-mobile m-auto">
                                        <i class="fa fa-bus text-main fs-20"></i>
                                    </div>
                                    <div class="mt-1">
                                        <div class="d-flex gap-2">
                                            @php
                                                $time = \Carbon\Carbon::parse($trip->tripTime)->format('h:i a');
                                            @endphp
                                            <p class="m-0 fs-12">{{ $time }}</p>
                                            <p class="m-0 vip ">{{ $trip->degree }}</p>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex flex-column align-items-center ">
                                                <div class="green-circle-mobile"></div>
                                                <div class="line-mobile"></div>
                                                <div class="red-circle-mobile"></div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between">
                                                <p class="m-0 fs-12">{{ $trip->fromStation }} </p>
                                                <p class="m-0 fs-12">{{ $trip->toStation }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class="m-0 fs-12">{{ $trip->price }} جنية مصري</p>
                                    <p class="m-0 fs-12">لكل مقعد</p>
                                    <p class="m-0 fs-12 text-success">متبقي {{ $trip->available_seats }} مقاعد</p>
                                    <button class="btn btn-main mt-2 btn-sm rounded-5" type="button">
                                        حجز
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach




            </div>
            <div class="tab-pane fade" id="tommorrow" role="tabpanel" aria-labelledby="tommorrow-tab">

                <div class="d-flex justify-content-center align-items-center gap-4 my-4">
                    <div class="d-flex align-items-center gap-2 travel-direction-box">
                        <div>
                            <i class="fa fa-bus text-black"></i>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0 text-black">القاهرة</h6>
                            </div>
                            <div>
                                <p class="m-0">
                                    التحرير
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fa fa-arrow-left text-black fs-20"></i>
                    </div>
                    <div class="d-flex flex-column align-items-center travel-direction-box">
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="m-0 text-black">الاسكندرية</h6>
                        </div>
                        <div>
                            <p class="m-0">
                                ميامي
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-3 border rounded-7 py-3 px-3 bus-card mb-3">
                    <div class="d-flex justify-content-between">

                        <div class="d-flex justify-content-between gap-2">
                            <div class="bus-box m-auto">
                                <i class="fa fa-bus text-main fs-20"></i>
                            </div>
                            <div class="mt-1">
                                <div class="d-flex gap-2">
                                    <p class="m-0 fs-12">13:30 صباحا</p>
                                    <p class="m-0 vip ">vip</p>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="green-circle"></div>
                                        <div class="line"></div>
                                        <div class="red-circle"></div>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between">
                                        <p class="m-0 fs-12">القاهرة | التحرير</p>
                                        <p class="m-0 fs-12">الإسكندرية</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="m-0 fs-12">350 جنية مصري</p>
                            <p class="m-0 fs-12">لكل مقعد</p>
                            <p class="m-0 fs-12 text-success">متبقي 5 مقاعد</p>
                            <a href="chairs-mobile.html">
                                <button class="btn btn-main mt-2 btn-sm rounded-5">
                                    حجز
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="dayafter" role="tabpanel" aria-labelledby="dayafter-tab">25</div>
            <div class="tab-pane fade" id="dayafter2" role="tabpanel" aria-labelledby="dayafter-tab">26
            </div>
            <div class="tab-pane fade" id="dayafter3" role="tabpanel" aria-labelledby="dayafter-tab">27
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
