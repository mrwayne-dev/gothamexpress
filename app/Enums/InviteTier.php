<?php

namespace App\Enums;

enum InviteTier: string
{
    case Super = 'super';
    case Operator = 'operator';

    public function toRole(): UserRole
    {
        return match ($this) {
            self::Super => UserRole::SuperAdmin,
            self::Operator => UserRole::Operator,
        };
    }
}
