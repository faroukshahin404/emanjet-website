<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'slug',
        'title',
        'meta_title',
        'meta_description',
        'meta_tags',
        'status',
    ];
    protected $casts = [
        'title' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'meta_tags' => 'array',
    ];

    public function getTranslatedTitleAttribute()
    {
        return $this->getTranslation('title', app()->getLocale());
    }
    public function getTranslatedMetaTitleAttribute()
    {
        return $this->getTranslation('meta_title', app()->getLocale());
    }
    public function getTranslatedMetaDescriptionAttribute()
    {
        return $this->getTranslation('meta_description', app()->getLocale());
    }
    public function getTranslatedMetaTagsAttribute()
    {
        return $this->getTranslation('meta_tags', app()->getLocale());
    }


    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function pageSeos()
    {
        return $this->hasMany(PageSeo::class);
    }
}
