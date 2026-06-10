@extends('admin.layouts.admin_layout')

@section('title', 'Create Menu Item - BunBun CMS')
@section('page_title', 'Create Menu Item')
@section('page_subtitle', 'Add new food item')

@section('content')

<div class="max-w-3xl rounded-3xl bg-white p-8 shadow-xl">
    <form method="POST" action="/admin/menu-items" enctype="multipart/form-data">
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

        @include('admin.menu-items.form', ['menuItem' => null])

        <div class="mt-6 flex gap-3">
            <button class="rounded-xl bg-[#E50914] px-6 py-3 font-bold text-white">
                Save Item
            </button>

            <a href="/admin/menu-items" class="rounded-xl bg-black px-6 py-3 font-bold text-white">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
