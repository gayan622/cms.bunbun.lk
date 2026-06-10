@extends('admin.layouts.admin_layout')

@section('title', 'Edit Menu Item - BunBun CMS')
@section('page_title', 'Edit Menu Item')
@section('page_subtitle', 'Update food item details')

@section('content')

<div class="max-w-3xl rounded-3xl bg-white p-8 shadow-xl">
    <form method="POST" action="/admin/menu-items/{{ $menuItem->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($errors->any())
        <div class="mb-5 p-4 bg-red-100 text-red-700 rounded-xl">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        @include('admin.menu-items.form', ['menuItem' => $menuItem])

        <div class="mt-6 flex gap-3">
            <button class="rounded-xl bg-[#E50914] px-6 py-3 font-bold text-white">
                Update Item
            </button>

            <a href="/admin/menu-items" class="rounded-xl bg-black px-6 py-3 font-bold text-white">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
