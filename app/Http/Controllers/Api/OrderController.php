<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string',
            'phone'          => 'required|string',
			'address'        => 'required|string',
            'payment_method' => 'required|in:cod,online', // Must match ENUM
            'order_type'     => 'required|in:delivery,takeaway,dine_in',
            'items'          => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity'     => 'required|integer|min:1',
        ]);

        // Calculate the next order number for today
            $todayCount = Order::whereDate('created_at', today())->count();
            $nextOrderNumber = $todayCount + 1;

        try {
            DB::beginTransaction();

            $orderTotal = 0;
            $orderItemsData = [];

            foreach ($validated['items'] as $item) {
                $menuItem = MenuItem::findOrFail($item['menu_item_id']);
                $itemTotal = $menuItem->price * $item['quantity'];
                $orderTotal += $itemTotal;

                $orderItemsData[] = [
                    'menu_item_id' => $menuItem->id,
                    'item_name'    => $menuItem->name,
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $menuItem->price,
                    'total'        => $itemTotal,
                ];
            }

            // Create Order matching migration columns
            $order = Order::create([
                'order_number'   => 'BUN-' . $nextOrderNumber,
                'customer_name'  => $validated['customer_name'],
                'phone'          => $validated['phone'],
				'address'        => $validated['address'],
                'payment_method' => $validated['payment_method'],
                'order_type'     => $validated['order_type'],
                'subtotal'       => $orderTotal, 
                'total'          => $orderTotal,
                'status'         => 'pending',
                'payment_status' => 'pending',
            ]);

            $order->items()->createMany($orderItemsData);

            DB::commit();

            return response()->json([
                'message' => 'Order placed successfully', 
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Order failed', 'error' => $e->getMessage()], 500);
        }
    }
}