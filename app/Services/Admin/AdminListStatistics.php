<?php

namespace App\Services\Admin;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BusCategory;
use App\Models\City;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Station;
use Carbon\Carbon;

/**
 * Aggregates lightweight counts for admin index "summary" cards (ov-er style).
 */
class AdminListStatistics
{
    public static function faqs(): array
    {
        return [
            'total' => Faq::count(),
            'active' => Faq::where('status', true)->count(),
            'recent' => Faq::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
        ];
    }

    public static function blogs(): array
    {
        return [
            'total' => Blog::count(),
            'categories_used' => BlogCategory::has('blogs')->count(),
            'recent' => Blog::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
        ];
    }

    public static function blogCategories(): array
    {
        return [
            'total' => BlogCategory::count(),
            'with_posts' => BlogCategory::has('blogs')->count(),
            'recent' => BlogCategory::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
        ];
    }

    public static function destinations(): array
    {
        return [
            'total' => Destination::count(),
            'recent' => Destination::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'ordered' => Destination::where('order', '>', 0)->count(),
        ];
    }

    public static function busCategories(): array
    {
        return [
            'total' => BusCategory::count(),
            'recent' => BusCategory::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'avg_passengers' => round((float) (BusCategory::query()->avg('passengers') ?? 0), 1),
        ];
    }

    public static function cities(): array
    {
        return [
            'total' => City::count(),
            'available_online' => City::where('available_online', true)->count(),
            'recent' => City::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
        ];
    }

    public static function stations(): array
    {
        return [
            'total' => Station::count(),
            'available_online' => Station::where('available_online', true)->count(),
            'recent' => Station::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
        ];
    }

    public static function pages(): array
    {
        return [
            'total' => Page::count(),
            'active' => Page::where('status', true)->count(),
            'with_sections' => Page::has('pageSeos')->count(),
        ];
    }

    /**
     * @return array{total:int,active:int,section_types:int}
     */
    public static function pageSeosForPage(Page $page): array
    {
        $sections = $page->pageSeos;

        return [
            'total' => $sections->count(),
            'active' => $sections->where('status', true)->count(),
            'section_types' => $sections->pluck('section_type')->unique()->count(),
        ];
    }
}
