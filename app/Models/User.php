<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'location',
        'role',
        'telegram_chat_id',
        'telegram_enabled',
        'email_verified_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'telegram_enabled' => 'boolean',
        ];
    }

    public function packagesCreated(): HasMany
    {
        return $this->hasMany(Package::class, 'created_by');
    }

    public function packagesOwned(): HasMany
    {
        return $this->hasMany(Package::class, 'user_id');
    }

    public function transactionsConfirmed(): HasMany
    {
        return $this->hasMany(Transaction::class, 'confirmed_by');
    }

    public function inviteCodesCreated(): HasMany
    {
        return $this->hasMany(InviteCode::class, 'created_by');
    }

    public function inviteCodesUsed(): HasMany
    {
        return $this->hasMany(InviteCode::class, 'used_by');
    }
}
