@extends('layouts.master')

@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center">
        <a href="/">
            <i class="fas fa-arrow-right fs-25 text-black"></i>
        </a>
        <p class="m-0 fs-25 text-black">الحافلات المتاحة</p>
        <div></div>
    </div>

    <div class="mt-3">
        <div class="tabs-container">
        
            
            <div class="tabs-wrapper" style="position: sticky; top: 0; z-index: 100; background: white;">
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
                            <input type="hidden" id="num-of-seats" name="seats" value="{{ request()->seats }}" />

                            <li class="nav-item" role="presentation">

                                <button class="nav-link" id="{{ $date }}-tab"
                                    style="background-color: {{ request()->go_date == $date ? 'var(--main-color)' : 'white' }};"
                                    type="submit" role="tab" name="go_date" value="{{ $date }}"
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
                @if($trips->count() > 0)
                
                @foreach ($trips as $trip)
                    <a
                        href="{{ route('mobile.one-way.choose-seat', array_merge(request()->all(), ['selected_trip_id' => $trip->id])) }}">
                        <div class="mt-3 border rounded-7 py-3 px-3 bus-card mb-3">
                            <div class="d-flex justify-content-between" style="color: black;">

                                <div class="d-flex justify-content-between gap-2" style="color: black;">
                                    <div class="bus-box-mobile m-auto" style="color: black;">
                                        <i class="fa fa-bus text-main fs-20"></i>
                                    </div>
                                    <div class="mt-1" style="color: black;">
                                        <div class="d-flex gap-2" style="color: black;">
                                            @php
                                                $time = \Carbon\Carbon::parse($trip->tripTime)->format('h:i a');
                                            @endphp
                                            <p class="m-0 fs-12" style="color: black;">{{ $time }}</p>
                                            <p class="m-0 vip" style="color: black;">{{ $trip->degree }}</p>
                                        </div>
                                        <div class="d-flex align-items-center gap-2" style="color: black;">
                                            <div class="d-flex flex-column align-items-center" style="color: black;">
                                                <div class="green-circle-mobile"></div>
                                                <div class="line-mobile"></div>
                                                <div class="red-circle-mobile"></div>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between" style="color: black;">
                                                <p class="m-0 fs-12" style="color: black;">{{ $trip->fromStation }} </p>
                                                <p class="m-0 fs-12" style="color: black;">{{ $trip->toStation }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="color: black;">
                                    <p class="m-0 fs-12" style="color: black;">{{ $trip->price }} {{__('EGP')}}</p>
                                    <p class="m-0 fs-12" style="color: black;">{{__('per seat')}}</p>
                                    <p class="m-0 fs-12 text-success" style="color: black;">{{__('Available Seats')}} {{ $trip->available_seats }}</p>
                                    <button class="btn btn-main mt-2 btn-sm rounded-5" type="button">
                                        {{__('Book')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
                @else 
                {{-- NO TRIPS Design --}}
                <div class="d-flex justify-content-center align-items-center">
                    <div class="text-center">
                        <i class="fa fa-bus text-main" style="font-size: 100px"></i>
                        <p class="m-0 fs-20">{{ __('No Trips Available') }}</p>
                        <p class="m-0 fs-15">{{ __('Please, choose another date or destination') }}</p>
                        <hr>
                        <a
                         class="login" href="tel:{{ $contactUs['phone'] }}">
                         <i class="fa fa-phone fs-15"></i>
                            {{ __('Call Us') }}
                        </a>
                    </div>
                </div>
                @endif 




            </div>
            
            
        </div>
    </div>
@endsection

@push('scripts')
@endpush
