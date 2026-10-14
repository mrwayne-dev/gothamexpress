<?php

namespace App\Policies;

use App\Models\Package;
use App\Models\User;

class PackagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->isAdmin();
    }

    public function view(User $user, Package $package): bool
    {
        return $user->role->isAdmin() || $package->user_id === $user->id || $package->email === $user->email;
    }

    public function create(User $user): bool
    {
        return $user->role->isAdmin();
    }

    public function update(User $user, Package $package): bool
    {
        return $user->role->isAdmin();
    }

    public function delete(User $user, Package $package): bool
    {
        return $user->role->isAdmin();
    }
}
