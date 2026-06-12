<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\{Order, OrderItem, MenuItem, Category}; // Added Category import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class POSController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        $menuItems = MenuItem::where('is_available', true)->latest()->get();

        return view('admin.cashier.pos', compact('categories', 'menuItems'));
    }

    public function store(Request $request)
{
    // 1. Validate including payment_status
    $request->validate([
        'items' => 'required|array|min:1',
        'items.*.id' => 'required|exists:menu_items,id',
        'items.*.qty' => 'required|integer|min:1',
        'total' => 'required|numeric',
        'type' => 'required|in:dine_in,takeaway,delivery',
        'payment_status' => 'required|in:pending,paid', // Added this
        'paid' => 'required|numeric',
        'customer_name' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
    ]);

    $todayCount = Order::whereDate('created_at', today())->count();
    $nextOrderNumber = $todayCount + 1;

    try {
        return DB::transaction(function () use ($request, $nextOrderNumber) {
            $calculatedTotal = 0;
            $orderItemsData = [];

            foreach ($request->items as $item) {
                $menuItem = MenuItem::findOrFail($item['id']);

                if ($menuItem->stock < $item['qty']) {
                    throw new \Exception("Insufficient stock for: {$menuItem->name}");
                }

                $menuItem->decrement('stock', $item['qty']);
                $itemTotal = $menuItem->price * $item['qty'];
                $calculatedTotal += $itemTotal;

                $orderItemsData[] = [
                    'menu_item_id' => $menuItem->id,
                    'item_name' => $menuItem->name,
                    'quantity' => $item['qty'],
                    'unit_price' => $menuItem->price,
                    'total' => $itemTotal
                ];
            }

            $order = Order::create([
                'order_number'   => 'BUN-' . $nextOrderNumber,
                'customer_name'  => $request->customer_name ?? 'Walk-in Customer',
                'phone'          => $request->phone ?? '0000000000',
                'payment_method' => $request->payment_method ?? 'cod',
                'order_type'     => $request->type,
                'subtotal'       => $calculatedTotal,
                'total'          => $calculatedTotal,
                'status'         => 'pending',
                'payment_status' => $request->payment_status, // Use the value from the form
                'paid'           => $request->paid, // Use the paid amount from the form
            ]);

            $order->items()->createMany($orderItemsData);

            return response()->json(['success' => true, 'message' => 'Order placed successfully!', 'order_number' => $order->order_number], 201);
        });
    } catch (\Exception $e) {
        // Log the full trace to storage/logs/laravel.log
    Log::error('POS Order Error: ' . $e->getMessage());
    Log::error($e->getTraceAsString());

    // Return more descriptive info to the frontend for debugging
    return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'file' => $e->getFile(), // Shows which file caused the error
        'line' => $e->getLine()  // Shows the exact line number
    ], 500);
        //return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
    }
}
}
