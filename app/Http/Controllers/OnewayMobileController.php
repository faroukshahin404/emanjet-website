<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Degree;
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

        return view('mobile.one-way.trips.index', [
            'trips' => $trips,
            'fromCity' => City::find(request()->city_from_id),
            'toCity' => City::find(request()->city_to_id),
            'fromStation' => Station::find(request()->station_from_id),
            'toStation' => Station::find(request()->station_to_id),
            'cities' => $cities,
            'degrees' => $degrees
        ]);
    }
}
