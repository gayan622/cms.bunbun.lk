@extends('admin.layouts.admin_layout')

@section('title', 'Orders - BunBun CMS')
@section('page_title', 'Orders')
@section('page_subtitle', 'Manage customer food orders')

@section('content')

<div class="overflow-hidden rounded-3xl bg-white shadow-xl">
    <table class="w-full">
        <thead class="bg-[#E50914] text-white">
            <tr>
                <th class="p-4 text-left">Order No</th>
                <th class="p-4 text-left">Customer</th>
                <th class="p-4 text-left">Phone</th>
                <th class="p-4 text-left">Total</th>
                <th class="p-4 text-left">Order Status</th>
                <th class="p-4 text-left">Payment</th>
                <th class="p-4 text-left">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($items as $item)
                <tr class="border-b">
                    <td class="p-4 font-black text-[#E50914]">{{ $item->order_number }}</td>
                    <td class="p-4 font-bold">{{ $item->customer_name }}</td>
                    <td class="p-4">{{ $item->phone }}</td>
                    <td class="p-4 font-bold">Rs. {{ $item->total }}</td>
                    <td class="p-4">{{ ucfirst($item->status) }}</td>
                    <td class="p-4">{{ ucfirst($item->payment_status) }}</td>
                    <td class="p-4 flex gap-3">
                        <a href="/admin/orders/{{ $item->id }}" class="font-bold text-blue-600">View</a>
                        <a href="/admin/orders/{{ $item->id }}/edit" class="font-bold text-[#E50914]">Edit</a>

                        <form method="POST" action="/admin/orders/{{ $item->id }}" onsubmit="return confirm('Delete this order?')">
                            @csrf
                            @method('DELETE')
                            <button class="font-bold text-red-700">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        No orders found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection