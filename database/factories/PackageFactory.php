<?php

namespace Database\Factories;

use App\Enums\PackageStatus;
use App\Enums\PaymentStatus;
use App\Models\Package;
use App\Models\User;
use App\Services\TrackingIdService;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Package> */
class PackageFactory extends Factory
{
    public function definition(): array
    {
        $firstname = fake()->firstName();
        $lastname = fake()->lastName();

        return [
            'tracking_id' => app(TrackingIdService::class)->generate(),
            'package_name' => fake()->words(3, true),
            'amount' => fake()->randomFloat(2, 25, 850),
            'description' => fake()->sentence(10),
            'invoice_message' => fake()->optional()->sentence(),
            'sender' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->streetAddress(),
            'location' => fake()->city().', '.fake()->country(),
            'address_type' => fake()->randomElement(['Residential', 'Commercial']),
            'image' => null,
            'status' => fake()->randomElement([
                PackageStatus::Processing,
                PackageStatus::Processing,
                PackageStatus::InTransit,
                PackageStatus::Delivered,
            ]),
            'payment_status' => fake()->randomElement([PaymentStatus::Unpaid, PaymentStatus::Paid]),
            'created_by' => User::factory()->superAdmin(),
            'user_id' => null,
        ];
    }
}
