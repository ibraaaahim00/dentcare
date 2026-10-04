<?php

use App\Models\ClinicSetting;

if (! function_exists('clinic_setting')) {
    /**
     * Get a clinic setting value by key with optional fallback.
     */
    function clinic_setting(string $key, mixed $default = null): mixed
    {
        return ClinicSetting::get($key, $default);
    }
}
