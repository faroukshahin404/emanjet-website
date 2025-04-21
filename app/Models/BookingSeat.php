<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingSeat extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];



    public function tripSeat(){
        return $this->belongsTo(TripSeat::class, 'seat_id');
    }


   
    
} //end of class
