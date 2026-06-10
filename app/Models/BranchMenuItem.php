<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 

class BranchMenuItem extends Model
{
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_menu_items')
            ->withPivot(['is_available', 'branch_price'])
            ->withTimestamps();
    }
}
