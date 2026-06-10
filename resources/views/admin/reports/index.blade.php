@extends('admin.layouts.admin_layout')

@section('title', 'Reports - BunBun CMS')
@section('page_title', 'Reports')
@section('page_subtitle', 'Daily sales, pending orders, completed orders, quotations and monthly PNL')

@section('content')

<form method="GET" class="mb-6 flex gap-3">
    <input type="month" name="month" value="{{ $month }}" class="rounded-xl border p-3">
    <button class="rounded-xl bg-[#E50914] px-5 py-3 font-bold text-white">
        Filter Month
    </button>
</form>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Today Sales</p>
        <h3 class="text-3xl font-black text-[#E50914]">
            Rs. {{ number_format($dailySales, 2) }}
        </h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Pending Orders</p>
        <h3 class="text-3xl font-black">
            {{ $pendingOrders }}
        </h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Completed Orders</p>
        <h3 class="text-3xl font-black">
            {{ $completedOrders }}
        </h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Monthly PNL</p>
        <h3 class="text-3xl font-black {{ $monthlyProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">
            Rs. {{ number_format($monthlyProfit, 2) }}
        </h3>
    </div>

</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Monthly Revenue</p>
        <h3 class="text-3xl font-black text-green-600">
            Rs. {{ number_format($monthlyRevenue, 2) }}
        </h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Monthly Expenses</p>
        <h3 class="text-3xl font-black text-red-600">
            Rs. {{ number_format($monthlyExpenses, 2) }}
        </h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Net Profit / Loss</p>
        <h3 class="text-3xl font-black {{ $monthlyProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">
            Rs. {{ number_format($monthlyProfit, 2) }}
        </h3>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <div class="rounded-3xl bg-white shadow-xl overflow-hidden">
        <div class="bg-[#E50914] text-white p-4 font-black">
            Next Orders
        </div>

        <table class="w-full">
            <thead class="bg-[#FAF6EE]">
                <tr>
                    <th class="p-3 text-left">Order</th>
                    <th class="p-3 text-left">Customer</th>
                    <th class="p-3 text-left">Total</th>
                    <th class="p-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nextOrders as $order)
                    <tr class="border-b">
                        <td class="p-3 font-bold">{{ $order->order_number }}</td>
                        <td class="p-3">{{ $order->customer_name }}</td>
                        <td class="p-3">Rs. {{ $order->total }}</td>
                        <td class="p-3">{{ ucfirst($order->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-5 text-center text-gray-500">No next orders.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="rounded-3xl bg-white shadow-xl overflow-hidden">
        <div class="bg-[#1C1A17] text-white p-4 font-black">
            Party Quotations
        </div>

        <table class="w-full">
            <thead class="bg-[#FAF6EE]">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Event</th>
                    <th class="p-3 text-left">Guests</th>
                    <th class="p-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partyQuotations as $quotation)
                    <tr class="border-b">
                        <td class="p-3 font-bold">{{ $quotation->name }}</td>
                        <td class="p-3">{{ ucfirst(str_replace('_', ' ', $quotation->event_type)) }}</td>
                        <td class="p-3">{{ $quotation->guest_count }}</td>
                        <td class="p-3">{{ ucfirst($quotation->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-5 text-center text-gray-500">No quotations.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<div class="mt-8 rounded-3xl bg-white shadow-xl overflow-hidden">
    <div class="bg-[#E50914] text-white p-4 font-black">
        Today Sales Report
    </div>

    <table class="w-full">
        <thead class="bg-[#FAF6EE]">
            <tr>
                <th class="p-3 text-left">Order</th>
                <th class="p-3 text-left">Customer</th>
                <th class="p-3 text-left">Phone</th>
                <th class="p-3 text-left">Total</th>
                <th class="p-3 text-left">Payment</th>
                <th class="p-3 text-left">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($recentSales as $sale)
                <tr class="border-b">
                    <td class="p-3 font-bold">{{ $sale->order_number }}</td>
                    <td class="p-3">{{ $sale->customer_name }}</td>
                    <td class="p-3">{{ $sale->phone }}</td>
                    <td class="p-3 font-bold text-[#E50914]">Rs. {{ $sale->total }}</td>
                    <td class="p-3">{{ ucfirst($sale->payment_status) }}</td>
                    <td class="p-3">{{ ucfirst($sale->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-gray-500">
                        No sales today.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection