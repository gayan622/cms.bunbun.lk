@extends('admin.layouts.admin_layout')

@section('title', 'Delivery Dashboard')
@section('page_title', 'Delivery Dashboard')
@section('page_subtitle', 'Assigned delivery orders')

@section('content')

<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3" id="delivery-board">
    @forelse($orders as $order)
        <div class="rounded-3xl bg-white p-6 shadow-xl border-l-4 border-blue-500">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-2xl font-black text-[#E50914]">{{ $order->order_number }}</h3>
                <span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-bold text-blue-700">
                    {{ strtoupper($order->status) }}
                </span>
            </div>

            <div class="space-y-2 mb-4">
                <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                <p><strong>Phone:</strong> <a href="tel:{{ $order->phone }}" class="text-blue-600 underline">{{ $order->phone }}</a></p>
                <p><strong>Address:</strong> {{ $order->address }}</p>
                <p class="text-xl font-black">Total: Rs. {{ number_format($order->total, 2) }}</p>
            </div>

            {{-- Action Form --}}
            <form action="{{ route('delivery.updateStatus', [$order->id, 'delivered']) }}" method="POST" class="mt-6">
                @csrf @method('PUT')
                <button type="submit"
                        class="w-full rounded-xl bg-green-600 p-4 text-center font-bold text-white transition hover:bg-green-700">
                    Mark as Delivered
                </button>
            </form>
        </div>
    @empty
        <div class="col-span-full rounded-3xl bg-white p-10 text-center shadow-xl">
            <p class="text-gray-500 text-lg font-bold">No delivery orders currently assigned.</p>
        </div>
    @endforelse
</div>

{{-- Auto-refresh script --}}
<script>
    // Refresh the page every 30 seconds to fetch new orders
    setInterval(() => {
        window.location.reload();
    }, 30000);
</script>

@endsection
