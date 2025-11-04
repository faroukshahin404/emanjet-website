<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoundConfirmBookingRequest;
use App\Models\City;
use App\Models\Degree;
use App\Models\RunTrip;
use App\Models\Station;
use App\Services\ConfirmBookingService;
use App\Traits\BookingTrait;
use App\Traits\FawryIntegration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\QNBPaymentIntegration;

class RoundTripController extends Controller
{
    use BookingTrait, FawryIntegration, QNBPaymentIntegration;
    public function __construct(private ConfirmBookingService $confirmBookingService)
    {
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
        ],[
            'city_from_id.exists' => __('City From is required'),
            'city_to_id.exists' => __('City To is required'),
            'station_from_id.exists' => __('Station From is required'),
            'station_to_id.exists' => __('Station To is required'),
            'seats.required' => __('Seats are required'),
            'go_date.required' => __('Go Date is required'),
            'go_date.date' => __('Go Date must be a valid date'),
            'go_date.after_or_equal' => __('Go Date must be today or later')
        ]);
        $goTrips = $this->getTrips(
            date: $request->go_date,
            stationFrom_id: $request->station_from_id,
            stationTo_id: $request->station_to_id,
            cityFrom_id: $request->city_from_id,
            cityTo_id: $request->city_to_id,
            seats: $request->seats,
            times: $request->times ?? [],
            degrees: $request->degrees
        );

        $backTrips = $this->getTrips(
            date: $request->back_date,
            stationFrom_id: $request->station_to_id,
            stationTo_id: $request->station_from_id,
            cityFrom_id: $request->city_to_id,
            cityTo_id: $request->city_from_id,
            seats: $request->seats,
            times: $request->times ?? [],
            degrees: $request->degrees
        );
        $trips = $goTrips->merge($backTrips);
        $cities = City::available()->orderBy('rank')->get();
        $degrees = Degree::whereIn('id', $trips->pluck('degree_id'))->get();

        return view('round.trips.index', [
            'goTrips' => $goTrips,
            'backTrips' => $backTrips,
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
        $validated = $request->validate([
            'tripType' => 'required|in:round',
            'city_from_id' => 'required|exists:cities,id',
            'city_to_id' => 'required|exists:cities,id',
            'station_from_id' => 'required|exists:stations,id',
            'station_to_id' => 'required|exists:stations,id',
            'seats' => 'required|integer|min:1',
            'go_date' => 'required|date|after_or_equal:today',
            'back_date' => 'required|date|after_or_equal:go_date',
            'selected_go_trip_id' => 'required|exists:run_trips,id',
            'selected_back_trip_id' => 'required|exists:run_trips,id',
        ], [
            'city_from_id.exists' => __('City From is required'),
            'city_to_id.exists' => __('City To is required'),
            'station_from_id.exists' => __('Station From is required'),
            'station_to_id.exists' => __('Station To is required'),
            'seats.required' => __('Seats are required'),
            'go_date.required' => __('Go Date is required'),
            'go_date.date' => __('Go Date must be a valid date'),
            'go_date.after_or_equal' => __('Go Date must be today or later'),
            'back_date.required' => __('Back Date is required'),
            'back_date.date' => __('Back Date must be a valid date'),
            'back_date.after_or_equal' => __('Back Date must be today or later'),
            'selected_go_trip_id.required' => __('Go Trip is required'),
            'selected_go_trip_id.exists' => __('Go Trip is invalid'),
            'selected_back_trip_id.required' => __('Back Trip is required'),
            'selected_back_trip_id.exists' => __('Back Trip is invalid'),
        ]);

        // بيانات المدن والمحطات
        $fromCity = City::findOrFail($validated['city_from_id']);
        $toCity = City::findOrFail($validated['city_to_id']);
        $fromStation = Station::findOrFail($validated['station_from_id']);
        $toStation = Station::findOrFail($validated['station_to_id']);

        // معالجة رحلة الذهاب
        $goTrip = RunTrip::findOrFail($validated['selected_go_trip_id']);
        $goSeats = $this->getBusSeat($goTrip->id, $validated['station_from_id'], $validated['station_to_id']);
        $goTripTime = $this->getTripTime($goTrip->id, $validated['station_from_id']);

        // معالجة رحلة العودة (إذا كانت رحلة ذهاب وعودة)
        $backSeats = [];
        $backTripTime = null;
        $backTrip = null;

        $backTrip = RunTrip::findOrFail($validated['selected_back_trip_id']);
        $backSeats = $this->getBusSeat($backTrip->id, $validated['station_to_id'], $validated['station_from_id']);
        $backTripTime = $this->getTripTime($backTrip->id, $validated['station_to_id']);
        $busType = $goTrip->busType;
        return view('round.choose-seat.index', [
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

    public function confirmBooking(RoundConfirmBookingRequest $request)
    {

        try {
            DB::beginTransaction();
            $ticket = $this->confirmBookingService->round_confirm_booking($request);
            if ($request->payment_method == 'fawry') {
                $payment_link = $this->getPaymentLink($ticket['payment_key'], $ticket['total'], $ticket['user_id'], 1, asset('/'));
                DB::commit();
                return redirect()->to($payment_link);
            } else {
                $payment = $this->initiateQNBPaymentLink([
                    'amount' => $ticket['total'],
                    'order_id' => $ticket['payment_key'],
                ]);
                if ($payment['success'] == true) {
                    DB::commit();
                    return redirect($payment['url']);
                } else {
                    return redirect()->back()->with('error', __('Payment failed'));
                }
            }
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
