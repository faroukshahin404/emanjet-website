<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'image',
        'content',
        'category_id',
        'views',
        'likes',
        'reading_time',
        'meta_title',
        'meta_description',
        'meta_tags',
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'meta_tags' => 'array',
    ];

    public function getTranslatedTitleAttribute()
    {
        return $this->title[app()->getLocale()] ?? $this->title['en'] ?? '';
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

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
