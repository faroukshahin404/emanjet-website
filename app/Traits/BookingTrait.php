<?php

namespace App\Traits;

use App\Models\BookingSeat;
use App\Models\DashSetting;
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
        $bookingLeadHours = max(0, (int) DashSetting::get('booking_hours_before_departure', 8));

        // Subquery to get booked seats
        $seatsSubQuery = DB::table('booking_seats')
            ->select('runTrip_id', DB::raw('COUNT(DISTINCT id) as booked_seats'))
            ->groupBy('runTrip_id');

        $query = DB::table('run_trips')
            ->where('run_trips.active', 1)
            ->whereNull('run_trips.deleted_at')
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
        if ($times && is_array($times)) {
            $query->where(function ($q) use ($times) {
                $hasAm = in_array('am', $times);
                $hasPm = in_array('pm', $times);

                if ($hasAm && !$hasPm) {
                    $q->whereRaw("TIME(run_trips.startTime) BETWEEN '05:00:00' AND '11:59:59'");
                } elseif ($hasPm && !$hasAm) {
                    $q->where(function ($q) {
                        $q->whereRaw("TIME(run_trips.startTime) BETWEEN '12:00:00' AND '23:59:59'")
                            ->orWhereRaw("TIME(run_trips.startTime) BETWEEN '00:00:00' AND '04:59:59'");
                    });
                }
            });
        }

        $query->join('cities as fromCity', 'fromCity.id', '=', 'fromStation.city_id')
        ->join('trip_data', 'trip_data.id' , '=', 'run_trips.tripData_id')
            ->join('cities as toCity', 'toCity.id', '=', 'toStation.city_id')
            ->join('trip_stations', function ($q) {
                $q->on('trip_stations.station_id', '=', 'fromStation.id');
                $q->on('trip_stations.tripData_id', '=', 'run_trips.tripData_id');
            })
            ->join('bus_types', 'bus_types.id', '=', 'trip_data.busType_id')
            ->join('trip_degrees', 'trip_degrees.tripData_id', '=', 'run_trips.tripData_id')
            ->join('degrees', function ($join) {
                $join->on('degrees.id', '=', 'trip_degrees.degree_id')
                    ->whereRaw('JSON_VALID(degrees.name)');
            })
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
            DB::raw('lines.priceBack - lines.priceGo as back_price'),
            DB::raw("JSON_UNQUOTE(JSON_EXTRACT(degrees.name, '$.ar')) as degree"),
            DB::raw("JSON_UNQUOTE(JSON_EXTRACT(fromCity.name, '$.ar')) as fromCity"),
            DB::raw("JSON_UNQUOTE(JSON_EXTRACT(toCity.name, '$.ar')) as toCity"),
            DB::raw("JSON_UNQUOTE(JSON_EXTRACT(fromStation.name, '$.ar')) as fromStation"),
            DB::raw("JSON_UNQUOTE(JSON_EXTRACT(toStation.name, '$.ar')) as toStation"),
            'bus_types.name as bus_type',
            'trip_stations.timeInMinutes',
            DB::raw('(bus_types.slug - COALESCE(seats_sub_query.booked_seats, 0)) as available_seats'),
            DB::raw("DATE_ADD(CONCAT(run_trips.startDate, ' ', run_trips.startTime), INTERVAL trip_stations.timeInMinutes MINUTE) as tripTime"),
            DB::raw("DATE_FORMAT(DATE_ADD(CONCAT(run_trips.startDate, ' ', run_trips.startTime), INTERVAL trip_stations.timeInMinutes MINUTE), '%Y-%m-%d') as tripDate")
        ])
            ->having('tripTime', '>', Carbon::now()->addHours($bookingLeadHours)->toDateTimeString())
            ->having('tripDate', '=', $date->format('Y-m-d'))
            ->orderBy('tripTime', 'asc');

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

    public function getNextWeekDays($date)
    {
        $days = [];
        $selectedDate = Carbon::parse($date);
        $today = Carbon::today();

        // Target an 8-day window around the selected date
        // But enforce today as the floor
        $start = $selectedDate->copy()->subDays(3);
        if ($start->lt($today)) {
            $start = $today->copy();
        }

        for ($i = 0; $i < 8; $i++) {
            $days[] = $start->copy()->addDays($i)->format('Y-m-d');
        }

        return $days;
    }

    /**
     * Same window as getNextWeekDays but the first day is never before $floorDate (Y-m-d).
     * Used for return-date pills so dates before departure are not shown.
     */
    public function getNextWeekDaysWithFloor(string $date, string $floorDate): array
    {
        $selectedDate = Carbon::parse($date);
        $floor = Carbon::parse($floorDate);
        $today = Carbon::today();
        if ($floor->lt($today)) {
            $floor = $today->copy();
        }

        $start = $selectedDate->copy()->subDays(3);
        if ($start->lt($floor)) {
            $start = $floor->copy();
        }

        $days = [];
        for ($i = 0; $i < 8; $i++) {
            $days[] = $start->copy()->addDays($i)->format('Y-m-d');
        }

        return $days;
    }

    public function parseAnyDate($input, $formats = ['Y-m-d', 'Y/m/d', 'd-m-Y', 'd/m/Y', 'd-m-Y', 'd/m/Y', 'dmY', 'dmy', 'ymd', 'Ymd'])
    {
        // Step 1: Normalize Arabic-Indic digits (U+0660–U+0669) to Western — use codepoints so source stays ASCII-only
        $arabic = array_map(static fn (int $cp) => mb_chr($cp, 'UTF-8'), range(0x0660, 0x0669));
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $input = str_replace($arabic, $western, $input);

        // Step 2: Remove extra spaces and normalize separators
        $input = trim($input);
        $input = str_replace(['\\', '.', '_'], '-', $input); // optional normalization
        $input = preg_replace('/[\/\-]/', '-', $input); // unify to dash

        // Step 3: Try parsing with common formats
        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $input)->format('Y-m-d');
                return $date;
            } catch (\Exception $e) {

                // continue to next format
            }
        }

        // Step 4: Fallback: try general Carbon parsing
        try {
            return Carbon::parse($input)->format('Y-m-d');
        } catch (\Exception $e) {

            return date('Y-m-d');
        }
    }
}
