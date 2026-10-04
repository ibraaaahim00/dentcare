<?php

namespace App\Enums;

enum ContactMessageStatus: string
{
    case Unread = 'unread';
    case Read = 'read';
    case Replied = 'replied';

    public function label(): string
    {
        return match ($this) {
            self::Unread => 'Unread',
            self::Read => 'Read',
            self::Replied => 'Replied',
        };
    }

    public function labelAr(): string
    {
        return match ($this) {
            self::Unread => 'غير مقروءة',
            self::Read => 'تمت القراءة',
            self::Replied => 'تم الرد',
        };
    }
}
