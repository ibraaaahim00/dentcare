<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'clinic_name_ar' => ['required', 'string', 'max:255'],
            'clinic_name_en' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'emergency_phone' => ['nullable', 'string', 'max:50'],
            'address_ar' => ['required', 'string', 'max:255'],
            'address_en' => ['required', 'string', 'max:255'],
            'booking_interval' => ['required', 'integer', 'min:15', 'max:120'],
            'minimum_notice_hours' => ['required', 'integer', 'min:0', 'max:72'],
            'maximum_days_ahead' => ['required', 'integer', 'min:1', 'max:365'],
            'cancellation_hours' => ['required', 'integer', 'min:0', 'max:72'],
        ];
    }
}
