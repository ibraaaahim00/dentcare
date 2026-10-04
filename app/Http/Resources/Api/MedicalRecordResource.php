<?php

namespace App\Http\Resources\Api;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MedicalRecord
 */
class MedicalRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'appointment_id' => $this->appointment_id,
            'diagnosis' => $this->diagnosis,
            'treatment' => $this->treatment,
            'notes' => $this->notes,
            'treatment_date' => $this->treatment_date?->format('Y-m-d'),
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'patient' => new UserResource($this->whenLoaded('patient')),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
