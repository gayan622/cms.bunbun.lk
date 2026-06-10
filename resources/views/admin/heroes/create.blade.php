@extends('admin.layouts.admin_layout')

@section('title', 'Create Hero - BunBun CMS')
@section('page_title', 'Create Hero')
@section('page_subtitle', 'Add new homepage hero section')

@section('content')

<div class="max-w-4xl rounded-3xl bg-white p-8 shadow-xl">
    <form method="POST"
          action="{{ route('heroes.store') }}"
          enctype="multipart/form-data">

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

        @include('admin.heroes.form', [
            'hero' => null
        ])

        <div class="mt-8 flex gap-3">
            <button
                type="submit"
                class="rounded-xl bg-[#E50914] px-6 py-3 font-bold text-white hover:bg-red-700">
                Save Hero
            </button>

            <a href="{{ route('heroes.index') }}"
               class="rounded-xl bg-black px-6 py-3 font-bold text-white">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
