<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title_ar' => 'حالة تصميم ابتسامة هوليود كاملة بعدسات الفينير',
                'title_en' => 'Full Smile Makeover with Ultra-thin E.max Veneers',
                'image' => 'gallery/smile-1.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title_ar' => 'زراعة فورية للأسنان الأمامية مع التحميل المؤقت',
                'title_en' => 'Immediate Anterior Dental Implant & Crown Restoration',
                'image' => 'gallery/implant-1.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title_ar' => 'نتيجة تصحيح العضة والازدحام بالتقويم الشفاف',
                'title_en' => 'Orthodontic Alignment Outcome via Clear Aligners',
                'image' => 'gallery/aligner-1.jpg',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title_ar' => 'غرفة الجراحة والتعقيم الرقمي الحديثة في العيادة',
                'title_en' => 'State-of-the-Art Digital Surgery & Sterilization Suite',
                'image' => 'gallery/clinic-suite.jpg',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title_ar' => 'نتيجة جلسة تبييض زووم 4 المباشرة في العيادة',
                'title_en' => 'Immediate Zoom 4 Laser In-Office Whitening Result',
                'image' => 'gallery/whitening-1.jpg',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title_ar' => 'منطقة الاستقبال والضيافة المريحة لراحة المراجعين',
                'title_en' => 'DentCare Executive Lounge & Patient Hospitality Area',
                'image' => 'gallery/lounge.jpg',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            GalleryItem::updateOrCreate(
                ['title_en' => $item['title_en']],
                $item
            );
        }
    }
}
