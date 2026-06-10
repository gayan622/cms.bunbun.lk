@extends('admin.layouts.admin_layout')

@section('title', 'Coupons - BunBun CMS')
@section('page_title', 'Coupons')
@section('page_subtitle', 'Manage regular customer discount coupons')

@section('content')

<div class="mb-6 flex justify-end">
    <a href="/admin/coupons/create" class="rounded-xl bg-[#E50914] px-5 py-3 font-bold text-white">
        + Add Coupon
    </a>
</div>

<div class="overflow-hidden rounded-3xl bg-white shadow-xl">
    <table class="w-full">
        <thead class="bg-[#E50914] text-white">
            <tr>
                <th class="p-4 text-left">Code</th>
                <th class="p-4 text-left">Type</th>
                <th class="p-4 text-left">Value</th>
                <th class="p-4 text-left">Min Spend</th>
                <th class="p-4 text-left">Expiry</th>
                <th class="p-4 text-left">Active</th>
                <th class="p-4 text-left">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($items as $item)
                <tr class="border-b">
                    <td class="p-4 font-black text-[#E50914]">{{ $item->code }}</td>
                    <td class="p-4">{{ ucfirst($item->type) }}</td>
                    <td class="p-4">{{ $item->type === 'percent' ? $item->value.'%' : 'Rs. '.$item->value }}</td>
                    <td class="p-4">Rs. {{ $item->minimum_spend }}</td>
                    <td class="p-4">{{ optional($item->expires_at)->format('Y-m-d') ?? '-' }}</td>
                    <td class="p-4">{{ $item->is_active ? 'Yes' : 'No' }}</td>
                    <td class="p-4 flex gap-3">
                        <a href="/admin/coupons/{{ $item->id }}/edit" class="font-bold text-[#E50914]">Edit</a>

                        <form method="POST" action="/admin/coupons/{{ $item->id }}" onsubmit="return confirm('Delete this coupon?')">
                            @csrf
                            @method('DELETE')
                            <button class="font-bold text-red-700">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        No coupons found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection