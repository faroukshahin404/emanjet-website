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
            $legacyContactSeo = $generalPageSeos->where('section_type', 'contact-us')->where('status', true)->first();
            $socialMediaSeo = $generalPageSeos->where('section_type', 'social-media')->where('status', true)->first();
            $socialFullJson = is_array($socialMediaSeo?->content_json)
                ? $socialMediaSeo->content_json
                : [];
            $locale = app()->getLocale();
            $socialLocaleBranch = $socialFullJson[$locale] ?? $socialFullJson['en'] ?? [];
            $legacyFlat = [];
            if ($legacyContactSeo && is_array($legacyContactSeo->content_json)) {
                $legacyFlat = $legacyContactSeo->content_json[$locale]
                    ?? $legacyContactSeo->content_json['en']
                    ?? [];
                $legacyFlat = is_array($legacyFlat) ? $legacyFlat : [];
            }
            $contactUs = SocialMediaLinks::contactForPublic(
                is_array($socialLocaleBranch) ? $socialLocaleBranch : [],
                $legacyFlat
            );
            $socialMediaBranch = $socialMediaSeo?->translated_content_json ?? [];
            
            $footerAboutSeo = $generalPageSeos->where('section_type', 'footer-about')->where('status', true)->first();
            $footerAbout = $footerAboutSeo?->translated_content_json ?? [
                'description' => __('Eman Jet is your trusted partner for comfortable and safe travel across the region.')
            ];

            $newsletterSeo = $generalPageSeos->where('section_type', 'newsletter')->where('status', true)->first();
            $newsletter = $newsletterSeo?->translated_content_json ?? [
                'title' => __('Newsletter'),
                'description' => __('Subscribe to our newsletter for the latest updates and offers.'),
                'button-text' => __('Join'),
                'email-placeholder' => __('Your Email')
            ];

            $apps = $this->appLinksFromDashSettings();
            $pageSeo = $view->getData()['seo'] ?? null;
            $generalSeo = $generalPage ? getSeoData($generalPage->toArray()) : [];
            $seo = isset($pageSeo) ? $pageSeo : $generalSeo;
            $view->with([
                'contactUs' => $contactUs,
                'socialMedia' => SocialMediaLinks::forFooter($socialMediaBranch),
                'footerAbout' => $footerAbout,
                'newsletter' => $newsletter,
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
