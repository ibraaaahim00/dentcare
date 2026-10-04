<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Doctor = 'doctor';
    case Patient = 'patient';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Doctor => 'Doctor',
            self::Patient => 'Patient',
        };
    }

    public function labelAr(): string
    {
        return match ($this) {
            self::Admin => 'مدير النظام',
            self::Doctor => 'طبيب',
            self::Patient => 'مريض',
        };
    }
}
