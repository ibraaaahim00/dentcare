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
            ['key' => 'address_ar', 'value' => 'الرياض - طريق الملك فهد - برج الرعاية الطبية - الطابق 4', 'type' => 'string'],
            ['key' => 'address_en', 'value' => 'King Fahd Road, Medical Care Tower, 4th Floor, Riyadh, Saudi Arabia', 'type' => 'string'],
            ['key' => 'facebook', 'value' => 'https://facebook.com/dentcare', 'type' => 'string'],
            ['key' => 'instagram', 'value' => 'https://instagram.com/dentcare', 'type' => 'string'],
            ['key' => 'twitter', 'value' => 'https://twitter.com/dentcare', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            ClinicSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']]
            );
        }
    }
}
