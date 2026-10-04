<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            [
                'title_ar' => 'تعقيم طبي أوروبي معتمد',
                'title_en' => 'Hospital-Standard Sterilization',
                'description_ar' => 'نطبق أعلى معايير مكافحة العدوى والتعقيم الحراري المزدوج لكل مريض لضمان أقصى درجات الأمان والسلامة.',
                'description_en' => 'Stringent multi-stage autoclaving and individual hygienic blister packs for every single clinical visit.',
                'icon' => 'shield-check',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title_ar' => 'أشعة رقمية ثلاثية الأبعاد وليزر',
                'title_en' => '3D Cone Beam & Laser Tech',
                'description_ar' => 'تشخيص فائق الدقة بدون ألم وبأقل تعرض للإشعاع، مع تخطيط جراحي رقمي مسبق لزراعة الأسنان.',
                'description_en' => 'Instant computerized diagnoses with high-precision planning for implants and gentle laser soft-tissue treatments.',
                'icon' => 'sparkles',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title_ar' => 'حجز ذكي ودقيق بدون انتظار',
                'title_en' => 'Zero Wait Online Booking',
                'description_ar' => 'نظام مواعيد لحظي يتيح لك اختيار الطبيب والوقت المناسب مباشرة مع تأكيد فوري عبر الرسائل.',
                'description_en' => 'Direct slot booking engine synchronizing real clinic doctor availability and eliminating waiting times.',
                'icon' => 'calendar',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
