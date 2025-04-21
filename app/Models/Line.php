<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Line extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['tripData_id', 'stationFrom_id', 'stationTo_id', 'degree_id', 'admin_id',
                            'active', 'priceGo', 'priceBack', 'priceForeignerGo', 'priceForeignerBack',
                            'setting_id', 'cancelFee', 'editFee', 'from_id', 'to_id'];




} //end of class
