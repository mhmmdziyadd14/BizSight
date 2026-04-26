{{-- File: admin/product.blade.php --}}
<x-app-layout>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-gradient-orange { background: linear-gradient(135deg, #F97316 0%, #EA580C 100%); }
        .text-gradient-orange { background: linear-gradient(135deg, #F97316 0%, #F59E0B 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .bg-gradient-navy { background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); }
        
        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 40px; font-size: 10px; font-weight: 800; letter-spacing: 0.05em; text-transform: uppercase; }
        .status-healthy { background: #10B98110; color: #10B981; border: 1px solid #10B98130; }
        .status-risky { background: #F59E0B10; color: #F59E0B; border: 1px solid #F9731630; }
        .status-danger { background: #EF444410; color: #EF4444; border: 1px solid #EF444430; }
        
        .dark .status-healthy { background: rgba(16, 185, 129, 0.1); color: #34d399; border-color: rgba(16, 185, 129, 0.2); }
        .dark .status-risky { background: rgba(245, 158, 11, 0.1); color: #fbbf24; border-color: rgba(245, 158, 11, 0.2); }
        .dark .status-danger { background: rgba(239, 68, 68, 0.1); color: #f87171; border-color: rgba(239, 68, 68, 0.2); }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    </style>

    <div class="py-10 bg-gray-50 dark:bg-navy-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between border-b pb-6 border-gray-200 dark:border-white/5 fade-in-up">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-navy dark:bg-orange-500 rounded-2xl flex items-center justify-center shadow-lg transition-colors">
                        <svg class="w-7 h-7 text-orange-500 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-navy dark:text-white transition-colors">Product <span class="text-orange-500">Monitoring</span></h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Analisis real-time kelayakan produk di seluruh ekosistem.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10 fade-in-up">
                <div class="bg-white dark:bg-navy-900 p-6 rounded-[24px] border border-gray-100 dark:border-white/5 shadow-sm transition-colors">
                    <p class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-1">Total Analysis</p>
                    <p class="text-3xl font-black text-navy dark:text-white">{{ $allCalculations->count() }}</p>
                </div>
                <div class="bg-white dark:bg-navy-900 p-6 rounded-[24px] border border-gray-100 dark:border-white/5 shadow-sm transition-colors">
                    <p class="text-[10px] font-black text-green-500 uppercase tracking-widest mb-1">Healthy Products</p>
                    <p class="text-3xl font-black text-navy dark:text-white">{{ $allCalculations->where('status_label', 'Healthy')->count() }}</p>
                </div>
                <div class="bg-white dark:bg-navy-900 p-6 rounded-[24px] border border-gray-100 dark:border-white/5 shadow-sm transition-colors">
                    <p class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-1">Fragile/Risky</p>
                    <p class="text-3xl font-black text-navy dark:text-white">{{ $allCalculations->where('status_label', 'Fragile')->count() }}</p>
                </div>
                <div class="bg-white dark:bg-navy-900 p-6 rounded-[24px] border border-gray-100 dark:border-white/5 shadow-sm transition-colors">
                    <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1">Critical Status</p>
                    <p class="text-3xl font-black text-navy dark:text-white">{{ $allCalculations->where('status_label', 'Critical')->count() }}</p>
                </div>
            </div>

            <!-- Monitoring Table -->
            <div class="bg-white dark:bg-navy-900 rounded-[32px] shadow-xl border border-gray-100 dark:border-white/5 overflow-hidden fade-in-up transition-colors">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 dark:bg-navy-950/50 transition-colors">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Product Instance</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Ownership</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Financial Summary</th>
                                <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">System Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-white/5 bg-white dark:bg-navy-900 transition-colors">
                            @foreach($allCalculations as $calc)
                            <tr class="hover:bg-orange-50/30 dark:hover:bg-white/5 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="font-black text-navy dark:text-white text-base">{{ $calc->product_name }}</div>
                                    <div class="text-[9px] font-bold text-orange-500 uppercase mt-1 tracking-widest">#BZS-{{ $calc->id }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-bold text-navy dark:text-gray-300">{{ $calc->user->name }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ $calc->user->email }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-6">
                                        <div>
                                            <div class="text-[9px] font-black text-gray-400 uppercase mb-1 tracking-widest">Net Margin</div>
                                            <div class="text-base font-black text-navy dark:text-white">{{ number_format($calc->net_margin_percent, 1) }}%</div>
                                        </div>
                                        <div>
                                            <div class="text-[9px] font-black text-gray-400 uppercase mb-1 tracking-widest">Target Price</div>
                                            <div class="text-base font-black text-orange-500">Rp{{ number_format($calc->target_selling_price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    @php
                                        $label = strtoupper($calc->status_label);
                                        $colorClass = ($label === 'HEALTHY') ? 'status-healthy' : (($label === 'FRAGILE') ? 'status-risky' : 'status-danger');
                                        $dotClass = ($label === 'HEALTHY') ? 'bg-green-500' : (($label === 'FRAGILE') ? 'bg-orange-500' : 'bg-red-500');
                                    @endphp
                                    <span class="status-badge {{ $colorClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                        {{ $label }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>