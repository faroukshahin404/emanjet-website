<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSeo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');  // تعطيل التحقق من القيود
        PageSeo::truncate();  // حذف جميع السجلات
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');  // تفعيل التحقق من القيود

        $contactDefault = [
            'email' => ['value' => 'Info@emanjet.com', 'visible' => true, 'icon_class' => 'fa-solid fa-envelope'],
            'phone' => ['value' => '010000000', 'visible' => true, 'icon_class' => 'fa-solid fa-phone'],
            'whatsapp' => ['value' => '01000000', 'visible' => true, 'icon_class' => 'fa-brands fa-whatsapp'],
            'complaints_email' => ['value' => 'customer-complaints@emanjet.com', 'visible' => true, 'icon_class' => 'fa-solid fa-headset'],
        ];
        $linksSeed = [
            ['icon_class' => 'fa-brands fa-facebook-f', 'url' => 'https://www.facebook.com/emanjet', 'visible' => true],
            ['icon_class' => 'fa-brands fa-twitter', 'url' => 'https://twitter.com/emanjet', 'visible' => true],
            ['icon_class' => 'fa-brands fa-instagram', 'url' => 'https://www.instagram.com/emanjet', 'visible' => true],
            ['icon_class' => 'fa-brands fa-linkedin-in', 'url' => 'https://www.linkedin.com/company/emanjet', 'visible' => true],
        ];

        $generalSeos = [
            [
                'page_slug' => 'general',
                'section_type' => 'social-media',
                'content_json' => [
                    'ar' => [
                        'links' => json_decode(json_encode($linksSeed), true),
                        'contact' => json_decode(json_encode($contactDefault), true),
                    ],
                    'en' => [
                        'links' => json_decode(json_encode($linksSeed), true),
                        'contact' => json_decode(json_encode($contactDefault), true),
                    ],
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'general',
                'section_type' => 'footer-about',
                'content_json' => [
                    'ar' => [
                        'description' => 'الإيمان جيت هي شريكك الموثوق لرحلات مريحة وآمنة عبر أنحاء المنطقة. نحن نقدم خدمات نقل فاخرة بتركيز عالٍ على الجودة ورضا المسافرين.',
                        'quick-links-title' => 'روابط سريعة',
                        'support-title' => 'الدعم',
                        'copyright-text' => 'جميع الحقوق محفوظة.',
                        'get-it-on' => 'احصل عليه من',
                    ],
                    'en' => [
                        'description' => 'Eman Jet is your trusted partner for comfortable and safe travel across the region. We provide premium bus services with a focus on quality and passenger satisfaction.',
                        'quick-links-title' => 'Quick Links',
                        'support-title' => 'Support',
                        'copyright-text' => 'All rights reserved.',
                        'get-it-on' => 'Get It On',
                    ],
                ],
                'order' => 2,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'general',
                'section_type' => 'newsletter',
                'content_json' => [
                    'ar' => [
                        'title' => 'النشرة البريدية',
                        'description' => 'اشترك في نشرتنا البريدية للحصول على أحدث التحديثات والعروض.',
                        'button-text' => 'انضم',
                        'email-placeholder' => 'بريدك الإلكتروني',
                    ],
                    'en' => [
                        'title' => 'Newsletter',
                        'description' => 'Subscribe to our newsletter for the latest updates and offers.',
                        'button-text' => 'Join',
                        'email-placeholder' => 'Your Email',
                    ],
                ],
                'order' => 3,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $homeSeos = [
            [
                'page_slug' => 'home',
                'section_type' => 'hero-section',
                'content_json' => [
                    'ar' => [
                        'card-title' => 'احجز رحلتك دلوقتي!',
                        'image' => 'https://placehold.co/1675x700',
                        'caption-title' => 'نحن هنا لمساعدتك',
                        'caption-description' => 'احجز رحلتك مع الإيمان جيت وادفع بالبطاقة الائتمانية في لحظة!',
                    ],
                    'en' => [
                        'card-title' => 'Book your trip now!',
                        'image' => 'https://placehold.co/1675x700',
                        'caption-title' => 'We are here to help you',
                        'caption-description' => 'Book your trip with Eman Jet and pay with your credit card instantly!',
                    ],
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'home',
                'section_type' => 'any-where',
                'content_json' => [
                    'ar' => [
                        'title' => 'الإيمان جيت معك في آي مكان',
                        'description' => 'لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.',
                        'image' => 'https://placehold.co/745x677',
                    ],
                    'en' => [
                        'title' => 'Eman Jet is with you anywhere',
                        'description' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.',
                        'image' => 'https://placehold.co/745x677',
                    ],
                ],
                'order' => 2,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'home',
                'section_type' => 'payment-methods',
                'content_json' => [
                    'ar' => [
                        'title' => 'اختر طريقة الدفع اللي تناسبك',
                        'images' => [
                            'https://placehold.co/170x60',
                            'https://placehold.co/170x60',
                            'https://placehold.co/170x60',
                            'https://placehold.co/170x60',
                            'https://placehold.co/170x60',
                            'https://placehold.co/170x60',
                        ],
                    ],
                    'en' => [
                        'title' => 'Choose the payment method that suits you',
                        'images' => [
                            'https://placehold.co/170x60',
                            'https://placehold.co/170x60',
                            'https://placehold.co/170x60',
                            'https://placehold.co/170x60',
                            'https://placehold.co/170x60',
                            'https://placehold.co/170x60',
                        ],
                    ],
                ],
                'order' => 3,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'home',
                'section_type' => 'popular-destinations',
                'content_json' => [
                    'ar' => [
                        'pre-title' => 'استكشف مصر',
                        'title' => 'وجهات شائعة',
                        'description' => 'استكشف أشهر الوجهات والمدن المصرية التي نصل إليها يومياً بأمان وراحة.',
                    ],
                    'en' => [
                        'pre-title' => 'EXPLORE EGYPT',
                        'title' => 'Popular Destinations',
                        'description' => 'Explore the most popular destinations and Egyptian cities we reach daily with safety and comfort.',
                    ],
                ],
                'order' => 4,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'home',
                'section_type' => 'reservation',
                'content_json' => [
                    'ar' => [
                        'title' => 'انطلق إلى سحر شواطئ مصر الخلابة واستمتع بالمياه الفيروزية والأجواء المنعشة!',
                        'description' => 'لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.',
                        'image' => 'https://placehold.co/1657x550',
                    ],
                    'en' => [
                        'title' => 'Head to the magic of Egypt\'s stunning beaches and enjoy the turquoise waters and refreshing atmosphere!',
                        'description' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.',
                        'image' => 'https://placehold.co/1657x550',
                    ],
                ],
                'order' => 5,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'home',
                'section_type' => 'advantage',
                'content_json' => [
                    'ar' => [
                        'pre-title' => 'مزايا الإيمان جيت',
                        'title' => 'ليه تختار الإيمان جيت؟',
                        'description' => 'نحن نقدم تجربة سفر تجمع بين الأمان والراحة وأحدث التقنيات لضمان أن تكون رحلتك مثالية.',
                        'items' => [
                            [
                                'icon' => 'fa-solid fa-shield',
                                'title' => 'الأمان والراحة',
                                'description' => 'يتم صيانة أسطولنا وفقاً لأعلى المعايير الدولية مع سائقين محترفين لراحة بالك.'
                            ],
                            [
                                'icon' => 'fa-solid fa-bus-simple',
                                'title' => 'أسطول حديث',
                                'description' => 'سافر في أحدث موديلات الحافلات المجهزة بواي فاي وتكييف ومقاعد مريحة لتجربة مميزة.'
                            ],
                            [
                                'icon' => 'fa-solid fa-ticket-simple',
                                'title' => 'حجز سهل',
                                'description' => 'احجز رحلاتك في ثوانٍ من خلال موقعنا أو تطبيق الهاتف مع خيارات دفع آمنة متعددة.'
                            ]
                        ]
                    ],
                    'en' => [
                        'pre-title' => 'THE EMAN JET ADVANTAGE',
                        'title' => 'Why Choose Eman Jet?',
                        'description' => 'We provide a travel experience that combines safety, comfort, and state-of-the-art technology to ensure your journey is perfect.',
                        'items' => [
                            [
                                'icon' => 'fa-solid fa-shield',
                                'title' => 'Safety & Comfort',
                                'description' => 'Our fleet is maintained to the highest international standards with professional drivers for your peace of mind.'
                            ],
                            [
                                'icon' => 'fa-solid fa-bus-simple',
                                'title' => 'Modern Fleet',
                                'description' => 'Travel in our latest-model buses equipped with Wi-Fi, air conditioning, and ergonomic seating for a premium experience.'
                            ],
                            [
                                'icon' => 'fa-solid fa-ticket-simple',
                                'title' => 'Easy Booking',
                                'description' => 'Book your trips in seconds through our website or mobile app with multiple secure payment options.'
                            ]
                        ]
                    ]
                ],
                'order' => 6,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'home',
                'section_type' => 'stats',
                'content_json' => [
                    'ar' => [
                        'items' => [
                            ['icon' => 'fa-solid fa-calendar-check', 'number' => '30+', 'label' => 'عاماً من التميز'],
                            ['icon' => 'fa-solid fa-city', 'number' => '50+', 'label' => 'مدينة نغطيها'],
                            ['icon' => 'fa-solid fa-users-viewfinder', 'number' => '2M+', 'label' => 'مسافر سعيد'],
                            ['icon' => 'fa-solid fa-shield', 'number' => '100%', 'label' => 'سجل أمان'],
                        ]
                    ],
                    'en' => [
                        'items' => [
                            ['icon' => 'fa-solid fa-calendar-check', 'number' => '30+', 'label' => 'Years of Excellence'],
                            ['icon' => 'fa-solid fa-city', 'number' => '50+', 'label' => 'Cities Covered'],
                            ['icon' => 'fa-solid fa-users-viewfinder', 'number' => '2M+', 'label' => 'Happy Travelers'],
                            ['icon' => 'fa-solid fa-shield', 'number' => '100%', 'label' => 'Safety Record'],
                        ]
                    ]
                ],
                'order' => 7,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'home',
                'section_type' => 'quality-commitment',
                'content_json' => [
                    'ar' => [
                        'pre-title' => 'التزامنا',
                        'title' => 'راحتك هي أولويتنا',
                        'items' => [
                            [
                                'icon' => 'fa-solid fa-clock-rotate-left',
                                'title' => 'الدقة في المواعيد',
                                'description' => 'نحن نقدر وقتك. رحلاتنا مجدولة بدقة سويسرية لضمان وصولك إلى وجهتك في الوقت المحدد تماماً.'
                            ],
                            [
                                'icon' => 'fa-solid fa-hand-holding-heart',
                                'title' => 'خدمة متميزة',
                                'description' => 'من الدعم المحلي إلى طاقم العمل المحترف على متن الحافلة، نوفر بيئة ترحيبية تجعل كل ميل متعة.'
                            ],
                            [
                                'icon' => 'fa-solid fa-snowflake',
                                'title' => 'مرافق فاخرة',
                                'description' => 'استمتع بواي فاي عالي السرعة، وتحكم منعش في المناخ، ومقاعد مريحة مصممة لأطول الرحلات المصرية.'
                            ]
                        ]
                    ],
                    'en' => [
                        'pre-title' => 'OUR COMMITMENT',
                        'title' => 'Your Comfort is Our Priority',
                        'items' => [
                            [
                                'icon' => 'fa-solid fa-clock-rotate-left',
                                'title' => 'Punctuality',
                                'description' => 'We value your time. Our trips are scheduled with Swiss precision to ensure you reach your destination exactly when expected.'
                            ],
                            [
                                'icon' => 'fa-solid fa-hand-holding-heart',
                                'title' => 'Superior Service',
                                'description' => 'From local support to professional onboard staff, we provide a hospitable environment that makes every mile a pleasure.'
                            ],
                            [
                                'icon' => 'fa-solid fa-snowflake',
                                'title' => 'Premium Amenities',
                                'description' => 'Enjoy high-speed Wi-Fi, refreshing climate control, and ergonomic seating designed for the longest Egyptian journeys.'
                            ]
                        ]
                    ]
                ],
                'order' => 8,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $destinationSeos = [
            [
                'page_slug' => 'destinations',
                'section_type' => 'hero-section',
                'content_json' => [
                    'ar' => [
                        'pre-title' => 'خطوطنا',
                        'title' => 'اكتشف مغامرتك القادمة',
                        'description' => 'استكشف أفضل الوجهات في جميع أنحاء البلاد مع الإيمان جيت. خدمات متميزة، رحلات آمنة، وتجارب لا تنسى.',
                        'search-title' => 'مسافر علي فين؟',
                        'image' => 'https://placehold.co/1657x600',
                    ],
                    'en' => [
                        'pre-title' => 'OUR ROUTES',
                        'title' => 'Discover Your Next Adventure',
                        'description' => 'Explore the best destinations across the country with Eman Jet. Premium services, safe journeys, and unforgettable experiences.',
                        'search-title' => 'Where are you traveling to?',
                        'image' => 'https://placehold.co/1657x600',
                    ],
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'destinations',
                'section_type' => 'popular-cities',
                'content_json' => [
                    'ar' => [
                        'pre-title' => 'سافر عبر البلاد',
                        'title' => 'استكشف المدن الشائعة',
                        'description' => 'مسارات منسقة لراحتك القصوى. اختر وجهتك واحجز تذكرتك في ثوانٍ.',
                    ],
                    'en' => [
                        'pre-title' => 'TRAVEL THE COUNTRY',
                        'title' => 'Explore Popular Cities',
                        'description' => 'Curated routes for your ultimate comfort. Choose your destination and book your ticket in seconds.',
                    ],
                ],
                'order' => 2,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'destinations',
                'section_type' => 'try',
                'content_json' => [
                    'ar' => [
                        'title' => 'جربه الآن',
                        'description' => 'احجز الآن واستمتع بتجربة مريحة',
                        'button-text' => 'ابحث عن رحلتك الآن',
                        'image' => 'https://placehold.co/805x475',
                    ],
                    'en' => [
                        'title' => 'Try it now',
                        'description' => 'Book now and enjoy a comfortable experience',
                        'button-text' => 'Find your trip now',
                        'image' => 'https://placehold.co/805x475',
                    ],
                ],
                'order' => 3,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $blogsSeos = [
            [
                'page_slug' => 'blogs',
                'section_type' => 'hero-section',
                'content_json' => [
                    'ar' => [
                        'pre-title' => 'قصصنا',
                        'title' => 'مدونة الإيمان جيت',
                        'description' => 'استكشف مجموعة متنوعة من الوجهات المميزة والقصص التي نوفرها عبر خطوطنا المنتشرة في جميع أنحاء الجمهورية. نضمن لك تجربة سفر مريحة وآمنة، مع الإيمان جيت!',
                        'image' => 'https://placehold.co/805x668',
                    ],
                    'en' => [
                        'pre-title' => 'OUR STORIES',
                        'title' => 'Eman Jet Blog',
                        'description' => 'Explore a variety of distinctive destinations and stories we provide through our widespread lines across the republic. We guarantee you a comfortable and safe travel experience with Eman Jet!',
                        'image' => 'https://placehold.co/805x668',
                    ],
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ],
            [
                'page_slug' => 'blogs',
                'section_type' => 'trip-start',
                'content_json' => [
                    'ar' => [
                        'title' => 'رحلاتك تبدأ من هنا',
                        'description' => 'انضم إلينا الآن وابدأ رحلتك القادمة مع أفضل خدمات النقل في مصر.',
                        'button-text' => 'احجز الآن',
                        'images' => [
                            'https://placehold.co/400x400?text=trip+1',
                            'https://placehold.co/400x400?text=trip+2',
                            'https://placehold.co/400x400?text=trip+3',
                            'https://placehold.co/400x400?text=trip+4',
                        ],
                    ],
                    'en' => [
                        'title' => 'Your journeys start here',
                        'description' => 'Join us now and start your next journey with the best transport services in Egypt.',
                        'button-text' => 'Book Now',
                        'images' => [
                            'https://placehold.co/400x400?text=trip+1',
                            'https://placehold.co/400x400?text=trip+2',
                            'https://placehold.co/400x400?text=trip+3',
                            'https://placehold.co/400x400?text=trip+4',
                        ],
                    ],
                ],
                'order' => 2,
                'status' => true,
                'created_at' => now(),
            ],
        ];

        $aboutSeos = [
            [
                'page_slug' => 'about-us',
                'section_type' => 'hero-section',
                'content_json' => [
                    'ar' => [
                        'pre-title' => 'من نحن',
                        'title' => 'من نحن',
                        'description' => 'نحن في الإيمان جيت نؤمن بأهمية الراحة والأمان لعملائنا، ونسعى دائمًا لتقديم تجربة سفر متميزة تجمع بين الاحترافية والجودة. فريقنا ملتزم بتوفير أفضل وسائل الراحة، ودعم العملاء على مدار الساعة، وتقديم حلول مبتكرة تسهّل عليك رحلتك من البداية حتى النهاية.',
                        'image' => 'https://placehold.co/805x668',
                        'stats' => [
                            ['number' => '10+', 'label' => 'سنوات الخبرة'],
                            ['number' => '50+', 'label' => 'خطوط السفر'],
                            ['number' => '+1M', 'label' => 'الركاب'],
                        ]
                    ],
                    'en' => [
                        'pre-title' => 'Who We Are',
                        'title' => 'About Us',
                        'description' => 'At Eman Jet, we believe in the importance of comfort and safety for our customers, and we always strive to provide a distinguished travel experience that combines professionalism and quality. Our team is committed to providing the best amenities, 24/7 customer support, and innovative solutions that make your journey easier from start to finish.',
                        'image' => 'https://placehold.co/805x668',
                        'stats' => [
                            ['number' => '10+', 'label' => 'YEARS'],
                            ['number' => '50+', 'label' => 'ROUTES'],
                            ['number' => '+1M', 'label' => 'PASSENGERS'],
                        ]
                    ],
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ],
            [
                'page_slug' => 'about-us',
                'section_type' => 'services',
                'content_json' => [
                    'ar' => [
                        'pre-title' => 'تميز الخدمة',
                        'title' => 'تعرف أكثر علينا',
                        'description' => 'اكتشف رؤيتنا ومهمتنا وقيمنا التي تدفعنا للأمام لتقديم أفضل خدمة سفر في المنطقة.',
                        'items' => [
                            [
                                'icon' => 'fa-solid fa-eye',
                                'title' => 'رؤيتنا',
                                'description' => 'رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. نسعى جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب.'
                            ],
                            [
                                'icon' => 'fa-solid fa-bullseye',
                                'title' => 'مهمتنا',
                                'description' => 'مهمتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. نسعى دائماً لتوفير الراحة والرفاهية لعملائنا.'
                            ],
                            [
                                'icon' => 'fa-solid fa-heart',
                                'title' => 'قيمنا',
                                'description' => 'قيمنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. نسعى جاهدين لنصبح شركة رائدة في مجال خدمات النقل.'
                            ],
                            [
                                'icon' => 'fa-solid fa-building',
                                'title' => 'فروع الإيمان جيت',
                                'description' => 'فروع الإيمان جيت منتشرة لخدمتكم. رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً.'
                            ],
                            [
                                'icon' => 'fa-solid fa-bus',
                                'title' => 'خطوط الإيمان جيت',
                                'description' => 'خطوط الإيمان جيت: رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً.'
                            ],
                            [
                                'icon' => 'fa-solid fa-credit-card',
                                'title' => 'طرق الدفع',
                                'description' => 'طرق الدفع: رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً.'
                            ],
                            [
                                'icon' => 'fa-solid fa-shield',
                                'title' => 'رفاهية وأمان',
                                'description' => 'رفاهية وأمان: رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً.'
                            ],
                        ]
                    ],
                    'en' => [
                        'pre-title' => 'EXPERIENCE EXCELLENCE',
                        'title' => 'Learn More About Us',
                        'description' => 'Discover our vision, mission, and values that drive us forward to provide the best travel service in the region.',
                        'items' => [
                            [
                                'icon' => 'fa-solid fa-eye',
                                'title' => 'Our Vision',
                                'description' => 'Our vision is to provide distinguished services that exceed the needs and expectations of our customers to become the easiest and safest solution.'
                            ],
                            [
                                'icon' => 'fa-solid fa-bullseye',
                                'title' => 'Our Mission',
                                'description' => 'Our mission is to provide distinguished services that exceed the needs and expectations of our customers to become the easiest and safest solution.'
                            ],
                            [
                                'icon' => 'fa-solid fa-heart',
                                'title' => 'Our Values',
                                'description' => 'Our values are to provide distinguished services that exceed the needs and expectations of our customers to become the easiest and safest solution.'
                            ],
                            [
                                'icon' => 'fa-solid fa-building',
                                'title' => 'Eman Jet Branches',
                                'description' => 'Eman Jet Branches are spread to serve you. Our vision is to provide distinguished services that exceed the needs.'
                            ],
                            [
                                'icon' => 'fa-solid fa-bus',
                                'title' => 'Eman Jet Routes',
                                'description' => 'Eman Jet Routes: Our vision is to provide distinguished services that exceed the needs and expectations.'
                            ],
                            [
                                'icon' => 'fa-solid fa-credit-card',
                                'title' => 'Payment Methods',
                                'description' => 'Payment Methods: Our vision is to provide distinguished services that exceed the needs and expectations.'
                            ],
                            [
                                'icon' => 'fa-solid fa-shield',
                                'title' => 'Safety & Comfort',
                                'description' => 'Safety & Comfort: Our vision is to provide distinguished services that exceed the needs and expectations.'
                            ],
                        ]
                    ],
                ],
                'order' => 2,
                'status' => true,
                'created_at' => now(),
            ],
        ];

        $contactSeos = [
            [
                'page_slug' => 'contact-us',
                'section_type' => 'contact-form',
                'content_json' => [
                    'ar' => [
                        'title' => 'نموذج الاتصال',
                        'description' => 'يرجى ملء النموذج أدناه وسنقوم بالرد عليك في أقرب وقت ممكن.',
                        'form-title' => 'أرسل لنا رسالة',
                        'image' => 'https://placehold.co/805x668',
                        'button-text' => 'إرسال الرسالة',
                        'complaints-title' => 'الشكاوى والاقتراحات',
                        'complaints-description' => 'هل تواجه أي مشاكل؟ نحن هنا للاستماع إليك وتحسين خدمتنا.',
                    ],
                    'en' => [
                        'title' => 'Contact Form',
                        'description' => 'Please fill out the form below and we will get back to you as soon as possible.',
                        'form-title' => 'Send Us a Message',
                        'image' => 'https://placehold.co/805x668',
                        'button-text' => 'Submit Message',
                        'complaints-title' => 'Complaints & Feedback',
                        'complaints-description' => 'Experience any issues? We are here to listen and improve our service.',
                    ],
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ],
        ];

        $faqsSeos = [
            [
                'page_slug' => 'faqs',
                'section_type' => 'hero-section',
                'content_json' => [
                    'ar' => [
                        'title' => 'الأسئلة الشائعة',
                        'description' => 'في هذا القسم، جمعنا لك أبرز الأسئلة التي قد تدور في ذهنك حول خدماتنا.',
                        'image' => 'https://placehold.co/805x668',
                    ],
                    'en' => [
                        'title' => 'Frequently Asked Questions',
                        'description' => 'In this section, we have collected the most prominent questions about our services.',
                        'image' => 'https://placehold.co/805x668',
                    ],
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ],
        ];

        $privacySeos = [
            [
                'page_slug' => 'privacy-policy',
                'section_type' => 'privacy-policy',
                'content_json' => [
                    'ar' => [
                        'title' => 'سياسة الخصوصية',
                        'description' => 'نحن نولي أهمية كبيرة لحماية خصوصيتك...',
                        'button-text' => 'موافق',
                        'image' => 'https://placehold.co/805x668',
                    ],
                    'en' => [
                        'title' => 'Privacy Policy',
                        'description' => 'We take your privacy very seriously...',
                        'button-text' => 'Agree',
                        'image' => 'https://placehold.co/805x668',
                    ],
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ],
        ];

        $usageTermsSeos = [
            [
                'page_slug' => 'usage-terms',
                'section_type' => 'usage-terms',
                'content_json' => [
                    'ar' => [
                        'title' => 'شروط الاستخدام',
                        'description' => 'يرجى قراءة هذه الشروط بعناية قبل استخدام الموقع...',
                        'button-text' => 'موافق',
                        'image' => 'https://placehold.co/805x668',
                    ],
                    'en' => [
                        'title' => 'Usage Terms',
                        'description' => 'Please read these terms carefully before using the site...',
                        'button-text' => 'Agree',
                        'image' => 'https://placehold.co/805x668',
                    ],
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ],
        ];

        $seos = array_merge($generalSeos, $homeSeos, $aboutSeos, $contactSeos, $faqsSeos, $privacySeos, $usageTermsSeos, $destinationSeos, $blogsSeos);

        foreach ($seos as $seo) {
            $page = Page::where('slug', $seo['page_slug'])->first();
            if ($page) {
                PageSeo::updateOrCreate(
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
