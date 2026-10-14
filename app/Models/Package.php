<?php

namespace App\Models;

use App\Enums\PackageStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id', 'package_name', 'amount', 'description', 'invoice_message',
        'sender', 'phone', 'firstname', 'lastname', 'email', 'address', 'location',
        'address_type', 'image', 'status', 'payment_status', 'created_by', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'status' => PackageStatus::class,
            'payment_status' => PaymentStatus::class,
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(PackageStatusLog::class);
    }
}
