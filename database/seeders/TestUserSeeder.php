<?php

namespace Database\Seeders;

use App\Enums\PackageStatus;
use App\Enums\PaymentStatus;
use App\Enums\UserRole;
use App\Models\Package;
use App\Models\PackageStatusLog;
use App\Models\User;
use App\Services\TrackingIdService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Only runs in local/testing. Creates a verified "user@example.com" plus
 * a couple of linked sample packages so Day 5 opens with real data.
 */
class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) return;

        $admin = User::where('role', UserRole::SuperAdmin)->first();
        if (! $admin) return;

        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => UserRole::User,
                'phone' => '+1 (555) 010-1010',
                'location' => 'Dallas, TX',
                'email_verified_at' => now(),
            ],
        );

        $tracking = app(TrackingIdService::class);

        $samples = [
            ['status' => PackageStatus::InTransit, 'payment' => PaymentStatus::Paid, 'name' => 'Vinyl boxed set'],
            ['status' => PackageStatus::Processing, 'payment' => PaymentStatus::Unpaid, 'name' => 'Watch repair return'],
        ];

        foreach ($samples as $s) {
            $pkg = Package::firstOrCreate(
                ['email' => $user->email, 'package_name' => $s['name']],
                [
                    'tracking_id' => $tracking->generate(),
                    'amount' => 275.50,
                    'description' => 'Seeded sample for the user dashboard.',
                    'invoice_message' => 'Thank you for using Gotham Express.',
                    'sender' => 'Wayne Industries',
                    'phone' => '+1 (555) 000-0100',
                    'firstname' => 'Test',
                    'lastname' => 'User',
                    'address' => '2400 Industrial Blvd',
                    'location' => 'Dallas, TX',
                    'address_type' => 'Commercial',
                    'status' => $s['status'],
                    'payment_status' => $s['payment'],
                    'created_by' => $admin->id,
                    'user_id' => $user->id,
                ],
            );

            PackageStatusLog::firstOrCreate(
                ['package_id' => $pkg->id, 'to_status' => $pkg->status->value],
                [
                    'from_status' => null,
                    'changed_by' => $admin->id,
                    'notes' => 'Seeded',
                    'created_at' => now(),
                ],
            );
        }
    }
}
