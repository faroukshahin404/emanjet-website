<?php

namespace App\Providers;

use App\Models\DashSetting;
use App\Models\Page;
use App\Support\SocialMediaLinks;
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
            $generalPageSeos = $generalPage ? $generalPage->pageSeos : collect();
            $contactUs = $generalPageSeos->where('section_type', 'contact-us')->where('status', true)->first();
            $socialMediaSeo = $generalPageSeos->where('section_type', 'social-media')->where('status', true)->first();
            $socialMediaBranch = $socialMediaSeo?->translated_content_json ?? [];
            $apps = $this->appLinksFromDashSettings();
            $pageSeo = $view->getData()['seo'] ?? null;
            $generalSeo = $generalPage ? getSeoData($generalPage->toArray()) : [];
            $seo = isset($pageSeo) ? $pageSeo : $generalSeo;
            $view->with([
                'contactUs' => $contactUs?->translated_content_json ?? [],
                'socialMedia' => SocialMediaLinks::forFooter($socialMediaBranch),
                'apps' => $apps,
                'seo' => $seo,
            ]);
        });
    }

    /**
     * Build public app store links from DashSetting (active flag + URL per platform).
     * Returns [] when both platforms are inactive or have no URL.
     */
    protected function appLinksFromDashSettings(): array
    {
        $apps = [];

        $androidLink = trim((string) (DashSetting::get('app_android_link', '') ?? ''));
        if ((string) DashSetting::get('app_android_active', '0') === '1' && $androidLink !== '') {
            $apps['android'] = $androidLink;
        }

        $iosLink = trim((string) (DashSetting::get('app_ios_link', '') ?? ''));
        if ((string) DashSetting::get('app_ios_active', '0') === '1' && $iosLink !== '') {
            $apps['ios'] = $iosLink;
        }

        return $apps;
    }
}
