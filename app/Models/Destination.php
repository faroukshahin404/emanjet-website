<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'content',
        'image',
        'latitude',
        'longitude',
        'order',
        'meta_title',
        'meta_description',
        'meta_tags',
    ];

    protected $casts = [
        'name' => 'array',
        'content' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'meta_tags' => 'array',
        'order' => 'integer',
    ];

    public function getTranslatedNameAttribute()
    {
        return $this->name[app()->getLocale()] ?? $this->name['en'] ?? '';
    }

    public function getTranslatedContentAttribute()
    {
        return $this->content[app()->getLocale()] ?? $this->content['en'] ?? '';
    }

    public function getTranslatedMetaTitleAttribute()
    {
        return $this->meta_title[app()->getLocale()] ?? $this->meta_title['en'] ?? '';
    }

    public function getTranslatedMetaDescriptionAttribute()
    {
        return $this->meta_description[app()->getLocale()] ?? $this->meta_description['en'] ?? '';
    }

    public function getTranslatedMetaTagsAttribute()
    {
        return $this->meta_tags[app()->getLocale()] ?? $this->meta_tags['en'] ?? [];
    }
}
