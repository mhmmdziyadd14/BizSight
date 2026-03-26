{{-- File: product-monitoring.blade.php --}}
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
        
        .table-row-hover {
            transition: all 0.2s ease;
        }
        
        .table-row-hover:hover {
            background: linear-gradient(90deg, #FEF3C7 0%, #FFF7ED 100%);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 40px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }
        
        .status-healthy {
            background: linear-gradient(135deg, #10B98110 0%, #05966920 100%);
            color: #059669;
            border: 1px solid #10B98130;
        }
        
        .status-risky {
            background: linear-gradient(135deg, #F59E0B10 0%, #F9731620 100%);
            color: #F59E0B;
            border: 1px solid #F9731630;
        }
        
        .status-danger {
            background: linear-gradient(135deg, #EF444410 0%, #DC262620 100%);
            color: #DC2626;
            border: 1px solid #EF444430;
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
        
        .empty-state {
            animation: fadeInUp 0.4s ease-out;
        }
    </style>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-navy-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between border-b pb-6 border-orange-200/50 fade-in-up">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="text-gradient-orange">AVS</span>
                                <span class="text-navy-900">Store Monitor</span>
                            </h1>
                            <p class="mt-1 text-sm text-navy-600 font-medium">
                                Real-time monitoring produk dan performa bisnis AVS Store
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm px-5 py-2.5 rounded-2xl shadow-sm border border-orange-200">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                        </span>
                        <span class="text-[10px] font-black text-navy-700 uppercase tracking-widest">Live Data Feed</span>
                    </div>
                </div>
            </div>

            <!-- Stats Summary Cards -->
            @if($calculations->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8 fade-in-up">
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total Produk</p>
                            <p class="text-2xl font-black text-navy-900 mt-1">{{ $calculations->count() }}</p>
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
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Avg. Harga Jual</p>
                            <p class="text-xl font-black text-navy-900 mt-1">Rp{{ number_format($calculations->avg('selling_price') ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total Pemilik</p>
                            <p class="text-2xl font-black text-navy-900 mt-1">{{ $calculations->groupBy('user_id')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Produk Viable</p>
                            <p class="text-2xl font-black text-green-600 mt-1">{{ $calculations->where('status', 'viable')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Product Monitoring Table Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden fade-in-up">
                <div class="bg-gradient-navy px-6 py-5 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white text-base tracking-wide">Monitoring Produk User (AVS Store)</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[9px] font-bold text-orange-300 uppercase tracking-wider">{{ $calculations->count() }} Produk</span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    @if($calculations->isEmpty())
                        <div class="p-12 text-center empty-state">
                            <div class="w-16 h-16 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-black text-navy-800 mb-2">Belum Ada Data Produk</h3>
                            <p class="text-sm text-navy-500 max-w-md mx-auto">Belum ada data produk yang tersedia. Silakan lakukan perhitungan HPP terlebih dahulu.</p>
                        </div>
                    @else
                        <table class="w-full text-left text-sm">
                            <thead class="bg-orange-50/70 border-b border-orange-100">
                                <tr class="text-[10px] font-black text-navy-600 uppercase tracking-wider">
                                    <th class="px-6 py-4">Pemilik</th>
                                    <th class="px-6 py-4">Nama Produk</th>
                                    <th class="px-6 py-4 text-right">HPP</th>
                                    <th class="px-6 py-4 text-right">Harga Jual</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                 </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-50">
                                @foreach($calculations as $calc)
                                <tr class="table-row-hover transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 bg-gradient-orange rounded-full flex items-center justify-center text-white text-[10px] font-bold shadow-sm">
                                                {{ strtoupper(substr($calc->user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-semibold text-navy-800">{{ $calc->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            </div>
                                            <span class="font-bold text-navy-800">{{ $calc->product_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="font-mono font-semibold text-navy-700">Rp{{ number_format($calc->hpp, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="font-mono font-bold text-orange-600">Rp{{ number_format($calc->selling_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusClass = '';
                                            $statusIcon = '';
                                            if($calc->status == 'viable') {
                                                $statusClass = 'status-healthy';
                                                $statusIcon = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
                                            } elseif($calc->status == 'warning') {
                                                $statusClass = 'status-risky';
                                                $statusIcon = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
                                            } else {
                                                $statusClass = 'status-danger';
                                                $statusIcon = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                                            }
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {!! $statusIcon !!}
                                            {{ $calc->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <!-- Table Footer with Summary -->
                        <div class="bg-orange-50/30 px-6 py-3 border-t border-orange-100 flex justify-between items-center">
                            <div class="text-[10px] font-semibold text-navy-500">
                                Menampilkan {{ $calculations->count() }} produk dari total keseluruhan
                            </div>
                            <div class="flex gap-3 text-[10px] font-bold">
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Viable</span>
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-orange-500"></span> Warning</span>
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> Critical</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Action Card -->
            @if($calculations->isEmpty())
            <div class="mt-6 bg-gradient-to-r from-orange-500/10 to-orange-400/5 rounded-2xl p-5 border border-orange-200/50">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-orange-600 uppercase tracking-wider">Mulai Analisis Bisnis</p>
                            <p class="text-xs text-navy-500">Lakukan perhitungan HPP untuk melihat status kelayakan produk Anda.</p>
                        </div>
                    </div>
                    <a href="{{ route('business.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-xl text-[10px] font-black uppercase tracking-wider hover:shadow-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Buat Perhitungan HPP
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>