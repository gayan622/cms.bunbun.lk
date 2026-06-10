@extends('admin.layouts.admin_layout')

@section('title', 'Menu Items - BunBun CMS')
@section('page_title', 'Menu Items')
@section('page_subtitle', 'Manage restaurant food items')

@section('content')

<div class="mb-6 flex justify-end">
    <a href="/admin/menu-items/create" class="bg-[#E50914] text-white px-5 py-3 rounded-xl font-bold">
        + Add Menu Item
    </a>
</div>

<div class="overflow-hidden rounded-3xl bg-white shadow-xl">
    <table class="w-full">
        <thead class="bg-[#E50914] text-white">
    <tr>
        <th class="p-4 text-left">Image</th>
        <th class="p-4 text-left">Name</th>
        <th class="p-4 text-left">Category</th>
        <th class="p-4 text-left">Price</th>
        <th class="p-4 text-left">Stock</th>
        <th class="p-4 text-left">Available</th>
        <th class="p-4 text-left">Action</th>
    </tr>
</thead>

        <tbody>
            @forelse($items as $item)
                <tr class="border-b">
    <td class="p-4">
        @if($item->image)
            <img src="{{ asset('storage/'.$item->image) }}" class="h-14 w-14 rounded-xl object-cover">
        @else - @endif
    </td>
    <td class="p-4 font-bold">{{ $item->name }}</td>
    <td class="p-4">{{ $item->category->name ?? '-' }}</td>
    <td class="p-4 font-bold text-[#E50914]">Rs. {{ $item->price }}</td>

    <td class="p-4 font-bold">
        <span class="{{ $item->stock < 5 ? 'text-red-600' : 'text-green-600' }}">
            {{ $item->stock }}
        </span>

        <form action="{{ route('menu-items.add-stock', $item->id) }}" method="POST" class="flex items-center gap-2 mt-1">
            @csrf
            <input type="number" name="amount" value="1" class="w-16 rounded border p-1 text-sm" required>
            <button type="submit" class="text-xs bg-gray-100 px-2 py-1 rounded hover:bg-gray-200">+Add</button>
        </form>
    </td>

    <td class="p-4">{{ $item->is_available ? 'Yes' : 'No' }}</td>
    <td class="p-4">
        <a href="/admin/menu-items/{{ $item->id }}/edit" class="text-[#E50914] font-bold">Edit</a>
    </td>
</tr>
            @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">
                        No menu items found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
