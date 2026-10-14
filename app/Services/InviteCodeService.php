<?php

namespace App\Services;

use App\Enums\InviteTier;
use App\Models\InviteCode;
use App\Models\User;
use Illuminate\Support\Str;

class InviteCodeService
{
    public function generate(InviteTier $tier, ?int $createdBy = null): InviteCode
    {
        $hours = (int) config('gotham.invite_code.expiry_hours', 6);
        $length = (int) config('gotham.invite_code.length', 10);

        do {
            $code = strtoupper(Str::random($length));
        } while (InviteCode::where('code', $code)->exists());

        return InviteCode::create([
            'code' => $code,
            'tier' => $tier,
            'created_by' => $createdBy,
            'expires_at' => now()->addHours($hours),
        ]);
    }

    public function find(string $code): ?InviteCode
    {
        return InviteCode::where('code', strtoupper($code))->first();
    }

    public function isUsable(?InviteCode $code): bool
    {
        return $code && $code->isUsable();
    }

    public function consume(InviteCode $code, User $user): void
    {
        $code->forceFill(['used_by' => $user->id, 'used_at' => now()])->save();
    }

    public function purgeExpired(): int
    {
        return InviteCode::expired()->delete();
    }
}
