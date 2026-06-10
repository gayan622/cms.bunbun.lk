<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartyQuotation;
use Illuminate\Http\Request;

class PartyQuotationController extends Controller
{
    public function index()
    {
        $items = PartyQuotation::latest()->get();
        return view('admin.party-quotations.index', compact('items'));
    }

    public function create()
    {
        return view('admin.party-quotations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'event_type' => 'required|in:office_party,birthday_party,other',
            'guest_count' => 'required|integer|min:1',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'hall_name' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'status' => 'required|in:new,contacted,quoted,confirmed,cancelled',
            'booking_status' => 'nullable|in:pending,confirmed,rejected,completed',
            'payment_status' => 'nullable|in:pending,advance_paid,partial_paid,paid',
            'advance_payment' => 'nullable|numeric',
            'balance_payment' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
        ]);

        $data['status'] = $data['status'] ?? 'new';
        $data['booking_status'] = $data['booking_status'] ?? 'pending';
        $data['payment_status'] = $data['payment_status'] ?? 'pending';
        $data['advance_payment'] = $data['advance_payment'] ?? 0;
        $data['balance_payment'] = $data['balance_payment'] ?? 0;
        $data['total_amount'] = $data['total_amount'] ?? 0;

        PartyQuotation::create($data);

        return redirect('/admin/party-quotations')->with('success', 'Quotation created');
    }

    public function show(PartyQuotation $partyQuotation)
    {
        return view('admin.party-quotations.show', compact('partyQuotation'));
    }

    public function edit(PartyQuotation $partyQuotation)
    {
        return view('admin.party-quotations.edit', compact('partyQuotation'));
    }

    public function update(Request $request, PartyQuotation $partyQuotation)
    {



    $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'event_type' => 'required|in:office_party,birthday_party,other',
            'guest_count' => 'required|integer|min:1',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'hall_name' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'status' => 'required|in:new,contacted,quoted,confirmed,cancelled',
            'booking_status' => 'required|in:pending,confirmed,rejected,completed',
            'payment_status' => 'required|in:pending,advance_paid,partial_paid,paid',
            'advance_payment' => 'nullable|numeric',
            'balance_payment' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
        ]);

        $data['status'] = $data['status'] ?? 'new';
        $data['booking_status'] = $data['booking_status'] ?? 'pending';
        $data['payment_status'] = $data['payment_status'] ?? 'pending';
        $data['advance_payment'] = $data['advance_payment'] ?? 0;
        $data['balance_payment'] = $data['balance_payment'] ?? 0;
        $data['total_amount'] = $data['total_amount'] ?? 0;

        $partyQuotation->update($data);

        return redirect('/admin/party-quotations')->with('success', 'Quotation updated');
    }

    public function destroy(PartyQuotation $partyQuotation)
    {
        $partyQuotation->delete();
        return back()->with('success', 'Quotation deleted');
    }
}
