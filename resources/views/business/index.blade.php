{{-- File: business-viability-calculator.blade.php --}}
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
        
        .input-focus-ring {
            transition: all 0.2s ease;
        }
        
        .input-focus-ring:focus {
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
            border-color: #F97316;
            outline: none;
        }
        
        .btn-analyze {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }
        
        .btn-analyze:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
        }
        
        .btn-analyze:active {
            transform: translateY(0);
        }
        
        .btn-pdf {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }
        
        .btn-pdf:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
        }
        
        .stat-card {
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
        }
        
        .health-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 60px;
            font-weight: 800;
            font-size: 24px;
        }
        
        .health-healthy {
            background: linear-gradient(135deg, #10B98110 0%, #05966920 100%);
            color: #059669;
            border: 1px solid #10B98130;
        }
        
        .health-risky {
            background: linear-gradient(135deg, #F59E0B10 0%, #F9731620 100%);
            color: #F59E0B;
            border: 1px solid #F9731630;
        }
        
        .health-danger {
            background: linear-gradient(135deg, #EF444410 0%, #DC262620 100%);
            color: #DC2626;
            border: 1px solid #EF444430;
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
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        .result-card {
            animation: fadeInUp 0.5s ease-out;
        }
        
        .empty-state {
            animation: fadeInUp 0.4s ease-out;
        }
        
        .metric-card {
            background: linear-gradient(135deg, #FEF3C7 0%, #FFEDD5 100%);
            border-radius: 20px;
            padding: 16px;
            transition: all 0.2s ease;
        }
        
        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.1);
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="text-gradient-orange">Biz</span>
                                <span class="text-navy-900">Sight</span>
                            </h1>
                            <p class="mt-2 text-sm text-navy-600 max-w-2xl">
                                Ubah data mentah menjadi keputusan bisnis yang matang. Masukkan angka penting Anda dan biarkan mesin BizSight menganalisis kelayakannya.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center gap-2 bg-white border border-orange-200 px-5 py-2.5 rounded-full text-xs font-black text-orange-600 uppercase tracking-widest shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                        </span>
                        Enterprise Edition v2.0
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left Panel - Input Form -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden sticky top-8 card-hover">
                        <div class="bg-gradient-navy px-6 py-5 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                                    <span class="text-white text-xs font-black">A</span>
                                </div>
                                <h3 class="font-bold text-white tracking-wide">Business Variables</h3>
                            </div>
                            <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        
                        <form action="{{ route('calculate') }}" method="POST" class="p-6 space-y-5">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Product Name</label>
                                <input type="text" name="product_name" required
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                    placeholder="Contoh: Sayur Organik X">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Pilih HPP yang sudah dibuat</label>
                                <select id="hppSelect" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all">
                                    <option value="">-- Tidak Pakai (Isi manual) --</option>
                                    @foreach($hppOptions as $option)
                                        <option value="{{ $option->total_hpp_per_unit }}" data-hpp="{{ $option->total_hpp_per_unit }}">{{ $option->hpp_id }} • {{ $option->name }} • Rp{{ number_format($option->total_hpp_per_unit, 0, ',', '.') }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-2 text-[10px] text-gray-400">Pilih HPP untuk mengisi nilai HPP ke formulir secara otomatis.</p>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">HPP & Selling Price</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                            <input type="number" name="hpp" required class="w-full pl-9 border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring" value="85000" placeholder="HPP">
                                        </div>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                            <input type="number" name="selling_price" required class="w-full pl-9 border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring" value="175000" placeholder="Jual">
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Admin Fee (%)</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="admin_fee_percent" class="w-full border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring" value="0" placeholder="Admin Fee">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Overhead (%)</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="overhead_percent" class="w-full border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring" value="0" placeholder="Overhead">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Pajak (%)</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="tax_percent" class="w-full border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring" value="0" placeholder="Pajak">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Promo (%)</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="promo_percent" class="w-full border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring" value="0" placeholder="Promo">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-[10px] text-gray-400">Akan dibandingkan margin normal dengan margin promo (selisih margin ditampilkan di bawah).</p>

                                <div>
                                    <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Ads & Batch Quantity</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                            <input type="number" name="ads_per_unit" required class="w-full pl-9 border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring" value="30000">
                                        </div>
                                        <div class="relative">
                                            <input type="number" name="est_batch_quantity" required class="w-full pr-10 border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring" value="100">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-[9px] font-bold">PCS</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit" 
                                    class="btn-analyze w-full flex items-center justify-center gap-2 text-white py-4 rounded-2xl font-extrabold text-sm uppercase tracking-widest shadow-xl active:scale-95 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    Analyze Viability
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Panel - Results -->
                <div class="lg:col-span-8">
                    <div class="mb-8 bg-white rounded-3xl p-6 shadow-sm border border-orange-100 fade-in-up">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-navy-800">Business Checker</h3>
                                    <p class="text-xs text-navy-500">Gunakan panel di samping untuk menganalisis kelayakan bisnis.</p>
                                </div>
                            </div>
                            <a href="{{ route('hpp.index') }}" class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-widest text-orange-500 hover:text-orange-600 transition-colors">
                                Lihat Daftar HPP
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    @if($calculations->count() > 0)
                        @php $latest = $calculations->first(); @endphp
                        
                        <div class="space-y-6 result-card">
                            <!-- Financial Metrics -->
                            <div class="bg-white rounded-3xl p-6 shadow-sm border border-orange-100">
                                <div class="flex items-center gap-2 mb-5">
                                    <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <span class="text-orange-500 text-xs font-black">B</span>
                                    </div>
                                    <h3 class="font-bold text-navy-800">Financial Breakdown</h3>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                                    <div class="metric-card">
                                        <div class="text-[9px] font-black text-orange-600 uppercase mb-1">Margin/Unit</div>
                                        <div class="text-lg font-bold text-navy-800">Rp{{ number_format($latest->selling_price - $latest->hpp, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="metric-card">
                                        <div class="text-[9px] font-black text-orange-600 uppercase mb-1">Margin Normal</div>
                                        <div class="text-lg font-bold text-navy-800">{{ number_format($latest->net_margin_percent, 1) }}%</div>
                                    </div>
                                    <div class="metric-card">
                                        <div class="text-[9px] font-black text-orange-600 uppercase mb-1">Margin Promo</div>
                                        <div class="text-lg font-bold text-navy-800">{{ number_format($latest->promo_margin_percent ?? 0, 1) }}%</div>
                                    </div>
                                    <div class="metric-card">
                                        <div class="text-[9px] font-black text-orange-600 uppercase mb-1">Selisih Margin</div>
                                        <div class="text-lg font-bold text-navy-800">{{ number_format($latest->margin_diff_percent ?? 0, 1) }}%</div>
                                    </div>
                                    <div class="metric-card">
                                        <div class="text-[9px] font-black text-orange-600 uppercase mb-1">Total Ads Cost</div>
                                        <div class="text-lg font-bold text-navy-800">Rp{{ number_format($latest->ads_per_unit * $latest->est_batch_quantity, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="metric-card" style="background: linear-gradient(135deg, #F97316 0%, #F59E0B 100%);">
                                        <div class="text-[9px] font-black text-white/80 uppercase mb-1">Net Profit/Unit</div>
                                        <div class="text-lg font-bold text-white">Rp{{ number_format($latest->net_profit, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- The Verdict Card -->
                            <div class="bg-gradient-navy rounded-3xl overflow-hidden shadow-xl">
                                <div class="bg-gradient-navy px-6 py-5 flex justify-between items-center border-b border-orange-500/30">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                                            <span class="text-white text-xs font-black italic">C</span>
                                        </div>
                                        <h3 class="font-bold text-white tracking-wide">The Verdict</h3>
                                    </div>
                                    <span class="text-[9px] font-bold text-orange-300 uppercase tracking-wider">BizSight Analysis Result</span>
                                </div>

                                <div class="p-8 bg-white rounded-b-3xl">
                                    <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-8 pb-6 border-b border-orange-100">
                                        <div>
                                            <div class="text-[9px] font-black text-orange-500 uppercase tracking-wider mb-2">Health Status</div>
                                            @php
                                                $statusClass = '';
                                                $statusIcon = '';
                                                if (strtoupper($latest->status_label) === 'HEALTHY') {
                                                    $statusClass = 'health-healthy';
                                                    $statusIcon = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
                                                } elseif (strtoupper($latest->status_label) === 'RISKY') {
                                                    $statusClass = 'health-risky';
                                                    $statusIcon = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
                                                } else {
                                                    $statusClass = 'health-danger';
                                                    $statusIcon = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
                                                }
                                            @endphp
                                            <div class="health-badge {{ $statusClass }}">
                                                {!! $statusIcon !!}
                                                {{ $latest->status_label }}
                                            </div>
                                        </div>
                                        <div class="flex gap-6">
                                            <div class="text-center">
                                                <div class="text-[9px] font-black text-orange-500 uppercase tracking-wider mb-1">Net Margin</div>
                                                <div class="text-3xl font-black text-orange-500">{{ number_format($latest->net_margin_percent, 1) }}%</div>
                                            </div>
                                            <div class="w-px h-12 bg-orange-200"></div>
                                            <div class="text-center">
                                                <div class="text-[9px] font-black text-orange-500 uppercase tracking-wider mb-1">BEP Unit</div>
                                                <div class="text-3xl font-black text-navy-800">{{ $latest->bep_unit }} <span class="text-xs text-gray-400">pcs</span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-8 mb-8">
                                        <div>
                                            <div class="text-[9px] font-black text-orange-500 uppercase tracking-wider mb-2">Logic Reasoning</div>
                                            <p class="text-lg text-navy-800 font-bold italic leading-relaxed">"{{ $latest->logic_reason }}"</p>
                                        </div>
                                        <div>
                                            <div class="text-[9px] font-black text-orange-500 uppercase tracking-wider mb-2">Action Required</div>
                                            @php
                                                $actionBg = 'bg-gradient-navy';
                                                if (strtoupper($latest->status_label) === 'HEALTHY') {
                                                    $actionBg = 'bg-gradient-to-r from-green-900 to-green-800';
                                                } elseif (strtoupper($latest->status_label) === 'RISKY') {
                                                    $actionBg = 'bg-gradient-to-r from-orange-900 to-orange-800';
                                                } elseif (strtoupper($latest->status_label) === 'DANGER') {
                                                    $actionBg = 'bg-gradient-to-r from-red-900 to-red-800';
                                                }
                                            @endphp
                                            <div class="{{ $actionBg }} p-5 rounded-2xl shadow-lg">
                                                <p class="text-sm font-semibold text-white leading-relaxed">{{ $latest->action_required }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex gap-4">
                                        <a href="{{ route('print.pdf', $latest->id) }}" class="flex-1 btn-pdf flex items-center justify-center gap-2 text-white py-3.5 rounded-xl text-xs font-black uppercase tracking-wider shadow-lg transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Generate PDF Report
                                        </a>
                                        <button onclick="window.print()" class="px-6 border-2 border-orange-500 rounded-xl hover:bg-orange-50 transition-all group">
                                            <svg class="w-5 h-5 text-orange-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="h-full flex flex-col items-center justify-center bg-white rounded-3xl border-2 border-dashed border-orange-200 p-12 text-center empty-state">
                            <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <h4 class="text-2xl font-black text-navy-800 mb-2">Siap Menganalisis Bisnis Anda?</h4>
                            <p class="text-gray-400 max-w-sm">Masukkan variabel harga dan biaya di sisi kiri. BizSight akan menghitung profitabilitas batch Anda secara instan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-orange-100 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="text-xl font-extrabold text-navy-800 mb-4 italic">
                <span class="text-gradient-orange">Biz</span>Sight
            </div>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">© 2026 Developed by Muhammad Ziyad • ITENAS Bandung</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hppSelect = document.getElementById('hppSelect');
            const hppInput = document.querySelector('input[name="hpp"]');

            if (!hppSelect || !hppInput) return;

            hppSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                if (!selectedValue) {
                    hppInput.value = '';
                    return;
                }
                hppInput.value = selectedValue;
            });
        });
    </script>
</x-app-layout>