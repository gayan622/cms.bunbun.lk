@extends('admin.layouts.admin_layout')

@section('title', 'Edit Hero - BunBun CMS')
@section('page_title', 'Edit Hero')
@section('page_subtitle', 'Update hero content')

@section('content')

<div class="max-w-4xl rounded-3xl bg-white p-8 shadow-xl">
    <form method="POST"
          action="{{ route('heroes.update', $hero->id) }}"
          enctype="multipart/form-data">

```
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

    @include('admin.heroes.form', [
        'hero' => $hero
    ])

    <div class="mt-8 flex gap-3">
        <button
            type="submit"
            class="rounded-xl bg-[#E50914] px-6 py-3 font-bold text-white">
            Update Hero
        </button>

        <a href="{{ route('heroes.index') }}"
           class="rounded-xl bg-black px-6 py-3 font-bold text-white">
            Cancel
        </a>
    </div>

</form>
```

</div>

@endsection
