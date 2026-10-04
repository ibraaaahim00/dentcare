<?php

namespace Database\Seeders;

use App\Models\WorkingHour;
use Illuminate\Database\Seeder;

class WorkingHourSeeder extends Seeder
{
    public function run(): void
    {
        $days = [
            ['day_of_week' => 0, 'start_time' => '09:00:00', 'end_time' => '21:00:00', 'is_closed' => false], // Sunday
            ['day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '21:00:00', 'is_closed' => false], // Monday
            ['day_of_week' => 2, 'start_time' => '09:00:00', 'end_time' => '21:00:00', 'is_closed' => false], // Tuesday
            ['day_of_week' => 3, 'start_time' => '09:00:00', 'end_time' => '21:00:00', 'is_closed' => false], // Wednesday
            ['day_of_week' => 4, 'start_time' => '09:00:00', 'end_time' => '21:00:00', 'is_closed' => false], // Thursday
            ['day_of_week' => 5, 'start_time' => '09:00:00', 'end_time' => '17:00:00', 'is_closed' => true],  // Friday (Closed)
            ['day_of_week' => 6, 'start_time' => '10:00:00', 'end_time' => '18:00:00', 'is_closed' => false], // Saturday
        ];

        foreach ($days as $day) {
            WorkingHour::updateOrCreate(
                ['day_of_week' => $day['day_of_week']],
                $day
            );
        }
    }
}
