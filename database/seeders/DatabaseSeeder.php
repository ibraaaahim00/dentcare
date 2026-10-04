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
            ServiceSeeder::class,
            CategorySeeder::class,
            BlogPostSeeder::class,
            FaqSeeder::class,
            GallerySeeder::class,
            AppointmentSeeder::class,
            MedicalRecordSeeder::class,
            ReviewSeeder::class,
            ContactMessageSeeder::class,
        ]);
    }
}
