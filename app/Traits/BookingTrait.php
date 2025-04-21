<?php

namespace App\Traits;

use App\Models\BookingSeat;
use App\Models\Line;
use App\Models\RunTrip;
use App\Models\TripSeat;
use App\Models\TripStation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait BookingTrait
{
    public function getTrips($date, $cityFrom_id = null, $cityTo_id = null, $seats = 1, $stationFrom_id = null, $stationTo_id = null, $degrees = null, $times = [])
    {
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $originalDate = clone $date;

        // Subquery to get booked seats
        $seatsSubQuery = DB::table('booking_seats')
            ->select('runTrip_id', DB::raw('COUNT(DISTINCT id) as booked_seats'))
            ->groupBy('runTrip_id');

        $query = DB::table('run_trips')
            ->whereBetween('run_trips.startDate', [
                $originalDate->copy()->subDay()->format('Y-m-d'),
                $originalDate->format('Y-m-d')
            ])
            ->join('lines', 'lines.tripData_id', '=', 'run_trips.tripData_id');

        if ($stationFrom_id) {
            $query->where('lines.from_id', $stationFrom_id);
        }
        if ($stationTo_id) {
            $query->where('lines.to_id', $stationTo_id);
        }

        $query->join('stations as fromStation', 'fromStation.id', '=', 'lines.from_id')
            ->join('stations as toStation', 'toStation.id', '=', 'lines.to_id');

        if ($cityFrom_id) {
            $query->where('fromStation.city_id', $cityFrom_id);
        }
        if ($cityTo_id) {
            $query->where('toStation.city_id', $cityTo_id);
        }

        $query->join('cities as fromCity', 'fromCity.id', '=', 'fromStation.city_id')
            ->join('cities as toCity', 'toCity.id', '=', 'toStation.city_id')
            ->join('trip_stations', function ($q) {
                $q->on('trip_stations.station_id', '=', 'fromStation.id');
                $q->on('trip_stations.tripData_id', '=', 'run_trips.tripData_id');
            })
            ->join('bus_types', 'bus_types.id', '=', 'run_trips.busType_id')
            ->join('trip_degrees', 'trip_degrees.tripData_id', '=', 'run_trips.tripData_id')
            ->join('degrees', 'degrees.id', '=', 'trip_degrees.degree_id')

            ->leftJoinSub($seatsSubQuery, 'seats_sub_query', 'seats_sub_query.runTrip_id', '=', 'run_trips.id');
        if ($degrees) {
            $query->whereIn('trip_degrees.degree_id', $degrees);
        }
        if ($seats) {
            $query->where(DB::raw('bus_types.slug - COALESCE(seats_sub_query.booked_seats, 0)'), '>=', $seats);
        }

        $query->select([
            'run_trips.id',
            'degrees.id as degree_id',
            'lines.priceGo as price',
            'lines.priceBack as round_price',
            DB::raw("JSON_UNQUOTE(JSON_EXTRACT(degrees.name, '$.ar')) as degree"),
            DB::raw("JSON_UNQUOTE(JSON_EXTRACT(fromCity.name, '$.ar')) as fromCity"),
            DB::raw("JSON_UNQUOTE(JSON_EXTRACT(toCity.name, '$.ar')) as toCity"),
            DB::raw("JSON_UNQUOTE(JSON_EXTRACT(fromStation.name, '$.ar')) as fromStation"),
            DB::raw("JSON_UNQUOTE(JSON_EXTRACT(toStation.name, '$.ar')) as toStation"),
            'bus_types.name as bus_type',
            'trip_stations.timeInMinutes',
            DB::raw('(bus_types.slug - COALESCE(seats_sub_query.booked_seats, 0)) as available_seats'),
            DB::raw("DATE_ADD(CONCAT(run_trips.startDate, ' ', run_trips.startTime), INTERVAL trip_stations.timeInMinutes MINUTE) as tripTime")
        ])
            ->having('tripTime', '>', Carbon::now()->addHours(4)->toDateTimeString());
        // if (@$times && is_array($times) && count($times) > 0) {

        //     $query->having(function ($q) use ($times) {
        //         $hasOr = false;

        //         if (in_array('am', $times??[])) {
        //             $q->whereRaw("TIME(tripTime) BETWEEN '05:00:00' AND '17:59:59'");
        //             $hasOr = true;
        //         }

        //         if (in_array('pm', $times??[])) {
        //             if ($hasOr) {
        //                 $q->orWhereRaw("TIME(tripTime) BETWEEN '18:00:00' AND '23:59:59'")
        //                     ->orWhereRaw("TIME(tripTime) BETWEEN '00:00:00' AND '04:59:59'");
        //             } else {
        //                 $q->whereRaw("TIME(tripTime) BETWEEN '18:00:00' AND '23:59:59'")
        //                     ->orWhereRaw("TIME(tripTime) BETWEEN '00:00:00' AND '04:59:59'");
        //             }
        //         }
        //     });
        // }

        return $query->get();
    }


    public function getBusSeat($runTrip_id, $stationFrom_id, $stationTo_id)
    {
        $runTrip = RunTrip::find($runTrip_id);
        $seats = TripSeat::where('tripData_id', $runTrip->tripData_id)->get();
        $line = Line::where([
            'from_id' => $stationFrom_id,
            'to_id' => $stationTo_id,
            'tripData_id' => $runTrip->tripData_id
        ])->first();
        $list = [];
        foreach ($seats as $key => $seat) {
            $list[] = [
                'tripSeat_id' => $seat->id,
                'seat_id' => $seat->seat_id,
                'type' => $seat->seat->type,
                'name' => @$seat->seat->name ?? $seat->name,
                'price' => @$line->priceGo,
                'round_price' => @$line->priceBack,
                'available' => BookingSeat::where([
                    'seat_id' => $seat->id
                ])->first() == null,
            ];
        }
        return $list;
    }
    public function getTripTime($runTrip_id, $stationFrom_id)
    {
        $runTrip = RunTrip::find($runTrip_id);
        $tripStation = TripStation::where([
            'station_id' => $stationFrom_id,
            'tripData_id' => $runTrip->tripData_id,
        ])->first();

        return Carbon::createFromFormat('Y-m-d H:i:s', $runTrip->startDate . ' ' . $runTrip->startTime)->addMinutes(@$tripStation->timeInMinutes ?? 0);
    }
    
}
