@extends('admin.layouts.admin_layout')

@section('title', 'Create Branch')
@section('page_title', 'Create Branch')

@section('content')

<form method="POST" action="/admin/branches"
      class="rounded-3xl bg-white p-8 shadow-xl">
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

    <div class="grid gap-6 md:grid-cols-2">

        <div>
            <label class="mb-2 block font-bold">
                Branch Name
            </label>

            <input type="text"
                   name="name"
                   class="w-full rounded-xl border p-4"
                   required>
        </div>

        <div>
            <label class="mb-2 block font-bold">
                Phone
            </label>

            <input type="text"
                   name="phone"
                   class="w-full rounded-xl border p-4">
        </div>

        <div class="md:col-span-2">
            <label class="mb-2 block font-bold">
                Address
            </label>

            <textarea name="address"
                      rows="4"
                      class="w-full rounded-xl border p-4"></textarea>
        </div>

        <div>
            <label class="mb-2 block font-bold">
                Email
            </label>

            <input type="email"
                   name="email"
                   class="w-full rounded-xl border p-4">
        </div>

        <div>
            <label class="mb-2 block font-bold">
                Status
            </label>

            <div class="flex items-center gap-3">
                <input type="checkbox"
                       name="is_active"
                       checked>

                <span>Active Branch</span>
            </div>
        </div>

    </div>

    <div class="mt-10">
        <h3 class="mb-5 text-2xl font-black">
            Allowed Menu Items
        </h3>

        <div class="grid gap-3 md:grid-cols-3">

            @foreach($menuItems as $item)

                <label class="flex items-center gap-3 rounded-xl border p-4">

                    <input type="checkbox"
                           name="menu_items[]"
                           value="{{ $item->id }}">

                    <span>{{ $item->name }}</span>

                    <input type="number"
               name="prices[{{ $item->id }}]"
               placeholder="Price"
               step="0.01"
               class="w-24 rounded-lg border p-1 ml-auto">

                </label>

            @endforeach

        </div>
    </div>

    <button class="mt-8 rounded-2xl bg-[#E50914] px-6 py-4 font-black text-white">
        Create Branch
    </button>

</form>

@endsection
