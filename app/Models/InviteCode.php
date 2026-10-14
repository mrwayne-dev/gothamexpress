<?php

namespace App\Models;

use App\Enums\InviteTier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InviteCode extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'tier', 'created_by', 'used_by', 'used_at', 'expires_at'];

    protected function casts(): array
    {
        return [
            'tier' => InviteTier::class,
            'used_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function consumer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    public function isUsable(): bool
    {
        return $this->used_at === null && $this->expires_at->isFuture();
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->whereNull('used_at')->where('expires_at', '>', now());
    }

    public function scopeUsed(Builder $q): Builder
    {
        return $q->whereNotNull('used_at');
    }

    public function scopeExpired(Builder $q): Builder
    {
        return $q->whereNull('used_at')->where('expires_at', '<=', now());
    }
}
