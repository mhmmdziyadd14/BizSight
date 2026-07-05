{{-- File: products/index.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Our Products - Clarity Labs</title>
    
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

        .section-title {
            font-size: 22px;
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
            gap: 28px;
            margin-bottom: 48px;
        }

        @media (max-width: 1024px) {
            .app-container { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .product-grid { grid-template-columns: 1fr; }
        }

        .product-card {
            background: var(--bg);
            border: 1.5px solid var(--bd);
            border-radius: var(--radlg);
            padding: 36px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .product-card:hover {
            border-color: var(--ora);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
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

        .product-name { font-size: 22px; font-weight: 900; color: var(--blk); letter-spacing: -0.02em; }
        .product-desc { font-size: 14px; color: var(--t2); line-height: 1.6; font-weight: 500; }

        .price-tag {
            font-size: 28px;
            font-weight: 900;
            color: var(--blk);
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .price-tag span {
            font-size: 14px;
            color: var(--t3);
            font-weight: 600;
        }

        .features-list {
            margin: 8px 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--t2);
        }

        .feature-icon-check {
            color: #22c55e;
            width: 18px;
            height: 18px;
        }

        .btn-checkout-group {
            display: flex;
            gap: 12px;
            margin-top: auto;
        }

        .btn-midtrans {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px;
            background: var(--ora);
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            font-size: 13px;
            text-transform: uppercase;
            tracking-wider: 0.05em;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-midtrans:hover {
            background: var(--ora-dk);
            transform: translateY(-1px);
        }

        .btn-scalev {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px;
            background: var(--bg3);
            color: var(--t1);
            text-decoration: none;
            border: 1px solid var(--bd);
            border-radius: 12px;
            font-weight: 800;
            font-size: 13px;
            text-transform: uppercase;
            tracking-wider: 0.05em;
            transition: all 0.2s;
        }

        .btn-scalev:hover {
            background: var(--bd);
            transform: translateY(-1px);
        }

        .badge-premium {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 10px;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #F59E0B;
            color: white;
        }

        .badge-trial {
            background: var(--ora-lt);
            color: var(--ora);
            border: 1px solid var(--ora);
            font-size: 10px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            width: fit-content;
        }

        /* theme toggle */
        .theme-toggle-btn {
            background: none;
            border: none;
            color: var(--t2);
            cursor: pointer;
            padding: 8px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle-btn:hover { background: var(--bg3); }
    </style>
</head>
<body>

@php
    $user = auth()->user();
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
        <a href="{{ route('dashboard') }}" class="nav-link">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            My Products
        </a>
        <a href="{{ route('products.index') }}" class="nav-link active">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Our Products
        </a>
        <a href="{{ route('dashboard') }}#orders" class="nav-link">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            Purchase History
        </a>

        @if($user->isAdmin())
        <p class="sidebar-section">Admin Menu</p>
        <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Admin Panel
        </a>
        @endif

        <p class="sidebar-section">Account</p>
        <a href="{{ route('dashboard') }}#profile" class="nav-link">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Profile Settings
        </a>
        <a href="#" class="nav-link" onclick="toggleTheme(); event.preventDefault();">
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
                <h1 class="page-title">Our Products</h1>
                <p class="page-subtitle">Buka fitur premium lainnya untuk mengakselerasi brand fashion Anda.</p>
            </div>
            
            <button onclick="toggleTheme()" class="theme-toggle-btn">
                <svg class="w-6 h-6 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                <svg class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </button>
        </div>

        @if (session('success'))
            <div style="margin-bottom: 32px; padding: 16px 20px; background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); color: #22c55e; border-radius: var(--rad); font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="margin-bottom: 32px; padding: 16px 20px; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; border-radius: var(--rad); font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- SECTION 1: LIFETIME PRODUCTS -->
        <div class="section-title">
            <div class="title-dot"></div>
            Akses Lifetime (Miliki Selamanya)
        </div>
        
        <div class="product-grid">
            @forelse ($lifetimeProducts as $product)
                <div class="product-card">
                    @if ($product->type === 'bundle')
                        <div class="badge-premium">Bundle Hemat</div>
                    @endif
                    
                    <div class="product-icon">
                        @if ($product->name === 'Visual Clarity Pack')
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @elseif ($product->name === 'Profit Clarity Calculator')
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @elseif ($product->name === 'Decision Engine')
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @else
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m12-5a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @endif
                    </div>
                    
                    <div>
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <p class="product-desc mt-2">
                            @if ($product->name === 'Visual Clarity Pack')
                                Briefing template dan dokumen kerja visual terstandarisasi untuk tim Anda.
                            @elseif ($product->name === 'Profit Clarity Calculator')
                                Kalkulator HPP pakaian canggih untuk menghitung CMT, bahan, reject, dan margin keuntungan.
                            @elseif ($product->name === 'Decision Engine')
                                Analisis kelayakan produk pakaian secara instan berbasis angka dan proyeksi bisnis terarah.
                            @elseif ($product->name === 'Clarity Essentials')
                                Bundle produk esensial mencakup Profit Clarity Calculator dan Decision Engine.
                            @else
                                Paket lengkap Clarity Labs: Profit Calculator, Decision Engine, dan Visual Pack.
                            @endif
                        </p>
                    </div>

                    <div class="features-list">
                        @foreach ($product->features as $featureCode)
                            <div class="feature-item">
                                <svg class="feature-icon-check" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                <span>
                                    @if ($featureCode === 'PCC') Profit Clarity Calculator @endif
                                    @if ($featureCode === 'DE') Clarity Decision Engine @endif
                                    @if ($featureCode === 'VCP') Visual Clarity Pack @endif
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="price-tag">
                        Rp {{ number_format($product->price / 1000, 0) }}k
                        <span>/ miliki selamanya</span>
                    </div>

                    <div class="btn-checkout-group">
                        <form action="{{ route('checkout') }}" method="POST" style="flex: 1; display: flex;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn-midtrans">Beli Langsung</button>
                        </form>
                        @if (isset($product->scalev_url))
                            <a href="{{ $product->scalev_url }}" target="_blank" class="btn-scalev">Beli di Scalev</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card" style="grid-column: span 2; text-align: center; padding: 60px; color: var(--t3); font-weight: 700;">
                    Hebat! Anda sudah membeli semua produk lifetime yang tersedia.
                </div>
            @endforelse
        </div>

        <!-- SECTION 2: TRIAL EXTENSIONS / MONTHLY -->
        <div class="section-title">
            <div class="title-dot"></div>
            Fitur Waktu Terbatas / Langganan Bulanan
        </div>

        <div class="product-grid">
            @forelse ($trialExtensions as $product)
                <div class="product-card">
                    <div class="badge-trial">Akses 30 Hari</div>
                    
                    <div class="product-icon" style="margin-top: 10px;">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>

                    <div>
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <p class="product-desc mt-2">
                            Perpanjang atau buka akses penuh ke fitur ini selama 30 hari ke depan. Pilihan ekonomis untuk kebutuhan musiman.
                        </p>
                    </div>

                    <!-- Trial Status Info -->
                    @if (isset($product->existing_trial))
                        @php
                            $isExpired = $product->existing_trial->expires_at && now()->greaterThan($product->existing_trial->expires_at);
                        @endphp
                        <div class="p-3.5 rounded-xl text-xs font-bold transition-all" style="background: {{ $isExpired ? 'rgba(239, 68, 68, 0.1)' : 'rgba(249, 115, 22, 0.1)' }}; color: {{ $isExpired ? '#ef4444' : 'var(--ora)' }}; display: flex; align-items: center; gap: 8px;">
                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @if ($isExpired)
                                Sesi Trial Anda Telah Berakhir (Expired)
                            @else
                                Trial Aktif sampai: {{ $product->existing_trial->expires_at->format('d M Y') }}
                            @endif
                        </div>
                    @else
                        <div class="p-3.5 rounded-xl text-xs font-bold text-gray-400 dark:text-gray-500" style="background: var(--bg3); display: flex; align-items: center; gap: 8px;">
                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Belum Ada Akses Aktif
                        </div>
                    @endif

                    <div class="price-tag">
                        Rp {{ number_format($product->price / 1000, 0) }}k
                        <span>/ 30 hari akses</span>
                    </div>

                    <div class="btn-checkout-group">
                        <form action="{{ route('checkout') }}" method="POST" style="flex: 1; display: flex;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn-midtrans">Beli Langsung</button>
                        </form>
                        @if (isset($product->scalev_url))
                            <a href="{{ $product->scalev_url }}" target="_blank" class="btn-scalev">Beli di Scalev</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card" style="grid-column: span 2; text-align: center; padding: 60px; color: var(--t3); font-weight: 700;">
                    Tidak ada perpanjangan trial yang tersedia untuk dibeli saat ini.
                </div>
            @endforelse
        </div>
    </main>
</div>

<script>
    function toggleTheme() {
        const html = document.documentElement;
        const isDark = html.classList.contains('dark');
        const newTheme = isDark ? 'light' : 'dark';
        
        if (isDark) {
            html.classList.remove('dark');
        } else {
            html.classList.add('dark');
        }
        
        localStorage.setItem('theme', newTheme);
        
        // Sync theme setting to session via API
        fetch('/profile', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ theme: newTheme })
        }).catch(err => console.log('Theme sync error:', err));
    }
</script>

</body>
</html>
