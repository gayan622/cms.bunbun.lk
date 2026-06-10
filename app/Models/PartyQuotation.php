<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartyQuotation extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'event_type',
        'guest_count',
        'message',
        'event_date',
        'event_time',
        'hall_name',
        'special_note',
        'status',
        'booking_status',
        'payment_status',
        'advance_payment',
        'balance_payment',
        'total_amount',
    ];

    protected $casts = [
        'event_date' => 'date',
        'advance_payment' => 'decimal:2',
        'balance_payment' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];
}
