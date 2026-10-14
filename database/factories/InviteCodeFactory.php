<?php

namespace Database\Factories;

use App\Enums\InviteTier;
use App\Models\InviteCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<InviteCode> */
class InviteCodeFactory extends Factory
{
    public function definition(): array
    {
        $hours = (int) config('gotham.invite_code.expiry_hours', 6);
        return [
            'code' => strtoupper(Str::random((int) config('gotham.invite_code.length', 10))),
            'tier' => fake()->randomElement([InviteTier::Super, InviteTier::Operator]),
            'created_by' => null,
            'used_by' => null,
            'used_at' => null,
            'expires_at' => now()->addHours($hours),
        ];
    }

    public function used(): static
    {
        return $this->state(fn () => ['used_at' => now()]);
    }
}
