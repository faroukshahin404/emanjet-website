<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];
    protected $casts = [
        'name' => 'array',
    ];


    public function getTranslatedNameAttribute()
    {
        return $this->name[app()->getLocale()] ?? $this->name['en'] ?? '';
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }
}
