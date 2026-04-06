<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'order',
        'status',
    ];

    protected $casts = [
        'question' => 'array',
        'answer' => 'array',
        'order' => 'integer',
        'status' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order')->latest('id');
    }

    public function getTranslatedQuestionAttribute(): string
    {
        return $this->question[app()->getLocale()] ?? $this->question['en'] ?? '';
    }

    public function getTranslatedAnswerAttribute(): string
    {
        return $this->answer[app()->getLocale()] ?? $this->answer['en'] ?? '';
    }
}
