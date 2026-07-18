{{-- File: decisions-list.blade.php --}}
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
        
        .table-row-hover {
            transition: all 0.2s ease;
        }
        
        .table-row-hover:hover {
            background: linear-gradient(90deg, #FEF3C7 0%, #FFF7ED 100%);
            cursor: pointer;
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
        
        .status-fragile {
            background: linear-gradient(135deg, #F59E0B10 0%, #F9731620 100%);
            color: #F59E0B;
            border: 1px solid #F9731630;
        }
        
        .status-critical {
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

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-orange-100/20 dark:from-navy-800 dark:via-navy-900 dark:to-navy-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between border-b pb-6 border-orange-500/10 dark:border-orange-500/30 fade-in-up">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="text-gradient-orange">Clarity</span>
                                <span class="text-navy-900 dark:text-white">Decisions</span>
                            </h1>
                            <p class="mt-1 text-sm text-slate-500 dark:text-gray-400 font-medium">
                                Daftar analisis kelayakan bisnis Anda
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex gap-3">
                    <div class="inline-flex items-center gap-2 bg-white dark:bg-navy-900 px-5 py-2.5 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 transition-all">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                        </span>
                        <span class="text-[10px] font-black text-navy-900 dark:text-navy-300 uppercase tracking-widest">Live Data</span>
                    </div>
                    <a href="{{ route('business.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-2xl text-[10px] font-black uppercase tracking-wider hover:shadow-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Analisis Baru
                    </a>
                </div>
            </div>

            <!-- Stats Summary Cards -->
            @if($calculations->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8 fade-in-up">
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider">Total Analisis</p>
                            <p class="text-2xl font-black text-navy-900 dark:text-white mt-1">{{ $calculations->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-900 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider">Avg. Harga Jual</p>
                            <p class="text-xl font-black text-navy-900 dark:text-white mt-1">Rp{{ number_format($calculations->avg('selling_price') ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-900 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider">Status Healthy</p>
                            <p class="text-2xl font-black text-green-600 dark:text-green-400 mt-1">{{ $calculations->where('status', 'HEALTHY')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-50 dark:bg-navy-900 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white dark:bg-navy-900 rounded-2xl shadow-sm border border-orange-500/10 dark:border-orange-500/20 p-5 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider">Avg. Net Margin</p>
                            <p class="text-2xl font-black text-orange-600 dark:text-orange-400 mt-1">
                                @php
                                    $avgMargin = $calculations->avg(function($calc) {
                                        $hpp = $calc->hpp;
                                        $selling = $calc->selling_price;
                                        $margin = ($selling - $hpp) / $selling * 100;
                                        return $margin;
                                    });
                                @endphp
                                {{ number_format($avgMargin, 1, ',', '.') }}%
                            </p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-900 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Decisions List Table Card -->
            <div class="bg-white dark:bg-navy-900 rounded-3xl shadow-xl border border-orange-500/10 dark:border-orange-500/20 overflow-hidden fade-in-up transition-all">
                <div class="bg-orange-50 dark:bg-navy-950 px-6 py-5 flex justify-between items-center border-b border-orange-500/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-navy-900 dark:text-white text-base tracking-wide">Daftar Analisis Decision Engine</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[9px] font-bold text-orange-300 uppercase tracking-wider">{{ $calculations->count() }} Analisis</span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    @if($calculations->isEmpty())
                        <div class="p-12 text-center empty-state">
                            <div class="w-16 h-16 bg-orange-50 dark:bg-navy-950 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-black text-navy-900 dark:text-white mb-2">Belum Ada Analisis</h3>
                            <p class="text-sm text-slate-500 dark:text-gray-400 max-w-md mx-auto">Belum ada data analisis yang tersedia. Silakan lakukan analisis kelayakan bisnis terlebih dahulu.</p>
                        </div>
                    @else
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-orange-50 dark:bg-navy-950 border-b border-orange-500/10 transition-colors">
                                    <th class="px-6 py-4 text-[10px] font-black text-navy-600 dark:text-orange-400 uppercase tracking-wider">Product Instance</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-navy-600 dark:text-orange-400 uppercase tracking-wider">Economic Variables</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-navy-600 dark:text-orange-400 uppercase tracking-wider">Performance</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-navy-600 dark:text-orange-400 uppercase tracking-wider text-right">System Result</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-50 dark:divide-navy-800">
                                @foreach($calculations as $calc)
                                @php
                                    $margin = $calc->net_margin_percent;
                                    $statusClass = '';
                                    if($calc->status_label == 'HEALTHY') {
                                        $statusClass = 'status-healthy';
                                    } elseif($calc->status_label == 'FRAGILE') {
                                        $statusClass = 'status-fragile';
                                    } else {
                                        $statusClass = 'status-critical';
                                    }
                                @endphp
                                <tr class="table-row-hover transition-colors group">
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-navy-900 dark:text-white text-lg leading-tight">{{ $calc->product_name }}</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[9px] font-black text-orange-500 uppercase tracking-widest">ID: #BZS-{{ $calc->id }}</span>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">| <span class="local-time" data-utc="{{ $calc->created_at->toIso8601String() }}">{{ $calc->created_at->format('d M Y') }}</span></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div>
                                                <div class="text-[8px] font-black text-slate-400 uppercase mb-1 tracking-wider">HPP Value</div>
                                                <div class="text-sm font-bold text-navy-700 dark:text-slate-300">Rp{{ number_format($calc->hpp, 0, ',', '.') }}</div>
                                            </div>
                                            <div class="h-8 w-px bg-orange-100 dark:bg-navy-700"></div>
                                            <div>
                                                <div class="text-[8px] font-black text-slate-400 uppercase mb-1 tracking-wider">Selling Price</div>
                                                <div class="text-sm font-bold text-orange-600">Rp{{ number_format($calc->selling_price, 0, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div>
                                                <div class="text-[8px] font-black text-slate-400 uppercase mb-1 tracking-wider">Net Margin</div>
                                                <div class="text-base font-black {{ $margin > 25 ? 'text-green-600' : ($margin > 10 ? 'text-orange-600' : 'text-red-600') }}">
                                                    {{ number_format($margin, 1, ',', '.') }}%
                                                </div>
                                            </div>
                                            <div class="h-8 w-px bg-orange-100 dark:bg-navy-700"></div>
                                            <div>
                                                <div class="text-[8px] font-black text-slate-400 uppercase mb-1 tracking-wider">Confidence</div>
                                                 <div class="flex items-center gap-2">
                                                     <span class="text-sm font-black text-navy-800 dark:text-slate-200">{{ $calc->confidence }}%</span>
                                                     <div class="w-12 h-1 bg-slate-100 dark:bg-navy-950 rounded-full overflow-hidden">
                                                         <div class="h-full bg-gradient-orange" style="width: {{ $calc->confidence }}%"></div>
                                                     </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex flex-col items-end gap-3">
                                            <span class="status-badge {{ $statusClass }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $calc->status_label === 'HEALTHY' ? 'bg-green-500' : ($calc->status_label === 'FRAGILE' ? 'bg-orange-500' : 'bg-red-500') }}"></span>
                                                {{ ucfirst(strtolower($calc->status_label)) }}
                                            </span>
                                            <div class="flex items-center gap-3">
                                                <form action="{{ route('business.destroy', $calc->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hasil analisis ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1.5 text-[10px] font-black text-red-500 hover:text-red-700 transition-all uppercase tracking-widest border-b-2 border-red-500/0 hover:border-red-500/50 pb-0.5">
                                                        Hapus
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <a href="{{ route('decisions.show', $calc->id) }}" class="inline-flex items-center gap-1.5 text-[10px] font-black text-orange-600 dark:text-orange-400 hover:text-orange-700 transition-all uppercase tracking-widest border-b-2 border-orange-500/0 hover:border-orange-500/50 pb-0.5">
                                                    Lihat Laporan
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <!-- Table Footer with Summary -->
                        <div class="bg-orange-50/50 dark:bg-navy-950/50 px-6 py-4 border-t border-orange-500/10 dark:border-navy-700 flex justify-between items-center transition-colors">
                            <div class="text-[10px] font-semibold text-slate-500 dark:text-slate-400">
                                Menampilkan {{ $calculations->count() }} analisis dari total keseluruhan
                            </div>
                            <div class="flex gap-3 text-[10px] font-bold">
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> <span class="dark:text-gray-300">Healthy</span></span>
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-orange-500"></span> <span class="dark:text-gray-300">Fragile</span></span>
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> <span class="dark:text-gray-300">Critical</span></span>
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
                            <p class="text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider">Mulai Analisis Bisnis</p>
                            <p class="text-xs text-slate-500 dark:text-gray-400">Lakukan analisis kelayakan produk Anda untuk melihat keputusan bisnis yang tepat.</p>
                        </div>
                    </div>
                    <a href="{{ route('business.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-xl text-[10px] font-black uppercase tracking-wider hover:shadow-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Analisis Sekarang
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>