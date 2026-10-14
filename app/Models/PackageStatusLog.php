<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageStatusLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['package_id', 'from_status', 'to_status', 'changed_by', 'notes', 'created_at'];

    protected $casts = ['created_at' => 'datetime'];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
