<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\DailyOffer;
use App\Models\PartyQuotation;
use App\Models\Coupon;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index()
    {

        // Category Data
        $categories = Category::withCount('menuItems')->get();

        // Low Stock Data (Finds items with less than 10 in stock)
        $lowStockItems = MenuItem::where('stock', '<', 10)->limit(5)->get();

        return view('admin.dashboard', [

            // Master Data
            'categoryCount' => Category::count(),
            'menuCount' => MenuItem::count(),
            'couponCount' => Coupon::count(),
            'offerCount' => DailyOffer::count(),

            // Orders
            'orderCount' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'confirmedOrders' => Order::where('status', 'confirmed')->count(),
            'preparingOrders' => Order::where('status', 'preparing')->count(),
            'completedOrders' => Order::where('status', 'delivered')->count(),

            // Sales
            'todaySales' => Order::whereDate('created_at', today())
                ->where('payment_status', 'paid')
                ->sum('total'),

            'monthlySales' => Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('payment_status', 'paid')
                ->sum('total'),

            // Expenses
            'monthlyExpenses' => Expense::whereMonth('expense_date', now()->month)
                ->whereYear('expense_date', now()->year)
                ->sum('amount'),

            // Quotations
            'quotationCount' => PartyQuotation::count(),

            'pendingQuotations' => PartyQuotation::where(
                'booking_status',
                'pending'
            )->count(),

            'confirmedQuotations' => PartyQuotation::where(
                'booking_status',
                'confirmed'
            )->count(),
            'todaySales' => Order::whereDate('created_at', today())->sum('total'),
        'monthSales' => Order::whereMonth('created_at', now()->month)->sum('total'),
        'categoryNames'   => $categories->pluck('name'),
        'categoryCounts'  => $categories->pluck('menu_items_count'),
        'lowStockNames'   => $lowStockItems->pluck('name'),
        'lowStockValues'  => $lowStockItems->pluck('stock'),
        ]);
    }
}
