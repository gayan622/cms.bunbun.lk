<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PartyQuotation;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $month = $request->month ?? now()->format('Y-m');

        $monthStart = Carbon::parse($month . '-01')->startOfMonth();
        $monthEnd = Carbon::parse($month . '-01')->endOfMonth();

        $dailySales = Order::whereDate('created_at', $today)
            ->where('payment_status', 'paid')
            ->sum('total');

        $pendingOrders = Order::where('status', 'pending')->count();

        $completedOrders = Order::where('status', 'delivered')->count();

        $nextOrders = Order::whereIn('status', ['confirmed', 'preparing'])
            ->latest()
            ->take(10)
            ->get();

        $partyQuotations = PartyQuotation::latest()
            ->take(10)
            ->get();

        $monthlyRevenue = Order::whereBetween('created_at', [$monthStart, $monthEnd])
            ->where('payment_status', 'paid')
            ->sum('total');

        $monthlyExpenses = Expense::whereBetween('expense_date', [$monthStart, $monthEnd])
            ->sum('amount');

        $monthlyProfit = $monthlyRevenue - $monthlyExpenses;

        $recentSales = Order::whereDate('created_at', $today)
            ->latest()
            ->get();

        return view('admin.reports.index', compact(
            'dailySales',
            'pendingOrders',
            'completedOrders',
            'nextOrders',
            'partyQuotations',
            'monthlyRevenue',
            'monthlyExpenses',
            'monthlyProfit',
            'recentSales',
            'month'
        ));
    }
}