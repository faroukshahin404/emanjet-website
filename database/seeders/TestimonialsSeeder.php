<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialsSeeder extends Seeder
{
    public function run()
    {
        $testimonials = [
            [
                'name' => 'أحمد عبد الله',
                'content' => 'رحلة رائعة مع Super Jet! الباص نظيف ومريح، والطاقم محترف.',
                'image' => 'https://placehold.co/150',
            ],
            [
                'name' => 'ليلى منصور',
                'content' => 'أفضل تجربة سفر خضتها داخل مصر، الالتزام بالمواعيد ممتاز!',
                'image' => 'https://placehold.co/150',
            ],
            [
                'name' => 'خالد فؤاد',
                'content' => 'سهولة الحجز أونلاين وفّرت علي وقت وجهد كبير.',
                'image' => 'https://placehold.co/150',
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name']],
                [
                    'content' => $testimonial['content'],
                    'image' => $testimonial['image'],
                ]
            );
        }
    }
}
