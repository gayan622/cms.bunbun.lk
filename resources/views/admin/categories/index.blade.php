@extends('admin.layouts.admin_layout')

@section('title','Categories')

@section('content')

<div class="flex justify-between mb-6">
    <h2 class="text-3xl font-black">
        Categories
    </h2>

    <a href="/admin/categories/create"
       class="bg-[#E50914] text-white px-5 py-3 rounded-xl">
        Add Category
    </a>
</div>

<div class="bg-white rounded-3xl shadow overflow-hidden">

<table class="w-full">

<thead class="bg-[#E50914] text-white">
<tr>
    <th class="p-4">ID</th>
    <th>Name</th>
    <th>Slug</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

@foreach($categories as $category)

<tr class="border-b">

<td class="p-4">{{ $category->id }}</td>

<td>{{ $category->name }}</td>

<td>{{ $category->slug }}</td>

<td>
@if($category->is_active)
<span class="text-green-600">
Active
</span>
@else
<span class="text-red-600">
Disabled
</span>
@endif
</td>

<td>

<a href="/admin/categories/{{ $category->id }}/edit"
   class="text-blue-600">
Edit
</a>

<form
method="POST"
action="/admin/categories/{{ $category->id }}"
class="inline">

@csrf
@method('DELETE')

<button class="text-red-600 ml-3">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection
