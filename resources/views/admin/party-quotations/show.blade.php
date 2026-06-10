@extends('admin.layouts.admin_layout')

@section('title', 'View Quotation - BunBun CMS')
@section('page_title', 'View Quotation')
@section('page_subtitle', 'Quotation request details')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 rounded-3xl bg-white p-8 shadow-xl">
        <h3 class="text-2xl font-black text-[#E50914] mb-6">
            Customer Details
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <p class="text-gray-500 text-sm">Name</p>
                <p class="font-bold text-lg">{{ $partyQuotation->name }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Phone</p>
                <p class="font-bold text-lg">{{ $partyQuotation->phone }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Email</p>
                <p class="font-bold text-lg">{{ $partyQuotation->email ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Event Type</p>
                <p class="font-bold text-lg">
                    {{ ucfirst(str_replace('_', ' ', $partyQuotation->event_type)) }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Guest Count</p>
                <p class="font-bold text-lg">{{ $partyQuotation->guest_count }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Event Date</p>
                <p class="font-bold text-lg">
                    {{ optional($partyQuotation->event_date)->format('Y-m-d') }}
                </p>
            </div>
        </div>

        <div class="mt-8">
            <p class="text-gray-500 text-sm">Message</p>
            <div class="mt-2 rounded-2xl bg-[#FAF6EE] p-5 text-gray-700">
                {{ $partyQuotation->message ?? 'No message provided.' }}
            </div>
        </div>
    </div>

    <div class="rounded-3xl bg-[#1C1A17] p-8 text-white shadow-xl">
        <h3 class="text-2xl font-black text-yellow-400 mb-5">
            Status
        </h3>

        <p class="mb-6 rounded-full bg-white/10 px-4 py-3 font-bold">
            {{ ucfirst($partyQuotation->status) }}
        </p>

        <a href="/admin/party-quotations/{{ $partyQuotation->id }}/edit" class="block rounded-xl bg-[#E50914] p-4 text-center font-bold">
            Edit Quotation
        </a>

        <a href="/admin/party-quotations" class="mt-3 block rounded-xl bg-white/10 p-4 text-center font-bold">
            Back
        </a>
    </div>

</div>

@endsection