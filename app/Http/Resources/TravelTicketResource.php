<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelTicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $seats=[];
            foreach ($this->bookingSeats as $key => $seat) {
                $seats[]= @$seat->tripSeat->seat->name;
            }
        return [

            'id'=>$this->id,
            'created_at'=>$this->created_at,
            
            'duration'=>'--',
            'date'=> $this->tripDate($this->trip_id , $this->stationFrom_id , $this->runTrip->startDate .' '. $this->runTrip->startTime)->format('Y-m-d'),
            'time'=> $this->tripDate($this->trip_id , $this->stationFrom_id , $this->runTrip->startDate .' '. $this->runTrip->startTime)->format('h:i a'),
            'driver'=>@$this->runTrip->driver->name,
            'bus'=>@$this->runTrip->bus->code,
            'from'=>@$this->stationFrom->name,
            'to'=>@$this->stationTo->name,
            'city_from'=>@$this->stationFrom->city->name,
            'city_to'=>@$this->stationTo->city->name,
            'feature'=>["fastest" , 'comfort'],
            'seats'=>$seats,
            'status'=>payment_status($this->reserv_type),
            'confirmed'=> $this->reserv_type =='PAID'?1:0 
        ];
    }
    function tripDate($tripData_id , $stationFrom_id , $date){
        $tripTime = \App\Models\TripStation::where([
            'tripData_id'=>$tripData_id,
            'station_id'=>$stationFrom_id
        ])->first();
        $startTime = Carbon::parse($date);
        // return response()->json(['date'=>$date]);
        // dd(@$startTime->addMinutes(@$tripTime->timeInMinutes??0));
        return $startTime->addMinutes(@$tripTime->timeInMinutes??0);
    }
    
}
