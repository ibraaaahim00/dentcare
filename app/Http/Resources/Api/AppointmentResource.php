<?php

namespace App\Http\Resources\Api;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Appointment
 */
class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'service_id' => $this->service_id,
            'appointment_date' => $this->appointment_date?->format('Y-m-d'),
            'start_time' => substr($this->start_time, 0, 5),
            'end_time' => substr($this->end_time, 0, 5),
            'status' => $this->status?->value,
            'status_label' => $this->status?->label(),
            'status_label_ar' => $this->status?->labelAr(),
            'patient_notes' => $this->patient_notes,
            'doctor_notes' => $this->doctor_notes,
            'cancellation_reason' => $this->cancellation_reason,
            'confirmed_at' => $this->confirmed_at?->toISOString(),
            'completed_at' => $this->completed_at?->toISOString(),
            'cancelled_at' => $this->cancelled_at?->toISOString(),
            'patient' => new UserResource($this->whenLoaded('patient')),
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'service' => new ServiceResource($this->whenLoaded('service')),
            'medical_record' => new MedicalRecordResource($this->whenLoaded('medicalRecord')),
        ];
    }
}
