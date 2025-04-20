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
        'meta_tags' => 'array',
    ];

    // public $translatable = ['title', 'meta_title', 'meta_description'];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function pageSeos()
    {
        return $this->hasMany(PageSeo::class);
    }
}
