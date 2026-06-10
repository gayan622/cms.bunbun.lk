@extends('admin.layouts.admin_layout')

@section('title', 'Edit Order - BunBun CMS')
@section('page_title', 'Edit Order')
@section('page_subtitle', 'Update order and payment status')

@section('content')

<div class="max-w-2xl rounded-3xl bg-white p-8 shadow-xl">
    <form method="POST" action="/admin/orders/{{ $order->id }}">
        @csrf
        @method('PUT')

        @if ($errors->any())
        <div class="mb-5 p-4 bg-red-100 text-red-700 rounded-xl">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <div class="mb-6">
            <p class="text-gray-500 text-sm">Order Number</p>
            <p class="text-xl font-black text-[#E50914]">{{ $order->order_number }}</p>
        </div>

        <label class="block font-bold mb-2">Order Status</label>
        <select name="status" class="mb-5 w-full rounded-xl border p-4">
            @foreach(['pending', 'confirmed', 'preparing', 'delivered', 'cancelled'] as $status)
                <option value="{{ $status }}" @selected($order->status === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        <label class="block font-bold mb-2">Payment Status</label>
        <select name="payment_status" class="w-full rounded-xl border p-4">
            @foreach(['pending', 'paid', 'failed'] as $paymentStatus)
                <option value="{{ $paymentStatus }}" @selected($order->payment_status === $paymentStatus)>
                    {{ ucfirst($paymentStatus) }}
                </option>
            @endforeach
        </select>

        <div class="mt-6 flex gap-3">
            <button class="rounded-xl bg-[#E50914] px-6 py-3 font-bold text-white">
                Update Order
            </button>

            <a href="/admin/orders" class="rounded-xl bg-black px-6 py-3 font-bold text-white">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
