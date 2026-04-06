<?php


function admin_id($payment_method): int
{
    switch ($payment_method) {
        case 'fawry':
            return 3001;


        default:
            return 3001;
    }
}


function isSeatAvailable($seat_id, $runTrip_id, $tripData_id, $line_id)
{
    $tripSeat = \App\Models\TripSeat::find($seat_id);
    $bookingSeats = \App\Models\BookingSeat::where([
        'runTrip_id' => $runTrip_id,
        'seat_id' => $tripSeat->id
    ])->get();
    foreach ($bookingSeats as $key => $bookingSeat) {
        $bookedFrom = \App\Models\TripStation::find($bookingSeat->tripStationFrom_id)->rank;
        $bookedTo = \App\Models\TripStation::find($bookingSeat->tripStationTo_id)->rank;
        //
        $line = \App\Models\Line::find($line_id);
        $searchFrom = \App\Models\TripStation::where([
            'station_id' => $line->from_id,
            'tripData_id' => $tripData_id,
        ])->first()->rank;
        $searchTo = \App\Models\TripStation::where([
            'station_id' => $line->to_id,
            'tripData_id' => $tripData_id,
        ])->first()->rank;
        //

        if (
            ($bookedFrom <= $searchFrom && $searchFrom < $bookedTo)
            || ($bookedFrom < $searchTo && $searchTo <= $bookedTo)
            || ($bookedFrom >= $searchFrom && $searchTo >= $bookedTo)
        ) {

            return $bookingSeat;
        }
    }
    return null;
}

function payment_status($status)
{
    if ($status == "PAID" || $status == "CAPTURED" || $status == "pending") {
        return __('Payment confirmed');
    } elseif ($status == "CANCELED") {
        return __('Payment cancelled');
    } elseif ($status == "NEW" || $status == "New") {
        return __('Payment pending');
    }

    return __('Payment failed');
}






if (!function_exists('getSeoData')) {
    /**
     * Get SEO data for a given page.
     *
     * @param   $pageData
     * @return array
     */
    function getSeoData($pageData)
    {
        $locale = app()->getLocale();
        $metaTags = $pageData['meta_tags'] ?? [];

        $seoData = [
            'meta_title' => is_array($pageData['meta_title'] ?? null) ? ($pageData['meta_title'][$locale] ?? reset($pageData['meta_title'])) : ($pageData['meta_title'] ?? 'Default Meta Title'),

            'meta_description' => is_array($pageData['meta_description'] ?? null) ? ($pageData['meta_description'][$locale] ?? reset($pageData['meta_description'])) : ($pageData['meta_description'] ?? 'Default Meta Description'),

            'meta_keywords' => $metaTags['keywords'] ?? 'default, keywords',
            'meta_image' => $metaTags['image'] ?? 'default-image.jpg',

            'og_title' => is_array($metaTags['og_title'] ?? null) ? ($metaTags['og_title'][$locale] ?? reset($metaTags['og_title'])) : ($metaTags['og_title'] ?? ($pageData['meta_title'][$locale] ?? 'Default OG Title')),

            'og_description' => is_array($metaTags['og_description'] ?? null) ? ($metaTags['og_description'][$locale] ?? reset($metaTags['og_description'])) : ($metaTags['og_description'] ?? ($pageData['meta_description'][$locale] ?? 'Default OG Description')),

            'og_image' => $metaTags['og_image'] ?? $metaTags['image'] ?? 'default-og-image.jpg',
        ];

        return $seoData;
    }

}

function getSeatInfo($seat_id, $from_id, $to_id, $runTrip_id, $type)
{

    $seat = \App\Models\TripSeat::find($seat_id);
    $runTrip = \App\Models\RunTrip::find($runTrip_id);
    $line = \App\Models\Line::where([
        'from_id' => $from_id,
        'to_id' => $to_id,
        'tripData_id' => $runTrip->tripData_id
    ])->first();


    return [
        'tripSeat_id' => $seat_id,
        'name' => $seat->seat->name,
        'price' => $type == 'back' ? $line->priceBack - $line->priceGo : $line->priceGo,
        'round_price' => $line->priceBack,

    ];
}



use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

function extractTranslations()
{
    // مسارات الملفات
    $viewTranslations = resource_path('views');
    $requestTranslations = app_path('Http/Requests');
    $controllerTranslations = app_path('Http/Controllers');
    $paths = [$viewTranslations, $requestTranslations, $controllerTranslations];
    $translations = [];

    $files = File::allFiles($paths);

    // تحميل الترجمة الحالية من ملف ar.json
    $langPath = resource_path('lang/ar.json');
    $existingTranslations = File::exists($langPath) ? json_decode(File::get($langPath), true) : [];

    // البحث في كل الملفات
    foreach ($files as $file) {
        $content = File::get($file->getRealPath());

        // البحث عن جميع النصوص داخل __('...') أو trans('...')
        preg_match_all("/__\(['\"](.*?)['\"]\)/", $content, $matches1);
        preg_match_all("/trans\(['\"](.*?)['\"]\)/", $content, $matches2);

        // دمج جميع النصوص المستخرجة بدون تكرار
        $matches = array_merge($matches1[1], $matches2[1]);

        foreach ($matches as $key) {
            // إضافة المفتاح إذا لم يكن موجودًا مسبقًا
            if (!array_key_exists($key, $existingTranslations)) {
                $translations[$key] = $key; // Optional: set placeholder value for new keys
            }
        }
    }
    return $translations;
}


