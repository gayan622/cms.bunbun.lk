<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        // Fetch categories that are active, including their related menu items
        $categories = Category::where('is_active', true)
            ->latest()
            ->with('menuItems') 
            ->get();

        return response()->json($categories);
    }
}