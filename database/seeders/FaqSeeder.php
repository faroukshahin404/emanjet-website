<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Seed FAQ records (multilingual question/answer).
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Faq::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $items = [
            [
                'question' => [
                    'ar' => 'ما هي سياسة الإلغاء؟',
                    'en' => 'What is the cancellation policy?',
                ],
                'answer' => [
                    'ar' => 'يمكنك إلغاء الحجز قبل 24 ساعة من موعد الرحلة.',
                    'en' => 'You can cancel the reservation 24 hours before the trip date.',
                ],
                'order' => 1,
                'status' => true,
            ],
            [
                'question' => [
                    'ar' => 'كيف يمكنني تغيير موعد الرحلة؟',
                    'en' => 'How can I change the trip date?',
                ],
                'answer' => [
                    'ar' => 'يمكنك تغيير موعد الرحلة من خلال الاتصال بخدمة العملاء.',
                    'en' => 'You can change the trip date by contacting customer service.',
                ],
                'order' => 2,
                'status' => true,
            ],
            [
                'question' => [
                    'ar' => 'ما هي طرق الدفع المتاحة؟',
                    'en' => 'What payment methods are available?',
                ],
                'answer' => [
                    'ar' => 'نقبل الدفع نقدًا وبطاقات الائتمان والخصم.',
                    'en' => 'We accept cash, credit and debit cards.',
                ],
                'order' => 3,
                'status' => true,
            ],
            [
                'question' => [
                    'ar' => 'هل يمكنني استرداد المبلغ؟',
                    'en' => 'Can I get a refund?',
                ],
                'answer' => [
                    'ar' => 'نعم، يمكنك استرداد المبلغ وفقًا لسياسة الإلغاء.',
                    'en' => 'Yes, you can get a refund according to the cancellation policy.',
                ],
                'order' => 4,
                'status' => true,
            ],
            [
                'question' => [
                    'ar' => 'هل يمكنني تغيير اسم المسافر بعد الحجز؟',
                    'en' => 'Can I change the passenger name after booking?',
                ],
                'answer' => [
                    'ar' => 'نعم، يمكنك تغيير اسم المسافر قبل 24 ساعة من موعد الرحلة.',
                    'en' => 'Yes, you can change the passenger name 24 hours before the trip date.',
                ],
                'order' => 5,
                'status' => true,
            ],
            [
                'question' => [
                    'ar' => 'ما هي سياسة الأمتعة؟',
                    'en' => 'What is the baggage policy?',
                ],
                'answer' => [
                    'ar' => 'يمكنك حمل حقيبة واحدة بحد أقصى 20 كجم.',
                    'en' => 'You can carry one bag with a maximum of 20 kg.',
                ],
                'order' => 6,
                'status' => true,
            ],
            [
                'question' => [
                    'ar' => 'هل هناك خصومات للطلاب؟',
                    'en' => 'Are there discounts for students?',
                ],
                'answer' => [
                    'ar' => 'نعم، نقدم خصومات خاصة للطلاب عند تقديم بطاقة الطالب.',
                    'en' => 'Yes, we offer special discounts for students when presenting a student card.',
                ],
                'order' => 7,
                'status' => true,
            ],
        ];

        foreach ($items as $item) {
            Faq::create($item);
        }
    }
}
