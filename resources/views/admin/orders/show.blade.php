@extends('admin.layouts.admin_layout')

@section('title', 'View Order - BunBun CMS')
@section('page_title', 'View Order')
@section('page_subtitle', 'Order details and ordered items')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 rounded-3xl bg-white p-8 shadow-xl">
        <h3 class="text-2xl font-black text-[#E50914] mb-6">
            Order {{ $order->order_number }}
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
            <div><p class="text-sm text-gray-500">Customer</p><p class="font-bold">{{ $order->customer_name }}</p></div>
            <div><p class="text-sm text-gray-500">Phone</p><p class="font-bold">{{ $order->phone }}</p></div>
            <div><p class="text-sm text-gray-500">Email</p><p class="font-bold">{{ $order->email ?? '-' }}</p></div>
            <div><p class="text-sm text-gray-500">Payment Method</p><p class="font-bold">{{ strtoupper($order->payment_method) }}</p></div>
            <div class="md:col-span-2"><p class="text-sm text-gray-500">Address</p><p class="font-bold">{{ $order->address ?? '-' }}</p></div>
        </div>

        <table class="w-full">
            <thead class="bg-[#FAF6EE]">
                <tr>
                    <th class="p-3 text-left">Item</th>
                    <th class="p-3 text-left">Qty</th>
                    <th class="p-3 text-left">Unit</th>
                    <th class="p-3 text-left">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $orderItem)
                    <tr class="border-b">
                        <td class="p-3 font-bold">{{ $orderItem->item_name }}</td>
                        <td class="p-3">{{ $orderItem->quantity }}</td>
                        <td class="p-3">Rs. {{ $orderItem->unit_price }}</td>
                        <td class="p-3 font-bold">Rs. {{ $orderItem->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="rounded-3xl bg-[#1C1A17] p-8 text-white shadow-xl">
        <h3 class="text-2xl font-black text-yellow-400 mb-5">Summary</h3>

        <div class="space-y-3">
            <p>Subtotal: <b>Rs. {{ $order->subtotal }}</b></p>
            <p>Discount: <b>Rs. {{ $order->discount }}</b></p>
            <p class="text-2xl text-yellow-400">Total: <b>Rs. {{ $order->total }}</b></p>
            <p>Status: <b>{{ ucfirst($order->status) }}</b></p>
            <p>Payment: <b>{{ ucfirst($order->payment_status) }}</b></p>
        </div>

        <a href="/admin/orders/{{ $order->id }}/edit" class="mt-6 block rounded-xl bg-[#E50914] p-4 text-center font-bold">
            Update Order
        </a>

        <a href="/admin/orders" class="mt-3 block rounded-xl bg-white/10 p-4 text-center font-bold">
            Back
        </a>
    </div>

</div>

@endsection