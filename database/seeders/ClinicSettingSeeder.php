<?php

namespace Database\Seeders;

use App\Models\ClinicSetting;
use Illuminate\Database\Seeder;

class ClinicSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'clinic_name_ar', 'value' => 'DentCare مركز طب وجراحة الأسنان', 'type' => 'string'],
            ['key' => 'clinic_name_en', 'value' => 'DentCare Advanced Dental Center', 'type' => 'string'],
            ['key' => 'email', 'value' => 'contact@dentcare.com', 'type' => 'string'],
            ['key' => 'phone', 'value' => '+966 11 456 7890', 'type' => 'string'],
            ['key' => 'emergency_phone', 'value' => '+966 50 123 4567', 'type' => 'string'],
            ['key' => 'whatsapp', 'value' => '+966501234567', 'type' => 'string'],
            ['key' => 'address_ar', 'value' => 'الرياض - طريق الملك فهد - برج الرعاية الطبية - الطابق 4', 'type' => 'string'],
            ['key' => 'address_en', 'value' => 'King Fahd Road, Medical Care Tower, 4th Floor, Riyadh, Saudi Arabia', 'type' => 'string'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/dentcare', 'type' => 'string'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/dentcare', 'type' => 'string'],
            ['key' => 'twitter_url', 'value' => 'https://x.com/dentcare', 'type' => 'string'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com', 'type' => 'string'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com', 'type' => 'string'],
            ['key' => 'google_map_link', 'value' => 'https://maps.google.com', 'type' => 'string'],
            ['key' => 'header_topbar_announcement_ar', 'value' => 'خصم 20% على باقات تبييض وتجميل الأسنان هذا الشهر!', 'type' => 'string'],
            ['key' => 'header_topbar_announcement_en', 'value' => '20% off all cosmetic dentistry & teeth whitening packages this month!', 'type' => 'string'],
            ['key' => 'footer_text_ar', 'value' => 'عيادة أسنان متكاملة تقدم أحدث تقنيات طب وتجميل وزراعة الأسنان، لضمان صحة وجمال ابتسامتك في بيئة آمنة ومريحة.', 'type' => 'string'],
            ['key' => 'footer_text_en', 'value' => 'A premier dental clinic offering state-of-the-art restorative, aesthetic, and implant dentistry for your healthiest, brightest smile.', 'type' => 'string'],
            ['key' => 'copyright_text_ar', 'value' => 'جميع الحقوق محفوظة © DentCare مركز طب وجراحة الأسنان', 'type' => 'string'],
            ['key' => 'copyright_text_en', 'value' => 'All rights reserved © DentCare Advanced Dental Center', 'type' => 'string'],
            ['key' => 'meta_title_ar', 'value' => 'DentCare — أفضل عيادة أسنان وحجز مواعيد فوري', 'type' => 'string'],
            ['key' => 'meta_title_en', 'value' => 'DentCare — Premier Dental Care & Online Booking', 'type' => 'string'],
            ['key' => 'meta_description_ar', 'value' => 'احجز موعدك الآن مع نخبة من أطباء واستشاريي الأسنان في DentCare.', 'type' => 'string'],
            ['key' => 'meta_description_en', 'value' => 'Book your online dental appointment with top specialized dentists at DentCare.', 'type' => 'string'],
            ['key' => 'meta_keywords_ar', 'value' => 'طب أسنان, تبييض أسنان, زراعة أسنان, تقويم أسنان, الرياض', 'type' => 'string'],
            ['key' => 'meta_keywords_en', 'value' => 'dentist, dental clinic, dental implants, teeth whitening, orthodontics, Riyadh', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            ClinicSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']]
            );
        }
    }
}
