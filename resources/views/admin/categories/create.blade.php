@extends('admin.layouts.admin_layout')

@section('title','Create Category')

@section('content')

<div class="bg-white p-8 rounded-3xl shadow">

<form
method="POST"
action="/admin/categories"
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

@include('admin.categories.form')

<button class="bg-[#E50914] text-white px-6 py-3 rounded-xl mt-6">
Save Category
</button>

</form>

</div>

@endsection
