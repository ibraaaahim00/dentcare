<?php

namespace Database\Seeders;

use App\Models\CtaSection;
use Illuminate\Database\Seeder;

class CtaSectionSeeder extends Seeder
{
    public function run(): void
    {
        CtaSection::create([
            'badge_ar' => 'هل أنت جاهز لابتسامة جديدة؟',
            'badge_en' => 'Ready for a Healthier Smile?',
            'title_ar' => 'احجز استشارتك اليوم واستعد إشراقة ابتسامتك مع نُخبة الأطباء',
            'title_en' => 'Book Your Consultation Today & Restore Your Confident Smile',
            'description_ar' => 'نحن هنا لمساعدتك على الحصول على أسنان صحية ومظهر جذاب مع أفضل أطباء الأسنان وأحدث الأجهزة الطبية في بيئة مريحة.',
            'description_en' => 'Experience compassionate dental care in a state-of-the-art facility. Reserve your appointment with our team now.',
            'button_text_ar' => 'احجز موعداً إلكترونياً',
            'button_text_en' => 'Book Online Now',
            'button_url' => '/appointments',
            'secondary_button_text_ar' => 'اتصل بنا مباشرة',
            'secondary_button_text_en' => 'Call Us Directly',
            'secondary_button_url' => '/contact',
            'phone' => '+966 11 456 7890',
            'background_image' => null,
            'is_active' => true,
        ]);
    }
}
