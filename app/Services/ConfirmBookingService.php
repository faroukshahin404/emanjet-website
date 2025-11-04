<?php

namespace App\Services;

use App\Http\Requests\OnewayConfirmBookingRequest;
use App\Http\Requests\RoundConfirmBookingRequest;
use App\Traits\ConfirmBookingTrait;
use App\Models\ReservationBookingRequest;
use Illuminate\Support\Facades\Auth;

class ConfirmBookingService
{
    use ConfirmBookingTrait;

    public function one_way_confirm_booking(OnewayConfirmBookingRequest $request, $pos = 'website')
    {
        if ($request->payment_method == 'fawry') {
            $parent = $this->store_ticket(
                seats: $request->seat_id,
                payment_key: null,
                stationFrom_id: $request->station_from_id,
                stationTo_id: $request->station_to_id,
                runTrip_id: $request->selected_trip_id,
                payment_method: $request->payment_method,
                trip_type: 1,
                pos: $pos
            );
            foreach ($request->seat_id as $key => $seat_id) {
                $ticket = $this->store_ticket(
                    seats: [$seat_id],
                    payment_key: $parent->id,
                    stationFrom_id: $request->station_from_id,
                    stationTo_id: $request->station_to_id,
                    runTrip_id: $request->selected_trip_id,
                    payment_method: $request->payment_method,
                    trip_type: 1,
                    pos: $pos
                );
            }
            return [
                'total' => $parent->total,
                'payment_key' => $parent->id,
                'user_id' => Auth::user()->id,
            ];
        } else {
            $paymentKey = $this->generateUniqueId();
            foreach ($request->seat_id as $key => $seat_id) {
                $this->store_ticket(
                    seats: [$seat_id],
                    payment_key: $paymentKey,
                    stationFrom_id: $request->station_from_id,
                    stationTo_id: $request->station_to_id,
                    runTrip_id: $request->selected_trip_id,
                    payment_method: $request->payment_method,
                    trip_type: 1,
                    pos: $pos
                );
            }
            $total = ReservationBookingRequest::where('payment_key', $paymentKey)->sum('total');
            return [
                'total' => $total,
                'payment_key' => $paymentKey,
                'user_id' => Auth::user()->id,
            ];
        }
    }

    function generateUniqueId(): string
    {

        $timestamp = now()->timestamp; // Get current timestamp
        $randomNumber = mt_rand(1000, 9999); // Generate a random number
        $uniqueId =  $timestamp . $randomNumber;
        return $uniqueId;
    }


    public function round_confirm_booking(RoundConfirmBookingRequest $request, $pos = 'website')
    {
        if ($request->payment_method == 'fawry') {
            $parent = $this->store_ticket(
                seats: $request->go_seat_id,
                payment_key: null,
                stationFrom_id: $request->station_from_id,
                stationTo_id: $request->station_to_id,
                runTrip_id: $request->go_trip_id,
                payment_method: $request->payment_method,
                trip_type: 2,
                round_trip_id: $request->back_trip_id,
                pos: $pos
            );
            // Book Go Trip
            foreach ($request->go_seat_id as $key => $seat_id) {
                $ticket = $this->store_ticket(
                    seats: [$seat_id],
                    payment_key: $parent->id,
                    stationFrom_id: $request->station_from_id,
                    stationTo_id: $request->station_to_id,
                    runTrip_id: $request->go_trip_id,
                    payment_method: $request->payment_method,
                    trip_type: 1,
                    pos: $pos
                );
            }
            // Book Back Trip
            foreach ($request->round_seat_id as $key => $seat_id) {
                $ticket = $this->store_ticket(
                    seats: [$seat_id],
                    payment_key: $parent->id,
                    stationFrom_id: $request->station_to_id,
                    stationTo_id: $request->station_from_id,
                    runTrip_id: $request->back_trip_id,
                    payment_method: $request->payment_method,
                    round_trip_id: $request->back_trip_id,
                    trip_type: 2,
                    pos: $pos
                );
            }
            return [
                'total' => $parent->total,
                'payment_key' => $parent->id,
                'user_id' => Auth::user()->id,
            ];
        }else if($request->payment_method == 'qnb'){
            $paymentKey = $this->generateUniqueId();
            foreach ($request->go_seat_id as $key => $seat_id) {
                $ticket = $this->store_ticket(
                    seats: [$seat_id],
                    payment_key: $paymentKey,
                    stationFrom_id: $request->station_from_id,
                    stationTo_id: $request->station_to_id,
                    runTrip_id: $request->go_trip_id,
                    payment_method: $request->payment_method,
                    trip_type: 1,
                    pos: $pos
                );
            }
            // Book Back Trip
            foreach ($request->round_seat_id as $key => $seat_id) {
                $ticket = $this->store_ticket(
                    seats: [$seat_id],
                    payment_key: $paymentKey,
                    stationFrom_id: $request->station_to_id,
                    stationTo_id: $request->station_from_id,
                    runTrip_id: $request->back_trip_id,
                    payment_method: $request->payment_method,
                    round_trip_id: $request->back_trip_id,
                    trip_type: 2,
                    pos: $pos
                );
            }
            $total = ReservationBookingRequest::where('payment_key', $paymentKey)->sum('total');
            return [
                'total' => $total,
                'payment_key' => $paymentKey,
                'user_id' => Auth::user()->id,
            ];
        }
    }
}
