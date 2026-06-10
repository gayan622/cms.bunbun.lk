@extends('admin.layouts.admin_layout')

@section('title', 'Branches')
@section('page_title', 'Branches')
@section('page_subtitle', 'Manage restaurant branches')

@section('content')

<div class="mb-6 flex justify-end">
    <a href="/admin/branches/create"
       class="rounded-xl bg-[#E50914] px-5 py-3 font-bold text-white">
        + Add Branch
    </a>
</div>

<div class="overflow-hidden rounded-3xl bg-white shadow-xl">

    <table class="w-full">

        <thead class="bg-[#1C1A17] text-white">
            <tr>
                <th class="p-4 text-left">Name</th>
                <th class="p-4 text-left">Phone</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-left">Actions</th>
            </tr>
        </thead>

        <tbody>

        @forelse($items as $item)

            <tr class="border-b">

                <td class="p-4 font-bold">
                    {{ $item->name }}
                </td>

                <td class="p-4">
                    {{ $item->phone }}
                </td>

                <td class="p-4">
                    @if($item->is_active)
                        <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-bold text-green-700">
                            Active
                        </span>
                    @else
                        <span class="rounded-full bg-red-100 px-3 py-1 text-sm font-bold text-red-700">
                            Inactive
                        </span>
                    @endif
                </td>

                <td class="p-4">
                    <div class="flex gap-2">

                        <a href="/admin/branches/{{ $item->id }}"
                           class="rounded-lg bg-blue-500 px-3 py-2 text-sm font-bold text-white">
                            View
                        </a>

                        <a href="/admin/branches/{{ $item->id }}/edit"
                           class="rounded-lg bg-yellow-400 px-3 py-2 text-sm font-bold text-black">
                            Edit
                        </a>

                        <form method="POST"
                              action="/admin/branches/{{ $item->id }}">
                            @csrf
                            @method('DELETE')

                            <button class="rounded-lg bg-red-600 px-3 py-2 text-sm font-bold text-white">
                                Delete
                            </button>
                        </form>

                    </div>
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="4" class="p-10 text-center text-gray-500">
                    No branches found.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection