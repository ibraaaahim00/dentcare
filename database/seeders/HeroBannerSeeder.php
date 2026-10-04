<?php

namespace Database\Seeders;

use App\Models\HeroBanner;
use Illuminate\Database\Seeder;

class HeroBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'badge_ar' => 'أحدث مركز لطب وتجميل الأسنان',
                'badge_en' => 'State-of-the-Art Dental Care',
                'title_ar' => 'ابتسامتك المثالية تبدأ برعاية استثنائية ومتطورة',
                'title_en' => 'Your Perfect Smile Begins With Exceptional Dental Care',
                'description_ar' => 'نقدم لكم أرقى مستويات طب وجراحة الفم والأسنان بأيدي نخبة من أمهر الأطباء والاستشاريين مع أحدث تقنيات الليزر والعلاج بدون ألم.',
                'description_en' => 'Experience world-class dental procedures delivered by board-certified specialists with gentle touch and cutting-edge painless technology.',
                'button_text_ar' => 'احجز موعدك الآن',
                'button_text_en' => 'Book Appointment',
                'button_url' => '/appointments',
                'secondary_button_text_ar' => 'استكشف خدماتنا',
                'secondary_button_text_en' => 'Our Services',
                'secondary_button_url' => '/services',
                'image' => null,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'badge_ar' => 'ابتسامة هوليوود المتألقة',
                'badge_en' => 'Hollywood Smile Makeover',
                'title_ar' => 'تقنيات عدسات الفينير والزيركون بدون برد للأسنان',
                'title_en' => 'Ultra-Thin Ceramic & Zirconia Veneers With Zero Pain',
                'description_ar' => 'احصل على ابتسامة أحلامك بتصميم رقمي ثلاثي الأبعاد يعكس جمال ملامحك الطبيعية بأعلى درجات الدقة والجمال.',
                'description_en' => 'Customized digital smile designs tailored to your facial aesthetics with maximum durability and natural translucency.',
                'button_text_ar' => 'احجز استشارة التجميل',
                'button_text_en' => 'Book Smile Consult',
                'button_url' => '/appointments',
                'secondary_button_text_ar' => 'شاهد النتائج',
                'secondary_button_text_en' => 'View Results',
                'secondary_button_url' => '/gallery',
                'image' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            HeroBanner::create($banner);
        }
    }
}
