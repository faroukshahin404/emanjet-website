<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripData extends Model
{
    use HasFactory ;


    protected $fillable = ['name', 'busType_id', 'runningLine_id',"city_from_id",'city_to_id', 'admin_id', 'type', 'notes', 'active'];

    
    

    


    public function busType()
    {
        return $this->belongsTo(BusType::class,'busType_id')->with('seats');
    }


    

    public function tripStations()
    {
        return $this->hasMany(TripStation::class,'tripData_id')->orderBy('rank');
    }

    public function first_station()
    {
        return $this->tripStations()->orderBy('rank', 'asc');
    }

    public function last_station()
    {
        return $this->tripStations()->orderBy('rank', 'desc');
    }
    public function lines()
    {
        return $this->hasMany(Line::class,'tripData_id')->where("active","1");
    }

    public function largestLine()
    {
        return $this->hasOne(Line::class,'tripData_id')->ofMany('priceGo', 'max')->with('from','to');
    }
 
    public function runTrips()
    {
        return $this->hasMany(RunTrip::class,'tripData_id');
    }
    public function tripDegrees()
    {
        return $this->hasMany(TripDegree::class,'tripData_id');
    }
    

    public function tripSeats()
    {
        return $this->hasMany(TripSeat::class,'tripData_id');
    }


    
    


    public function ReservationBookingRequests()
    {
        return $this->hasMany(ReservationBookingRequest::class,'tripData_id');
    }

    public function childerns()
    {
        return $this->hasMany(TripData::class,'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(TripData::class, 'parent_id');
    }

    public function rootParent()
    {
        $parent = $this->parent;
        while ($parent && $parent->parent) {
            $parent = $parent->parent;
        }
        return $parent;
    }
    public function fromCity(){
        return $this->belongsTo(City::class , 'city_from_id');
    }
    public function toCity(){
        return $this->belongsTo(City::class , 'city_to_id');
    }

   /*** end relations ***/

} //end class
