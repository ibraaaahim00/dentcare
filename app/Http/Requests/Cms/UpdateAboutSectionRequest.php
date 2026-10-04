<?php

namespace App\Http\Requests\Cms;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutSectionRequest extends FormRequest
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
            'subtitle_ar' => ['nullable', 'string', 'max:255'],
            'subtitle_en' => ['nullable', 'string', 'max:255'],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'vision_ar' => ['nullable', 'string'],
            'vision_en' => ['nullable', 'string'],
            'mission_ar' => ['nullable', 'string'],
            'mission_en' => ['nullable', 'string'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'experience_text_ar' => ['nullable', 'string', 'max:100'],
            'experience_text_en' => ['nullable', 'string', 'max:100'],
            'button_text_ar' => ['nullable', 'string', 'max:100'],
            'button_text_en' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'secondary_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
