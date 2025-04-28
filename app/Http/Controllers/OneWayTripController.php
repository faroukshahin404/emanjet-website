<?php

namespace App\Http\Controllers;


use App\Http\Requests\OnewayConfirmBooking;
use App\Http\Requests\OnewayConfirmBookingRequest;
use App\Models\City;
use App\Models\Degree;
use App\Models\RunTrip;
use App\Models\Station;
use App\Services\ConfirmBookingService;
use App\Traits\BookingTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\FawryIntegration;

class OneWayTripController extends Controller
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
            'tripType.required' => __('Trip Type is required'),
            'tripType.in' => __('Trip Type must be either oneway or round'),

            'city_from_id.required' => __('City From is required'),
            'city_from_id.exists' => __('Selected City From does not exist'),

            'city_to_id.required' => __('City To is required'),
            'city_to_id.exists' => __('Selected City To does not exist'),

            'station_from_id.required' => __('Station From is required'),
            'station_from_id.exists' => __('Selected Station From does not exist'),

            'station_to_id.required' => __('Station To is required'),
            'station_to_id.exists' => __('Selected Station To does not exist'),

            'seats.required' => __('Seats are required'),

            'back_date.date' => __('Back Date must be a valid date'),
            'back_date.after_or_equal' => __('Back Date must be today or later'),

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
        $cities = City::available()->orderBy('rank')->get();
        $degrees = Degree::whereIn('id', $trips->pluck('degree_id'))->get();

        return view('one-way.trips.index', [
            'trips' => $trips,
            'fromCity' => City::find(request()->city_from_id),
            'toCity' => City::find(request()->city_to_id),
            'fromStation' => Station::find(request()->station_from_id),
            'toStation' => Station::find(request()->station_to_id),
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
        $trip = RunTrip::find($request->selected_trip_id);
        $busType = $trip->busType;

        return view('one-way.choose-seat.index', [
            'seats' => $seats,
            'fromCity' => City::find(request()->city_from_id),
            'toCity' => City::find(request()->city_to_id),
            'fromStation' => Station::find(request()->station_from_id),
            'toStation' => Station::find(request()->station_to_id),
            'tripTime' => $tripTime,
            'busType' => $busType
        ]);
    }

    public function confirmBooking(OnewayConfirmBookingRequest $request)
    {
        try {
            DB::beginTransaction();
            $ticket = $this->confirmBookingService->one_way_confirm_booking($request);
            if ($request->payment_method == 'fawry') {
                $payment_link = $this->getPaymentLink($ticket->id, $ticket->total, $ticket->user_id, 1, asset('/'));
                DB::commit();
                return redirect()->to($payment_link);
            } else {

                return redirect()->back()->with('error', __('Incorrect payment method!'));
            }
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
