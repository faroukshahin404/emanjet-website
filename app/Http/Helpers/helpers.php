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





if (!function_exists('getSeoData')) {
    /**
     * Get SEO data for a given page.
     *
     * @param   $pageData
     * @return array
     */
    function getSeoData($pageData)
    {
        // التأكد من أن meta_tags موجودة وإذا كانت كائن أو مصفوفة
        $metaTags = $pageData['meta_tags'] ?? [];

        // التأكد من وجود meta_tags في حالة كونها كائنًا أو مصفوفة فارغة
        $seoData = [
            'meta_title' => $pageData['meta_title'] ?? 'Default Meta Title',
            'meta_description' => $pageData['meta_description'] ?? 'Default Meta Description',
            'meta_keywords' => $metaTags['keywords'] ?? 'default, keywords',
            'meta_image' => $metaTags['image'] ?? 'default-image.jpg',
            'og_title' => $metaTags['og_title'] ?? $pageData['meta_title'],
            'og_description' => $metaTags['og_description'] ?? $pageData['meta_description'],
            'og_image' => $metaTags['og_image'] ?? $metaTags['image'] ?? 'default-og-image.jpg', // افتراض صورة افتراضية في حال غياب `og_image`
        ];

        return $seoData;
    }
}
