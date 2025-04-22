<?php

namespace App\Providers;

use App\Models\Page;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        view()->composer('*', function ($view) {
            $generalPage = Page::where('slug', 'general')->first();
            $generalPageSeos = $generalPage->pageSeos;
            $contactUs = $generalPageSeos->where('section_type', 'contact-us')->first();
            $socialMedia = $generalPageSeos->where('section_type', 'social-media')->first();
            $apps = $generalPageSeos->where('section_type', 'apps')->first();
            $pageSeo = $view->getData()['seo'] ?? null;
            $generalSeo = getSeoData($generalPage->first());
            $seo = isset($pageSeo) ? $pageSeo : $generalSeo;
            $view->with([
                'contactUs' => $contactUs->translated_content_json,
                'socialMedia' => $socialMedia->translated_content_json,
                'apps' => $apps->translated_content_json,
                'seo' => $seo,
            ]);
        });
    }
}
