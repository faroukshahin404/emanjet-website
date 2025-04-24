<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSeo;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');  // تعطيل التحقق من القيود
        PageSeo::truncate();  // حذف جميع السجلات من جدول الشهادات
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');  // تفعيل التحقق من القيود

        $generalSeos = [
            [
                'page_slug' => 'general',
                'section_type' => 'contact-us',
                'content_json' => [

                    'ar' => [
                        'phone' => '010000000',
                        'whatsapp' => '01000000',
                        'email' => 'Info@superje',
                        'complaints_email' => 'customer-complaints@superjet-eg.com',
                    ],
                    'en' => [
                        'phone' => '010000000',
                        'whatsapp' => '01000000',
                        'email' => 'Info@superje',
                        'complaints_email' => 'customer-complaints@superjet-eg.com',
                    ]
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'general',
                'section_type' => 'social-media',
                'content_json' => [
                    'ar' => [
                        'facebook' => 'https://www.facebook.com/superjet',
                        'twitter' => 'https://twitter.com/superjet',
                        'instagram' => 'https://www.instagram.com/superjet',
                        'linkedin' => 'https://www.linkedin.com/company/superjet',
                    ],
                    'en' => [
                        'facebook' => 'https://www.facebook.com/superjet',
                        'twitter' => 'https://twitter.com/superjet',
                        'instagram' => 'https://www.instagram.com/superjet',
                        'linkedin' => 'https://www.linkedin.com/company/superjet',
                    ]
                ],
                'order' => 2,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'general',
                'section_type' => 'apps',
                'content_json' => [
                    'ar' => [
                        'android' => 'https://play.google.com/store/apps/details?id=com.superjet',
                        'ios' => 'https://apps.apple.com/app/superjet/id1234567890',
                    ],
                    'en' => [
                        'android' => 'https://play.google.com/store/apps/details?id=com.superjet',
                        'ios' => 'https://apps.apple.com/app/superjet/id1234567890',
                    ]
                ],
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
                'content_json' => [
                    'ar' => [
                        'card-title' => 'احجز رحلتك دلوقتي!',
                        'image' => 'https://placehold.co/1675x700',
                        'caption-title' => 'نحن هنا لمساعدتك',
                        'caption-description' => 'احجز رحلتك مع السوبر جيت وادفع بالبطاقة الائتمانية في لحظة!',
                    ],
                    'en' => [
                        'card-title' => 'Book your trip now!',
                        'image' => 'https://placehold.co/1675x700',
                        'caption-title' => 'We are here to help you',
                        'caption-description' => 'Book your trip with Super Jet and pay with your credit card instantly!',
                    ]
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
                        'title' => 'سوبر جيت معك في آي مكان',
                        'description' => 'لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.',
                        'image' => 'https://placehold.co/745x677',
                    ],
                    'en' => [
                        'title' => 'Super Jet is with you anywhere',
                        'description' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.',
                        'image' => 'https://placehold.co/745x677',
                    ]
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
                    ]
                ],
                'order' => 3,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //Make table for bus types (bus Categories)
            // [
            //     'page_slug' => 'home',
            //     'section_type' => 'bus-types',
            //     'content_json' => [
            //         'ar' => [
            //             [
            //                 'name' => 'درجة أولى',
            //                 'passengers' => 30,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 5,
            //             ],
            //             [
            //                 'name' => 'درجة ثانية',
            //                 'passengers' => 40,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 4.5,
            //             ],
            //             [
            //                 'name' => 'درجة ثالثة',
            //                 'passengers' => 50,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 3,
            //             ],
            //             [
            //                 'name' => 'درجة رابعة',
            //                 'passengers' => 60,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 2.5,
            //             ],
            //             [
            //                 'name' => 'درجة خامسة',
            //                 'passengers' => 70,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 2,
            //             ],
            //             [
            //                 'name' => 'درجة سادسة',
            //                 'passengers' => 80,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 1.5,
            //             ]
            //         ],
            //         'en' => [
            //             [
            //                 'name' => 'First Class',
            //                 'passengers' => 30,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 5,
            //             ],
            //             [
            //                 'name' => 'Second Class',
            //                 'passengers' => 40,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 4.5,
            //             ],
            //             [
            //                 'name' => 'Third Class',
            //                 'passengers' => 50,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 3,
            //             ],
            //             [
            //                 'name' => 'Fourth Class',
            //                 'passengers' => 60,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 2.5,
            //             ],
            //             [
            //                 'name' => 'Fifth Class',
            //                 'passengers' => 70,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 2,
            //             ],
            //             [
            //                 'name' => 'Sixth Class',
            //                 'passengers' => 80,
            //                 'image' => 'https://placehold.co/217x123',
            //                 'rate' => 1.5,
            //             ]
            //         ]
            //     ],
            //     'order' => 4,
            //     'status' => true,
            // ],
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
                    ]
                ],
                'order' => 5,
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
                        'search-title' => 'مسافر علي فين؟',
                        'image' => 'https://placehold.co/1657x600',
                    ],
                    'en' => [
                        'search-title' => 'Where are you traveling to?',
                        'image' => 'https://placehold.co/1657x600',
                    ]
                ],
                'order' => 1,
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
                        'description' => 'احجز الآن واستمتع بتجربة فريدة',
                        'image' => 'https://placehold.co/805x475',
                    ],
                    'en' => [
                        'title' => 'Try it now',
                        'description' => 'Book now and enjoy a unique experience',
                        'image' => 'https://placehold.co/805x475',
                    ]
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_slug' => 'destinations',
                'section_type' => 'app',
                'content_json' => [
                    'ar' => [
                        'title' => 'تطبيقنا',
                        'description' => 'قم بتنزيل تطبيقنا الآن واستمتع بتجربة فريدة',
                        'image' => 'https://placehold.co/450x577',
                    ],
                    'en' => [
                        'title' => 'Our App',
                        'description' => 'Download our app now and enjoy a unique experience',
                        'image' => 'https://placehold.co/450x577',
                    ]
                ],
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
                'content_json' => [
                    'ar' => [
                        'title' => 'وجهاتنا',
                        'description' => 'استكشف مجموعة متنوعة من الوجهات المميزة التي نوفرها عبر خطوطنا المنتشرة في جميع أنحاء الجمهورية. سواء كنت تبحث عن رحلة عمل سريعة أو عطلة للاسترخاء، فإننا نقدم لك خيارات متعددة تناسب جميع احتياجاتك. نضمن لك تجربة سفر مريحة وآمنة، مع الالتزام بأعلى معايير الجودة والاحترافية. اكتشف الآن وجهتك القادمة مع سوبر جيت!',
                        'image' => 'https://placehold.co/805x668',
                    ],
                    'en' => [
                        'title' => 'Our Destinations',
                        'description' => 'Explore a variety of distinctive destinations we provide through our widespread lines across the republic. Whether you\'re looking for a quick business trip or a relaxing vacation, we offer multiple options to suit all your needs. We guarantee you a comfortable and safe travel experience, while adhering to the highest standards of quality and professionalism. Discover your next destination with Super Jet!',
                        'image' => 'https://placehold.co/805x668',
                    ]
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
                    ],
                    'en' => [
                        'title' => 'Start Your Journey',
                        'description' => 'Start your adventure with Super Jet! Book your trip easily and enjoy a comfortable and safe experience through our electronic platform. Choose your favorite destination and get ready to discover a new world of modern transportation.',
                        'button-text' => 'Book Now',
                        'images' => [
                            'https://placehold.co/208x292',
                            'https://placehold.co/208x196',
                            'https://placehold.co/209x127',
                            'https://placehold.co/209x292',
                            'https://placehold.co/209x127',
                        ]
                    ]
                ],
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
                'content_json' => [
                    'ar' => [
                        'title' => 'من نحن',
                        'description' => 'نحن في سوبرجيت نؤمن بأهمية الراحة والأمان لعملائنا، ونسعى دائمًا لتقديم تجربة سفر متميزة تجمع بين الاحترافية والجودة. بفضل سنوات من الخبرة في مجال النقل والسفر، نعمل جاهدين على تحسين خدماتنا باستمرار لتلبي توقعات عملائنا وتفوقها. فريقنا ملتزم بتوفير أفضل وسائل الراحة، ودعم العملاء على مدار الساعة، وتقديم حلول مبتكرة تسهّل عليك رحلتك من البداية حتى النهاية.',
                        'image' => 'https://placehold.co/805x668',
                    ],
                    'en' => [
                        'title' => 'About Us',
                        'description' => 'At Super Jet, we believe in the importance of comfort and safety for our customers, and we always strive to provide a distinguished travel experience that combines professionalism and quality. Thanks to years of experience in the field of transportation and travel, we work hard to continuously improve our services to meet and exceed our customers\' expectations. Our team is committed to providing the best amenities, 24/7 customer support, and innovative solutions that make your journey easier from start to finish.',
                        'image' => 'https://placehold.co/805x668',
                    ]
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
                        'vision' => 'رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                        'mission' => 'مهمتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                        'values' => 'قيمنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                        'branches' => 'فروع سوبر جيت: رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                        'routes' => 'خطوط سوبر جيت: رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                        'payment_methods' => 'طرق الدفع: رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                        'safety_and_comfort' => 'رفاهية وأمان: رؤيتنا هي تقديم خدمات مميزة تتجاوز احتياجات وتوقعات عملائنا حتى تصبح الحل الأسهل والأكثر أماناً. فإننا نسعى دائماً جاهدين لنصبح شركة رائدة في مجال خدمات نقل الركاب بكافة الوسائل باستخدام كافة التقنيات الحديثة لتوفير الراحة والرفاهية لعملائنا.',
                    ],
                    'en' => [
                        'vision' => 'Our vision is to provide distinguished services that exceed the needs and expectations of our customers to become the easiest and safest solution. We always strive to become a leading company in passenger transportation services using all modern technologies to provide comfort and luxury to our customers.',
                        'mission' => 'Our mission is to provide distinguished services that exceed the needs and expectations of our customers to become the easiest and safest solution. We always strive to become a leading company in passenger transportation services using all modern technologies to provide comfort and luxury to our customers.',
                        'values' => 'Our values are to provide distinguished services that exceed the needs and expectations of our customers to become the easiest and safest solution. We always strive to become a leading company in passenger transportation services using all modern technologies to provide comfort and luxury to our customers.',
                        'branches' => 'Super Jet Branches: Our vision is to provide distinguished services that exceed the needs and expectations of our customers to become the easiest and safest solution. We always strive to become a leading company in passenger transportation services using all modern technologies to provide comfort and luxury to our customers.',
                        'routes' => 'Super Jet Routes: Our vision is to provide distinguished services that exceed the needs and expectations of our customers to become the easiest and safest solution. We always strive to become a leading company in passenger transportation services using all modern technologies to provide comfort and luxury to our customers.',
                        'payment_methods' => 'Payment Methods: Our vision is to provide distinguished services that exceed the needs and expectations of our customers to become the easiest and safest solution. We always strive to become a leading company in passenger transportation services using all modern technologies to provide comfort and luxury to our customers.',
                        'safety_and_comfort' => 'Safety and Comfort: Our vision is to provide distinguished services that exceed the needs and expectations of our customers to become the easiest and safest solution. We always strive to become a leading company in passenger transportation services using all modern technologies to provide comfort and luxury to our customers.',
                    ]
                ],
                'order' => 2,
                'status' => true,
                'created_at' => now(),
            ]
        ];

        $contactSeos = [
            [
                'page_slug' => 'contact-us',
                'section_type' => 'contact-form',
                'content_json' => [
                    'ar' => [
                        'title' => 'نموذج الاتصال',
                        'description' => 'يرجى ملء النموذج أدناه وسنقوم بالرد عليك في أقرب وقت ممكن.',
                        'image' => 'https://placehold.co/805x668',
                        'button-text' => 'إرسال',
                    ],
                    'en' => [
                        'title' => 'Contact Form',
                        'description' => 'Please fill out the form below and we will get back to you as soon as possible.',
                        'image' => 'https://placehold.co/805x668',
                        'button-text' => 'Send',
                    ]
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ]
        ];

        $privacySeos = [
            [
                'page_slug' => 'privacy-policy',
                'section_type' => 'privacy-policy',
                'content_json' => [
                    'ar' => [
                        'title' => 'سياسة الخصوصية',
                        'description' => 'سياسة الخصوصية لشركة الاتحاد العربي للنقل البري سوبر جيت في شركة الاتحاد العربي للنقل البري سوبر جيت، نولي أهمية كبيرة لحماية خصوصيتك وبياناتك الشخصية. تهدف سياسة الخصوصية هذه إلى توضيح كيفية جمعنا للمعلومات، واستخدامها، ومشاركتها، وحمايتها عند استخدامك لخدماتنا. المعلومات التي نقوم بجمعها المعلومات الشخصية مثل الاسم، رقم الهاتف، البريد الإلكتروني، رقم الهوية، عند إنشاء حساب أو الحجز عبر الإنترنت بيانات الرحلات مثل مواعيد السفر، الوجهات، وأرقام التذاكر معلومات الموقع الجغرافي في حال تم تفعيلها البيانات التقنية مثل نوع الجهاز، نظام التشغيل، المتصفح، عنوان IP كيفية استخدام المعلومات لتأكيد الحجز ومعالجة المدفوعات للتواصل معك بخصوص الرحلات أو التحديثات أو العروض لتحسين جودة خدماتنا وتجربتك للامتثال للمتطلبات القانونية والتنظيمية مشاركة المعلومات لا نقوم بمشاركة بياناتك مع أي طرف ثالث إلا في الحالات التالية مع شركاء موثوقين لأغراض تشغيلية مثل شركات الدفع إذا طُلب منا ذلك بموجب القانون في حال وجود تهديد لأمن المستخدمين أو الخدمة حماية البيانات نستخدم أحدث تقنيات التشفير والتأمين لضمان حماية بياناتك يتم تخزين المعلومات على خوادم آمنة ويُسمح بالوصول إليها فقط للمصرح لهم ملفات تعريف الارتباط Cookies نستخدم ملفات تعريف الارتباط لتحسين تجربة المستخدم وتحليل استخدام الموقع. يمكنك تعطيلها من إعدادات المتصفح حقوق المستخدم يحق لك طلب نسخة من بياناتك أو تعديلها أو حذفها يمكنك سحب موافقتك على استخدام بياناتك في أي وقت التعديلات على سياسة الخصوصية قد نقوم بتحديث هذه السياسة من وقت لآخر، وسيتم نشر أي تغييرات على هذه الصفحة',
                        'image' => 'https://placehold.co/805x668',
                        'button-text' => 'موافق',
                    ],
                    'en' => [
                        'title' => 'Privacy Policy',
                        'description' => 'Privacy Policy of SuperJet At SuperJet, your privacy is important to us. This Privacy Policy outlines how we collect, use, share, and protect your information when you use our services. Information We Collect Personal information such as name, phone number, email, ID number, when creating an account or booking online Travel details such as trip schedules, destinations, and ticket numbers Geolocation data if enabled Technical data like device type, operating system, browser, and IP address How We Use the Information To confirm bookings and process payments To contact you about your trips, updates, or promotions To improve our services and user experience To comply with legal and regulatory requirements Information Sharing We do not share your personal data with third parties, except With trusted partners for operational purposes e.g., payment processors When required by law In case of a security threat to users or the service Data Security We use the latest encryption and security technologies to protect your information Data is stored on secure servers with restricted access Cookies We use cookies to enhance user experience and analyze website usage. You can disable cookies in your browser settings User Rights You have the right to request, modify, or delete your data You can withdraw your consent for data usage at any time Changes to the Privacy Policy We may update this policy occasionally. Any changes will be posted on this page',
                        'image' => 'https://placehold.co/805x668',
                        'button-text' => 'Agree',
                    ]
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ]
        ];
        $usageTermsSeos = [
            [
                'page_slug' => 'usage-terms',
                'section_type' => 'usage-terms',
                'content_json' => [
                    'ar' => [
                        'title' => 'سياسة الاستخدام',
                        'description' => 'سياسة الاستخدام لشركة الاتحاد العربي للنقل البري سوبر جيت يرجى قراءة هذه الشروط بعناية قبل استخدام موقع أو تطبيق شركة الاتحاد العربي للنقل البري سوبر جيت. باستخدامك لأي من خدماتنا، فإنك توافق على الالتزام بسياسة الاستخدام التالية: 1. قبول الشروط باستخدام الموقع أو التطبيق، فإنك تقر بأنك قرأت وفهمت ووافقت على هذه السياسة، وفي حال عدم موافقتك، يُرجى عدم استخدام الخدمة. 2. استخدام الخدمة يجب أن تستخدم الخدمة فقط للأغراض المشروعة مثل الحجز أو الاستعلام عن الرحلات. يُحظر استخدام الخدمة لأي غرض تجاري غير مصرح به أو للتلاعب أو الاحتيال. 3. الحسابات والمعلومات تتحمل مسؤولية دقة المعلومات التي تقدمها. لا يجوز استخدام حسابك من قبل أي طرف ثالث دون إذن منك. يحق لنا تعليق أو إلغاء الحسابات التي تُستخدم بشكل مسيء أو مخالف للسياسات. 4. حقوق الملكية جميع المحتويات النصوص، الصور، الشعارات، العلامات التجارية مملوكة لشركة الاتحاد العربي للنقل البري أو للجهات المرخصة لها. لا يجوز إعادة استخدام أو نسخ أي جزء من الموقع أو التطبيق دون إذن كتابي مسبق. 5. حدود المسؤولية نسعى لتقديم معلومات دقيقة ولكن لا نضمن خلو الموقع من الأخطاء أو التوقفات المؤقتة. لسنا مسؤولين عن أي خسائر ناتجة عن استخدام الخدمة أو الاعتماد على المعلومات المعروضة. 6. التعديلات على السياسة نحتفظ بالحق في تعديل سياسة الاستخدام في أي وقت، وسيتم نشر التحديثات عبر الموقع. 7. القانون الواجب التطبيق تخضع هذه السياسة لقوانين جمهورية مصر العربية، ويكون لمحاكم القاهرة الاختصاص الحصري في حال نشوء أي نزاع.',
                        'image' => 'https://placehold.co/805x668',
                        'button-text' => 'موافق',
                    ],
                    'en' => [
                        'title' => 'Usage Terms',
                        'description' => 'Please read these terms carefully before using the website or app of SuperJet. By using any of our services, you agree to be bound by the following terms: 1. Acceptance of Terms By using our platform, you confirm that you have read, understood, and agreed to these terms. If you do not agree, please do not use the service. 2. Use of the Service The service must be used only for lawful purposes, such as booking or checking trips. Unauthorized commercial use, manipulation, or fraud is strictly prohibited. 3. Accounts and Information You are responsible for the accuracy of the information you provide. Your account must not be used by others without your permission. We reserve the right to suspend or terminate accounts used in violation of our policies. 4. Intellectual Property All content text, images, logos, trademarks is owned by Arab Union for Land Transport or its licensors. Reuse or reproduction of any part of the website/app without prior written consent is prohibited. 5. Limitation of Liability While we strive for accuracy, we do not guarantee that the site will be error-free or uninterrupted. We are not liable for any loss resulting from the use of the service or reliance on displayed information. 6. Changes to the Terms We reserve the right to update these terms at any time. Changes will be posted on the website. 7. Governing Law These terms are governed by the laws of the Arab Republic of Egypt. The courts of Cairo shall have exclusive jurisdiction over any disputes.',
                        'image' => 'https://placehold.co/805x668',
                        'button-text' => 'Agree',
                    ]
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ]
        ];

        $faqsSeos = [
            [
                'page_slug' => 'faqs',
                'section_type' => 'hero-section',
                'content_json' => [
                    'ar' => [
                        'title' => 'الأسئلة الشائعة',
                        'description' => 'في هذا القسم، جمعنا لك أبرز الأسئلة التي قد تدور في ذهنك حول خدماتنا، الحجز، وسائل الراحة، وسياسات السفر المختلفة. هدفنا هو تقديم تجربة سهلة وواضحة لجميع عملائنا، لذلك نحرص دائمًا على الإجابة على كل استفسار بدقة ووضوح. إذا لم تجد إجابتك هنا، لا تتردد في التواصل معنا وسنكون سعداء بمساعدتك.',
                        'image' => 'https://placehold.co/805x668',
                    ],
                    'en' => [
                        'title' => 'Frequently Asked Questions',
                        'description' => 'In this section, we have collected the most prominent questions that may be on your mind about our services, reservations, amenities, and various travel policies. Our goal is to provide an easy and clear experience for all our customers, so we always strive to answer every inquiry accurately and clearly. If you don\'t find your answer here, feel free to contact us and we\'ll be happy to help you.',
                        'image' => 'https://placehold.co/805x668',
                    ]
                ],
                'order' => 1,
                'status' => true,
                'created_at' => now(),
            ],
            [
                'page_slug' => 'faqs',
                'section_type' => 'faq-list',
                'content_json' => [
                    'ar' => [
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
                    ],
                    'en' => [
                        'faqs' => [
                            [
                                'question' => 'What is the cancellation policy?',
                                'answer' => 'You can cancel the reservation 24 hours before the trip date.',
                            ],
                            [
                                'question' => 'How can I change the trip date?',
                                'answer' => 'You can change the trip date by contacting customer service.',
                            ],
                            [
                                'question' => 'What payment methods are available?',
                                'answer' => 'We accept cash, credit and debit cards.',
                            ],
                            [
                                'question' => 'Can I get a refund?',
                                'answer' => 'Yes, you can get a refund according to the cancellation policy.',
                            ],
                            [
                                'question' => 'Can I change the passenger name after booking?',
                                'answer' => 'Yes, you can change the passenger name 24 hours before the trip date.',
                            ],
                            [
                                'question' => 'What is the baggage policy?',
                                'answer' => 'You can carry one bag with a maximum of 20 kg.',
                            ],
                            [
                                'question' => 'Are there discounts for students?',
                                'answer' => 'Yes, we offer special discounts for students when presenting a student card.',
                            ]
                        ]
                    ]
                ],
                'order' => 2,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];



        $seos = array_merge($generalSeos, $homeSeos, $aboutSeos, $contactSeos, $destinationSeos, $blogsSeos, $faqsSeos, $privacySeos, $usageTermsSeos);

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
