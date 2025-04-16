<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RunTrip extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'runningLine_id',
        'city_from_id',
        'city_to_id',
        'tripData_id',
        'admin_id',
        'driver_id',
        'bus_id',
        'busType_id',
        'host_id',
        'type',
        'active',
        'canceled',
        'startDate',
        'startTime',
        'notes',
        'driverTips',
        'hostTips',
        'available_online',
        'trip_distance',
        'reservation_possible'
    ];




} //end of class
