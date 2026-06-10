<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MenuItem;

class Branch extends Model
{
   protected $fillable = [
            'name',
            'slug',
            'address',
            'phone',
            'email',
            'latitude',
            'longitude',
            'is_active',
        ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function menuItems()
{
    return $this->belongsToMany(
        MenuItem::class,
        'branch_menu_items', // Force use of plural name
        'branch_id',
        'menu_item_id'
    )
    ->withPivot(['is_available', 'branch_price'])
    ->withTimestamps();
}
}
