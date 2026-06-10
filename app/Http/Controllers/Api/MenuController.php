<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Branch;

class MenuController extends Controller
{
   public function index()
    {
        $items = MenuItem::with('category')
            ->where('is_available', true)
            ->latest()
            ->get();

        return response()->json($items);
    }

    public function branches()
    {
        return Branch::where('is_active', true)->get();
    }

    public function branchMenu(Branch $branch)
    {
        return $branch->menuItems()
            ->wherePivot('is_available', true)
            ->with('category')
            ->get()
            ->map(function ($item) {
                $item->selling_price = $item->pivot->branch_price ?? $item->price;
                return $item;
            });
    }
}
