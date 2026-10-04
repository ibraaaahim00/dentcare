<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;
use Carbon\Carbon;

class MedicalRecordService
{
    public function __construct(
        protected MedicalRecordRepositoryInterface $medicalRecordRepository
    ) {}

    /**
     * Create or update a medical record for a consultation.
     */
    public function recordTreatment(Doctor $doctor, array $data): MedicalRecord
    {
        $data['doctor_id'] = $doctor->id;
        if (empty($data['treatment_date'])) {
            $data['treatment_date'] = Carbon::today()->toDateString();
        }

        if (! empty($data['appointment_id'])) {
            $appointment = Appointment::find($data['appointment_id']);
            if ($appointment) {
                $data['patient_id'] = $appointment->patient_id;
            }
        }

        /** @var MedicalRecord */
        return $this->medicalRecordRepository->create($data);
    }
}
