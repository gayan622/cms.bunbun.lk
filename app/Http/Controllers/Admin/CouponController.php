<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $items = Coupon::latest()->get();
        return view('admin.coupons.index', compact('items'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:100|unique:coupons,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'minimum_spend' => 'nullable|numeric',
            'usage_limit' => 'nullable|integer',
            'expires_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['code'] = strtoupper($data['code']);
        $data['minimum_spend'] = $data['minimum_spend'] ?? 0;
        $data['is_active'] = $request->has('is_active');

        Coupon::create($data);

        return redirect('/admin/coupons')->with('success', 'Coupon created');
    }

    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $request->validate([
            'code' => 'required|string|max:100|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'minimum_spend' => 'nullable|numeric',
            'usage_limit' => 'nullable|integer',
            'expires_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $data['code'] = strtoupper($data['code']);
        $data['minimum_spend'] = $data['minimum_spend'] ?? 0;
        $data['is_active'] = $request->has('is_active');

        $coupon->update($data);

        return redirect('/admin/coupons')->with('success', 'Coupon updated');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'Coupon deleted');
    }
}
