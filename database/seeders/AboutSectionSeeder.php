<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use Illuminate\Database\Seeder;

class AboutSectionSeeder extends Seeder
{
    public function run(): void
    {
        AboutSection::create([
            'badge_ar' => 'تعرف على DentCare',
            'badge_en' => 'About DentCare',
            'title_ar' => 'نبني الابتسامات بثقة، خبرة، وتقنيات لا تضاهى',
            'title_en' => 'Building Confident Smiles with Clinical Precision',
            'subtitle_ar' => 'رعاية وقائية وعلاجية مريحة تلبي أعلى معايير الجودة العالمية',
            'subtitle_en' => 'Gentle preventative and aesthetic dentistry using the most hygienic practices',
            'description_ar' => 'تأسست عيادة دنت كير بهدف تقديم تجربة علاجية فريدة تقضي على هاجس الخوف من عيادات الأسنان، من خلال الجمع بين أرقى الكفاءات الطبية والتقنيات الرقمية ثلاثية الأبعاد والليزر المتقدم.',
            'description_en' => 'DentCare was founded on a simple philosophy: dental care should be gentle, transparent, and built around each patient’s unique health and aesthetic goals.',
            'vision_ar' => 'أن نكون المركز الرائد والأكثر ثقة لطب وتجميل الأسنان إقليمياً.',
            'vision_en' => 'To be the most trusted and forward-thinking dental center in the region.',
            'mission_ar' => 'توفير رعاية وقائية وعلاجية مريحة تلبي أعلى معايير الجودة العالمية والتعقيم الدقيق.',
            'mission_en' => 'Delivering preventative and aesthetic dentistry using hospital-grade hygiene and advanced precision.',
            'experience_years' => 15,
            'experience_text_ar' => 'عاماً من التميز والابتكار',
            'experience_text_en' => 'Years of Clinical Excellence',
            'button_text_ar' => 'احجز موعدك الآن',
            'button_text_en' => 'Book Your Visit',
            'button_url' => '/appointments',
            'image' => null,
            'secondary_image' => null,
            'is_active' => true,
        ]);
    }
}
