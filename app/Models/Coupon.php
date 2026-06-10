<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'minimum_spend',
        'usage_limit',
        'expires_at',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_spend' => 'decimal:2',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
