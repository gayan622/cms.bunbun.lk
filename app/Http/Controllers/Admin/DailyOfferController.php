<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyOffer;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class DailyOfferController extends Controller
{
    public function index()
    {
        $items = DailyOffer::with('menuItem')->latest()->get();
        return view('admin.daily-offers.index', compact('items'));
    }

    public function create()
    {
        $menuItems = MenuItem::where('is_available', true)->latest()->get();
        return view('admin.daily-offers.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'title' => 'required|string|max:255',
            'offer_price' => 'required|numeric',
            'offer_date' => 'required|date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        DailyOffer::create($data);

        return redirect('/admin/daily-offers')->with('success', 'Offer created');
    }

    public function show(DailyOffer $dailyOffer)
    {
        return view('admin.daily-offers.show', compact('dailyOffer'));
    }

    public function edit(DailyOffer $dailyOffer)
    {
        $menuItems = MenuItem::where('is_available', true)->latest()->get();
        return view('admin.daily-offers.edit', compact('dailyOffer', 'menuItems'));
    }

    public function update(Request $request, DailyOffer $dailyOffer)
    {
        $data = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'title' => 'required|string|max:255',
            'offer_price' => 'required|numeric',
            'offer_date' => 'required|date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $dailyOffer->update($data);

        return redirect('/admin/daily-offers')->with('success', 'Offer updated');
    }

    public function destroy(DailyOffer $dailyOffer)
    {
        $dailyOffer->delete();
        return back()->with('success', 'Offer deleted');
    }
}