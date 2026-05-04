<?php
namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');  // تعطيل التحقق من القيود
        BlogCategory::truncate();
        Blog::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');  // تفعيل التحقق من القيود

        $categories = [
            'أفضل الوجهات' => 'Top Destinations',
            'نصائح السفر' => 'Travel Tips',
            'أماكن تستحق الزيارة' => 'Places Worth Visiting',
            'تجارب المسافرين' => 'Travelers Experiences',
            'خدمات الباصات' => 'Bus Services',
        ];

        foreach ($categories as $catAr => $catEn) {
            $category = BlogCategory::updateOrCreate([
                'name' => [
                    'ar' => $catAr,
                    'en' => $catEn,
                ],
            ], [
                'name' => [
                    'ar' => $catAr,
                    'en' => $catEn,
                ],
                'slug' => Str::slug($catEn),
            ]);

            for ($i = 1; $i <= 3; $i++) {
                $titleAr = "مقال رقم $i عن {$catAr}";
                $titleEn = "Article #$i about {$catEn}";
                Blog::updateOrCreate([
                    'title' => [
                        'ar' => $titleAr,
                        'en' => $titleEn,
                    ],
                ], [
                    'title' => [
                        'ar' => $titleAr,
                        'en' => $titleEn,
                    ],
                    'content' => [
                        'ar' => "هذا المحتوى يشرح تفاصيل مهمة للمسافرين عن {$catAr}. المقال رقم $i يشمل نصائح ومعلومات قيّمة.",
                        'en' => "This content provides important details for travelers about {$catEn}. Article #$i includes tips and
    valuable information.",
                    ],
                    'image' => "https://placehold.co/600x400?text={$i}+{$category->id}",
                    'category_id' => $category->id,
                    'views' => rand(100, 1000),
                    'likes' => rand(10, 300),
                    'reading_time' => rand(5, 15),
                    'meta_title' => [
                        'ar' => "إيمان جيت - {$catAr} | مقال $i",
                        'en' => "Eman Jet - {$catEn} | Article $i",
                    ],
                    'meta_description' => [
                        'ar' => "اكتشف كل ما يتعلق بـ {$catAr} في مقال رقم $i على موقع إيمان جيت.",
                        'en' => "Discover everything about {$catEn} in Article #$i on Eman Jet website.",
                    ],
                    'meta_tags' => [
                        'ar' => [
                            'keywords' => "{$catAr}, سفر, رحلات, EmanJet",
                            'image' => "https://via.placeholder.com/800x400?text={$i}+{$category->id}",
                            'og_title' => "Eman Jet | {$catAr} - مقال $i",
                            'og_description' => "مقال شامل من إيمان جيت عن {$catAr}، رقم $i.",
                            'og_image' => "https://via.placeholder.com/1200x630?text=OG+{$i}+{$category->id}",
                        ],
                        'en' => [
                            'keywords' => "{$catEn}, travel, trips, EmanJet",
                            'image' => "https://via.placeholder.com/800x400?text={$i}+{$category->id}",
                            'og_title' => "Eman Jet | {$catEn} - Article $i",
                            'og_description' => "Comprehensive article from Eman Jet about {$catEn}, number $i.",
                            'og_image' => "https://via.placeholder.com/1200x630?text=OG+{$i}+{$category->id}",
                        ],
                    ],
                ]);
            }
        }
    }
}
