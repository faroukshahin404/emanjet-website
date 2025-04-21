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
                    'card-title' => 'احجز رحلتك دلوقتي!',
                    'image' => 'https://placehold.co/1675x700',
                    'caption-title' => 'نحن هنا لمساعدتك',
                    'caption-description' => 'احجز رحلتك مع السوبر جيت وادفع بالبطاقة الائتمانية في لحظة!',
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
                    'title' => 'سوبر جيت معك في آي مكان',
                    'description' => 'لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.

                    و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب الألم الذي ربما تنجم عنه بعض المتعة ؟',
                    'image' => 'https://placehold.co/745x677',
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
                    'title' => 'اختر طريقة الدفع اللي تناسبك',
                    'images' => [
                        'https://placehold.co/170x60',
                        'https://placehold.co/170x60',
                        'https://placehold.co/170x60',
                        'https://placehold.co/170x60',
                        'https://placehold.co/170x60',
                        'https://placehold.co/170x60',
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
                    'title' => 'انطلق إلى سحر شواطئ مصر الخلابة واستمتع بالمياه الفيروزية والأجواء المنعشة!',
                    'description' => 'لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.',
                    'image' => 'https://placehold.co/1657x550',
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
                'section_type' => 'hero-section',
                'content_json' => json_encode([
                    'search-title' => 'مسافر علي فين؟',
                    'image' => 'https://placehold.co/1657x600',
                ]),
                'order' => 1,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'destinations',
                'section_type' => 'try',
                'content_json' => json_encode([
                    'title' => 'جربه الآن',
                    'description' => 'احجز الآن واستمتع بتجربة فريدة',
                    'image' => 'https://placehold.co/805x475',
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
                    'image' => 'https://placehold.co/450x577',
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
                    'description' => 'استكشف مجموعة متنوعة من الوجهات المميزة التي نوفرها عبر خطوطنا المنتشرة في جميع أنحاء الجمهورية. سواء كنت تبحث عن رحلة عمل سريعة أو عطلة للاسترخاء، فإننا نقدم لك خيارات متعددة تناسب جميع احتياجاتك. نضمن لك تجربة سفر مريحة وآمنة، مع الالتزام بأعلى معايير الجودة والاحترافية. اكتشف الآن وجهتك القادمة مع سوبر جيت!',
                    'image' => 'https://placehold.co/805x668',
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
                    'description' => 'ابدأ مغامرتك مع سوبر جيت! احجز رحلتك بسهولة واستمتع بتجربة مريحة وآمنة عبر منصتنا الإلكترونية. اختر وجهتك المفضلة واستعد لاكتشاف عالم جديد من التنقل العصري.',

                    'button-text' => 'احجز الآن',
                    'images' => [
                        'https://placehold.co/208x292',
                        'https://placehold.co/208x196',
                        'https://placehold.co/209x127',
                        'https://placehold.co/209x292',
                        'https://placehold.co/209x127',
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
                    'description' => 'نحن في سوبرجيت نؤمن بأهمية الراحة والأمان لعملائنا، ونسعى دائمًا لتقديم تجربة سفر متميزة تجمع بين الاحترافية والجودة. بفضل سنوات من الخبرة في مجال النقل والسفر، نعمل جاهدين على تحسين خدماتنا باستمرار لتلبي توقعات عملائنا وتفوقها. فريقنا ملتزم بتوفير أفضل وسائل الراحة، ودعم العملاء على مدار الساعة، وتقديم حلول مبتكرة تسهّل عليك رحلتك من البداية حتى النهاية.',
                    'image' => 'https://placehold.co/805x668',
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
                    'image' => 'https://placehold.co/805x668',
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
                    'description' => 'في هذا القسم، جمعنا لك أبرز الأسئلة التي قد تدور في ذهنك حول خدماتنا، الحجز، وسائل الراحة، وسياسات السفر المختلفة. هدفنا هو تقديم تجربة سهلة وواضحة لجميع عملائنا، لذلك نحرص دائمًا على الإجابة على كل استفسار بدقة ووضوح. إذا لم تجد إجابتك هنا، لا تتردد في التواصل معنا وسنكون سعداء بمساعدتك.',
                    'image' => 'https://placehold.co/805x668',
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
