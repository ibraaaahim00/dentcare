<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patient1 = User::where('email', 'patient1@dentcare.com')->first();
        $patient2 = User::where('email', 'patient2@dentcare.com')->first();
        $patient3 = User::where('email', 'patient3@dentcare.com')->first();

        $doctors = Doctor::with('services')->get();
        if ($doctors->isEmpty() || ! $patient1) {
            return;
        }

        $doc1 = $doctors[0];
        $doc2 = $doctors[1] ?? $doc1;
        $doc3 = $doctors[2] ?? $doc1;

        $services = Service::all();
        $whitening = $services->firstWhere('slug', 'laser-teeth-whitening') ?? $services->first();
        $implant = $services->firstWhere('slug', 'dental-implants') ?? $services->first();
        $aligner = $services->firstWhere('slug', 'clear-aligners') ?? $services->first();
        $cleaning = $services->firstWhere('slug', 'dental-cleaning-polishing') ?? $services->first();

        // 1. Completed appointment (5 days ago) for Patient 1
        Appointment::updateOrCreate(
            [
                'patient_id' => $patient1->id,
                'doctor_id' => $doc1->id,
                'appointment_date' => Carbon::today()->subDays(5)->toDateString(),
                'start_time' => '10:00:00',
            ],
            [
                'service_id' => $whitening->id,
                'end_time' => '10:45:00',
                'status' => AppointmentStatus::Completed,
                'patient_notes' => 'Patient requested special attention to lower front incisor stain.',
                'doctor_notes' => 'Zoom 4 whitening executed successfully. Lightened 7 shades from A3 to B1.',
                'confirmed_at' => Carbon::today()->subDays(6),
                'completed_at' => Carbon::today()->subDays(5)->setTime(11, 0),
            ]
        );

        // 2. Completed appointment (3 days ago) for Patient 2
        Appointment::updateOrCreate(
            [
                'patient_id' => $patient2->id,
                'doctor_id' => $doc2->id,
                'appointment_date' => Carbon::today()->subDays(3)->toDateString(),
                'start_time' => '14:00:00',
            ],
            [
                'service_id' => $implant->id,
                'end_time' => '15:00:00',
                'status' => AppointmentStatus::Completed,
                'patient_notes' => 'Consultation and surgical evaluation for lower left molar implant.',
                'doctor_notes' => 'Straumann implant placed on site #36 with good initial stability. Sutured.',
                'confirmed_at' => Carbon::today()->subDays(4),
                'completed_at' => Carbon::today()->subDays(3)->setTime(15, 15),
            ]
        );

        // 3. Confirmed appointment Today for Patient 1
        Appointment::updateOrCreate(
            [
                'patient_id' => $patient1->id,
                'doctor_id' => $doc1->id,
                'appointment_date' => Carbon::today()->toDateString(),
                'start_time' => '16:00:00',
            ],
            [
                'service_id' => $aligner->id,
                'end_time' => '16:30:00',
                'status' => AppointmentStatus::Confirmed,
                'patient_notes' => 'Follow up on Invisalign tray set #4 fitting.',
                'doctor_notes' => null,
                'confirmed_at' => Carbon::today()->subDays(1),
            ]
        );

        // 4. Pending appointment Tomorrow for Patient 3
        Appointment::updateOrCreate(
            [
                'patient_id' => $patient3->id,
                'doctor_id' => $doc3->id,
                'appointment_date' => Carbon::tomorrow()->toDateString(),
                'start_time' => '11:00:00',
            ],
            [
                'service_id' => $cleaning->id,
                'end_time' => '11:30:00',
                'status' => AppointmentStatus::Pending,
                'patient_notes' => 'Routine scaling and air-flow polishing visit.',
                'doctor_notes' => null,
            ]
        );

        // 5. Cancelled appointment
        Appointment::updateOrCreate(
            [
                'patient_id' => $patient2->id,
                'doctor_id' => $doc1->id,
                'appointment_date' => Carbon::today()->subDays(10)->toDateString(),
                'start_time' => '12:00:00',
            ],
            [
                'service_id' => $cleaning->id,
                'end_time' => '12:30:00',
                'status' => AppointmentStatus::Cancelled,
                'patient_notes' => 'Need early morning appointment.',
                'cancellation_reason' => 'Patient had an emergency business trip.',
                'cancelled_at' => Carbon::today()->subDays(11),
            ]
        );
    }
}
