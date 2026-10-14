<?php

namespace App\Policies;

use App\Models\User;

/** Gates admin-user management and invite-code generation. Super-admin only. */
class UserManagementPolicy
{
    public function manageAdmins(User $user): bool
    {
        return $user->role->canManageAdmins();
    }

    public function generateInviteCodes(User $user): bool
    {
        return $user->role->canManageAdmins();
    }

    public function viewAuditLog(User $user): bool
    {
        return $user->role->canManageAdmins();
    }

    public function manageWallets(User $user): bool
    {
        return $user->role->canManageAdmins();
    }
}
