<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory, SoftDeletes;
    use HasTranslations;

    public $translatable = ['name'];

    public function scopeAvailable($query)
    {
        return $query->where('active', 1)->where('available_online', 1);
    }
    public function getImageAttribute()
    {

        return @$this->attributes['image'] == null ? 'https://www.touristegypt.com/wp-content/uploads/2023/05/Sharm-el-Sheikh2.jpg' : asset('uploads/city/' . @$this->attributes['image']);
    }

    protected $appends = ['image'];

    /*** end relations ***/
    public function stations()
    {
        return $this->hasMany(Station::class)->where('available_online', 1)->where('active', 1);
    }


} //end of class
