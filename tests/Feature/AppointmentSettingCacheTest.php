<?php

use App\Models\AppointmentSetting;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Cache::forget('appointment_settings_singleton');
    Cache::forget('appointment_settings_singleton_v2');
});

test('current returns a model when a legacy cached value exists', function () {
    $appointmentSetting = AppointmentSetting::create([
        'booking_interval' => 30,
        'minimum_notice_hours' => 2,
        'maximum_days_ahead' => 30,
        'cancellation_hours' => 4,
    ]);
    Cache::put('appointment_settings_singleton', 'legacy cached value');

    $currentSetting = AppointmentSetting::current();

    expect($currentSetting)
        ->toBeInstanceOf(AppointmentSetting::class)
        ->and($currentSetting->id)->toBe($appointmentSetting->id)
        ->and($currentSetting->booking_interval)->toBe(30);
});

test('current rehydrates a model from cached attributes', function () {
    $appointmentSetting = AppointmentSetting::create([
        'booking_interval' => 45,
        'minimum_notice_hours' => 3,
        'maximum_days_ahead' => 60,
        'cancellation_hours' => 12,
    ]);
    Cache::put('appointment_settings_singleton_v2', $appointmentSetting->getAttributes());

    $currentSetting = AppointmentSetting::current();

    expect($currentSetting)
        ->toBeInstanceOf(AppointmentSetting::class)
        ->and($currentSetting->id)->toBe($appointmentSetting->id)
        ->and($currentSetting->booking_interval)->toBe(45)
        ->and($currentSetting->maximum_days_ahead)->toBe(60);
});
test('current creates default settings when no record exists', function () {
    $currentSetting = AppointmentSetting::current();

    expect($currentSetting)
        ->toBeInstanceOf(AppointmentSetting::class)
        ->and($currentSetting->booking_interval)->toBe(30)
        ->and($currentSetting->minimum_notice_hours)->toBe(2);
});
