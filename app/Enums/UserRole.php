<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Operator = 'operator';
    case User = 'user';

    public function isAdmin(): bool
    {
        return in_array($this, [self::SuperAdmin, self::Operator], true);
    }

    public function canManageAdmins(): bool
    {
        return $this === self::SuperAdmin;
    }
}
