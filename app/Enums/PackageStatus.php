<?php

namespace App\Enums;

enum PackageStatus: string
{
    case Processing = 'processing';
    case InTransit = 'in_transit';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    public function isTerminal(): bool
    {
        return in_array($this, [self::Delivered, self::Cancelled], true);
    }

    /** Enforced state machine. Day-3 controllers call this before saving. */
    public function canTransitionTo(self $next): bool
    {
        if ($this === $next) return true;
        return match ($this) {
            self::Processing => in_array($next, [self::InTransit, self::Cancelled], true),
            self::InTransit => in_array($next, [self::Delivered, self::Cancelled], true),
            self::Delivered, self::Cancelled => false,
        };
    }
}
