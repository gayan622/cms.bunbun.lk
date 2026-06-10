@extends('admin.layouts.admin_layout')

@section('title', 'Dashboard - BunBun CMS')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Overview of bunbun.lk CMS')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">

  <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Categories</p>
        <h3 class="text-4xl font-black text-[#E50914]">
            {{ $categoryCount }}
        </h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Menu Items</p>
        <h3 class="text-4xl font-black">{{ $menuCount }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Orders</p>
        <h3 class="text-4xl font-black">{{ $orderCount }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Offers</p>
        <h3 class="text-4xl font-black">{{ $offerCount }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-gray-500">Quotations</p>
        <h3 class="text-4xl font-black">{{ $quotationCount }}</h3>
    </div>

</div>


<!-- Charts Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Bar Chart: Today vs Month Sales -->
    <div class="bg-white p-6 rounded-3xl shadow">
        <h3 class="font-bold mb-4">Sales Comparison</h3>
        <canvas id="salesChart"></canvas>
    </div>

    <!-- Doughnut Chart: Orders vs Quotations -->
    <div class="bg-white p-6 rounded-3xl shadow">
        <h3 class="font-bold mb-4">Orders & Quotations</h3>
        <canvas id="activityChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
    <div class="bg-white p-6 rounded-3xl shadow">
        <h3 class="font-bold mb-4">Menu Categories</h3>
        <canvas id="categoryChart"></canvas>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <h3 class="font-bold mb-4">Low Stock Alerts (Top 5)</h3>
        <canvas id="stockChart"></canvas>
    </div>
</div>


<script>
    // Sales Bar Chart
    new Chart(document.getElementById('salesChart'), {
        type: 'bar',
        data: {
            labels: ['Today', 'This Month'],
            datasets: [{
                label: 'Sales (Rs)',
                data: [{{ $todaySales }}, {{ $monthSales }}],
                backgroundColor: ['#E50914', '#1C1A17']
            }]
        }
    });

    // Orders/Quotations Doughnut Chart
    new Chart(document.getElementById('activityChart'), {
        type: 'doughnut',
        data: {
            labels: ['Orders', 'Quotations'],
            datasets: [{
                data: [{{ $orderCount }}, {{ $quotationCount }}],
                backgroundColor: ['#3b82f6', '#f59e0b']
            }]
        }
    });

    // Category Pie Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($categoryNames) !!},
            datasets: [{
                data: {!! json_encode($categoryCounts) !!},
                backgroundColor: ['#E50914', '#1C1A17', '#F59E0B', '#3B82F6', '#10B981']
            }]
        }
    });

    // Stock Horizontal Bar Chart
    new Chart(document.getElementById('stockChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($lowStockNames) !!},
            datasets: [{
                label: 'Remaining Stock',
                data: {!! json_encode($lowStockValues) !!},
                backgroundColor: '#ef4444'
            }]
        },
        options: { indexAxis: 'y' } // Makes it a horizontal bar chart
    });


</script>
@endsection
