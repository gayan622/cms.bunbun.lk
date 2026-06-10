@extends('admin.layouts.admin_layout')

@section('title', 'Heroes - BunBun CMS')
@section('page_title', 'Hero Management')
@section('page_subtitle', 'Manage homepage hero sections')

@section('content')

<div class="rounded-3xl bg-white p-6 shadow-xl">

```
<div class="mb-6 flex items-center justify-between">
    <h2 class="text-xl font-bold">
        Heroes
    </h2>

    <a href="{{ route('heroes.create') }}"
       class="rounded-xl bg-[#E50914] px-5 py-3 font-bold text-white">
        + Add Hero
    </a>
</div>

<div class="overflow-x-auto">

    <table class="min-w-full border-collapse">

        <thead>
            <tr class="border-b bg-gray-100">
                <th class="p-4 text-left">Image</th>
                <th class="p-4 text-left">Title</th>
                <th class="p-4 text-left">Layout</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-left">Created</th>
                <th class="p-4 text-right">Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse($heroes as $hero)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-4">
                        @if($hero->image)
                            <img
                                src="{{ asset('storage/'.$hero->image) }}"
                                class="h-16 w-16 rounded-xl object-cover">
                        @endif
                    </td>

                    <td class="p-4">
                        <div class="font-semibold">
                            {{ $hero->title }}
                        </div>

                        <div class="text-sm text-gray-500">
                            {{ Str::limit($hero->description, 60) }}
                        </div>
                    </td>

                    <td class="p-4">
                        <span class="rounded-lg bg-blue-100 px-3 py-1 text-sm">
                            {{ ucfirst($hero->layout) }}
                        </span>
                    </td>

                    <td class="p-4">
                        @if($hero->is_active)
                            <span class="rounded-lg bg-green-100 px-3 py-1 text-green-700">
                                Active
                            </span>
                        @else
                            <span class="rounded-lg bg-red-100 px-3 py-1 text-red-700">
                                Inactive
                            </span>
                        @endif
                    </td>

                    <td class="p-4">
                        {{ $hero->created_at->format('d M Y') }}
                    </td>

                    <td class="p-4">

                        <div class="flex justify-end gap-2">

                            <a href="{{ route('heroes.edit', $hero->id) }}"
                               class="rounded-lg bg-yellow-500 px-3 py-2 text-white">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('heroes.destroy', $hero->id) }}"
                                  onsubmit="return confirm('Delete this hero?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="rounded-lg bg-red-600 px-3 py-2 text-white">
                                    Delete
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">
                        No hero sections found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>
```

</div>

@endsection
