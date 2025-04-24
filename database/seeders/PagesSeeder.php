<?php
namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSeo;
use DB;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // تعطيل التحقق من القيود
        Page::truncate(); // حذف جميع السجلات من جدول الشهادات
        PageSeo::truncate(); // حذف جميع السجلات من جدول الشهادات
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // تفعيل التحقق من القيود

        $pages = [
            [
                'title' => ['ar' => 'عام', 'en' => 'General'],
                'slug' => 'general',
                'meta_title' => ['ar' => 'عام', 'en' => 'General'],
                'meta_description' => ['ar' => 'معلومات عامة عن الموقع.', 'en' => 'General information about the website.'],
                'meta_tags' => [
                    'ar' => [
                        'keywords' => 'عام, معلومات',
                        'image' => 'general-page-image.jpg',
                        'og_title' => 'معلومات عامة',
                        'og_description' => 'معلومات عامة عن الموقع.',
                        'og_image' => 'general-page-og-image.jpg',
                    ],
                    'en' => [
                        'keywords' => 'general, information',
                        'image' => 'general-page-image.jpg',
                        'og_title' => 'General Information',
                        'og_description' => 'General information about the website.',
                        'og_image' => 'general-page-og-image.jpg',
                    ],
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => ['ar' => 'الصفحة الرئيسية', 'en' => 'Home'],
                'slug' => 'home',
                'meta_title' => ['ar' => 'مرحبًا بكم في موقعنا', 'en' => 'Welcome to Our Website'],
                'meta_description' => ['ar' => 'هذه الصفحة الرئيسية لموقعنا.', 'en' => 'This is the homepage of our website.'],
                'meta_tags' => [
                    'ar' => [
                        'keywords' => 'الرئيسية, مرحبا, الموقع',
                        'image' => 'home-page-image.jpg',
                        'og_title' => 'مرحبًا بكم في موقعنا',
                        'og_description' => 'هذه الصفحة الرئيسية لموقعنا.',
                        'og_image' => 'home-page-og-image.jpg',
                    ],
                    'en' => [
                        'keywords' => 'home, welcome, website',
                        'image' => 'home-page-image.jpg',
                        'og_title' => 'Welcome to Our Website',
                        'og_description' => 'This is the homepage of our website.',
                        'og_image' => 'home-page-og-image.jpg',
                    ],
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => ['ar' => 'من نحن', 'en' => 'About Us'],
                'slug' => 'about-us',
                'meta_title' => ['ar' => 'تعرف علينا', 'en' => 'Learn About Us'],
                'meta_description' => ['ar' => 'معلومات عن شركتنا وفريقنا.', 'en' => 'Information about our company and team.'],
                'meta_tags' => [
                    'ar' => [
                        'keywords' => 'عن, الشركة, الفريق',
                        'image' => 'about-page-image.jpg',
                        'og_title' => 'تعرف علينا',
                        'og_description' => 'معلومات عن شركتنا وفريقنا.',
                        'og_image' => 'about-page-og-image.jpg',
                    ],
                    'en' => [
                        'keywords' => 'about, company, team',
                        'image' => 'about-page-image.jpg',
                        'og_title' => 'Learn About Us',
                        'og_description' => 'Information about our company and team.',
                        'og_image' => 'about-page-og-image.jpg',
                    ],
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => ['ar' => 'اتصل بنا', 'en' => 'Contact Us'],
                'slug' => 'contact-us',
                'meta_title' => ['ar' => 'اتصل بنا', 'en' => 'Get in Touch'],
                'meta_description' => ['ar' => 'معلومات الاتصال ونموذج للوصول إلينا.', 'en' => 'Contact information and form to reach us.'],
                'meta_tags' => [
                    'ar' => [
                        'keywords' => 'اتصال, دعم, تواصل',
                        'image' => 'contact-page-image.jpg',
                        'og_title' => 'اتصل بنا',
                        'og_description' => 'معلومات الاتصال ونموذج للوصول إلينا.',
                        'og_image' => 'contact-page-og-image.jpg',
                    ],
                    'en' => [
                        'keywords' => 'contact, reach us, support',
                        'image' => 'contact-page-image.jpg',
                        'og_title' => 'Get in Touch',
                        'og_description' => 'Contact information and form to reach us.',
                        'og_image' => 'contact-page-og-image.jpg',
                    ],
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => ['ar' => 'الوجهات', 'en' => 'Destinations'],
                'slug' => 'destinations',
                'meta_title' => ['ar' => 'استكشف وجهاتنا', 'en' => 'Explore Our Destinations'],
                'meta_description' => ['ar' => 'اكتشف أفضل الأماكن للزيارة.', 'en' => 'Discover the best places to visit.'],
                'meta_tags' => [
                    'ar' => [
                        'keywords' => 'وجهات, سفر, استكشاف',
                        'image' => 'destinations-page-image.jpg',
                        'og_title' => 'استكشف وجهاتنا',
                        'og_description' => 'اكتشف أفضل الأماكن للزيارة.',
                        'og_image' => 'destinations-page-og-image.jpg',
                    ],
                    'en' => [
                        'keywords' => 'destinations, travel, explore',
                        'image' => 'destinations-page-image.jpg',
                        'og_title' => 'Explore Our Destinations',
                        'og_description' => 'Discover the best places to visit.',
                        'og_image' => 'destinations-page-og-image.jpg',
                    ],
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => ['ar' => 'المدونات', 'en' => 'Blogs'],
                'slug' => 'blogs',
                'meta_title' => ['ar' => 'أحدث المدونات', 'en' => 'Latest Blogs'],
                'meta_description' => ['ar' => 'اقرأ أحدث المدونات والمقالات.', 'en' => 'Read our latest blogs and articles.'],
                'meta_tags' => [
                    'ar' => [
                        'keywords' => 'مدونات, مقالات, أخبار',
                        'image' => 'blogs-page-image.jpg',
                        'og_title' => 'أحدث المدونات',
                        'og_description' => 'اقرأ أحدث المدونات والمقالات.',
                        'og_image' => 'blogs-page-og-image.jpg',
                    ],
                    'en' => [
                        'keywords' => 'blogs, articles, news',
                        'image' => 'blogs-page-image.jpg',
                        'og_title' => 'Latest Blogs',
                        'og_description' => 'Read our latest blogs and articles.',
                        'og_image' => 'blogs-page-og-image.jpg',
                    ],
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => ['ar' => 'الأسئلة الشائعة', 'en' => 'FAQs'],
                'slug' => 'faqs',
                'meta_title' => ['ar' => 'الأسئلة الشائعة', 'en' => 'Frequently Asked Questions'],
                'meta_description' => ['ar' => 'ابحث عن إجابات للأسئلة الشائعة.', 'en' => 'Find answers to common questions.'],
                'meta_tags' => [
                    'ar' => [
                        'keywords' => 'أسئلة, إجابات, دعم',
                        'image' => 'faqs-page-image.jpg',
                        'og_title' => 'الأسئلة الشائعة',
                        'og_description' => 'ابحث عن إجابات للأسئلة الشائعة.',
                        'og_image' => 'faqs-page-og-image.jpg',
                    ],
                    'en' => [
                        'keywords' => 'faqs, questions, answers',
                        'image' => 'faqs-page-image.jpg',
                        'og_title' => 'Frequently Asked Questions',
                        'og_description' => 'Find answers to common questions.',
                        'og_image' => 'faqs-page-og-image.jpg',
                    ],
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => ['ar' => 'سياسة الخصوصية', 'en' => 'Privacy Policy'],
                'slug' => 'privacy-policy',
                'meta_title' => ['ar' => 'سياسة الخصوصية', 'en' => 'Privacy Policy'],
                'meta_description' => ['ar' => 'تعرف على سياسة الخصوصية وكيفية حماية بياناتك الشخصية', 'en' => 'Learn about our privacy policy and how we protect your personal data'],
                'meta_tags' => [
                    'ar' => [
                        'keywords' => 'سياسة الخصوصية, حماية البيانات, الخصوصية',
                        'image' => 'privacy-policy-image.jpg',
                        'og_title' => 'سياسة الخصوصية',
                        'og_description' => 'اقرأ أحدث المدونات والمقالات.',
                        'og_image' => 'blogs-page-og-image.jpg',
                    ],
                    'en' => [
                        'keywords' => 'privacy policy, data protection, privacy, terms',
                        'image' => 'privacy-policy-image.jpg',
                        'og_title' => 'Privacy Policy',
                        'og_description' => 'Learn about our privacy policy and how we protect your personal data',
                        'og_image' => 'privacy-policy-og-image.jpg',
                    ],
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => ['ar' => 'شروط الاستخدام', 'en' => 'Terms of Use'],
                'slug' => 'usage-terms',
                'meta_title' => ['ar' => 'شروط الاستخدام', 'en' => 'Terms of Use'],
                'meta_description' => ['ar' => 'تعرف على شروط استخدام موقعنا وخدماتنا', 'en' => 'Learn about the terms and conditions for using our website and services'],
                'meta_tags' => [
                    'ar' => [
                        'keywords' => 'شروط الاستخدام, الشروط والأحكام, القواعد',
                        'image' => 'terms-of-use-image.jpg',
                        'og_title' => 'شروط الاستخدام',
                        'og_description' => 'تعرف على شروط استخدام موقعنا وخدماتنا',
                        'og_image' => 'terms-of-use-og-image.jpg',
                    ],
                    'en' => [
                        'keywords' => 'terms of use, terms and conditions, rules',
                        'image' => 'terms-of-use-image.jpg',
                        'og_title' => 'Terms of Use',
                        'og_description' => 'Learn about the terms and conditions for using our website and services',
                        'og_image' => 'terms-of-use-og-image.jpg',
                    ],
                ],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'meta_title' => $page['meta_title'],
                    'meta_description' => $page['meta_description'],
                    'meta_tags' => $page['meta_tags'],
                    'status' => $page['status'],
                    'created_at' => $page['created_at'],
                    'updated_at' => $page['updated_at'],
                ],
            );
        }
    }
}
