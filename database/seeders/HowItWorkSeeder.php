<?php

namespace Database\Seeders;

use App\Models\HowItWork;
use Illuminate\Database\Seeder;

class HowItWorkSeeder extends Seeder
{
    public function run(): void
    {
        $steps = [
            [
                'step_number' => 1,
                'title_ar' => 'اختر الخدمة والطبيب المختص',
                'title_en' => 'Choose Service & Doctor',
                'description_ar' => 'تصفح قائمة خدماتنا التخصصية واستعرض ملفات أطبائنا وخبراتهم لتحديد الاختيار الأنسب لحالتك.',
                'description_en' => 'Explore our specialized dental treatments and certified doctors to find your preferred provider.',
                'icon' => 'user-check',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'step_number' => 2,
                'title_ar' => 'حدد التاريخ والوقت المناسب',
                'title_en' => 'Select Date & Available Slot',
                'description_ar' => 'اختر الموعد المتاح في جدول الطبيب الفعلي دون الحاجة للانتظار في الهاتف أو مكالمات التأكيد.',
                'description_en' => 'Pick from real-time live availability directly synced with clinical operation hours.',
                'icon' => 'calendar',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'step_number' => 3,
                'title_ar' => 'احصل على التأكيد الفوري وتفضل بزيارتنا',
                'title_en' => 'Get Instant Confirmation & Visit',
                'description_ar' => 'تصلك رسالة وإشعار فوري بتفاصيل الموعد مع تذكير مسبق قبل الزيارة لتجربة استثنائية مريحة.',
                'description_en' => 'Receive instantaneous confirmation with reminders and clinical preparation tips for your appointment.',
                'icon' => 'check-circle',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($steps as $step) {
            HowItWork::create($step);
        }
    }
}
