<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ClinicSettingSeeder::class,
            WorkingHourSeeder::class,
            AppointmentSettingSeeder::class,
            UserSeeder::class,
            DoctorScheduleSeeder::class,
            ServiceSeeder::class,
            CategorySeeder::class,
            BlogPostSeeder::class,
            FaqSeeder::class,
            GallerySeeder::class,
            AppointmentSeeder::class,
            MedicalRecordSeeder::class,
            ReviewSeeder::class,
            ContactMessageSeeder::class,
            HeroBannerSeeder::class,
            AboutSectionSeeder::class,
            StatisticSeeder::class,
            FeatureSeeder::class,
            HowItWorkSeeder::class,
            CtaSectionSeeder::class,
        ]);
    }
}
