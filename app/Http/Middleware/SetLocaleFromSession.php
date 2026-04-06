<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\LanguageNegotiator;

/**
 * Sets app + laravellocalization locale from session, legacy URL segment, or browser negotiation.
 */
class SetLocaleFromSession
{
    public function handle(Request $request, Closure $next)
    {
        $laravelLocalization = app('laravellocalization');
        $default = config('laravellocalization.default', config('app.locale', 'ar'));

        $locale = session('locale');

        if ($locale === null && $request->attributes->has('locale_from_legacy_url')) {
            $legacy = $request->attributes->get('locale_from_legacy_url');
            if ($laravelLocalization->checkLocaleInSupportedLocales($legacy)) {
                $locale = $legacy;
                session(['locale' => $locale]);
            }
        }

        if ($locale === null && config('laravellocalization.useAcceptLanguageHeader', false)) {
            $negotiator = new LanguageNegotiator(
                $laravelLocalization->getDefaultLocale(),
                $laravelLocalization->getSupportedLocales(),
                $request
            );
            $negotiated = $negotiator->negotiateLanguage();
            if ($negotiated && $laravelLocalization->checkLocaleInSupportedLocales($negotiated)) {
                $locale = $negotiated;
                session(['locale' => $locale]);
            }
        }

        if ($locale === null || ! $laravelLocalization->checkLocaleInSupportedLocales($locale)) {
            $locale = $default;
            session(['locale' => $locale]);
        }

        LaravelLocalization::setLocale($locale);

        return $next($request);
    }
}