if (!function_exists('render_stars')) {
    function render_stars($rate)
    {
        $fullStars = floor($rate);
        $halfStar = ($rate - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

        $starsHtml = '';

        for ($i = 0; $i < $fullStars; $i++) {
            $starsHtml .= '<i class="fas fa-star text-warning"></i>';
        }

        if ($halfStar) {
            $starsHtml .= '<i class="fas fa-star-half-alt text-warning"></i>';
        }

        for ($i = 0; $i < $emptyStars; $i++) {
            $starsHtml .= '<i class="fas fa-star text-secondary"></i>';
        }

        return $starsHtml;
    }
}

if (!function_exists('admin_dashboard_setting')) {
    /**
     * Get a dashboard (admin UI) setting with safe fallback when table is missing.
     */
    function admin_dashboard_setting(string $key, $default = null)
    {
        if (! Schema::hasTable('dash_setting')) {
            return $default;
        }

        return \App\Models\DashSetting::get($key, $default);
    }
}

if (!function_exists('getCurrentLocale')) {
    function getCurrentLocale(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('getDirection')) {
    function getDirection(): string
    {
        return getCurrentLocale() === 'ar' ? 'rtl' : 'ltr';
    }
}

if (!function_exists('isRTL')) {
    function isRTL(): bool
    {
        return getDirection() === 'rtl';
    }
}

if (!function_exists('dashboard_setting')) {
    function dashboard_setting(string $key, $default = null)
    {
        return admin_dashboard_setting($key, $default);
    }
}

if (!function_exists('dashboard_logo')) {
    function dashboard_logo(string $type = 'sidebar'): string
    {
        $key = "logo.{$type}";
        $logo = dashboard_setting($key, 'images/logo.png');

        if (is_string($logo) && (str_starts_with($logo, 'img/') || str_starts_with($logo, 'images/'))) {
            return asset($logo);
        }

        if (is_string($logo) && $logo !== '') {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($logo);
        }

        return asset('images/logo.png');
    }
}

if (!function_exists('dashboard_favicon')) {
    function dashboard_favicon(): string
    {
        $favicon = dashboard_setting('favicon', 'images/favicon/favicon.svg');

        if (is_string($favicon) && (str_starts_with($favicon, 'img/') || str_starts_with($favicon, 'images/'))) {
            return asset($favicon);
        }

        if (is_string($favicon) && $favicon !== '') {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($favicon);
        }

        return asset('images/favicon/favicon.svg');
    }
}

if (!function_exists('dashboard_favicon_mime')) {
    /**
     * MIME type for the primary favicon link (matches stored path extension).
     */
    function dashboard_favicon_mime(): string
    {
        $favicon = (string) dashboard_setting('favicon', 'images/favicon/favicon.svg');
        $lower = strtolower($favicon);

        if (str_ends_with($lower, '.svg')) {
            return 'image/svg+xml';
        }
        if (str_ends_with($lower, '.ico')) {
            return 'image/x-icon';
        }

        return 'image/png';
    }
}

if (!function_exists('dashboard_project_name')) {
    function dashboard_project_name(): string
    {
        return (string) dashboard_setting('project_name', config('app.name', 'Laravel'));
    }
}

if (!function_exists('dashboard_copyright_link')) {
    function dashboard_copyright_link(): string
    {
        return (string) dashboard_setting('copyright.link', (string) config('app.url', '#'));
    }
}

if (!function_exists('dashboard_copyright_text')) {
    function dashboard_copyright_text(): string
    {
        return (string) dashboard_setting('copyright.text', config('app.name', 'Laravel'));
    }
}

if (!function_exists('dashboard_color')) {
    function dashboard_color(string $colorName): string
    {
        $defaults = [
            'primary' => '#D52034',
            'secondary' => '#3A3A3A',
            'success' => '#1B7F4F',
            'info' => '#0C4A6E',
            'warning' => '#C9A227',
            'danger' => '#9B1C26',
        ];

        $key = "color.{$colorName}";

        return (string) dashboard_setting($key, $defaults[$colorName] ?? '#D52034');
    }
}

if (!function_exists('dashboard_color_rgb')) {
    /**
     * Comma-separated RGB for CSS (e.g. "213, 32, 52") from stored hex color.
     */
    function dashboard_color_rgb(string $colorName): string
    {
        $hex = ltrim(dashboard_color($colorName), '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        if (strlen($hex) !== 6 || ! ctype_xdigit($hex)) {
            return '213, 32, 52';
        }

        return hexdec(substr($hex, 0, 2)) . ', ' . hexdec(substr($hex, 2, 2)) . ', ' . hexdec(substr($hex, 4, 2));
    }
}

if (!function_exists('dashboard_logo_dimensions')) {
    function dashboard_logo_dimensions(string $type): array
    {
        $dimensions = [
            'sidebar' => ['width' => 98, 'height' => 36, 'description' => 'Preferred: 98x36'],
            'auth' => ['width' => 200, 'height' => 60, 'description' => 'Preferred: 200x60'],
            'favicon' => ['width' => 32, 'height' => 32, 'description' => 'Preferred: 32x32'],
        ];

        return $dimensions[$type] ?? ['width' => 120, 'height' => 36, 'description' => 'Logo'];
    }
}
