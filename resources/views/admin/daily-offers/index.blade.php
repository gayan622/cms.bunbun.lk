@extends('admin.layouts.admin_layout')

@section('title', 'Daily Offers - BunBun CMS')
@section('page_title', 'Daily Offers')
@section('page_subtitle', 'Manage today offers and promotions')

@section('content')

<div class="mb-6 flex justify-end">
    <a href="/admin/daily-offers/create" class="rounded-xl bg-[#E50914] px-5 py-3 font-bold text-white">
        + Add Offer
    </a>
</div>

<div class="overflow-hidden rounded-3xl bg-white shadow-xl">
    <table class="w-full">
        <thead class="bg-[#E50914] text-white">
            <tr>
                <th class="p-4 text-left">Title</th>
                <th class="p-4 text-left">Menu Item</th>
                <th class="p-4 text-left">Offer Price</th>
                <th class="p-4 text-left">Date</th>
                <th class="p-4 text-left">Active</th>
                <th class="p-4 text-left">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($items as $item)
                <tr class="border-b">
                    <td class="p-4 font-bold">{{ $item->title }}</td>
                    <td class="p-4">{{ $item->menuItem->name ?? '-' }}</td>
                    <td class="p-4 font-bold text-[#E50914]">Rs. {{ $item->offer_price }}</td>
                    <td class="p-4">{{ optional($item->offer_date)->format('Y-m-d') }}</td>
                    <td class="p-4">{{ $item->is_active ? 'Yes' : 'No' }}</td>
                    <td class="p-4 flex gap-3">
                        <a href="/admin/daily-offers/{{ $item->id }}/edit" class="font-bold text-[#E50914]">
                            Edit
                        </a>

                        <form method="POST" action="/admin/daily-offers/{{ $item->id }}" onsubmit="return confirm('Delete this offer?')">
                            @csrf
                            @method('DELETE')
                            <button class="font-bold text-red-700">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">
                        No daily offers found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection