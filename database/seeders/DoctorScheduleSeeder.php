<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Database\Seeder;

class DoctorScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            // Days 0 (Sunday) to 6 (Saturday)
            for ($day = 0; $day <= 6; $day++) {
                DoctorSchedule::updateOrCreate(
                    [
                        'doctor_id' => $doctor->id,
                        'day_of_week' => $day,
                    ],
                    [
                        'start_time' => '09:00:00',
                        'end_time' => '17:00:00',
                        'break_start' => '13:00:00',
                        'break_end' => '14:00:00',
                        'is_day_off' => ($day === 5), // Friday off
                    ]
                );
            }
        }
    }
}
