<?php

namespace Database\Seeders;

use App\Models\AppointmentSetting;
use Illuminate\Database\Seeder;

class AppointmentSettingSeeder extends Seeder
{
    public function run(): void
    {
        AppointmentSetting::updateOrCreate(
            ['id' => 1],
            [
                'booking_interval' => 30,
                'minimum_notice_hours' => 2,
                'maximum_days_ahead' => 30,
                'cancellation_hours' => 12,
            ]
        );
    }
}
