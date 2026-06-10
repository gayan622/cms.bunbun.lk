@extends('admin.layouts.admin_layout')

@section('title', 'Edit Quotation - BunBun CMS')
@section('page_title', 'Edit Quotation')
@section('page_subtitle', 'Update party quotation details')

@section('content')

<div class="max-w-3xl rounded-3xl bg-white p-8 shadow-xl">
    <form method="POST" action="/admin/party-quotations/{{ $partyQuotation->id }}">
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

        @include('admin.party-quotations.form', ['partyQuotation' => $partyQuotation])

        <div class="mt-6 flex gap-3">
            <button class="rounded-xl bg-[#E50914] px-6 py-3 font-bold text-white">
                Update Quotation
            </button>

            <a href="/admin/party-quotations" class="rounded-xl bg-black px-6 py-3 font-bold text-white">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
