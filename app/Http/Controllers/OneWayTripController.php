<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Degree;
use App\Models\Station;
use App\Traits\BookingTrait;
use Illuminate\Http\Request;

class OneWayTripController extends Controller
{
    use BookingTrait;
    public function trips(Request $request)
    {

        $request->validate([
            'tripType' => 'required|in:oneway,round',
            'city_from_id' => 'required|exists:cities,id',
            'city_to_id' => 'required|exists:cities,id',
            // 'station_from_id'=>'required|exists:stations,id',
            // 'station_to_id'=>'required|exists:stations,id',
            'seats' => 'required',
            'back_date' => 'nullable|date|after_or_equal:today',
            'go_date' => 'required|date|after_or_equal:today'
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
        $cities = City::available()->orderBy('rank')->get();
        $degrees = Degree::whereIn('id', $trips->pluck('degree_id'))->get();

        return view('one-way.trips.index', [
            'trips' => $trips,
            'fromCity' => City::find(request()->city_from_id),
            'toCity' => City::find(request()->city_to_id),
            'cities' => $cities,
            'degrees' => $degrees
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
        $seats = $this->getBusSeat($request->selected_trip_id, $request->station_from_id, $request->station_to_id);
        $tripTime = $this->getTripTime($request->selected_trip_id, $request->station_from_id);
        return view('one-way.choose-seat.index', [
            'seats' => $seats,
            'fromCity' => City::find(request()->city_from_id),
            'toCity' => City::find(request()->city_to_id),
            'fromStation' => Station::find(request()->station_from_id),
            'toStation' => Station::find(request()->station_to_id),
            'tripTime' => $tripTime
        ]);
    }
}
