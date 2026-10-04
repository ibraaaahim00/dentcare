<?php

namespace App\Http\Requests\MedicalRecord;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'integer', 'exists:users,id'],
            'appointment_id' => ['nullable', 'integer', 'exists:appointments,id'],
            'diagnosis' => ['required', 'string'],
            'treatment' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'treatment_date' => ['required', 'date'],
        ];
    }
}
