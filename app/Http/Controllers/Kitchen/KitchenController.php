<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index()
    {
        // Fetch only active orders to reduce database load
        $orders = Order::with('items')
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->latest()
            ->get();

        return view('admin.kitchen.index', compact('orders'));
    }

    /**
     * Update the status of a specific order.
     * Note: 'order' is injected via Route Model Binding.
     */
    public function updateStatus(Request $request, Order $order, string $status)
    {
        // 1. Define allowed statuses
        $allowedStatuses = ['pending', 'confirmed', 'preparing', 'ready', 'delivered'];

        // 2. Validate status
        if (!in_array($status, $allowedStatuses)) {
            return back()->with('error', 'Invalid status transition.');
        }

        // 3. Perform update
        $order->update(['status' => $status]);

        // 4. Return to the kitchen dashboard with feedback
        return redirect()->route('kitchen.index')
                         ->with('success', "Order #{$order->order_number} marked as {$status}.");
    }
}
