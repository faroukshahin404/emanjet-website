<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripSeat extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['tripData_id', 'seat_id', 'degree_id', 'admin_id', 'name', 'busType_id'];


    public function seat()
    {
        return $this->belongsTo(Seat::class,'seat_id');
    }

} // end of class