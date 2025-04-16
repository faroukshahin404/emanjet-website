<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripStation extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['station_id', 'tripData_id', 'admin_id', 'type','station_cost', 'timeInMinutes', 'rank',
                            'printTimes', 'distance'];


    
                            


} //end class

