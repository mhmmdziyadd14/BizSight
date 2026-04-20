{{-- File: decisions-show.blade.php --}}
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

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-navy-50/30 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="header-actions mb-8 flex flex-col md:flex-row md:items-center justify-between border-b pb-6 border-orange-200/50">
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
                                <span class="text-navy-900">Results</span>
                            </h1>
                            <p class="mt-1 text-sm text-navy-600 font-medium">
                                {{ $calc->product_name }} • {{ $calc->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex gap-3">
                    <a href="{{ route('decisions.list') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-orange-200 text-orange-600 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-orange-50 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </a>
                    <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-xl text-xs font-black uppercase tracking-wider hover:shadow-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak PDF
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="space-y-6">
                <!-- 1. HERO SECTION -->
                <div class="result-section bg-gradient-orange rounded-3xl p-8 shadow-md border border-orange-200">
                    <div class="text-white">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="section-number">1</span>
                            <span class="text-xs font-bold uppercase tracking-wider">Hero Section</span>
                        </div>
                        <div class="text-3xl font-black mb-3">
                            @if($calc->status == 'CRITICAL')
                                STOP OR DO NOT PROCEED
                            @elseif($calc->status == 'FRAGILE')
                                SWITCH TO PRE ORDER
                            @else
                                SAFE TO SCALE
                            @endif
                        </div>
                        <p class="text-white/90 text-base leading-relaxed">
                            @if($calc->status == 'CRITICAL')
                                Your cost structure is killing your profit.
                            @elseif($calc->status == 'FRAGILE')
                                Margin not strong enough for stock-based selling.
                            @else
                                Your margins can support growth.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- 2. PROFIT REALITY -->
                <div class="result-section bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="section-number">2</span>
                        <h3 class="section-title" style="margin: 0; border: none; padding: 0;">Profit Reality</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-xl p-4 border border-orange-100">
                            <p class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wider">HPP</p>
                            <p class="text-2xl font-black text-navy-800">Rp{{ number_format($calc->hpp, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white rounded-xl p-4 border border-orange-100">
                            <p class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wider">Selling Price</p>
                            <p class="text-2xl font-black text-navy-800">Rp{{ number_format($calc->selling_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white rounded-xl p-4 border border-orange-100">
                            <p class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wider">Gross Profit</p>
                            <p class="text-2xl font-black text-green-600">Rp{{ number_format($calc->selling_price - $calc->hpp, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-200">
                            <p class="text-xs font-semibold text-orange-700 mb-2 uppercase tracking-wider">Net Margin</p>
                            @php
                                $margin = ($calc->selling_price - $calc->hpp) / $calc->selling_price * 100;
                            @endphp
                            <p class="text-2xl font-black" style="color: {{ $margin > 25 ? '#059669' : ($margin > 10 ? '#F59E0B' : '#DC2626') }}">
                                {{ number_format($margin, 1, ',', '.') }}%
                            </p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <p class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Status</p>
                        @php
                            $statusClass = '';
                            $statusText = '';
                            if($calc->status == 'HEALTHY') {
                                $statusClass = 'status-healthy';
                                $statusText = 'HEALTHY';
                            } elseif($calc->status == 'FRAGILE') {
                                $statusClass = 'status-fragile';
                                $statusText = 'FRAGILE';
                            } else {
                                $statusClass = 'status-critical';
                                $statusText = 'CRITICAL';
                            }
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                    </div>
                </div>

                <!-- 3. COST BREAKDOWN -->
                <div class="result-section bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="section-number">3</span>
                        <h3 class="section-title" style="margin: 0; border: none; padding: 0;">Cost Breakdown</h3>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-600 mb-1 uppercase">HPP</p>
                            <p class="text-lg font-black text-navy-800">{{ ($calc->hpp / $calc->selling_price * 100) }}%</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-600 mb-1 uppercase">Admin Fee</p>
                            <p class="text-lg font-black text-navy-800">{{ ($calc->admin_fee_percent ?? 0) }}%</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-600 mb-1 uppercase">Ads</p>
                            <p class="text-lg font-black text-navy-800">{{ ($calc->ads_percent ?? 0) }}%</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-600 mb-1 uppercase">Affiliate</p>
                            <p class="text-lg font-black text-navy-800">{{ ($calc->affiliate_percent ?? 0) }}%</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-600 mb-1 uppercase">Promo</p>
                            <p class="text-lg font-black text-navy-800">{{ ($calc->promo_percent ?? 0) }}%</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-600 mb-1 uppercase">Overhead</p>
                            <p class="text-lg font-black text-navy-800">{{ ($calc->overhead_percent ?? 0) }}%</p>
                        </div>
                    </div>
                </div>

                <!-- 4. CONFIDENCE -->
                <div class="result-section bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="section-number">4</span>
                        <h3 class="section-title" style="margin: 0; border: none; padding: 0;">Decision Confidence</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="text-5xl font-black text-orange-600">{{ $calc->confidence ?? 75 }}%</div>
                        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden border border-gray-300">
                            <div class="bg-gradient-orange h-4 rounded-full" style="width: {{ $calc->confidence ?? 75 }}%"></div>
                        </div>
                        <p class="text-sm text-gray-700">Confidence level untuk keputusan ini berdasarkan data yang tersedia dan kondisi pasar saat ini.</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="result-section flex gap-4 sticky bottom-0 bg-white rounded-3xl p-6 shadow-lg border border-orange-100">
                    <a href="{{ route('decisions.list') }}" class="flex-1 flex items-center justify-center gap-2 bg-white text-orange-600 border border-orange-200 py-3 rounded-xl text-sm font-bold uppercase tracking-wider hover:bg-orange-50 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Daftar
                    </a>
                    <button onclick="window.print()" class="flex-1 flex items-center justify-center gap-2 bg-gradient-orange text-white py-3 rounded-xl text-sm font-bold uppercase tracking-wider hover:shadow-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>