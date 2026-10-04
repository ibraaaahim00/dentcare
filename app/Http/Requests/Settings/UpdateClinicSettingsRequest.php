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
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'facebook_url' => ['nullable', 'string', 'max:255'],
            'twitter_url' => ['nullable', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['nullable', 'string', 'max:255'],
            'linkedin_url' => ['nullable', 'string', 'max:255'],
            'google_map_embed' => ['nullable', 'string'],
            'google_map_link' => ['nullable', 'string', 'max:500'],
            'header_topbar_announcement_ar' => ['nullable', 'string', 'max:255'],
            'header_topbar_announcement_en' => ['nullable', 'string', 'max:255'],
            'footer_text_ar' => ['nullable', 'string'],
            'footer_text_en' => ['nullable', 'string'],
            'copyright_text_ar' => ['nullable', 'string', 'max:255'],
            'copyright_text_en' => ['nullable', 'string', 'max:255'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_description_ar' => ['nullable', 'string', 'max:500'],
            'meta_description_en' => ['nullable', 'string', 'max:500'],
            'meta_keywords_ar' => ['nullable', 'string', 'max:255'],
            'meta_keywords_en' => ['nullable', 'string', 'max:255'],
            'booking_interval' => ['required', 'integer', 'min:15', 'max:120'],
            'minimum_notice_hours' => ['required', 'integer', 'min:0', 'max:72'],
            'maximum_days_ahead' => ['required', 'integer', 'min:1', 'max:365'],
            'cancellation_hours' => ['required', 'integer', 'min:0', 'max:72'],
        ];
    }
}
