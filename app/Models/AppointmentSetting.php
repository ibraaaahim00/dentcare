<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppointmentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_interval',
        'minimum_notice_hours',
        'maximum_days_ahead',
        'cancellation_hours',
    ];

    protected function casts(): array
    {
        return [
            'booking_interval' => 'integer',
            'minimum_notice_hours' => 'integer',
            'maximum_days_ahead' => 'integer',
            'cancellation_hours' => 'integer',
        ];
    }

    public static function current(): self
    {
        return Cache::rememberForever('appointment_settings_singleton', function () {
            return self::firstOrCreate([], [
                'booking_interval' => 30,
                'minimum_notice_hours' => 2,
                'maximum_days_ahead' => 30,
                'cancellation_hours' => 4,
            ]);
        });
    }

    public static function flushCache(): void
    {
        Cache::forget('appointment_settings_singleton');
    }
}
