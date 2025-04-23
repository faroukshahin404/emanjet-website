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
        'content_json' => 'array',  // تحويل البيانات من JSON إلى مصفوفة تلقائيًا
        'status' => 'boolean',
    ];

    // دالة للحصول على الترجمة
    public function getTranslatedContentJsonAttribute()
    {
        // تأكد من أن `content_json` يحتوي على بيانات مترجمة وتستخدم الحقل الصحيح للترجمة
        return $this->content_json[app()->getLocale()] ?? $this->content_json['en'] ?? '';
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
    protected $table = 'page_seos';
    protected $guarded = [];
}
