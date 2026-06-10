@extends('admin.layouts.admin_layout')

@section('title', 'Party Quotations - BunBun CMS')
@section('page_title', 'Party Quotations')
@section('page_subtitle', 'Office party and birthday celebration requests')

@section('content')

<div class="mb-6 flex justify-end">
    <a href="/admin/party-quotations/create" class="rounded-xl bg-[#E50914] px-5 py-3 font-bold text-white">
        + Add Quotation
    </a>
</div>

<div class="overflow-hidden rounded-3xl bg-white shadow-xl">
    <table class="w-full">
        <thead class="bg-[#E50914] text-white">
            <tr>
                <th class="p-4 text-left">Name</th>
                <th class="p-4 text-left">Phone</th>
                <th class="p-4 text-left">Event</th>
                <th class="p-4 text-left">Guests</th>
                <th class="p-4 text-left">Date</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-left">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($items as $item)
                <tr class="border-b">
                    <td class="p-4 font-bold">{{ $item->name }}</td>
                    <td class="p-4">{{ $item->phone }}</td>
                    <td class="p-4">{{ ucfirst(str_replace('_', ' ', $item->event_type)) }}</td>
                    <td class="p-4">{{ $item->guest_count }}</td>
                    <td class="p-4">{{ optional($item->event_date)->format('Y-m-d') }}</td>
                    <td class="p-4">
                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-sm font-bold text-yellow-700">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex gap-3">
                            <a href="/admin/party-quotations/{{ $item->id }}" class="font-bold text-blue-600">
                                View
                            </a>

                            <a href="/admin/party-quotations/{{ $item->id }}/edit" class="font-bold text-[#E50914]">
                                Edit
                            </a>

                            <form method="POST" action="/admin/party-quotations/{{ $item->id }}" onsubmit="return confirm('Delete this quotation?')">
                                @csrf
                                @method('DELETE')
                                <button class="font-bold text-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        No quotation requests found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection