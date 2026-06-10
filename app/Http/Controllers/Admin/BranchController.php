<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BranchController extends Controller
{
    public function index()
    {
        $items = Branch::latest('created_at')->get();

        return view('admin.branches.index', compact('items'));
    }

    public function create()
    {
        $menuItems = MenuItem::where('is_available', 1)->orderBy('created_at', 'desc')->get();

        return view('admin.branches.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
            'menu_items' => 'nullable|array',
            'menu_items.*' => 'exists:menu_items,id',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . time();
        $data['is_active'] = $request->has('is_active') ? true : false;

        $branch = Branch::create($data);

        if ($request->has('menu_items')) {
            $syncData = [];

            foreach ($request->menu_items as $menuItemId) {
            $inputPrice = $request->input("prices.$menuItemId");
            $finalPrice = !empty($inputPrice) ? $inputPrice : MenuItem::find($menuItemId)->price;
                $syncData[$menuItemId] = [
                    'is_available' => true,
                    'branch_price' => $finalPrice,
                ];
            }

            //$branch->menuItems()->sync($syncData);
            $branch->menuItems()->sync($request->menu_items);
        }

        return redirect('/admin/branches')->with('success', 'Branch created successfully');
    }

    public function show(Branch $branch)
    {
        $branch->load('menuItems');

        return view('admin.branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        $menuItems = MenuItem::where('is_available', 1)->orderBy('created_at', 'desc')->get();

        $selectedMenuItems = $branch->menuItems()->pluck('menu_items.id')->toArray();

        return view('admin.branches.edit', compact(
            'branch',
            'menuItems',
            'selectedMenuItems'
        ));
    }

    public function update(Request $request, Branch $branch)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'nullable|string',
        'phone' => 'nullable|string|max:50',
        'email' => 'nullable|email|max:255',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'is_active' => 'nullable', // Changed to nullable to handle checkbox logic
        'menu_items' => 'nullable|array',
        'menu_items.*' => 'exists:menu_items,id',
    ]);

    $data['slug'] = Str::slug($data['name']) . '-' . $branch->id;
    $data['is_active'] = $request->has('is_active');

    $branch->update($data);

    $syncData = [];

    if ($request->has('menu_items')) {
        foreach ($request->menu_items as $menuItemId) {
            // Get price from input or default to menu_items table price
            $inputPrice = $request->input("prices.$menuItemId");
            $finalPrice = !empty($inputPrice) ? $inputPrice : MenuItem::find($menuItemId)->price;

            $syncData[$menuItemId] = [
                'is_available' => true,
                'branch_price' => $finalPrice,
            ];
        }
    }

    //$branch->menuItems()->sync($syncData);
    $branch->menuItems()->sync($request->menu_items);

    return redirect('/admin/branches')->with('success', 'Branch updated successfully');
}

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return back()->with('success', 'Branch deleted successfully');
    }
}
