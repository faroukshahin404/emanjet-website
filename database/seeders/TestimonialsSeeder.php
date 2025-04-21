<?php
namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialsSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');  // تعطيل التحقق من القيود
        Testimonial::truncate();  // حذف جميع السجلات من جدول الشهادات
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');  // تفعيل التحقق من القيود

        $testimonials = [
            [
                'name' => [
                    'ar' => 'أحمد عبد الله',
                    'en' => 'Ahmed Abdullah',
                ],
                'content' => [
                    'ar' => 'رحلة رائعة مع Super Jet! الباص نظيف ومريح، والطاقم محترف.',
                    'en' => 'A wonderful trip with Super Jet! The bus is clean and comfortable, and the crew is professional.',
                ],
                'image' => 'https://placehold.co/150',
            ],
            [
                'name' => [
                    'ar' => 'ليلى منصور',
                    'en' => 'Layla Mansour',
                ],
                'content' => [
                    'ar' => 'أفضل تجربة سفر خضتها داخل مصر، الالتزام بالمواعيد ممتاز!',
                    'en' => 'The best travel experience I had in Egypt, excellent time commitment!',
                ],
                'image' => 'https://placehold.co/150',
            ],
            [
                'name' => [
                    'ar' => 'خالد فؤاد',
                    'en' => 'Khaled Fouad',
                ],
                'content' => [
                    'ar' => 'سهولة الحجز أونلاين وفّرت علي وقت وجهد كبير.',
                    'en' => 'The ease of online booking saved me a lot of time and effort.',
                ],
                'image' => 'https://placehold.co/150',
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name']], // هذه الخطوة تتأكد من تخزين الـ JSON بشكل صحيح
                [
                    'content' => $testimonial['content'],
                    'image' => $testimonial['image'],
                ]
            );
        }
    }
}
