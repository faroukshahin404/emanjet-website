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

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
