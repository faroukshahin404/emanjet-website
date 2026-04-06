<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['name','admin_id','status','busType_id','type'];


    public function showType($val)
    {
        switch ($val) {
            case 1:
                echo __('Available');
                break;
            case 2:
                echo __('Unavailable');
                break;
            case 3:
                echo __('Driver');
                break;
        }
    }


    

} 