<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DailyOffer;

class OfferController extends Controller
{
     public function today()
    {
        return DailyOffer::with('menuItem')
            ->whereDate('offer_date', today())
            ->where('is_active', true)
            ->first();
    }
}
