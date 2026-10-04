<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkingHoursRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hours' => ['required', 'array'],
            'hours.*.day_of_week' => ['required', 'integer', 'between:0,6'],
            'hours.*.start_time' => ['required', 'string', 'date_format:H:i'],
            'hours.*.end_time' => ['required', 'string', 'date_format:H:i', 'after:hours.*.start_time'],
            'hours.*.is_closed' => ['nullable', 'boolean'],
        ];
    }
}
