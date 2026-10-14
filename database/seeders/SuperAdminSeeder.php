<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('gotham.seed_admin.email');
        $password = config('gotham.seed_admin.password');
        $name = config('gotham.seed_admin.name', 'Super Admin');

        if (! $email || ! $password) {
            throw new RuntimeException(
                'SEED_ADMIN_EMAIL and SEED_ADMIN_PASSWORD must be set in .env to seed the first super admin.'
            );
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => UserRole::SuperAdmin,
                'email_verified_at' => now(),
                'phone' => null,
                'location' => null,
            ],
        );
    }
}
