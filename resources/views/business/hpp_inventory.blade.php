{{-- File: inventory-stock.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
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
            background: linear-gradient(90deg, #FEF3C7 0%, #FFF7ED 100%);
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
        
        .stock-low {
            color: #F97316;
            font-weight: 800;
        }
        
        .stock-critical {
            color: #EF4444;
            font-weight: 800;
            animation: pulseWarning 1.5s ease-in-out infinite;
        }
        
        @keyframes pulseWarning {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.6;
            }
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
        
        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.7rem;
            font-weight: 700;
        }
    </style>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-navy-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between border-b pb-6 border-orange-200/50 fade-in-up">
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
                                <span class="text-navy-800">Profit</span>
                            </h1>
                            <p class="mt-2 text-sm text-navy-600 max-w-2xl">
                                Data persediaan bahan. Lihat stok awal, masuk, keluar, dan stok akhir secara otomatis.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('materials.index') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl font-black text-xs uppercase tracking-widest text-white shadow-md hover:shadow-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        Kelola Bahan
                    </a>
                </div>
            </div>

            @include('business.partials.hpp_nav')

            <!-- Stats Cards -->
            @if(!$materials->isEmpty())
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-10 fade-in-up">
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total Bahan</p>
                            <p class="text-2xl font-black text-navy-900 mt-1">{{ $materials->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total Stok</p>
                            <p class="text-2xl font-black text-navy-900 mt-1">{{ number_format($materials->sum(function($m) { return ($m->stock_initial ?? 0) + ($m->stock_in ?? 0) - ($m->stock_out ?? 0); }), 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total Masuk</p>
                            <p class="text-2xl font-black text-blue-600 mt-1">{{ number_format($materials->sum('stock_in'), 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5 5 5m-5-5v12"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total Keluar</p>
                            <p class="text-2xl font-black text-red-600 mt-1">{{ number_format($materials->sum('stock_out'), 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5-5-5m5-5v12"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Inventory Table Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden fade-in-up">
                <div class="bg-gradient-navy px-6 py-5 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white text-base tracking-wide">Daftar Persediaan Bahan</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[9px] font-bold text-orange-300 uppercase tracking-wider">{{ $materials->count() }} Bahan</span>
                    </div>
                </div>

                @if($materials->isEmpty())
                    <div class="p-16 text-center empty-state">
                        <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-navy-800 mb-2">Belum Ada Data Bahan</h3>
                        <p class="text-sm text-navy-500 max-w-md mx-auto">
                            Tambahkan bahan baku terlebih dahulu untuk melihat data persediaan.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('materials.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-xl text-xs font-black uppercase tracking-wider hover:shadow-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Bahan Sekarang
                            </a>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-orange-50/70 border-b border-orange-100">
                                <tr class="text-[10px] font-black text-navy-600 uppercase tracking-wider">
                                    <th class="py-4 px-6">Nama Bahan</th>
                                    <th class="py-4 px-6">Warna</th>
                                    <th class="py-4 px-6 text-right">Stok Awal</th>
                                    <th class="py-4 px-6 text-right">Masuk</th>
                                    <th class="py-4 px-6 text-right">Keluar</th>
                                    <th class="py-4 px-6 text-right">Stok Akhir</th>
                                    <th class="py-4 px-6">Satuan</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-50">
                                @foreach($materials as $material)
                                    @php
                                        $stockEnd = ($material->stock_initial ?? 0) + ($material->stock_in ?? 0) - ($material->stock_out ?? 0);
                                        $stockStatus = $stockEnd <= 0 ? 'critical' : ($stockEnd <= 10 ? 'low' : 'normal');
                                    @endphp
                                    <tr class="table-row-hover transition-colors">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 bg-gradient-orange rounded-lg flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                                <span class="font-bold text-navy-800">{{ $material->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            @if($material->color && $material->color !== '-')
                                                <div class="flex items-center gap-1.5">
                                                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $material->color }};"></span>
                                                    <span class="text-sm text-navy-600">{{ $material->color }}</span>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-right font-mono font-bold text-navy-700">
                                            {{ number_format($material->stock_initial ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="py-4 px-6 text-right font-mono font-bold text-green-600">
                                            + {{ number_format($material->stock_in ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="py-4 px-6 text-right font-mono font-bold text-red-500">
                                            - {{ number_format($material->stock_out ?? 0, 2, ',', '.') }}
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <span class="font-mono font-black text-lg {{ $stockStatus == 'critical' ? 'stock-critical' : ($stockStatus == 'low' ? 'stock-low' : 'text-navy-800') }}">
                                                {{ number_format($stockEnd, 2, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="inline-flex px-2 py-1 rounded-lg bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wider">
                                                {{ $material->unit }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($stockStatus == 'critical')
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-red-100 text-red-600 text-[9px] font-black uppercase">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Habis
                                                </span>
                                            @elseif($stockStatus == 'low')
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-orange-100 text-orange-600 text-[9px] font-black uppercase">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Menipis
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-600 text-[9px] font-black uppercase">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Tersedia
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Table Footer -->
                    <div class="bg-orange-50/30 px-6 py-3 border-t border-orange-100 flex justify-between items-center">
                        <div class="text-[10px] font-semibold text-navy-500">
                            Menampilkan {{ $materials->count() }} bahan
                        </div>
                        <div class="flex gap-3 text-[10px] font-bold">
                            <span class="flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span> 
                                Tersedia
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-orange-500"></span> 
                                Menipis
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span> 
                                Habis
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Stock Alert Info -->
            @if(!$materials->isEmpty() && $materials->filter(function($m) { $stockEnd = ($m->stock_initial ?? 0) + ($m->stock_in ?? 0) - ($m->stock_out ?? 0); return $stockEnd <= 10; })->count() > 0)
            <div class="mt-6 bg-orange-500/10 border border-orange-500/30 rounded-2xl p-4 fade-in-up">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-orange-600 uppercase tracking-wider">Peringatan Stok</p>
                        <p class="text-xs text-navy-600 mt-1">
                            Terdapat {{ $materials->filter(function($m) { $stockEnd = ($m->stock_initial ?? 0) + ($m->stock_in ?? 0) - ($m->stock_out ?? 0); return $stockEnd <= 10; })->count() }} bahan dengan stok menipis atau habis. 
                            Segera lakukan pengadaan bahan untuk kelancaran produksi.
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>