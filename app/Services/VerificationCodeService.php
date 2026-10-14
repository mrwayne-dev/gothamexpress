<?php

namespace App\Services;

use App\Enums\VerificationCodeType;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\DB;

class VerificationCodeService
{
    /**
     * Create a new 6-digit code for (email, type) and return the raw code.
     * Previous unused codes for the same (email, type) are deleted first.
     */
    public function issue(string $email, VerificationCodeType $type): string
    {
        $raw = $this->randomDigits((int) config('gotham.verification_code.length', 6));
        $hash = hash('sha256', $raw);
        $minutes = $type === VerificationCodeType::PasswordReset
            ? (int) config('gotham.password_reset_code.expiry_minutes', 15)
            : (int) config('gotham.verification_code.expiry_minutes', 60);

        DB::transaction(function () use ($email, $type, $hash, $minutes) {
            VerificationCode::where('email', $email)
                ->where('type', $type)
                ->whereNull('used_at')
                ->delete();

            VerificationCode::create([
                'email' => $email,
                'code_hash' => $hash,
                'type' => $type,
                'attempts' => 0,
                'expires_at' => now()->addMinutes($minutes),
            ]);
        });

        return $raw;
    }

    /**
     * Verify a submitted code. Returns true on success and consumes the row.
     * Increments attempts on failure; stops accepting after max attempts.
     */
    public function verify(string $email, string $code, VerificationCodeType $type): bool
    {
        $maxAttempts = $type === VerificationCodeType::PasswordReset
            ? (int) config('gotham.password_reset_code.max_attempts', 5)
            : (int) config('gotham.verification_code.max_attempts', 5);

        $hash = hash('sha256', $code);

        $record = VerificationCode::where('email', $email)
            ->where('type', $type)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->orderByDesc('id')
            ->first();

        if (! $record) return false;

        if ($record->attempts >= $maxAttempts) return false;

        if (! hash_equals($record->code_hash, $hash)) {
            $record->increment('attempts');
            return false;
        }

        $record->forceFill(['used_at' => now()])->save();
        return true;
    }

    public function purgeExpired(): int
    {
        return VerificationCode::where('expires_at', '<', now()->subDay())->delete();
    }

    private function randomDigits(int $length): string
    {
        $out = '';
        for ($i = 0; $i < $length; $i++) {
            $out .= random_int(0, 9);
        }
        return $out;
    }
}
