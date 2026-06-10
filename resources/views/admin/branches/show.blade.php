@extends('admin.layouts.admin_layout')

@section('title', 'Branch Details')
@section('page_title', $branch->name)

@section('content')

<div class="rounded-3xl bg-white p-8 shadow-xl">

    <div class="mb-8 grid gap-6 md:grid-cols-2">

        <div>
            <h3 class="mb-2 text-xl font-black">Phone</h3>
            <p>{{ $branch->phone }}</p>
        </div>

        <div>
            <h3 class="mb-2 text-xl font-black">Email</h3>
            <p>{{ $branch->email }}</p>
        </div>

        <div class="md:col-span-2">
            <h3 class="mb-2 text-xl font-black">Address</h3>
            <p>{{ $branch->address }}</p>
        </div>

    </div>

    <div>
        <h3 class="mb-5 text-2xl font-black">
            Allowed Menu Items
        </h3>

        <div class="grid gap-4 md:grid-cols-3">

            @forelse($branch->menuItems as $item)

                <div class="rounded-2xl border p-5">

                    <h4 class="font-black">
                        {{ $item->name }}
                    </h4>

                    <p class="mt-2 text-sm text-gray-500">
                        Rs. {{ $item->price }}
                    </p>

                </div>

            @empty

                <p>No menu items assigned.</p>

            @endforelse

        </div>
    </div>

</div>

@endsection