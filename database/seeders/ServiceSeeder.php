<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name_ar' => 'تبييض الأسنان بالليزر زووم',
                'name_en' => 'Philips Zoom Laser Teeth Whitening',
                'slug' => 'laser-teeth-whitening',
                'description_ar' => 'جلسة تبييض متطورة وآمنة بتقنية Zoom 4 تمنحك ابتسامة ناصعة البياض بفارق يصل إلى 8 درجات في جلسة واحدة خلال 45 دقيقة مع معالجة حساسية الأسنان.',
                'description_en' => 'Advanced in-office Zoom 4 laser whitening that lightens teeth up to 8 shades in a single 45-minute appointment with built-in desensitizing formula.',
                'duration' => 45,
                'price' => 199.00,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name_ar' => 'زراعة الأسنان الفورية السويسرية',
                'name_en' => 'Swiss Premium Dental Implants',
                'slug' => 'dental-implants',
                'description_ar' => 'زراعة أسنان بتقنية Straumann السويسرية بتدخل جراحي طفيف مع إمكانية التحميل الفوري وتوفير تعويض دائم طبيعي مدى الحياة بنسبة نجاح تفوق 98%.',
                'description_en' => 'Minimally invasive Swiss Straumann titanium/zirconia implants with immediate loading options and lifelong osseointegration success.',
                'duration' => 60,
                'price' => 850.00,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name_ar' => 'التقويم الشفاف الذكي (Invisalign)',
                'name_en' => 'Invisalign Clear Aligners',
                'slug' => 'clear-aligners',
                'description_ar' => 'تصحيح اصطفاف الأسنان وقفل الفراغات بقوالب شفافة غير مرئية ومتحركة صممت بتقنية المسح الضوئي ثلاثي الأبعاد دون الحاجة للأسلاك المعدنية التقليدية.',
                'description_en' => 'Custom-molded transparent removable aligners engineered via 3D digital intraoral scan for seamless bite correction without metal brackets.',
                'duration' => 30,
                'price' => 450.00,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name_ar' => 'علاج جذور الأسنان بالميكروسكوب',
                'name_en' => 'Microscopic Root Canal Therapy',
                'slug' => 'root-canal-therapy',
                'description_ar' => 'سحب العصب وعلاج القنوات الجذرية تحت المجهر الجراحي بأحدث الأجهزة الدوارة في جلسة واحدة وبدون ألم نهائياً للحفاظ على السن الطبيعي.',
                'description_en' => 'Single-visit painless microscopic endodontic treatment utilizing rotary nickel-titanium instruments to eliminate infection and preserve the natural tooth.',
                'duration' => 60,
                'price' => 220.00,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name_ar' => 'عدسات الفينير وهوليود سمايل',
                'name_en' => 'Porcelain Veneers & Hollywood Smile',
                'slug' => 'porcelain-veneers',
                'description_ar' => 'عدسات إيماكس الألمانية فائقة الرقة (0.3 مم) بتصميم رقمي ثلاثي الأبعاد للابتسامة لتغطية التصبغات وتصحيح العيوب بجمالية ولمعان فائق.',
                'description_en' => 'Ultra-thin German E.max porcelain veneers designed with Digital Smile Design (DSD) to achieve your ideal symmetry and natural luminosity.',
                'duration' => 45,
                'price' => 350.00,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name_ar' => 'تنظيف الأسنان وإزالة الجير وتلميعها',
                'name_en' => 'Routine Dental Cleaning & Air-Flow Polishing',
                'slug' => 'dental-cleaning-polishing',
                'description_ar' => 'جلسة وقائية بالموجات فوق الصوتية وتقنية Air-Flow لإزالة الجير العميق وتصبغات القهوة والتدخين مع تطبيق الفلورايد لحماية المينا.',
                'description_en' => 'Ultrasonic scaling combined with Swiss Air-Flow polishing to remove stubborn plaque, coffee stains, and bacteria followed by remineralizing fluoride.',
                'duration' => 30,
                'price' => 80.00,
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        $doctors = Doctor::all();

        foreach ($services as $srvData) {
            $service = Service::updateOrCreate(
                ['slug' => $srvData['slug']],
                $srvData
            );

            // Assign services logically to doctors
            if (str_contains($service->slug, 'whitening') || str_contains($service->slug, 'cleaning') || str_contains($service->slug, 'veneers')) {
                // Cosmetic doc (doc 3) and doc 1
                $service->doctors()->syncWithoutDetaching($doctors->pluck('id')->toArray());
            } elseif (str_contains($service->slug, 'aligners')) {
                // Ortho doc (doc 1)
                $ortho = $doctors->first();
                if ($ortho) {
                    $service->doctors()->syncWithoutDetaching([$ortho->id]);
                }
            } elseif (str_contains($service->slug, 'implants')) {
                // Implant doc (doc 2)
                $implant = $doctors->skip(1)->first();
                if ($implant) {
                    $service->doctors()->syncWithoutDetaching([$implant->id]);
                }
            } elseif (str_contains($service->slug, 'root-canal')) {
                // Endodontic doc (doc 3)
                $endo = $doctors->last();
                if ($endo) {
                    $service->doctors()->syncWithoutDetaching([$endo->id]);
                }
            }
        }
    }
}
