<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PartyQuotation;

class PartyQuotationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email',
            'event_type' => 'required|string',
            'guest_count' => 'required|integer',
            'event_date' => 'required|date',
            'message' => 'nullable|string',
        ]);

        $quotation = PartyQuotation::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Quotation request submitted successfully',
            'data' => $quotation
        ]);
    }
}
