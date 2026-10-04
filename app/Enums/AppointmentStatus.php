<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case NoShow = 'no_show';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Confirmed => 'Confirmed',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
            self::NoShow => 'No Show',
        };
    }

    public function labelAr(): string
    {
        return match ($this) {
            self::Pending => 'قيد الانتظار',
            self::Confirmed => 'مؤكد',
            self::Completed => 'مكتمل',
            self::Cancelled => 'ملغى',
            self::NoShow => 'لم يحضر',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-amber-100 text-amber-800 border-amber-200',
            self::Confirmed => 'bg-blue-100 text-blue-800 border-blue-200',
            self::Completed => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            self::Cancelled => 'bg-rose-100 text-rose-800 border-rose-200',
            self::NoShow => 'bg-slate-100 text-slate-800 border-slate-200',
        };
    }

    public function canTransitionTo(AppointmentStatus $target): bool
    {
        if ($this === $target) {
            return true;
        }

        return match ($this) {
            self::Pending => in_array($target, [self::Confirmed, self::Cancelled], true),
            self::Confirmed => in_array($target, [self::Completed, self::Cancelled, self::NoShow], true),
            self::Completed, self::Cancelled, self::NoShow => false,
        };
    }
}
