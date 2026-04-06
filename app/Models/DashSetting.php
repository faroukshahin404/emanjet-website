<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DashSetting extends Model
{
    protected $table = 'dash_setting';

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    public static function get(string $key, $default = null)
    {
        $cacheKey = "dash_setting_{$key}";

        return Cache::remember($cacheKey, 86400, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value, string $type = 'text', string $group = 'general', ?string $description = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'description' => $description,
            ]
        );

        Cache::forget("dash_setting_{$key}");

        return $setting;
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget("dash_setting_{$setting->key}");
        });

        static::deleted(function ($setting) {
            Cache::forget("dash_setting_{$setting->key}");
        });
    }
}
