{{-- File: hpp-index.blade.php --}}
<x-app-layout>
    <style>
        * {
            font-family: 'Outfit', sans-serif;
        }
        
        .bg-gradient-orange {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
        }
        
        .text-gradient-orange {
            background: linear-gradient(135deg, #F97316 0%, #F59E0B 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .bg-gradient-navy {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .table-row-hover {
            transition: all 0.2s ease;
        }
        
        .table-row-hover:hover {
            background: linear-gradient(90deg, rgba(254, 243, 199, 0.1) 0%, rgba(255, 247, 237, 0.05) 100%);
        }
        
        .stat-card {
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #F97316, #F59E0B);
        }
        
        .badge-printed {
            background: linear-gradient(135deg, #10B98110 0%, #05966920 100%);
            color: #059669;
            border: 1px solid #10B98130;
        }
        
        .badge-unprinted {
            background: linear-gradient(135deg, #6B728010 0%, #9CA3AF20 100%);
            color: #6B7280;
            border: 1px solid #9CA3AF30;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .empty-state {
            animation: fadeInUp 0.4s ease-out;
        }
        
        .info-card {
            animation: slideIn 0.4s ease-out;
        }

        /* iframes in tab panels */
        .tab-panel iframe {
            width: 100%;
            border: none;
            border-radius: 16px;
            min-height: 80vh;
            display: block;
            background: transparent;
        }

        .tab-panel { display: none; }
        .tab-panel.active { display: block; animation: fadeInUp 0.3s ease-out; }
    </style>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-orange-100/20 dark:from-navy-800 dark:via-navy-900 dark:to-navy-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between border-b pb-8 border-orange-500/10 dark:border-orange-500/30 fade-in-up">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-2xl shadow-orange-500/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black tracking-tight">
                            <span class="text-navy-900 dark:text-white">Kalkulator</span>
                            <span class="text-gradient-orange">HPP</span>
                        </h1>
                        <p class="mt-2 text-base text-slate-500 dark:text-slate-400 font-medium">
                            Input detail produksi untuk menghitung Harga Pokok Penjualan secara presisi.
                        </p>
                    </div>
                </div>
                <div class="mt-6 md:mt-0" id="hpp-header-action">
                    <button onclick="document.querySelector('[data-tab=tab-profit]').click()" class="btn-primary inline-flex items-center gap-3 px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest text-white shadow-xl hover:shadow-orange-500/40 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat HPP Baru
                    </button>
                </div>
            </div>

            @include('business.partials.hpp_nav')

            <!-- ===== TAB: PROFIT COUNT (iframe) ===== -->
            <div id="tab-profit" class="tab-panel">
                <iframe id="profit-iframe" src="" data-src="{{ route('hpp.create') }}?embed=1" title="Profit Count" style="width:100%;border:none;min-height:90vh;border-radius:16px;"></iframe>
            </div>

            <!-- ===== TAB: MATERIAL ===== -->
            <div id="tab-material" class="tab-panel">
                <iframe id="material-iframe" src="" data-src="{{ route('hpp.bahan') }}?embed=1" title="Material" style="width:100%;border:none;min-height:85vh;border-radius:16px;"></iframe>
            </div>

            <!-- ===== TAB: DATA PRODUCT ===== -->
            <div id="tab-products" class="tab-panel">
                <iframe id="products-iframe" src="" data-src="{{ route('hpp.products') }}?embed=1" title="Data Produk" style="width:100%;border:none;min-height:85vh;border-radius:16px;"></iframe>
            </div>

            <!-- ===== TAB: INVENTORY ===== -->
            <div id="tab-inventory" class="tab-panel">
                <iframe id="inventory-iframe" src="" data-src="{{ route('hpp.inventory') }}?embed=1" title="Inventory" style="width:100%;border:none;min-height:85vh;border-radius:16px;"></iframe>
            </div>

            <!-- ===== TAB: BILL OF MATERIAL ===== -->
            <div id="tab-bom" class="tab-panel">
                <iframe id="bom-iframe" src="" data-src="{{ route('hpp.bom') }}?embed=1" title="Bill Of Material" style="width:100%;border:none;min-height:85vh;border-radius:16px;"></iframe>
            </div>

            <!-- ===== TAB: DATA HPP ===== -->
            <div id="tab-datahpp" class="tab-panel">

            <!-- Info Card -->
            <div class="mb-10 bg-gradient-to-r from-orange-500/10 via-orange-400/5 to-transparent rounded-3xl p-6 border border-orange-500/10 dark:border-orange-500/20 info-card transition-all">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-navy-900 dark:text-white">Ringkasan HPP</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">
                            Gunakan menu <span class="font-bold text-orange-400">Bahan</span> untuk menambahkan dan mengelola persediaan bahan, 
                            lalu buat perhitungan HPP dari menu <span class="font-bold text-orange-400">Hitung HPP</span>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            @if(!$hppCalculations->isEmpty())
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-10 fade-in-up">
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Total HPP</p>
                            <p class="text-3xl font-black text-navy-900 dark:text-white mt-1">{{ $hppCalculations->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-950 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Sudah Dicetak</p>
                            <p class="text-3xl font-black text-green-600 dark:text-green-400 mt-1">{{ $hppCalculations->whereNotNull('printed_at')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-950 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Belum Dicetak</p>
                            <p class="text-3xl font-black text-orange-600 dark:text-orange-400 mt-1">{{ $hppCalculations->whereNull('printed_at')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-950 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Rata-rata HPP</p>
                            <p class="text-2xl font-black text-navy-900 dark:text-white mt-1">Rp{{ number_format($hppCalculations->avg('total_hpp_per_unit') ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-950 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- HPP Table Card -->
            <div class="bg-white dark:bg-navy-900 rounded-3xl shadow-xl border border-orange-500/10 dark:border-orange-500/20 overflow-hidden fade-in-up transition-all">
                <div class="bg-orange-50 dark:bg-navy-950 px-8 py-6 flex justify-between items-center border-b border-orange-200/60 dark:border-white/5 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-black text-slate-900 dark:text-white text-lg tracking-wide uppercase">Daftar Perhitungan HPP</h3>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                        </span>
                        <span class="text-xs font-black text-slate-600 dark:text-slate-300 uppercase tracking-widest">{{ $hppCalculations->count() }} Data</span>
                    </div>
                </div>

                @if($hppCalculations->isEmpty())
                    <div class="p-16 text-center empty-state">
                        <div class="w-24 h-24 bg-orange-50 dark:bg-navy-950 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-orange-500 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-navy-900 dark:text-white mb-2">Belum Ada Data HPP</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto">
                            Silakan mulai dengan menambahkan bahan baku atau langsung buat perhitungan HPP baru.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('hpp.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-xl text-xs font-black uppercase tracking-wider hover:shadow-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buat HPP Sekarang
                            </a>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-orange-50/50 dark:bg-navy-950/50 border-b border-orange-500/10 transition-colors">
                                <tr class="text-[11px] font-black text-navy-900 dark:text-slate-300 uppercase tracking-widest">
                                    <th class="py-5 px-8">ID</th>
                                    <th class="py-5 px-8">Nama</th>
                                    <th class="py-5 px-8">Kategori</th>
                                    <th class="py-5 px-8 text-center">Tanggal</th>
                                    <th class="py-5 px-8 text-right">HPP/Unit</th>
                                    <th class="py-5 px-8 text-right">Harga Jual</th>
                                    <th class="py-5 px-8 text-center">Status Cetak</th>
                                    <th class="py-5 px-8 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-500/10">
                                @foreach($hppCalculations as $hpp)
                                    <tr class="table-row-hover hover:bg-orange-500/5 transition-colors group">
                                        <td class="py-5 px-8">
                                            <span class="font-mono font-bold text-navy-800 dark:text-slate-300 text-xs">{{ $hpp->hpp_id }}</span>
                                        </td>
                                        <td class="py-5 px-8">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-orange-500/10 text-orange-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                                <span class="font-black text-navy-900 dark:text-white">{{ $hpp->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-5 px-8">
                                            <span class="inline-flex px-3 py-1 rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 text-[10px] font-black uppercase tracking-widest border border-orange-500/10">
                                                {{ $hpp->category }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-8 text-center">
                                            <div class="flex items-center justify-center gap-2 text-slate-500 dark:text-slate-400 font-bold text-xs">
                                                <svg class="w-3.5 h-3.5 text-orange-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="local-time" data-utc="{{ $hpp->created_at->toIso8601String() }}">{{ $hpp->created_at->format('d M Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="py-5 px-8 text-right">
                                            <span class="font-mono font-black text-orange-600 dark:text-orange-500">Rp{{ number_format($hpp->total_hpp_per_unit, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="py-5 px-8 text-right">
                                            <span class="font-mono font-black text-green-600 dark:text-green-500">Rp{{ number_format($hpp->target_selling_price, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="py-5 px-8 text-center">
                                            @if($hpp->printed_at)
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-[10px] font-black uppercase tracking-widest border border-green-500/10">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Dicetak
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest border border-slate-500/10">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Belum
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-5 px-8 text-center">
                                            <div class="flex items-center justify-center gap-4">
                                                <a href="{{ route('hpp.show', $hpp->id) }}" class="flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest text-orange-500 hover:text-orange-600 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Detail
                                                </a>
                                                @if(!$hpp->printed_at)
                                                <a href="{{ route('hpp.print', $hpp->id) }}" target="_blank" class="flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest text-orange-500 hover:text-orange-600 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                    </svg>
                                                    Cetak
                                                </a>
                                                @endif
                                                <form action="{{ route('hpp.destroy', $hpp->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data HPP ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest text-red-500 hover:text-red-600 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16"></path>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Table Footer -->
                    <div class="bg-orange-50/30 dark:bg-navy-950/30 px-8 py-5 border-t border-orange-500/10 flex justify-between items-center transition-colors">
                        <div class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">
                            Menampilkan {{ $hppCalculations->count() }} perhitungan HPP
                        </div>
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-4 text-[9px] font-black uppercase tracking-widest">
                                <span class="flex items-center gap-1.5 text-slate-500">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    {{ $hppCalculations->whereNotNull('printed_at')->count() }} Dicetak
                                </span>
                                <span class="flex items-center gap-1.5 text-slate-500">
                                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                    {{ $hppCalculations->whereNull('printed_at')->count() }} Belum
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Hint Section -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 fade-in-up">
                <div class="bg-white dark:bg-black p-6 rounded-3xl border border-orange-500/10 dark:border-white/10 shadow-lg group hover:border-orange-500/50 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-orange-500/20 rounded-xl flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.754 18 18.168 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-navy-900 dark:text-white uppercase tracking-widest">Master Data Produk</h4>
                            <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Gunakan hasil HPP ini sebagai acuan Master Data di menu Produk.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-navy-900 p-6 rounded-3xl border border-orange-500/10 dark:border-orange-500/20 shadow-sm group hover:border-orange-500 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-orange-500/20 rounded-xl flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-navy-900 dark:text-white uppercase tracking-widest">Cetak Laporan</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Anda bisa mencetak rincian kalkulasi HPP dan Bill of Material (BOM).</p>
                        </div>
                    </div>
                </div>
            </div>

            </div>{{-- end tab-datahpp --}}
        </div>
    </div>
</x-app-layout>