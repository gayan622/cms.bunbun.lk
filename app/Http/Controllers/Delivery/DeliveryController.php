<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
       $orders = Order::where('order_type', 'delivery')  
        ->whereIn('status', ['ready', 'out_for_delivery'])
        ->latest()
        ->get();

        return view('admin.delivery.index', compact('orders'));
    }

	public function markAsDelivered($id) {
		$order = Order::findOrFail($id);
		$order->status = 'delivered';
		$order->save();

		return back()->with('success', 'Order marked as delivered!');
	}


    public function updateStatus(Request $request, Order $order, $status)
    {
        // Validate that the order is actually a 'delivery' type
        if ($order->order_type !== 'delivery') {
            return back()->withErrors('This is not a delivery order.');
        }

        $order->update(['status' => $status]);

        return redirect()->route('delivery.dashboard')->with('success', 'Order status updated successfully');
    }
}
