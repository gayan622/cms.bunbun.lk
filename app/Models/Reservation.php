<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'customer_name',
        'phone',
        'reservation_date',
        'reservation_time',
        'guest_count',
        'table_id',
        'status',
    ];

    protected $casts = [
        'reservation_date' => 'date',
    ];
}