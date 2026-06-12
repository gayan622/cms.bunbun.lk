<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'BunBun CMS')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-[#FAF6EE]">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-[#1C1A17] text-white p-6">
            <h1 class="text-3xl font-black text-yellow-400 mb-2">
                bunbun.lk
            </h1>

            <p class="text-sm text-white/50 mb-8">
               @if(auth()->check())
                    {{ ucfirst(auth()->user()->role) }} Panel
                @else
                    Guest Panel
                @endif
            </p>



               <nav class="space-y-6">


@if (auth()->check() && in_array(auth()->user()->role, ['admin', 'manager']))

    <div>
        <p class="mb-2 px-3 text-xs font-bold uppercase tracking-wider text-white/40">
            Dashboard
        </p>

        <a href="/admin/dashboard"
            class="block rounded-xl p-3 {{ request()->is('admin/dashboard') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Dashboard
        </a>
    </div>

    <div>
        <p class="mb-2 px-3 text-xs font-bold uppercase tracking-wider text-white/40">
            CMS Content
        </p>

        <a href="/admin/heroes"
            class="block rounded-xl p-3 {{ request()->is('admin/heroes*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Hero Sections
        </a>

        <a href="/admin/categories"
            class="block rounded-xl p-3 {{ request()->is('admin/categories*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Categories
        </a>

        <a href="/admin/menu-items"
            class="block rounded-xl p-3 {{ request()->is('admin/menu-items*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Menu Items
        </a>

        <a href="/admin/daily-offers"
            class="block rounded-xl p-3 {{ request()->is('admin/daily-offers*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Daily Offers
        </a>

        <a href="/admin/coupons"
            class="block rounded-xl p-3 {{ request()->is('admin/coupons*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Coupons
        </a>
    </div>

    <div>
        <p class="mb-2 px-3 text-xs font-bold uppercase tracking-wider text-white/40">
            Operations
        </p>

        <a href="/admin/orders"
            class="block rounded-xl p-3 {{ request()->is('admin/orders*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Orders
        </a>

        <a href="/admin/party-quotations"
            class="block rounded-xl p-3 {{ request()->is('admin/party-quotations*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Party Quotations
        </a>

        <a href="/admin/branches"
            class="block rounded-xl p-3 {{ request()->is('admin/branches*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Branches
        </a>

        <a href="/admin/reports"
            class="block rounded-xl p-3 {{ request()->is('admin/reports*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Reports / PNL
        </a>
    </div>

@endif

@if (auth()->check() && in_array(auth()->user()->role, ['admin', 'cashier']))

    <div>
        <p class="mb-2 px-3 text-xs font-bold uppercase tracking-wider text-white/40">
            Cashier
        </p>

        <a href="/cashier/dashboard"
            class="block rounded-xl p-3 {{ request()->is('cashier*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            POS System
        </a>
    </div>

@endif

@if (auth()->check() && in_array(auth()->user()->role, ['admin', 'kitchen']))

    <div>
        <p class="mb-2 px-3 text-xs font-bold uppercase tracking-wider text-white/40">
            Kitchen
        </p>

        <a href="/kitchen/dashboard"
            class="block rounded-xl p-3 {{ request()->is('kitchen*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Kitchen Display
        </a>
    </div>

@endif

@if (auth()->check() && in_array(auth()->user()->role, ['admin', 'delivery']))

    <div>
        <p class="mb-2 px-3 text-xs font-bold uppercase tracking-wider text-white/40">
            Delivery
        </p>

        <a href="/delivery/dashboard"
            class="block rounded-xl p-3 {{ request()->is('delivery*') ? 'bg-[#E50914]' : 'hover:bg-white/10' }}">
            Delivery Screen
        </a>
    </div>

@endif





            </nav>
        </aside>

        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-4xl font-black text-[#E50914]">
                        @yield('page_title', 'Dashboard')
                    </h2>

                    @hasSection('page_subtitle')
                        <p class="text-gray-500 mt-1">
                            @yield('page_subtitle')
                        </p>
                    @endif
                </div>

                <form method="POST" action="/logout">
                    @csrf
                    <button class="bg-black text-white px-5 py-3 rounded-xl">
                        Logout
                    </button>
                </form>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl bg-green-100 p-4 font-bold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>

</body>

</html>
