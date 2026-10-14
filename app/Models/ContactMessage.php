<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    public $timestamps = false;

    protected $fillable = ['firstname', 'email', 'inquiry', 'message', 'responded_at', 'created_at'];

    protected $casts = [
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
