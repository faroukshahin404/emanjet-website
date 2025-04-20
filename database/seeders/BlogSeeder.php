<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'أفضل الوجهات',
            'نصائح السفر',
            'أماكن تستحق الزيارة',
            'تجارب المسافرين',
            'خدمات الباصات',
        ];

        foreach ($categories as $catName) {
            $category = BlogCategory::updateOrCreate(['name' => $catName], [
                'name' => $catName,
                'slug' => Str::slug($catName),
            ]);

            for ($i = 1; $i <= 3; $i++) {
                Blog::updateOrCreate(['title' => "مقال رقم $i عن {$catName}",], [
                    'title' => "مقال رقم $i عن {$catName}",
                    'content' => "هذا المحتوى يشرح تفاصيل مهمة للمسافرين عن {$catName}. المقال رقم $i يشمل نصائح ومعلومات قيّمة.",
                    'image' => "https://placehold.co/600x400?text={$i}+{$category->id}",
                    'category_id' => $category->id,
                    'views' => rand(100, 1000),
                    'likes' => rand(10, 300),
                    'reading_time' => rand(5, 15),
                    'meta_title' => "سوبر جيت - {$catName} | مقال $i",
                    'meta_description' => "اكتشف كل ما يتعلق بـ {$catName} في مقال رقم $i على موقع سوبر جيت.",
                    'meta_tags' => json_encode([
                        'keywords' => "{$catName}, سفر, رحلات, SuperJet",
                        'image' => "https://via.placeholder.com/800x400?text={$i}+{$category->id}",
                        'og_title' => "Super Jet | {$catName} - مقال $i",
                        'og_description' => "مقال شامل من سوبر جيت عن {$catName}، رقم $i.",
                        'og_image' => "https://via.placeholder.com/1200x630?text=OG+{$i}+{$category->id}",
                    ]),
                ]);
            }
        }
    }
}
