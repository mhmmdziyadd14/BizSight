{{-- File: dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Clarity Labs</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        :root {
            --ora: #F97316;
            --ora-lt: #FFF7ED;
            --ora-dk: #EA580C;
            --blk: #0F172A;
            --bg: #ffffff;
            --bg2: #f8fafc;
            --bg3: #f1f5f9;
            --bd: #e2e8f0;
            --bd2: #cbd5e1;
            --t1: #1e293b;
            --t2: #475569;
            --t3: #94a3b8;
            --rad: 14px;
            --radlg: 24px;
            --font-sans: 'Plus Jakarta Sans', sans-serif;
        }

        .dark {
            --bg: #0F172A;
            --bg2: #1E293B;
            --bg3: #020617;
            --bd: #334155;
            --bd2: #475569;
            --t1: #f8fafc;
            --t2: #cbd5e1;
            --t3: #94a3b8;
            --blk: #ffffff;
            --ora-lt: rgba(249, 115, 22, 0.15);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: var(--font-sans); }
        
        body { background: var(--bg2); color: var(--t1); transition: background 0.3s, color 0.3s; }

        .app-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            background: var(--bg);
            border-right: 1px solid var(--bd);
            padding: 32px 0;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 50;
        }

        .sidebar-logo {
            padding: 0 32px 32px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-box {
            width: 40px;
            height: 40px;
            background: var(--ora);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }

        .logo-text {
            font-size: 18px;
            font-weight: 800;
            color: var(--blk);
            letter-spacing: -0.02em;
        }

        .sidebar-section {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--t3);
            padding: 24px 32px 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 32px;
            font-size: 14px;
            font-weight: 600;
            color: var(--t2);
            text-decoration: none;
            transition: all 0.2s;
            border-right: 3px solid transparent;
        }

        .nav-link:hover {
            background: var(--ora-lt);
            color: var(--ora);
        }

        .nav-link.active {
            background: var(--ora-lt);
            color: var(--ora);
            border-right-color: var(--ora);
        }

        .nav-icon { width: 20px; height: 20px; opacity: 0.7; }
        .nav-link.active .nav-icon { opacity: 1; }

        .sidebar-footer {
            margin-top: auto;
            padding: 24px 32px;
            border-top: 1px solid var(--bd);
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px;
            border-radius: 16px;
            background: var(--bg3);
            text-decoration: none;
            color: var(--t1);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: var(--ora);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
        }

        /* MAIN CONTENT */
        .main-content {
            padding: 48px 60px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 40px;
        }

        .page-title { font-size: 36px; font-weight: 900; color: var(--blk); letter-spacing: -0.04em; }
        .page-subtitle { font-size: 16px; color: var(--t2); font-weight: 500; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 48px;
        }

        .stat-card {
            background: var(--bg);
            border: 1px solid var(--bd);
            border-radius: var(--radlg);
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .stat-card:hover { transform: translateY(-4px); }

        .stat-label { font-size: 12px; font-weight: 800; color: var(--t3); text-transform: uppercase; letter-spacing: 0.1em; }
        .stat-value { font-size: 32px; font-weight: 900; color: var(--blk); }
        .stat-sub { font-size: 13px; color: var(--t2); }

        .card {
            background: var(--bg);
            border: 1px solid var(--bd);
            border-radius: var(--radlg);
            padding: 32px;
            margin-bottom: 32px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--blk);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .title-dot { width: 12px; height: 4px; border-radius: 4px; background: var(--ora); }

        /* PRODUCT CARDS */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .product-card {
            background: var(--bg);
            border: 1.5px solid var(--bd);
            border-radius: var(--radlg);
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .product-card:hover {
            border-color: var(--ora);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .product-icon {
            width: 48px;
            height: 48px;
            background: var(--ora-lt);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ora);
        }

        .product-name { font-size: 20px; font-weight: 800; color: var(--blk); }
        .product-desc { font-size: 14px; color: var(--t2); line-height: 1.6; }

        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 24px;
            background: var(--ora);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 800;
            font-size: 14px;
            transition: all 0.2s;
        }

        .btn-action:hover {
            background: var(--ora-dk);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--ora-lt);
        }

        .badge {
            font-size: 10px;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .badge-green { background: #dcfce7; color: #166534; }
        .dark .badge-green { background: rgba(34, 197, 94, 0.2); color: #86efac; }

        .page-view { display: none; animation: fadeIn 0.4s ease-out; }
        .page-view.active { display: block; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* TABLE */
        .tbl-wrap { width: 100%; overflow-x: auto; }
        .tbl { width: 100%; border-collapse: separate; border-spacing: 0; }
        .tbl th { text-align: left; padding: 16px; font-size: 11px; font-weight: 900; color: var(--t3); text-transform: uppercase; letter-spacing: 0.1em; border-bottom: 2px solid var(--bd); }
        .tbl td { padding: 20px 16px; border-bottom: 1px solid var(--bd); font-size: 14px; }
        .tbl tr:hover td { background: var(--bg3); }

        @media (max-width: 1024px) {
            .app-container { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .stats-grid, .product-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

@php
    $user = auth()->user();
    $isAdmin = $user->isAdmin();
    $accesses = $isAdmin ? [] : \App\Models\UserAccess::where('user_id', $user->id)->pluck('feature_code')->map(fn($val) => strtolower($val))->toArray();
    $hasVCP = $isAdmin || in_array('vcp', $accesses);
    $hasPCC = $isAdmin || in_array('pcc', $accesses);
    $hasDE = $isAdmin || in_array('de', $accesses);
    $ownedCount = ($hasVCP ? 1 : 0) + ($hasPCC ? 1 : 0) + ($hasDE ? 1 : 0);
    $orders = \App\Models\Order::where('user_id', $user->id)->with('items.product')->orderBy('created_at', 'desc')->get();
@endphp

<div class="app-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('welcome') }}" class="sidebar-logo">
            <img src="{{ asset('images/ClarityLabs_Light.svg') }}" alt="ClarityLabs" class="h-8 w-auto block dark:hidden">
            <img src="{{ asset('images/ClarityLabs_Dark.svg') }}" alt="ClarityLabs" class="h-8 w-auto hidden dark:block">
            <span class="logo-text">Clarity Labs</span>
        </a>

        <p class="sidebar-section">Main Menu</p>
        <a href="#" class="nav-link active" onclick="switchView('products', this)">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            My Products
        </a>
        <a href="#" class="nav-link" onclick="switchView('orders', this)">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            Purchase History
        </a>

        @if($isAdmin)
        <p class="sidebar-section">Admin Menu</p>
        <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Admin Panel
        </a>
        @endif

        <p class="sidebar-section">Account</p>
        <a href="#" class="nav-link" onclick="switchView('profile', this)">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Profile Settings
        </a>
        <a href="#" class="nav-link" onclick="toggleTheme()">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            Switch Theme
        </a>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">@csrf</form>
            <a href="#" class="user-pill" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                <div style="flex:1">
                    <p style="font-size:12px; font-weight:800">{{ explode(' ', $user->name)[0] }}</p>
                    <p style="font-size:10px; color:var(--t3)">Sign Out</p>
                </div>
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 16l4-4-4-4M21 12H9" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        
        <div class="header-row">
            <div>
                <h1 class="page-title">Clarity Dashboard</h1>
                <p class="page-subtitle">Welcome back, {{ $user->name }}. Everything is ready for your brand today.</p>
            </div>
            <div style="display:flex; gap:12px">
                <div style="text-align:right">
                    <p style="font-size:11px; font-weight:800; color:var(--t3); text-transform:uppercase">Subscription</p>
                    <p style="font-size:14px; font-weight:800; color:var(--ora)">{{ $isAdmin ? 'Admin Lifetime' : ($ownedCount >= 3 ? 'Elite Plan' : 'Standard') }}</p>
                </div>
            </div>
        </div>

        <!-- MY PRODUCTS VIEW -->
        <div class="page-view active" id="view-products">
            <div class="stats-grid">
                <div class="stat-card">
                    <p class="stat-label">Active Tools</p>
                    <p class="stat-value">{{ $ownedCount }}</p>
                    <p class="stat-sub">From 5 available tools</p>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Access Level</p>
                    <p class="stat-value">{{ $isAdmin ? 'Full' : ($ownedCount > 0 ? 'Partial' : 'Explorer') }}</p>
                    <p class="stat-sub">{{ $ownedCount == 3 ? 'Elite Bundle Active' : 'Upgrade to unlock all' }}</p>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Member Since</p>
                    <p class="stat-value">{{ $user->created_at->format('M Y') }}</p>
                    <p class="stat-sub">Thank you for your support</p>
                </div>
            </div>

            <div class="section-title"><div class="title-dot"></div> My Owned Products</div>
            
            <div class="product-grid">
                @if($hasVCP)
                <div class="product-card">
                    <div class="product-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:flex-start">
                            <h3 class="product-name">Visual Clarity Pack</h3>
                            <span class="badge badge-green">v1.2 Active</span>
                        </div>
                        <p class="product-desc">AI-powered technical packages, BOM, and production timeline for professional fashion brands.</p>
                    </div>
                    <a href="{{ route('clarity.visual') }}" class="btn-action">Open Visual Clarity →</a>
                </div>
                @endif

                @if($hasPCC)
                <div class="product-card">
                    <div class="product-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:flex-start">
                            <h3 class="product-name">Profit Clarity</h3>
                            <span class="badge badge-green">v2.0 Active</span>
                        </div>
                        <p class="product-desc">Advanced HPP calculator with automated material tracking and profit margin analysis.</p>
                    </div>
                    <a href="{{ route('hpp.index') }}" class="btn-action">Open Profit Calculator →</a>
                </div>
                @endif

                @if($hasDE)
                <div class="product-card">
                    <div class="product-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:flex-start">
                            <h3 class="product-name">Clarity Decision</h3>
                            <span class="badge badge-green">v1.5 Active</span>
                        </div>
                        <p class="product-desc">Business viability engine — analyze your unit economics and get AI strategic advice.</p>
                    </div>
                    <a href="{{ route('business.index') }}" class="btn-action">Open Decision Engine →</a>
                </div>
                @endif
            </div>

            @if(!$hasVCP || !$hasPCC)
            <div class="card" style="margin-top:48px; border-style:dashed; background:transparent">
                <div style="text-align:center; padding:20px">
                    <p style="font-weight:800; font-size:18px; margin-bottom:8px">Ready to scale your business?</p>
                    <p style="color:var(--t2); font-size:14px; margin-bottom:24px">Explore more tools and unlock the full potential of Clarity Labs.</p>
                    <a href="{{ route('welcome') }}#pricing" class="btn-action" style="display:inline-flex; width:auto">Browse Catalog →</a>
                </div>
            </div>
            @endif
        </div>

        <!-- ORDERS VIEW -->
        <div class="page-view" id="view-orders">
            <div class="card">
                <div class="section-title"><div class="title-dot"></div> Purchase History</div>
                <div class="tbl-wrap">
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td style="font-weight:800">#{{ strtoupper(substr($order->id, 0, 8)) }}</td>
                                <td><span class="local-time" data-utc="{{ $order->created_at->toIso8601String() }}">{{ $order->created_at->format('d M Y') }}</span></td>
                                <td>
                                    @foreach($order->items as $item)
                                        <div style="font-weight:600">{{ $item->product->name }}</div>
                                    @endforeach
                                </td>
                                <td style="font-weight:800">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ in_array($order->status, ['paid', 'success']) ? 'badge-green' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" style="text-align:center; padding:40px; color:var(--t3)">No purchases yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PROFILE VIEW -->
        <div class="page-view" id="view-profile">
            <div class="product-grid">
                <!-- Profile Info Form Card -->
                <div class="card">
                    <div class="section-title"><div class="title-dot"></div> Profile Info</div>
                    
                    @if (session('status') === 'profile-updated')
                        <div style="margin-bottom: 20px; padding: 12px 16px; background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); color: #22c55e; border-radius: 12px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Profile updated successfully!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" style="display:flex; flex-direction:column; gap:16px">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-1.5 ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-800 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 text-slate-800 dark:text-slate-100 transition-all"
                                style="width: 100%; border-radius: 12px; font-weight: 600;">
                            @error('name')
                                <p style="color: #ef4444; font-size: 11px; margin-top: 4px; font-weight: 700;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-1.5 ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-800 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 text-slate-800 dark:text-slate-100 transition-all"
                                style="width: 100%; border-radius: 12px; font-weight: 600;">
                            @error('email')
                                <p style="color: #ef4444; font-size: 11px; margin-top: 4px; font-weight: 700;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-1.5 ml-1">No Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                                class="w-full bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-800 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 text-slate-800 dark:text-slate-100 transition-all"
                                style="width: 100%; border-radius: 12px; font-weight: 600;">
                            @error('phone')
                                <p style="color: #ef4444; font-size: 11px; margin-top: 4px; font-weight: 700;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="margin-top: 8px;">
                            <button type="submit" class="btn-action" style="width:100%; background:var(--ora); color:#fff; border:none; padding: 12px; font-weight: 800;">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Security Form Card -->
                <div class="card">
                    <div class="section-title"><div class="title-dot"></div> Security</div>
                    
                    @if (session('status') === 'password-updated')
                        <div style="margin-bottom: 20px; padding: 12px 16px; background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); color: #22c55e; border-radius: 12px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Password updated successfully!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" style="display:flex; flex-direction:column; gap:16px">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-1.5 ml-1">Current Password</label>
                            <input type="password" name="current_password" required autocomplete="current-password"
                                class="w-full bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-800 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 text-slate-800 dark:text-slate-100 transition-all"
                                style="width: 100%; border-radius: 12px; font-weight: 600;">
                            @if($errors->updatePassword->has('current_password'))
                                <p style="color: #ef4444; font-size: 11px; margin-top: 4px; font-weight: 700;">{{ $errors->updatePassword->first('current_password') }}</p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-1.5 ml-1">New Password</label>
                            <input type="password" name="password" required autocomplete="new-password"
                                class="w-full bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-800 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 text-slate-800 dark:text-slate-100 transition-all"
                                style="width: 100%; border-radius: 12px; font-weight: 600;">
                            @if($errors->updatePassword->has('password'))
                                <p style="color: #ef4444; font-size: 11px; margin-top: 4px; font-weight: 700;">{{ $errors->updatePassword->first('password') }}</p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-1.5 ml-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-800 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 text-slate-800 dark:text-slate-100 transition-all"
                                style="width: 100%; border-radius: 12px; font-weight: 600;">
                        </div>

                        <div style="margin-top: 8px;">
                            <button type="submit" class="btn-action" style="width:100%; background:var(--ora); color:#fff; border:none; padding: 12px; font-weight: 800;">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
</div>

<script>
    function switchView(viewId, el) {
        document.querySelectorAll('.page-view').forEach(v => v.classList.remove('active'));
        document.querySelectorAll('.nav-link').forEach(n => n.classList.remove('active'));
        
        document.getElementById('view-' + viewId).classList.add('active');
        el.classList.add('active');
        
        // Simpan hash lokasi ke URL
        window.location.hash = viewId;
    }

    function toggleTheme() {
        const html = document.documentElement;
        html.classList.toggle('dark');
        localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
    }

    document.addEventListener('DOMContentLoaded', () => {
        const hash = window.location.hash;
        let defaultTab = 'products';
        
        // Cek jika session memiliki status/error profile/password, arahkan ke tab profile
        if (hash === '#profile' || 
            {{ session('status') === 'profile-updated' || session('status') === 'password-updated' || $errors->any() || $errors->updatePassword->any() ? 'true' : 'false' }}) {
            defaultTab = 'profile';
        } else if (hash === '#orders') {
            defaultTab = 'orders';
        }
        
        const targetLink = Array.from(document.querySelectorAll('.nav-link')).find(link => {
            const onClickText = link.getAttribute('onclick') || '';
            return onClickText.includes(defaultTab);
        });
        
        if (targetLink) {
            switchView(defaultTab, targetLink);
        }
    });
</script>

</body>
</html>