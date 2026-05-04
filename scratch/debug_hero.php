<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Page;

$page = Page::where('slug', 'home')->first();
$homePageSeos = $page ? $page->pageSeos()->get() : collect();
$sectionType = 'hero-section';

$section = $homePageSeos
    ->where('section_type', $sectionType)
    ->where('status', true)
    ->first();

if ($section) {
    echo "Section found in DB:\n";
    print_r($section->translated_content_json);
} else {
    echo "Section NOT found in DB, using defaults.\n";
}
