<?php

namespace App\Http\Requests\Cms;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCtaSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'badge_ar' => ['nullable', 'string', 'max:100'],
            'badge_en' => ['nullable', 'string', 'max:100'],
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'button_text_ar' => ['required', 'string', 'max:100'],
            'button_text_en' => ['required', 'string', 'max:100'],
            'button_url' => ['required', 'string', 'max:255'],
            'secondary_button_text_ar' => ['nullable', 'string', 'max:100'],
            'secondary_button_text_en' => ['nullable', 'string', 'max:100'],
            'secondary_button_url' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'background_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
