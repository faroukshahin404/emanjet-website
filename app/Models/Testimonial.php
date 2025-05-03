<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'content',
        'image',
    ];

    protected $casts = [
        'name' => 'array',
        'content' => 'array',
    ];

    public function getTranslatedNameAttribute()
    {
        return $this->name[app()->getLocale()] ?? $this->name['en'] ?? '';
    }

    public function getTranslatedContentAttribute()
    {
        return $this->content[app()->getLocale()] ?? $this->content['en'] ?? '';
    }
}
