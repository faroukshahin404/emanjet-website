<?php


function admin_id($payment_method): int
{
    switch ($payment_method) {
        case 'fawry':
            return 3001;


        default:
            return 3001;
    }
}


function isSeatAvailable($seat_id, $runTrip_id, $tripData_id, $line_id)
{
    $tripSeat = \App\Models\TripSeat::find($seat_id);
    $bookingSeats = \App\Models\BookingSeat::where([
        'runTrip_id' => $runTrip_id,
        'seat_id' => $tripSeat->id
    ])->get();
    foreach ($bookingSeats as $key => $bookingSeat) {
        $bookedFrom = \App\Models\TripStation::find($bookingSeat->tripStationFrom_id)->rank;
        $bookedTo = \App\Models\TripStation::find($bookingSeat->tripStationTo_id)->rank;
        // 
        $line = \App\Models\Line::find($line_id);
        $searchFrom = \App\Models\TripStation::where([
            'station_id' => $line->from_id,
            'tripData_id' => $tripData_id,
        ])->first()->rank;
        $searchTo = \App\Models\TripStation::where([
            'station_id' => $line->to_id,
            'tripData_id' => $tripData_id,
        ])->first()->rank;
        // 

        if (
            ($bookedFrom <= $searchFrom && $searchFrom < $bookedTo)
            || ($bookedFrom < $searchTo && $searchTo <= $bookedTo)
            || ($bookedFrom >= $searchFrom && $searchTo >= $bookedTo)
        ) {

            return $bookingSeat;
        }
    }
    return null;
}