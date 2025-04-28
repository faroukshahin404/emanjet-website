<?php

namespace App\Http\Resources;

use App\Models\Station;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $stations = Station::where('city_id' , $this->id)->where([
            'active'=>1,
            'available_online'=>1,
        ])->get();
        $station=[];
        foreach ($stations as $key => $item) {
            $station[]=[
                'id'=> $item->id,
                'name'=> $item->name,
                
            ];
        }
        return [
            'id'=> $this->id, 
            'name'=> $this->name,
            'stations'=> $station,
            'image'=> $this->image,
        ];
    }
}
