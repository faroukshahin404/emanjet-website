<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\RunTrip;
use App\Models\Station;
use App\Services\ConfirmBookingService;
use App\Traits\BookingTrait;
use App\Traits\FawryIntegration;
use Illuminate\Http\Request;

class RoundTripMobileController extends Controller
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
            'back_date' => 'required|date|after_or_equal:today',
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

        $dates = $this->getNextWeekDays();
        return view('mobile.round.trips.go-index', [
            'trips' => $trips,
            'fromCity' => City::find(request()->city_from_id),
            'toCity' => City::find(request()->city_to_id),
            'fromStation' => Station::find(request()->station_from_id),
            'toStation' => Station::find(request()->station_to_id),
            'dates' => $dates

        ]);
    }
    public function backTrips(Request $request)
    {
        $request->validate([
            'tripType' => 'required|in:oneway,round',
            'city_from_id' => 'required|exists:cities,id',
            'city_to_id' => 'required|exists:cities,id',
            'station_from_id' => 'required|exists:stations,id',
            'station_to_id' => 'required|exists:stations,id',
            'seats' => 'required',
            'back_date' => 'required|date|after_or_equal:today',
            'go_date' => 'required|date|after_or_equal:today',
            'go_trip_id' => 'required|exists:run_trips,id',
        ]);

        $trips = $this->getTrips(
            date: $request->back_date,
            stationFrom_id: $request->station_to_id,
            stationTo_id: $request->station_from_id,
            cityFrom_id: $request->city_to_id,
            cityTo_id: $request->city_from_id,
            seats: $request->seats,
            times: $request->times ?? [],
            degrees: $request->degrees
        );

        $dates = $this->getNextWeekDays();
        return view('mobile.round.trips.back-index', [
            'trips' => $trips,
            'fromCity' => City::find(request()->city_to_id),
            'toCity' => City::find(request()->city_from_id),
            'fromStation' => Station::find(request()->station_to_id),
            'toStation' => Station::find(request()->station_from_id),
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
            'back_date' => 'required|date|after_or_equal:today',
            'go_date' => 'required|date|after_or_equal:today',
            'go_trip_id' => 'required|exists:run_trips,id',
            'back_trip_id' => 'required|exists:run_trips,id',
        ]);
        $validated = $request->all();
        // بيانات المدن والمحطات
        $fromCity = City::findOrFail($validated['city_from_id']);
        $toCity = City::findOrFail($validated['city_to_id']);
        $fromStation = Station::findOrFail($validated['station_from_id']);
        $toStation = Station::findOrFail($validated['station_to_id']);

        // معالجة رحلة الذهاب
        $goTrip = RunTrip::findOrFail($validated['go_trip_id']);
        $goSeats = $this->getBusSeat($goTrip->id, $validated['station_from_id'], $validated['station_to_id']);
        $goTripTime = $this->getTripTime($goTrip->id, $validated['station_from_id']);

        // معالجة رحلة العودة (إذا كانت رحلة ذهاب وعودة)
        $backSeats = [];
        $backTripTime = null;
        $backTrip = null;


        $backTrip = RunTrip::findOrFail($validated['back_trip_id']);
        $backSeats = $this->getBusSeat($backTrip->id, $validated['station_to_id'], $validated['station_from_id']);
        $backTripTime = $this->getTripTime($backTrip->id, $validated['station_to_id']);
        $busType = $goTrip->busType;
    
        return view('mobile.round.choose-seat.index', [
            'goSeats' => $goSeats,
            'returnSeats' => $backSeats,
            'fromCity' => $fromCity,
            'toCity' => $toCity,
            'fromStation' => $fromStation,
            'toStation' => $toStation,
            'tripTime' => $goTripTime,
            'backTripTime' => $backTripTime,
            'tripType' => $validated['tripType'],
            'goTripId' => $goTrip->id,
            'backTripId' => $backTrip ? $backTrip->id : null,
            'seatCount' => $validated['seats'],
            'goTrip' => $goTrip,
            'backTrip' => $backTrip,
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
            'back_date' => 'required|date|after_or_equal:today',
            'go_date' => 'required|date|after_or_equal:today',
            'go_trip_id' => 'required|exists:run_trips,id',
            'back_trip_id' => 'required|exists:run_trips,id',
        ]);
        $goTripTime = $this->getTripTime($request->go_trip_id, $request->station_from_id);
        $backTripTime = $this->getTripTime($request->back_trip_id, $request->station_to_id);

        return view('mobile.round.confirm-booking.index', [

            'fromCity' => City::find(request()->city_from_id),
            'toCity' => City::find(request()->city_to_id),
            'fromStation' => Station::find(request()->station_from_id),
            'toStation' => Station::find(request()->station_to_id),
            'goTripTime' => $goTripTime,
            'backTripTime' => $backTripTime,
        ]);
    }
}
