@extends('admin.layouts.admin_layout')

@section('title', 'Create Offer - BunBun CMS')
@section('page_title', 'Create Daily Offer')
@section('page_subtitle', 'Add new offer for frontend today offer section')

@section('content')

<div class="max-w-3xl rounded-3xl bg-white p-8 shadow-xl">
    <form method="POST" action="/admin/daily-offers">
        @csrf

        @if ($errors->any())
        <div class="mb-5 p-4 bg-red-100 text-red-700 rounded-xl">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <div class="grid gap-5">
            <label class="font-bold">
                Offer Title
                <input type="text" name="title" value="{{ old('title') }}" class="mt-2 w-full rounded-xl border p-4" required>
            </label>

            <label class="font-bold">
                Menu Item
                <select name="menu_item_id" class="mt-2 w-full rounded-xl border p-4" required>
                    <option value="">Select Menu Item</option>

                    @foreach($menuItems as $menuItem)
                        <option value="{{ $menuItem->id }}" @selected(old('menu_item_id') == $menuItem->id)>
                            {{ $menuItem->name }} - Rs. {{ $menuItem->price }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="font-bold">
                Offer Price
                <input type="number" step="0.01" name="offer_price" value="{{ old('offer_price') }}" class="mt-2 w-full rounded-xl border p-4" required>
            </label>

            <label class="font-bold">
                Offer Date
                <input type="date" name="offer_date" value="{{ old('offer_date') }}" class="mt-2 w-full rounded-xl border p-4" required>
            </label>

            <label class="flex items-center gap-3 font-bold">
                <input type="checkbox" name="is_active" value="1" class="h-5 w-5" checked>
                Active
            </label>
        </div>

        <div class="mt-6 flex gap-3">
            <button class="rounded-xl bg-[#E50914] px-6 py-3 font-bold text-white">
                Save Offer
            </button>

            <a href="/admin/daily-offers" class="rounded-xl bg-black px-6 py-3 font-bold text-white">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
