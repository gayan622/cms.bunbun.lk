<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $items = Order::with('items')->latest()->get();
        return view('admin.orders.index', compact('items'));
    }

    public function create()
    {
        $menuItems = MenuItem::where('is_available', true)->latest()->get();
        return view('admin.orders.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'nullable|string',
            'order_type' => 'required|in:delivery,takeaway,dine_in',
            'payment_method' => 'required|in:cash,card,online,credit,cod',
            'payment_status' => 'required|in:pending,advance_paid,partial_paid,paid,failed',
            'status' => 'required|in:pending,confirmed,preparing,ready,out_for_delivery,delivered,cancelled',
            'subtotal' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'delivery_fee' => 'nullable|numeric',
            'total' => 'required|numeric',
            'advance_amount' => 'nullable|numeric',
            'balance_amount' => 'nullable|numeric',
            'table_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $data['order_number'] = 'BB-' . strtoupper(Str::random(8));
        $data['discount'] = $data['discount'] ?? 0;
        $data['delivery_fee'] = $data['delivery_fee'] ?? 0;
        $data['advance_amount'] = $data['advance_amount'] ?? 0;
        $data['balance_amount'] = $data['balance_amount'] ?? 0;
        $data['cashier_id'] = auth()->id();

        Order::create($data);

        return redirect('/admin/orders')->with('success', 'Order created');
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,out_for_delivery,delivered,cancelled',
            'payment_status' => 'required|in:pending,advance_paid,partial_paid,paid,failed',
            'payment_method' => 'nullable|in:cash,card,online,credit,cod',
            'advance_amount' => 'nullable|numeric',
            'balance_amount' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $order->update($data);

        return redirect('/admin/orders')->with('success', 'Order updated');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'Order deleted');
    }
}
