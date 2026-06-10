<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuItemController extends Controller
{
    public function index()
    {
        $items = MenuItem::with('category')->latest()->get();
        return view('admin.menu-items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.menu-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'badge' => 'nullable|string|max:100',
            'is_available' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . time();
        $data['is_available'] = $request->has('is_available');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu-items', 'public');
        }

        MenuItem::create($data);

        return redirect('/admin/menu-items')->with('success', 'Menu item created');
    }

    public function show(MenuItem $menuItem)
    {
        return view('admin.menu-items.show', compact('menuItem'));
    }

    public function edit(MenuItem $menuItem)
    {
        $categories = Category::latest()->get();
        return view('admin.menu-items.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'badge' => 'nullable|string|max:100',
            'is_available' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . $menuItem->id;
        $data['is_available'] = $request->has('is_available');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu-items', 'public');
        }

        $menuItem->update($data);

        return redirect('/admin/menu-items')->with('success', 'Menu item updated');
    }

    // NEW: Easy stock increment for inventory management
    public function addStock(Request $request, $id)
    {
        $request->validate(['amount' => 'required|integer|min:1']);

        $item = MenuItem::findOrFail($id);
        $item->increment('stock', $request->amount);

        return back()->with('success', "Stock updated! New total: {$item->stock}");
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return back()->with('success', 'Menu item deleted');
    }
}
