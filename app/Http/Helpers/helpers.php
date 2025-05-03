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
        return 'مؤكد';
    } elseif ($status == "CANCELED") {
        return 'ملغي';
    } elseif ($status == "NEW" || $status == "New") {
        return "معلق";
    } else {
        return "فشل";
    }
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
                $translations[$key] = $key; // يمكن تخصيص القيمة هنا لتكون الترجمة الفارغة أو أي قيمة أخرى
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
