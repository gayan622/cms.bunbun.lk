<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'item_name',
        'quantity',
        'unit',
        'minimum_quantity',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'minimum_quantity' => 'decimal:2',
    ];
}