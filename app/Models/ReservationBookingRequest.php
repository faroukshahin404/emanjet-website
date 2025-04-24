<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationBookingRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];

    public function stationFrom()  {
        return $this->belongsTo(Station::class, 'stationFrom_id');
    }
    public function stationTo()  {
        return $this->belongsTo(Station::class, 'stationTo_id');
    }

    public function runTrip()  {
        return $this->belongsTo(RunTrip::class, 'runTrip_id');
    }
    
    public function bookingSeats()  {
        return $this->hasMany(BookingSeat::class, 'booking_id');
    }

    public function user()  {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function payment()  {
        return $this->hasOne(PaymentDataSave::class, 'item_id', 'payment_key');
    }
} 
