<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingSeat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id',
        'runTrip_id',
        'seat_id',
        'tripStationFrom_id',
        'tripStationTo_id',
        'degree_id',
        'office_id',
        'city_id',
        'admin_id',
        'total',
        'active',
        'created_at',
        'updated_at',
        'name',
        'from_id',
        'to_id',
        'tripData_id',
        'runningLine_id',
        'trip_date',
        'trip_time'
    ];



   
    
} //end of class
