<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSeo extends Model
{
    protected $fillable = [
        'page_id',
        'section_type',
        'content_json',
        'order',
        'status',
    ];

    protected $casts = [
        'content_json' => 'array',
        'status' => 'boolean',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
