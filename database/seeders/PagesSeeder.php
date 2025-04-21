<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'general',
                'slug' => 'general',
                'meta_title' => 'General',
                'meta_description' => 'General information about the website.',
                'meta_tags' => [
                    'keywords' => 'general, information',
                    'image' => 'general-page-image.jpg',
                    'og_title' => 'General Information',
                    'og_description' => 'General information about the website.',
                    'og_image' => 'general-page-og-image.jpg',
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Home',
                'slug' => 'home',
                'meta_title' => 'Welcome to Our Website',
                'meta_description' => 'This is the homepage of our website.',
                'meta_tags' => [
                    'keywords' => 'home, welcome, website',
                    'image' => 'home-page-image.jpg',
                    'og_title' => 'Welcome to Our Website',
                    'og_description' => 'This is the homepage of our website.',
                    'og_image' => 'home-page-og-image.jpg',
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'meta_title' => 'Learn About Us',
                'meta_description' => 'Information about our company and team.',
                'meta_tags' => [
                    'keywords' => 'about, company, team',
                    'image' => 'about-page-image.jpg',
                    'og_title' => 'Learn About Us',
                    'og_description' => 'Information about our company and team.',
                    'og_image' => 'about-page-og-image.jpg',
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'meta_title' => 'Get in Touch',
                'meta_description' => 'Contact information and form to reach us.',
                'meta_tags' => [
                    'keywords' => 'contact, reach us, support',
                    'image' => 'contact-page-image.jpg',
                    'og_title' => 'Get in Touch',
                    'og_description' => 'Contact information and form to reach us.',
                    'og_image' => 'contact-page-og-image.jpg',
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Destinations',
                'slug' => 'destinations',
                'meta_title' => 'Explore Our Destinations',
                'meta_description' => 'Discover the best places to visit.',
                'meta_tags' => [
                    'keywords' => 'destinations, travel, explore',
                    'image' => 'destinations-page-image.jpg',
                    'og_title' => 'Explore Our Destinations',
                    'og_description' => 'Discover the best places to visit.',
                    'og_image' => 'destinations-page-og-image.jpg',
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // blogs
            [
                'title' => 'Blogs',
                'slug' => 'blogs',
                'meta_title' => 'Latest Blogs',
                'meta_description' => 'Read our latest blogs and articles.',
                'meta_tags' => [
                    'keywords' => 'blogs, articles, news',
                    'image' => 'blogs-page-image.jpg',
                    'og_title' => 'Latest Blogs',
                    'og_description' => 'Read our latest blogs and articles.',
                    'og_image' => 'blogs-page-og-image.jpg',
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'faqs',
                'slug' => 'faqs',
                'meta_title' => 'Frequently Asked Questions',
                'meta_description' => 'Find answers to common questions.',
                'meta_tags' => [
                    'keywords' => 'faqs, questions, answers',
                    'image' => 'faqs-page-image.jpg',
                    'og_title' => 'Frequently Asked Questions',
                    'og_description' => 'Find answers to common questions.',
                    'og_image' => 'faqs-page-og-image.jpg',
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $pages = collect($pages)->map(function ($page) {
            $page['meta_tags'] = json_encode($page['meta_tags']);
            return $page;
        })->toArray();
        foreach ($pages as $page) {
            Page::updateOrInsert(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'meta_title' => $page['meta_title'],
                    'meta_description' => $page['meta_description'],
                    'meta_tags' => $page['meta_tags'],
                    'status' => $page['status'],
                    'created_at' => $page['created_at'],
                    'updated_at' => $page['updated_at'],
                ]
            );
        }

    }
}
