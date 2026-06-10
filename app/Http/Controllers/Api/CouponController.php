<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ], 404);
        }

        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon expired'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'coupon' => $coupon
        ]);
    }
}
