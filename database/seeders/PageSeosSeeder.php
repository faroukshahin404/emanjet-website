<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSeo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $generalSeos = [
            [
                'page_slug' => 'general',
                'section_type' => 'contact-us',
                'content_json' => json_encode([
                    'phone' => '010000000',
                    'whatsapp' => '01000000',
                    'email' => 'Info@superje',
                    'complaints_email' => 'customer-complaints@superjet-eg.com',
                    // 'address' => 'العنوان',
                    // 'working_hours' => 'من 9 صباحا حتى 5 مساءا',
                    // 'working_days' => 'من السبت إلى الخميس',
                ]),
                'order' => 1,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'general',
                'section_type' => 'social-media',
                'content_json' => json_encode([
                    'facebook' => 'https://www.facebook.com/superjet',
                    'twitter' => 'https://twitter.com/superjet',
                    'instagram' => 'https://www.instagram.com/superjet',
                    'linkedin' => 'https://www.linkedin.com/company/superjet',
                ]),
                'order' => 2,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'general',
                'section_type' => 'apps',
                'content_json' => json_encode([
                    'android' => 'https://play.google.com/store/apps/details?id=com.superjet',
                    'ios' => 'https://apps.apple.com/app/superjet/id1234567890',
                ]),
                'order' => 3,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];


        $homeSeos = [
            [
                'page_slug' => 'home',
                'section_type' => 'hero-section',
                'content_json' => json_encode([
                    'card-title' => 'مرحبا بكم في موقعنا',
                    'image' => 'https://placehold.co/400',
                    'caption-title' => 'نحن هنا لمساعدتك',
                    'caption-description' => 'تصفح موقعنا واكتشف المزيد',
                ]),
                'order' => 1,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'home',
                'section_type' => 'any-where',
                'content_json' => json_encode([
                    'title' => 'تصفح من أي مكان',
                    'description' => 'يمكنك الوصول إلى موقعنا من أي مكان في العالم',
                    'image' => 'https://placehold.co/400',
                ]),
                'order' => 2,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'home',
                'section_type' => 'payment-methods',
                'content_json' => json_encode([
                    'title' => 'طرق الدفع',
                    'images' => [
                        'https://placehold.co/400',
                        'https://placehold.co/400',
                        'https://placehold.co/400',
                        'https://placehold.co/400',
                        'https://placehold.co/400',
                        'https://placehold.co/400',
                    ],
                ]),
                'order' => 3,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'home',
                'section_type' => 'reservation',
                'content_json' => json_encode([
                    'title' => 'احجز الآن',
                    'description' => 'احجز موعدك الآن واستمتع بخدماتنا',
                    'image' => 'https://placehold.co/400',
                ]),
                'order' => 4,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $destinationSeos = [
            [
                'page_slug' => 'destinations',
                'section_type' => 'try',
                'content_json' => json_encode([
                    'title' => 'جربه الآن',
                    'description' => 'احجز الآن واستمتع بتجربة فريدة',
                    'image' => 'https://placehold.co/400',
                ]),
                'order' => 1,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'destinations',
                'section_type' => 'app',
                'content_json' => json_encode([
                    'title' => 'تطبيقنا',
                    'description' => 'قم بتنزيل تطبيقنا الآن واستمتع بتجربة فريدة',
                    'image' => 'https://placehold.co/400',
                ]),
                'order' => 2,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $blogsSeos = [
            [
                'page_slug' => 'blogs',
                'section_type' => 'hero-section',
                'content_json' => json_encode([
                    'title' => 'وجهاتنا',
                    'description' => 'استكشف وجهاتنا المتنوعة',
                    'image' => 'https://placehold.co/400',
                ]),
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ],
            [
                'page_slug' => 'blogs',
                'section_type' => 'trip-start',
                'content_json' => json_encode([
                    'title' => 'ابدأ رحلتك',
                    'description' => 'احجز الآن واستمتع بتجربة فريدة',
                    'button-text' => 'احجز الآن',
                    'images' => [
                        'https://placehold.co/400',
                        'https://placehold.co/400',
                        'https://placehold.co/400',
                    ]
                ]),
                'order' => 2,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $aboutSeos = [
            [
                'page_slug' => 'about-us',
                'section_type' => 'hero-section',
                'content_json' => json_encode([
                    'title' => 'من نحن',
                    'description' => 'نحن هنا لمساعدتك',
                    'image' => 'https://placehold.co/400',
                ]),
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ],
            [
                'page_slug' => 'about-us',
                'section_type' => 'services',
                'content_json' => json_encode([
                    'vision' => 'رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                    'mission' => 'مهمتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                    'values' => 'قيمنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                    'branches' => 'فروع سوبر جيت: رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                    'routes' => 'خطوط سوبر جيت: رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                    'payment_methods' => 'طرق الدفع: رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                    'safety_and_comfort' => 'رفاهية وأمان: رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                ]),
                'order' => 2,
                'status' => true,
                'created_at' => now(),
            ]
        ];

        $contactSeos = [
            [
                'page_slug' => 'contact-us',
                'section_type' => 'contact-form',
                'content_json' => json_encode([
                    'title' => 'نموذج الاتصال',
                    'description' => 'يرجى ملء النموذج أدناه وسنقوم بالرد عليك في أقرب وقت ممكن.',
                    'image' => 'https://placehold.co/400',
                    'button-text' => 'إرسال',
                ]),
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ]
        ];

        $faqsSeos = [
            [
                'page_slug' => 'faqs',
                'section_type' => 'hero-section',
                'content_json' => json_encode([
                    'title' => 'الأسئلة الشائعة',
                    'description' => 'إذا كان لديك أي استفسارات، يرجى مراجعة الأسئلة الشائعة أدناه.',
                    'image' => 'https://placehold.co/400',
                ]),
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ],
            [
                'page_slug' => 'faqs',
                'section_type' => 'faq-list',
                'content_json' => json_encode([
                    'faqs' => [
                        [
                            'question' => 'ما هي سياسة الإلغاء؟',
                            'answer' => 'يمكنك إلغاء الحجز قبل 24 ساعة من موعد الرحلة.',
                        ],
                        [
                            'question' => 'كيف يمكنني تغيير موعد الرحلة؟',
                            'answer' => 'يمكنك تغيير موعد الرحلة من خلال الاتصال بخدمة العملاء.',
                        ],
                        [
                            'question' => 'ما هي طرق الدفع المتاحة؟',
                            'answer' => 'نقبل الدفع نقدًا وبطاقات الائتمان والخصم.',
                        ],
                        [
                            'question' => 'هل يمكنني استرداد المبلغ؟',
                            'answer' => 'نعم، يمكنك استرداد المبلغ وفقًا لسياسة الإلغاء.',
                        ],
                        [
                            'question' => 'هل يمكنني تغيير اسم المسافر بعد الحجز؟',
                            'answer' => 'نعم، يمكنك تغيير اسم المسافر قبل 24 ساعة من موعد الرحلة.',
                        ],
                        [
                            'question' => 'ما هي سياسة الأمتعة؟',
                            'answer' => 'يمكنك حمل حقيبة واحدة بحد أقصى 20 كجم.',
                        ],
                        [
                            'question' => 'هل هناك خصومات للطلاب؟',
                            'answer' => 'نعم، نقدم خصومات خاصة للطلاب عند تقديم بطاقة الطالب.',
                        ]
                    ]
                ]),
                'order' => 2,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $seos = array_merge($generalSeos, $homeSeos, $aboutSeos, $contactSeos, $destinationSeos, $blogsSeos, $faqsSeos);

        foreach ($seos as $seo) {
            $page = Page::where('slug', $seo['page_slug'])->first();
            if ($page) {
                PageSeo::updateOrInsert(
                    [
                        'page_id' => $page->id,
                        'section_type' => $seo['section_type'],
                    ],
                    [
                        'content_json' => $seo['content_json'],
                        'order' => $seo['order'],
                        'status' => $seo['status'] ?? true,
                        'created_at' => $seo['created_at'] ?? now(),
                        'updated_at' => $seo['updated_at'] ?? now(),
                    ]
                );
            }
        }
    }
}
