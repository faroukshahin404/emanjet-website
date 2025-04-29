<?php

namespace App\Http\Controllers;

use App\Models\BusType;
use App\Models\City;
use App\Models\Degree;
use App\Models\RunTrip;
use App\Models\Station;
use App\Services\ConfirmBookingService;
use App\Traits\BookingTrait;
use App\Traits\FawryIntegration;
use Illuminate\Http\Request;

class OnewayMobileController extends Controller
{
    protected $confirmBookingService;
    use BookingTrait, FawryIntegration;

    public function __construct(ConfirmBookingService $confirmBookingService)
    {
        $this->confirmBookingService = $confirmBookingService;
    }

    public function trips(Request $request)
    {
        $request->validate([
            'tripType' => 'required|in:oneway,round',
            'city_from_id' => 'required|exists:cities,id',
            'city_to_id' => 'required|exists:cities,id',
            'station_from_id' => 'required|exists:stations,id',
            'station_to_id' => 'required|exists:stations,id',
            'seats' => 'required',
            'back_date' => 'nullable|date|after_or_equal:today',
            'go_date' => 'required|date|after_or_equal:today'
        ], [
            'city_from_id.exists' => __('City From is required'),
            'city_to_id.exists' => __('City To is required'),
            'station_from_id.exists' => __('Station From is required'),
            'station_to_id.exists' => __('Station To is required'),
            'seats.required' => __('Seats are required'),
            'go_date.required' => __('Go Date is required'),
            'go_date.date' => __('Go Date must be a valid date'),
            'go_date.after_or_equal' => __('Go Date must be today or later')
        ]);

        $trips = $this->getTrips(
            date: $request->go_date,
            stationFrom_id: $request->station_from_id,
            stationTo_id: $request->station_to_id,
            cityFrom_id: $request->city_from_id,
            cityTo_id: $request->city_to_id,
            seats: $request->seats,
            times: $request->times ?? [],
            degrees: $request->degrees
        );

        $dates = $this->getNextWeekDays($request->go_date);
        return view('mobile.one-way.trips.index', [
            'trips' => $trips,
            'fromCity' => City::find(request()->city_from_id),
            'toCity' => City::find(request()->city_to_id),
            'fromStation' => Station::find(request()->station_from_id),
            'toStation' => Station::find(request()->station_to_id),
            'dates' => $dates

        ]);
    }

    public function chooseSeats(Request $request)
    {

        $request->validate([
            'tripType' => 'required|in:oneway,round',
            'city_from_id' => 'required|exists:cities,id',
            'city_to_id' => 'required|exists:cities,id',
            'station_from_id' => 'required|exists:stations,id',
            'station_to_id' => 'required|exists:stations,id',
            'seats' => 'required',
            'back_date' => 'nullable|date|after_or_equal:today',
            'go_date' => 'required|date|after_or_equal:today',
            'selected_trip_id' => 'required|exists:run_trips,id',
        ]);
        $trip = RunTrip::find($request->selected_trip_id);
        $busType = $trip->busType;

        $seats = $this->getBusSeat($request->selected_trip_id, $request->station_from_id, $request->station_to_id);
        $tripTime = $this->getTripTime($request->selected_trip_id, $request->station_from_id);
        return view('mobile.one-way.choose-seat.index', [
            'seats' => $seats,
            'fromCity' => City::find(request()->city_from_id),
            'toCity' => City::find(request()->city_to_id),
            'fromStation' => Station::find(request()->station_from_id),
            'toStation' => Station::find(request()->station_to_id),
            'tripTime' => $tripTime,
            'busType' => $busType
        ]);
    }

    public function bookingSummary(Request $request)
    {

        
        $request->validate([
            'tripType' => 'required|in:oneway,round',
            'city_from_id' => 'required|exists:cities,id',
            'city_to_id' => 'required|exists:cities,id',
            'station_from_id' => 'required|exists:stations,id', 
            'station_to_id' => 'required|exists:stations,id',
            'seats' => 'required',
            'back_date' => 'nullable|date|after_or_equal:today',
            'go_date' => 'required|date|after_or_equal:today',
            'selected_trip_id' => 'required|exists:run_trips,id',
            'selected_seats' => 'required'
        ], [
            'city_from_id.exists' => __('City From is required'),
            'city_to_id.exists' => __('City To is required'), 
            'station_from_id.exists' => __('Station From is required'),
            'station_to_id.exists' => __('Station To is required'),
            'seats.required' => __('Seats are required'),
            'go_date.required' => __('Go Date is required'),
            'go_date.date' => __('Go Date must be a valid date'),
            'go_date.after_or_equal' => __('Go Date must be today or later'),
            'selected_trip_id.required' => __('Trip is required'),
            'selected_trip_id.exists' => __('Invalid trip selected'),
            'selected_seats.required' => __('Please select seats')
        ]);
        $tripTime = $this->getTripTime($request->selected_trip_id, $request->station_from_id);

        return view('mobile.one-way.confirm-booking.index', [

            'fromCity' => City::find(request()->city_from_id),
            'toCity' => City::find(request()->city_to_id),
            'fromStation' => Station::find(request()->station_from_id),
            'toStation' => Station::find(request()->station_to_id),
            'tripTime' => $tripTime ,
            'tripDate' => $request->go_date,

        ]);

    }
}
