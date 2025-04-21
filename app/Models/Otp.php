<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'otp', 'expires_at', 'is_used', 'user_id'];


    protected $casts = [
        'expires_at' => 'datetime',
    ];
    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    public function isUsed()
    {
        return $this->is_used;
    }
}
