<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyOffer extends Model
{
    protected $fillable = [
        'menu_item_id',
        'title',
        'offer_price',
        'offer_date',
        'is_active',
    ];

    protected $casts = [
        'offer_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}