<?php

namespace App\Services;

use App\Http\Requests\OnewayConfirmBookingRequest;
use App\Http\Requests\RoundConfirmBookingRequest;
use App\Traits\ConfirmBookingTrait;

class ConfirmBookingService
{
    use ConfirmBookingTrait;

    public function one_way_confirm_booking(OnewayConfirmBookingRequest $request)
    {

        $parent = $this->store_ticket(
            seats: $request->seat_id,
            payment_key: null,
            stationFrom_id: $request->station_from_id,
            stationTo_id: $request->station_to_id,
            runTrip_id: $request->selected_trip_id,
            payment_method: $request->payment_method,
            trip_type: 1
        );
        foreach ($request->seat_id as $key => $seat_id) {
            $ticket = $this->store_ticket(
                seats: [$seat_id],
                payment_key: $parent->id,
                stationFrom_id: $request->station_from_id,
                stationTo_id: $request->station_to_id,
                runTrip_id: $request->selected_trip_id,
                payment_method: $request->payment_method,
                trip_type: 1
            );
        }
        return $parent;
    }

    public function round_confirm_booking(RoundConfirmBookingRequest $request){
        $parent = $this->store_ticket(
            seats: $request->go_seat_id,
            payment_key: null,
            stationFrom_id: $request->station_from_id,
            stationTo_id: $request->station_to_id,
            runTrip_id: $request->go_trip_id,
            payment_method: $request->payment_method,
            trip_type: 2,
            round_trip_id: $request->back_trip_id
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
                trip_type: 1
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
                trip_type: 1
            );
        }
        return $parent;
    }
}
