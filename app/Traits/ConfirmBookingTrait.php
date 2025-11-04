<?php

namespace App\Traits;

use App\Models\BookingSeat;
use App\Models\Line;
use App\Models\ReservationBookingRequest;
use App\Models\RunTrip;
use App\Models\TripSeat;
use App\Models\TripStation;
use Exception;
use Illuminate\Support\Facades\Auth;

trait ConfirmBookingTrait
{
    
    public function store_ticket($seats = [], $payment_key = null, $stationFrom_id, $stationTo_id, $runTrip_id, $payment_method , $trip_type , $round_trip_id = null , $pos = 'website')
    {

        $runTrip = RunTrip::find($runTrip_id);
        $user = Auth::user();
        if(!$user){
            $user = auth('sanctum')->user();
        }
        $line = Line::where([
            'from_id' => $stationFrom_id,
            'to_id' => $stationTo_id,
            'tripData_id' => $runTrip->tripData_id,
        ])->first();
        if($trip_type == 1){
            $total = $line->priceGo * count($seats);
            $subTotal = $line->priceGo * count($seats);
        }else{
            if($payment_key){
            $total = ($line->priceBack - $line->priceGo) * count($seats);
            $subTotal = ($line->priceBack - $line->priceGo) * count($seats);
            }else{
                $total = $line->priceBack * count($seats);
                $subTotal = $line->priceBack * count($seats); 
            }
            
        }
        


        $ticket = ReservationBookingRequest::create([
            'code' => null,
            'runTrip_id' => $runTrip_id,
            'trip_id' => $runTrip->tripData_id,
            'user_id' => $user->id,
            'payment_key' => $payment_key,
            'stationFrom_id' => $stationFrom_id,
            'stationTo_id' => $stationTo_id,
            'go_ticket_id' => null,
            'secret_code' => null,
            'coupon_id' => null,
            'address' => null,
            'total' => $total,
            'sub_total' => $subTotal,
            'is_printed' => 'N',
            'admin_id' => admin_id($payment_method),
            'office_id' => 225,
            'payment_type' => 7,
            'reserv_type' => 'NEW',
            'payment_method' => $payment_method,
            'pos' =>$pos,
            'type'=>$trip_type,
            'passenger_type'=>1,

        ]);
        if ($payment_key != null) {
            foreach ($seats as $key => $seat_id) {
                $tripSeat = TripSeat::find($seat_id);
                if(!isSeatAvailable($seat_id , $runTrip_id , $runTrip->tripData_id, $line->id)){
                    BookingSeat::create([
                        'booking_id' => $ticket->id,
                        'runTrip_id' => $ticket->runTrip_id,
                        'seat_id' => $seat_id,
                        'tripStationFrom_id' => $this->tripStation($stationFrom_id, $runTrip->tripData_id)->id,
                        'tripStationTo_id' => $this->tripStation($stationTo_id, $runTrip->tripData_id)->id,
                        'office_id' => $ticket->office_id,
                        'admin_id' => $ticket->admin_id,
                        'total' => $line->priceGo,
                        'name' => @$tripSeat->seat->name,
                        'from_id' => $stationFrom_id,
                        'to_id' => $stationTo_id,
                        'tripData_id' => $runTrip->tripData_id,
                        'runningLine_id' => $runTrip->runningLine_id,
                        'trip_date' => $runTrip->startDate,
                        'trip_time' => $runTrip->startTime,
                    ]);
                }else{
                    throw new Exception('Seat is unavailable: ' . $tripSeat->seat->name);
                }
                
            }
        }
        return  $ticket;
    }
    public function tripStation($station_id, $tripData_id)
    {
        return TripStation::where([
            'station_id' => $station_id,
            'tripData_id' => $tripData_id
        ])->first();
    }
}
