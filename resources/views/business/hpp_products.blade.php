{{-- File: product-data.blade.php --}}
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
        
        .profit-positive {
            color: #10B981;
        }
        
        .profit-negative {
            color: #EF4444;
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
        
        .category-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-fashion {
            background: linear-gradient(135deg, #FEF3C7, #FFEDD5);
            color: #F97316;
        }
        
        .dark .badge-fashion {
            background: linear-gradient(135deg, #78350F, #451A03);
            color: #FDBA74;
        }
        
        .badge-fnb {
            background: linear-gradient(135deg, #FEF3C7, #FFEDD5);
            color: #F59E0B;
        }
 
        .dark .badge-fnb {
            background: linear-gradient(135deg, #78350F, #451A03);
            color: #FCD34D;
        }
        
        .badge-furniture {
            background: linear-gradient(135deg, #FEF3C7, #FFEDD5);
            color: #F97316;
        }
 
        .dark .badge-furniture {
            background: linear-gradient(135deg, #78350F, #451A03);
            color: #FDBA74;
        }
        
        .badge-digital {
            background: linear-gradient(135deg, #FEF3C7, #FFEDD5);
            color: #F59E0B;
        }
 
        .dark .badge-digital {
            background: linear-gradient(135deg, #78350F, #451A03);
            color: #FCD34D;
        }
    </style>
 
    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-orange-100/20 dark:from-navy-800 dark:via-navy-900 dark:to-navy-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 fade-in-up">
            
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between border-b pb-6 border-orange-500/10 dark:border-orange-500/30">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="text-gradient-orange">Clarity</span>
                                <span class="text-navy-900 dark:text-white">Profit</span>
                            </h1>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300 max-w-2xl">
                                Kelola katalog produk hasil perhitungan HPP untuk kemudahan manajemen inventory.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('hpp.create') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl font-black text-xs uppercase tracking-widest text-white shadow-md hover:shadow-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat HPP Baru
                    </a>
                </div>
            </div>
 
            @include('business.partials.hpp_nav')
 
            <!-- Stats Cards -->
            @if(!$products->isEmpty())
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-10 fade-in-up">
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Total Produk</p>
                            <p class="text-2xl font-black text-navy-900 dark:text-white mt-1">{{ $products->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-950 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Rata-rata HPP</p>
                            <p class="text-xl font-black text-navy-900 dark:text-white mt-1">Rp{{ number_format($products->avg('total_hpp_per_unit') ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-950 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Rata-rata Harga Jual</p>
                            <p class="text-xl font-black text-navy-900 dark:text-white mt-1">Rp{{ number_format($products->avg('target_selling_price') ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-950 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Rata-rata Profit</p>
                            @php
                                $avgProfit = $products->avg(function($p) {
                                    return $p->target_selling_price - $p->total_hpp_per_unit;
                                }) ?? 0;
                            @endphp
                            <p class="text-xl font-black {{ $avgProfit >= 0 ? 'profit-positive' : 'profit-negative' }} mt-1">
                                Rp{{ number_format($avgProfit, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-950 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endif
 
            <!-- Products Table Card -->
            <div class="bg-white dark:bg-navy-900 rounded-3xl shadow-xl border border-orange-500/10 dark:border-orange-500/20 overflow-hidden fade-in-up transition-all">
                <div class="bg-orange-50 dark:bg-navy-950 px-8 py-6 flex justify-between items-center border-b border-orange-200/60 dark:border-white/5 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="font-black text-slate-900 dark:text-white text-lg tracking-wide uppercase">Daftar Produk (HPP Master)</h3>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-black text-slate-600 dark:text-slate-300 uppercase tracking-widest">{{ $products->count() }} Produk Aktif</span>
                    </div>
                </div>
 
                @if($products->isEmpty())
                    <div class="p-16 text-center empty-state">
                        <div class="w-24 h-24 bg-orange-50 dark:bg-navy-950 rounded-full flex items-center justify-center mx-auto mb-6 transition-colors">
                            <svg class="w-12 h-12 text-orange-500 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-navy-900 dark:text-white mb-2">Belum Ada Data Produk</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto">
                            Simpan hasil perhitungan HPP untuk mendaftarkan produk baru secara otomatis di sini.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-orange-50/50 dark:bg-navy-950/50 border-b border-orange-500/10 transition-colors">
                                <tr class="text-[11px] font-black text-navy-900 dark:text-slate-300 uppercase tracking-widest">
                                    <th class="py-5 px-8">ID Produk</th>
                                    <th class="py-5 px-8">Nama Produk</th>
                                    <th class="py-5 px-8">Kategori</th>
                                    <th class="py-5 px-8 text-right">HPP/Unit</th>
                                    <th class="py-5 px-8 text-right">Harga Jual</th>
                                    <th class="py-5 px-8 text-right">Profit/Unit</th>
                                    <th class="py-5 px-8 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-500/10">
                                @foreach($products as $product)
                                    @php
                                        $profit = $product->target_selling_price - $product->total_hpp_per_unit;
                                        $profitMargin = $product->target_selling_price > 0 ? ($profit / $product->target_selling_price) * 100 : 0;
                                        $isPositive = $profit >= 0;
                                    @endphp
                                    <tr class="table-row-hover hover:bg-orange-500/5 transition-colors group">
                                        <td class="py-5 px-8">
                                            <span class="font-mono font-bold text-navy-800 dark:text-slate-300 text-xs">{{ $product->hpp_id }}</span>
                                        </td>
                                        <td class="py-5 px-8">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-orange-500/10 text-orange-500 rounded-lg flex items-center justify-center group-hover:rotate-12 transition-transform">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                                <span class="font-black text-navy-900 dark:text-white">{{ $product->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-5 px-8">
                                            <span class="inline-flex px-3 py-1 rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 text-[10px] font-black uppercase tracking-widest border border-orange-500/10">
                                                {{ $product->category }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-8 text-right font-mono font-bold text-navy-900 dark:text-white">
                                            Rp{{ number_format($product->total_hpp_per_unit, 0, ',', '.') }}
                                        </td>
                                        <td class="py-5 px-8 text-right font-mono font-bold text-green-600 dark:text-green-500">
                                            Rp{{ number_format($product->target_selling_price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-5 px-8 text-right">
                                            <div class="flex flex-col items-end">
                                                <span class="font-mono font-black {{ $isPositive ? 'text-green-600' : 'text-red-500' }}">
                                                    {{ $isPositive ? '' : '-' }}Rp{{ number_format(abs($profit), 0, ',', '.') }}
                                                </span>
                                                <span class="text-[9px] font-bold {{ $isPositive ? 'text-green-500' : 'text-red-400' }}">
                                                    {{ $isPositive ? '+' : '' }}{{ number_format($profitMargin, 1) }}%
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-5 px-8 text-center">
                                            <div class="flex items-center justify-center gap-4">
                                                <a href="{{ route('hpp.show', $product->id) }}" class="flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest text-orange-500 hover:text-orange-600 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Detail
                                                </a>
                                                <form action="{{ route('hpp.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data produk ini?');">
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

                    <div class="bg-orange-50/30 dark:bg-navy-950/30 px-8 py-5 border-t border-orange-500/10 flex justify-between items-center transition-colors">
                        <div class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">
                            Menampilkan {{ $products->count() }} produk dari total keseluruhan
                        </div>
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-4 text-[9px] font-black uppercase tracking-widest">
                                <span class="flex items-center gap-1.5 text-green-500">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    Profit Positif
                                </span>
                                <span class="flex items-center gap-1.5 text-red-500">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    Profit Negatif
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Profit Summary Alert -->
            @if(!$products->isEmpty() && $products->filter(function($p) { return $p->target_selling_price <= $p->total_hpp_per_unit; })->count() > 0)
            <div class="mt-6 bg-red-500/10 border border-red-500/30 dark:border-red-500/20 rounded-2xl p-4 fade-in-up transition-all">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-red-600 dark:text-red-500 uppercase tracking-wider">Perhatian!</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            Terdapat {{ $products->filter(function($p) { return $p->target_selling_price <= $p->total_hpp_per_unit; })->count() }} produk dengan harga jual yang kurang dari atau sama dengan HPP. 
                            Segera evaluasi harga jual atau efisiensi biaya produksi.
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>