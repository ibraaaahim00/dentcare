<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppointmentSetting extends Model
{
    use HasFactory;

    private const CACHE_KEY = 'appointment_settings_singleton_v2';

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
        $attributes = Cache::rememberForever(self::CACHE_KEY, function (): array {
            return self::firstOrCreate([], self::defaultAttributes())->getAttributes();
        });

        if (! is_array($attributes) || ! array_key_exists('id', $attributes)) {
            Cache::forget(self::CACHE_KEY);
            $attributes = self::firstOrCreate([], self::defaultAttributes())->getAttributes();
            Cache::forever(self::CACHE_KEY, $attributes);
        }

        $appointmentSetting = new self;
        $appointmentSetting->setRawAttributes($attributes, true);
        $appointmentSetting->exists = true;

        return $appointmentSetting;
    }

    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget('appointment_settings_singleton');
    }

    /**
     * @return array<string, int>
     */
    private static function defaultAttributes(): array
    {
        return [
            'booking_interval' => 30,
            'minimum_notice_hours' => 2,
            'maximum_days_ahead' => 30,
            'cancellation_hours' => 4,
        ];
    }
}
