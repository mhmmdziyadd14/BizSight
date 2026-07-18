{{-- File: decisions-show.blade.php --}}
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

        .section-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            color: white;
            border-radius: 50%;
            font-weight: bold;
            font-size: 0.875rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 900;
            color: #0F172A;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #F97316;
        }

        .dark .section-title {
            color: white;
        }

        .result-section {
            page-break-inside: avoid;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 60px;
            font-weight: 800;
            font-size: 14px;
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

        @media print {
            body {
                background: white;
                padding: 0;
            }
            .header-actions {
                display: none !important;
            }
            .py-10 {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }
        }
    </style>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-orange-100/20 dark:from-navy-800 dark:via-navy-900 dark:to-navy-950 min-h-screen transition-colors duration-500">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="header-actions mb-8 flex flex-col md:flex-row md:items-center justify-between border-b pb-6 border-orange-500/10 dark:border-orange-500/30 transition-colors">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="text-gradient-orange">Analysis</span>
                                <span class="text-navy-900 dark:text-white">Results</span>
                            </h1>
                            <p class="mt-1 text-sm text-slate-500 dark:text-gray-400 font-medium">
                                {{ $calc->product_name }} • <span class="local-time" data-utc="{{ $calc->created_at->toIso8601String() }}" data-format="d M Y H:i">{{ $calc->created_at->format('d M Y H:i') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex gap-3">
                    <a href="{{ route('decisions.list') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-navy-900 border border-orange-500/10 dark:border-orange-500/20 text-orange-600 dark:text-orange-400 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-orange-50 dark:hover:bg-navy-800 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('print.pdf', $calc->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-xl text-xs font-black uppercase tracking-wider hover:shadow-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak PDF
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="space-y-6">
                <!-- 1. HERO SECTION -->
                <div class="result-section bg-gradient-orange rounded-3xl p-8 shadow-md border border-orange-500/10 transition-all">
                    <div class="text-white">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="section-number">1</span>
                            <span class="text-xs font-bold uppercase tracking-wider">Hero Section</span>
                        </div>
                        <div class="text-3xl font-black mb-3">
                            ➜ {{ $calc->status_label == 'CRITICAL' ? 'Critical - Optimization Needed' : ($calc->status_label == 'FRAGILE' ? 'Proceed with Caution' : 'Green Light to Scale') }}
                        </div>
                        <p class="text-white/90 text-base leading-relaxed">
                            {{ $calc->logic_reason }}
                        </p>
                    </div>
                </div>

                <!-- 2. PROFIT REALITY -->
                <div class="result-section bg-white dark:bg-navy-900 rounded-3xl p-8 shadow-sm border border-orange-500/10 dark:border-orange-500/20 transition-all">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="section-number">2</span>
                        <h3 class="section-title dark:text-white" style="margin: 0; border: none; padding: 0;">Profit Reality</h3>
                    </div>
                    <div class="mb-6 pb-6 border-b border-gray-200 dark:border-white/5">
                        <div class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Net Margin</div>
                        <div class="flex items-baseline gap-3">
                            @php
                                $margin = $calc->net_margin_percent;
                                $statusColor = $calc->status_label === 'CRITICAL' ? 'text-red-600' : ($calc->status_label === 'FRAGILE' ? 'text-amber-600' : 'text-green-600');
                                $statusBadgeBg = $calc->status_label === 'CRITICAL' ? 'bg-red-100' : ($calc->status_label === 'FRAGILE' ? 'bg-amber-100' : 'bg-green-100');
                            @endphp
                            <div class="text-5xl font-black {{ $statusColor }}">{{ number_format($margin, 1, ',', '.') }}%</div>
                            <div class="inline-block px-4 py-2 rounded-full {{ $statusBadgeBg }} text-sm font-bold {{ $statusColor }}">{{ $calc->status_label }}</div>
                        </div>
                    </div>
                    
                    <div class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-4">Cost Breakdown:</div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm"><span class="text-gray-700 dark:text-gray-400">Revenue</span><span class="font-bold dark:text-white">100%</span></div>
                            <div class="flex justify-between text-sm"><span class="text-gray-700 dark:text-gray-400">HPP</span><span class="font-bold dark:text-white">{{ number_format($hppPct, 1, ',', '.') }}%</span></div>
                            <div class="flex justify-between text-sm"><span class="text-gray-700 dark:text-gray-400">Admin Fee</span><span class="font-bold dark:text-white">{{ number_format($calc->admin_fee_percent ?? 0, 1, ',', '.') }}%</span></div>
                            <div class="flex justify-between text-sm"><span class="text-gray-700 dark:text-gray-400">Ads</span><span class="font-bold dark:text-white">{{ number_format($calc->ads_per_unit ?? 0, 1, ',', '.') }}%</span></div>
                            <div class="flex justify-between text-sm"><span class="text-gray-700 dark:text-gray-400">Affiliate</span><span class="font-bold dark:text-white">{{ number_format($calc->affiliate_percent ?? 0, 1, ',', '.') }}%</span></div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm"><span class="text-gray-700 dark:text-gray-400">Promo</span><span class="font-bold dark:text-white">{{ number_format($calc->promo_percent ?? 0, 1, ',', '.') }}%</span></div>
                            <div class="flex justify-between text-sm"><span class="text-gray-700 dark:text-gray-400">Overhead</span><span class="font-bold dark:text-white">{{ number_format($calc->overhead_percent ?? 0, 1, ',', '.') }}%</span></div>
                            <div class="flex justify-between text-sm"><span class="text-gray-700 dark:text-gray-400">Tax</span><span class="font-bold dark:text-white">{{ number_format($calc->tax_percent ?? 0, 1, ',', '.') }}%</span></div>
                            <div class="border-t border-gray-300 dark:border-white/10 pt-2">
                                <div class="flex justify-between text-sm font-bold dark:text-white"><span>Total Cost</span><span>{{ number_format($totalCostPct, 1, ',', '.') }}%</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-50 dark:bg-orange-950/20 border border-orange-200 dark:border-orange-500/30 rounded-xl p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Net Profit</span>
                            <span class="text-2xl font-black {{ $statusColor }}">{{ number_format($margin, 1, ',', '.') }}%</span>
                        </div>
                    </div>
                </div>

                <!-- 3. COST PRESSURE DETECTOR -->
                <div class="result-section bg-white dark:bg-navy-900 rounded-3xl p-8 shadow-sm border border-orange-500/10 dark:border-orange-500/20 transition-all">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="section-number">3</span>
                        <h3 class="section-title dark:text-white" style="margin: 0; border: none; padding: 0;">Cost Pressure Detector</h3>
                    </div>
                    <div class="mb-6">
                        <div class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-4">Biggest Cost Drivers:</div>
                        <div class="space-y-3">
                            @foreach($topCosts as $idx => $cost)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-navy-950 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 flex items-center justify-center bg-orange-100 dark:bg-orange-950 text-orange-700 dark:text-orange-400 font-bold rounded-full text-sm">{{ $idx + 1 }}</span>
                                        <span class="text-gray-700 dark:text-gray-300 font-semibold capitalize">{{ $cost[0] }}</span>
                                    </div>
                                    <span class="font-bold text-lg dark:text-white">{{ number_format($cost[1], 1, ',', '.') }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-900/30 rounded-xl p-4">
                        <div class="text-xs font-bold text-blue-900 dark:text-blue-400 uppercase tracking-wider mb-2">Insight:</div>
                        <p class="text-sm text-blue-900 dark:text-blue-200">{{ $insight }}</p>
                    </div>
                </div>

                <!-- 4. RISK ANALYSIS -->
                <div class="result-section bg-white dark:bg-navy-900 rounded-3xl p-8 shadow-sm border border-orange-500/10 dark:border-orange-500/20 transition-all">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="section-number">4</span>
                        <h3 class="section-title dark:text-white" style="margin: 0; border: none; padding: 0;">Risk Analysis</h3>
                    </div>
                    <div class="space-y-2">
                        @if(count($risks) > 0)
                            @foreach($risks as $risk)
                                <div class="flex items-start gap-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-900/30">
                                    <span class="text-red-600 dark:text-red-400 font-bold text-lg mt-0.5">•</span>
                                    <span class="text-red-900 dark:text-red-200 text-sm">{{ $risk }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-700 dark:text-gray-400">No significant risks identified.</p>
                        @endif
                    </div>
                </div>

                <!-- 5. STRATEGY DIRECTION -->
                <div class="result-section bg-white dark:bg-navy-900 rounded-3xl p-8 shadow-sm border border-orange-500/10 dark:border-orange-500/20 transition-all">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="section-number">5</span>
                        <h3 class="section-title dark:text-white" style="margin: 0; border: none; padding: 0;">Strategy Direction</h3>
                    </div>
                    <div class="bg-orange-50 dark:bg-orange-950/20 border border-orange-200 dark:border-orange-500/30 rounded-xl p-6">
                        <div class="text-sm font-bold text-orange-700 dark:text-orange-400 uppercase tracking-wider mb-2">Operating Mode</div>
                        <div class="text-3xl font-black text-orange-600 dark:text-orange-500 mb-4">{{ $strategy }}</div>
                        <p class="text-gray-700 dark:text-gray-300 font-semibold">Focus: {{ $focus }}</p>
                    </div>
                </div>

                <!-- 6. PRODUCTION DECISION -->
                <div class="result-section bg-white dark:bg-navy-900 rounded-3xl p-8 shadow-sm border border-orange-500/10 dark:border-orange-500/20 transition-all">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="section-number">6</span>
                        <h3 class="section-title dark:text-white" style="margin: 0; border: none; padding: 0;">Production Decision</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/10 rounded-xl p-4">
                            <div class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">Production Model</div>
                            <div class="text-lg font-bold text-navy-800 dark:text-white">Batch Limited</div>
                        </div>
                        <div class="bg-orange-50 dark:bg-orange-950/20 border border-orange-200 dark:border-orange-500/30 rounded-xl p-4">
                            <div class="text-xs font-bold text-orange-700 dark:text-orange-400 uppercase tracking-wider mb-2">Recommended Batch</div>
                            <div class="text-2xl font-black text-orange-600 dark:text-orange-500">{{ $calc->est_batch_quantity }} <span class="text-sm">pcs</span></div>
                        </div>
                    </div>
                </div>

                <!-- 7. ADS INSIGHT -->
                <div class="result-section bg-white dark:bg-navy-900 rounded-3xl p-8 shadow-sm border border-orange-500/10 dark:border-orange-500/20 transition-all">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="section-number">7</span>
                        <h3 class="section-title dark:text-white" style="margin: 0; border: none; padding: 0;">Ads Insight</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-navy-950 rounded-xl">
                            <span class="text-gray-700 dark:text-gray-300 font-semibold">Ads Cost</span>
                            <span class="text-2xl font-black text-orange-600 dark:text-orange-500">{{ number_format($calc->ads_per_unit ?? 0, 1, ',', '.') }}%</span>
                        </div>
                        @php
                            $adsStatusBg = $adsStatus === 'DANGEROUS' ? 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-900/30' : ($adsStatus === 'PRESSURING' ? 'bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-900/30' : 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-900/30');
                            $adsStatusText = $adsStatus === 'DANGEROUS' ? 'text-red-700 dark:text-red-400' : ($adsStatus === 'PRESSURING' ? 'text-amber-700 dark:text-amber-400' : 'text-green-700 dark:text-green-400');
                            $adsMessageText = $adsStatus === 'DANGEROUS' ? 'text-red-900 dark:text-red-200' : ($adsStatus === 'PRESSURING' ? 'text-amber-900 dark:text-amber-200' : 'text-green-900 dark:text-green-200');
                        @endphp
                        <div class="p-4 rounded-xl border {{ $adsStatusBg }}">
                            <div class="text-xs font-bold uppercase tracking-wider mb-2 {{ $adsStatusText }}">Status: {{ $adsStatus }}</div>
                            <p class="text-sm {{ $adsMessageText }}">{{ $adsMessage }}</p>
                        </div>
                    </div>
                </div>

                <!-- 8. ACTION PLAN -->
                <div class="result-section bg-white dark:bg-navy-900 rounded-3xl p-8 shadow-sm border border-orange-500/10 dark:border-orange-500/20 transition-all">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="section-number">8</span>
                        <h3 class="section-title dark:text-white" style="margin: 0; border: none; padding: 0;">Action Plan</h3>
                    </div>
                    <div class="space-y-2">
                        @foreach($actionPlan as $action)
                            <div class="flex items-start gap-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-900/30">
                                <span class="text-green-600 dark:text-green-400 font-bold">✓</span>
                                <span class="text-green-900 dark:text-green-200 text-sm">{{ $action }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 9. DECISION CONFIDENCE -->
                <div class="result-section bg-white dark:bg-navy-900 rounded-3xl p-8 shadow-sm border border-orange-500/10 dark:border-orange-500/20 transition-all">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="section-number">9</span>
                        <h3 class="section-title dark:text-white" style="margin: 0; border: none; padding: 0;">Decision Confidence</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="text-5xl font-black text-orange-600 dark:text-orange-400">{{ $calc->confidence }}%</div>
                        <div class="w-full bg-slate-100 dark:bg-navy-950 rounded-full h-4 overflow-hidden border border-orange-500/10 transition-all">
                            <div class="bg-gradient-orange h-4 rounded-full" style="width: {{ $calc->confidence }}%"></div>
                        </div>
                        <p class="text-sm text-gray-700 dark:text-gray-400">Confidence level untuk keputusan ini berdasarkan data yang tersedia dan kondisi pasar saat ini.</p>
                    </div>
                </div>

                <!-- 10. FINAL SNAPSHOT -->
                <div class="result-section bg-gradient-navy rounded-3xl p-8 shadow-md text-white">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-orange-500 rounded-full text-xs font-bold">10</span>
                        <h3 class="text-2xl font-black">Final Snapshot</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                            <div class="text-xs font-bold text-orange-300 uppercase tracking-wider mb-2">Status</div>
                            <div class="text-xl font-bold text-white">{{ $calc->status_label }}</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                            <div class="text-xs font-bold text-orange-300 uppercase tracking-wider mb-2">Mode</div>
                            <div class="text-xl font-bold text-white">{{ $strategy }}</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                            <div class="text-xs font-bold text-orange-300 uppercase tracking-wider mb-2">Production</div>
                            <div class="text-xl font-bold text-white">Batch Limited</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                            <div class="text-xs font-bold text-orange-300 uppercase tracking-wider mb-2">Net Margin</div>
                            <div class="text-2xl font-bold text-orange-300">{{ number_format($margin, 1, ',', '.') }}%</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4 col-span-2">
                            <div class="text-xs font-bold text-orange-300 uppercase tracking-wider mb-2">Risk Level</div>
                            <div class="text-xl font-bold text-white">{{ $calc->status_label === 'CRITICAL' ? 'Extreme' : ($calc->status_label === 'FRAGILE' ? 'Medium - High' : 'Controlled') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="result-section flex gap-4 sticky bottom-0 bg-white dark:bg-navy-900 rounded-3xl p-6 shadow-lg border border-orange-500/10 transition-all flex-wrap">
                    <a href="{{ route('decisions.list') }}" class="flex-1 flex items-center justify-center gap-2 bg-white dark:bg-navy-900 text-orange-600 dark:text-orange-400 border border-orange-500/10 dark:border-orange-500/20 py-3 rounded-xl text-sm font-bold uppercase tracking-wider hover:bg-orange-50 dark:hover:bg-navy-800 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('print.pdf', $calc->id) }}" class="flex-1 flex items-center justify-center gap-2 bg-gradient-orange text-white py-3 rounded-xl text-sm font-bold uppercase tracking-wider hover:shadow-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak PDF
                    </a>
                    <form action="{{ route('business.destroy', $calc->id) }}" method="POST" class="flex-1 flex" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hasil analisis ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/30 py-3 rounded-xl text-sm font-bold uppercase tracking-wider hover:bg-red-100 dark:hover:bg-red-900/40 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>