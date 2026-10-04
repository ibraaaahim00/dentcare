<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $completedAppointments = Appointment::where('status', AppointmentStatus::Completed)->get();

        foreach ($completedAppointments as $apt) {
            MedicalRecord::updateOrCreate(
                ['appointment_id' => $apt->id],
                [
                    'patient_id' => $apt->patient_id,
                    'doctor_id' => $apt->doctor_id,
                    'treatment_date' => $apt->appointment_date,
                    'diagnosis' => 'Clinical evaluation for '.($apt->service->name_en ?? 'Dental care').' with mild enamel discoloration.',
                    'treatment' => 'Completed '.($apt->service->name_en ?? 'dental procedure').' under aseptic conditions. Patient tolerated the intervention exceptionally well.',
                    'notes' => 'Patient advised on dental hygiene best practices. Follow-up recommended in 6 months.',
                ]
            );
        }
    }
}
