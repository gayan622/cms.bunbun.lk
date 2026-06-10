@extends('admin.layouts.admin_layout')

@section('title', 'Kitchen Dashboard')
@section('page_title', 'Kitchen Dashboard')
@section('page_subtitle', 'Live food preparation queue')

@section('content')

<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3" id="kitchen-board">
    @forelse($orders as $order)
       <div class="rounded-3xl bg-white p-6 shadow-xl transition-all duration-500" id="order-{{ $order->id }}">
    <div class="mb-4 flex items-center justify-between">
        <h3 class="text-3xl font-black text-[#E50914]">#{{ $order->order_number }}</h3>

        <span class="rounded-full px-3 py-1 text-xs font-bold uppercase
            {{ $order->status === 'preparing' ? 'bg-orange-100 text-orange-700' :
               ($order->status === 'ready' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700') }}">
            {{ $order->status }}
        </span>
    </div>

            <p class="font-bold">{{ $order->customer_name }}</p>
            <p class="text-sm text-gray-500">{{ ucfirst($order->order_type) }} • {{ $order->created_at->diffForHumans() }}</p>

            <div class="my-5 rounded-2xl bg-[#FAF6EE] p-4">
                @foreach($order->items as $item)
                    <div class="mb-2 flex justify-between border-b border-black/5 pb-1">
                        <span>{{ $item->item_name }}</span>
                        <strong class="text-lg">x{{ $item->quantity }}</strong>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-2 gap-3">
                <form action="{{ route('kitchen.update', [$order->id, 'preparing']) }}" method="POST">
                    @csrf @method('PUT')
                    <button class="w-full rounded-xl bg-orange-500 px-4 py-3 font-bold text-white hover:bg-orange-600">Preparing</button>
                </form>

                <form action="{{ route('kitchen.update', [$order->id, 'ready']) }}" method="POST">
                    @csrf @method('PUT')
                    <button class="w-full rounded-xl bg-green-600 px-4 py-3 font-bold text-white hover:bg-green-700">Ready</button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full rounded-3xl bg-white p-10 text-center shadow-xl">
            <p class="text-gray-500 text-xl font-bold">No active orders in the kitchen.</p>
        </div>
    @endforelse
</div>
<script>
    setInterval(async () => {
        try {
            const response = await fetch(window.location.href);
            const html = await response.text();
            const newDoc = new DOMParser().parseFromString(html, 'text/html');
            document.getElementById('kitchen-board').innerHTML = newDoc.getElementById('kitchen-board').innerHTML;
        } catch (error) {
            console.error('Failed to update kitchen board');
        }
    }, 10000); // Refreshes every 10 seconds without full page reload
</script>

@endsection
