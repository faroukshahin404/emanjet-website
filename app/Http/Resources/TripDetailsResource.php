<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\RunTrip;
use App\Models\TripSeat;
use App\Models\Line;
use App\Models\TripStation;
use Carbon\Carbon;

class TripDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tripData_id' => $this->tripData_id,
            'tripTime' => $this->getTripTime($this->id, $request->station_from_id),
            'pick_from_hotel' => true,
            'bus' => [
                'length' => $this->tripData->busType->length,
                'width' => $this->tripData->busType->width,
                'seats' => $this->seats($request),
            ],
        ];
    }
   
    
    public function seats($request)
    {
        $handledSeats = [];
        $seats = TripSeat::where('tripData_id', $this->tripData_id)->get();
        if ($request->station_from_id != null && $request->station_to_id != null) {
            foreach ($seats as $key => $seat) {
                $item['id'] = $seat->id;
                $item['name'] = $seat->seat->name;
                $item['type'] = $seat->seat->type;
                $item['visible'] = $seat->seat->type != 2;
                $line = Line::where([
                    'tripData_id' => $this->tripData_id,
                    'from_id' => $request->station_from_id,
                    'to_id' => $request->station_to_id,
                ])->first();
                $item['price'] =@$request->type==2? ($line->priceBack - $line->priceGo):$line->priceGo;
                if($item['id'] == 228){
                    $item['price'] = $item['price']+100;
                }
                $item['available'] = $seat->seat->type != 1 ?
                    false
                    : (isSeatAvailable($seat->id, $this->id, $this->tripData_id, $line->id) == null);
                $handledSeats[] = $item;
            }
        }
        return $handledSeats;
    }
    public function getTripTime($runTrip_id, $stationFrom_id = null)
    {
        $runTrip = RunTrip::find($runTrip_id);  

        if($stationFrom_id == null){
            return Carbon::parse( $runTrip->startDate . ' ' . $runTrip->startTime)->format('Y-m-d H:i:s');
        }
        $tripStation = TripStation::where([
            'station_id' => $stationFrom_id,
            'tripData_id' => $runTrip->tripData_id,
        ])->first();

        return Carbon::parse( $runTrip->startDate . ' ' . $runTrip->startTime)->addMinutes(@$tripStation->timeInMinutes ?? 0)->format('Y-m-d H:i:s');
    }
}
