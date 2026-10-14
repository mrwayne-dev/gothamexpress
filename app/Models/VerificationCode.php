<?php

namespace App\Models;

use App\Enums\VerificationCodeType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $fillable = ['email', 'code_hash', 'type', 'attempts', 'expires_at', 'used_at'];

    protected function casts(): array
    {
        return [
            'type' => VerificationCodeType::class,
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
            'attempts' => 'integer',
        ];
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->whereNull('used_at')->where('expires_at', '>', now());
    }

    public function isValid(): bool
    {
        $maxAttempts = (int) config('gotham.verification_code.max_attempts', 5);
        return $this->used_at === null
            && $this->expires_at->isFuture()
            && $this->attempts < $maxAttempts;
    }
}
