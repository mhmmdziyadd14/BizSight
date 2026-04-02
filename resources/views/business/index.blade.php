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

        .health-fragile {
            background: linear-gradient(135deg, #F59E0B10 0%, #F9731620 100%);
            color: #F59E0B;
            border: 1px solid #F9731630;
        }

        .health-critical {
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

            0%,
            100% {
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

        @media print {
            body {
                background: white;
            }
            .lg\:col-span-4, .sticky {
                display: none !important;
            }
            .lg\:col-span-8 {
                grid-column: span 12 !important;
                max-width: 100% !important;
            }
            .max-w-7xl {
                max-width: 100% !important;
            }
            .py-10 {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }
            .result-card {
                page-break-inside: avoid;
            }
            .result-card > * {
                page-break-inside: avoid;
            }
            .text-gradient-orange {
                color: #F97316 !important;
                -webkit-background-clip: auto !important;
                background-clip: auto !important;
            }
            .bg-gradient-orange, .bg-gradient-navy {
                background: white !important;
                border: 1px solid #333 !important;
                color: #000 !important;
            }
            footer {
                display: none !important;
            }
            .header-section {
                display: none !important;
            }
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 900;
            color: #0F172A;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #F97316;
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
            margin-right: 0.5rem;
        }

        .result-section {
            page-break-inside: avoid;
        }
    </style>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-navy-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div
                class="mb-10 flex flex-col md:flex-row md:items-end justify-between border-b pb-6 border-orange-200/50 fade-in-up">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class=\"text-gradient-orange\">Clarity</span>
                                <span class="text-navy-900">Decision</span>
                            </h1>
                            <p class="mt-2 text-sm text-navy-600 max-w-2xl">
                                Ubah data mentah menjadi keputusan bisnis yang matang. Masukkan angka penting Anda dan
                                biarkan mesin ClarityLabs menganalisis kelayakannya.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <span
                        class="inline-flex items-center gap-2 bg-white border border-orange-200 px-5 py-2.5 rounded-full text-xs font-black text-orange-600 uppercase tracking-widest shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
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
                        <form action="{{ route('calculate') }}" method="POST" class="space-y-0" id="decisionEngineForm">
                            @csrf

                            <!-- SECTION A: Business/Product Condition -->
                            <div class="bg-gradient-navy px-6 py-5 flex items-center justify-between border-b border-orange-500/30">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                                        <span class="text-white text-xs font-black">A</span>
                                    </div>
                                    <h3 class="font-bold text-white tracking-wide">Product Condition</h3>
                                </div>
                                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                    </path>
                                </svg>
                            </div>

                            <div class="p-6 border-b border-orange-100">
                                <div class="flex gap-3 mb-1">
                                    <button type="button" class="product-toggle active flex-1 py-2.5 px-4 rounded-lg font-bold text-xs uppercase tracking-wider text-white bg-gradient-orange transition-all" data-type="existing">
                                        ✓ Existing
                                    </button>
                                    <button type="button" class="product-toggle flex-1 py-2.5 px-4 rounded-lg font-bold text-xs uppercase tracking-wider text-orange-600 bg-orange-100 hover:bg-orange-200 transition-all" data-type="new">
                                        + New Product
                                    </button>
                                </div>
                                <input type="hidden" name="product_type" id="productType" value="existing">
                            </div>

                            <!-- SECTION B: Business Variables -->
                            <div class="p-6 border-b border-orange-100 space-y-5">
                                <div class="flex items-center gap-2 pb-3 border-b border-orange-100">
                                    <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <span class="text-orange-500 text-xs font-black">B</span>
                                    </div>
                                    <h4 class="font-bold text-sm text-navy-800">Business Variables</h4>
                                </div>

                                <!-- Product Name (Always Visible) -->
                                <div>
                                    <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Product
                                        Name</label>
                                    <input type="text" name="product_name"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                        placeholder="Contoh: Kemeja Premium V2" required>
                                </div>

                                <!-- HPP Selection (For Existing Products) -->
                                <div id="existing-product-select" class="section-toggle">
                                    <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Pilih
                                        HPP yang sudah dibuat</label>
                                    <select name="hpp_id" id="hppSelect"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                                        <option value="">HPP Manual</option>
                                        @foreach($hppOptions as $option)
                                            <option value="{{ $option->total_hpp_per_unit }}"
                                                data-hpp="{{ $option->total_hpp_per_unit }}">{{ $option->hpp_id }} •
                                                {{ $option->name }} •
                                                Rp{{ number_format($option->total_hpp_per_unit, 0, ',', '.') }}</option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-[10px] text-gray-400">Pilih HPP untuk mengisi nilai ke formulir secara otomatis.</p>
                                </div>

                                <!-- HPP & Selling Price -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="relative">
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">HPP (Rp)</label>
                                        <span class="absolute inset-y-7 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                        <input type="number" name="hpp" required
                                            class="w-full pl-9 border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                            value="85000" placeholder="HPP">
                                    </div>
                                    <div class="relative">
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Selling (Rp)</label>
                                        <span class="absolute inset-y-7 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                        <input type="number" name="selling_price" required
                                            class="w-full pl-9 border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                            value="175000" placeholder="Jual">
                                    </div>
                                </div>

                                <!-- Fees -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Admin Fee
                                            (%)</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="admin_fee_percent"
                                                class="w-full border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                                value="0" placeholder="0">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Overhead
                                            (%)</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="overhead_percent"
                                                class="w-full border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                                value="0" placeholder="0">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Pajak
                                            (%)</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="tax_percent"
                                                class="w-full border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                                value="0" placeholder="0">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Promo
                                            (%)</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="promo_percent"
                                                class="w-full border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                                value="0" placeholder="0">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-[10px] text-gray-400">Margin dibandingkan antara normal vs promo.</p>

                                <!-- Ads & Affiliate -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Ads
                                            (%)</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="ads_percent"
                                                class="w-full border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                                value="0" placeholder="0">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Affiliate
                                            (%)</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="affiliate_percent"
                                                class="w-full border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                                value="0" placeholder="0">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Batch Quantity -->
                                <div>
                                    <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Batch
                                        Quantity</label>
                                    <div class="relative">
                                        <input type="number" name="est_batch_quantity" required
                                            class="w-full pr-10 border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                            value="100">
                                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-[9px] font-bold">PCS</span>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION C: Performance (New Products Only) -->
                            <div id="section-c" class="section-toggle hidden p-6 border-b border-orange-100 space-y-4">
                                <div class="flex items-center gap-2 pb-3 border-b border-orange-100">
                                    <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <span class="text-orange-500 text-xs font-black">C</span>
                                    </div>
                                    <h4 class="font-bold text-sm text-navy-800">Performance</h4>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Monthly Revenue (Rp)</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-7 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                            <input type="number" name="monthly_revenue" step="10000" min="0"
                                                class="w-full pl-9 border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                                value="0" placeholder="0">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Monthly Order</label>
                                        <input type="number" name="monthly_order" step="1" min="0"
                                            class="w-full border border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring"
                                            value="0" placeholder="0">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Demand Trend</label>
                                    <select name="demand_trend"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                                        <option value="increasing">Increasing</option>
                                        <option value="stable" selected>Stable</option>
                                        <option value="decreasing">Decreasing</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Sales Consistency</label>
                                    <select name="sales_consistency"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                                        <option value="high" selected>High</option>
                                        <option value="medium">Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>
                            </div>

                            <!-- SECTION D: Business Condition (New Products Only) -->
                            <div id="section-d" class="section-toggle hidden p-6 border-b border-orange-100 space-y-4">
                                <div class="flex items-center gap-2 pb-3 border-b border-orange-100">
                                    <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <span class="text-orange-500 text-xs font-black">D</span>
                                    </div>
                                    <h4 class="font-bold text-sm text-navy-800">Business Condition</h4>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Inventory</label>
                                    <select name="inventory_condition"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                                        <option value="low">Low</option>
                                        <option value="normal" selected>Normal</option>
                                        <option value="overstock">Overstock</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Cashflow</label>
                                    <select name="cashflow_condition"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                                        <option value="healthy" selected>Healthy</option>
                                        <option value="tight">Tight</option>
                                        <option value="critical">Critical</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Marketing Dependency</label>
                                    <select name="marketing_dependency"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                                        <option value="mostly_organic">Mostly Organic</option>
                                        <option value="balanced" selected>Balanced</option>
                                        <option value="mostly_ads">Mostly Ads</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Product Lifecycle</label>
                                    <select name="product_lifecycle"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                                        <option value="new">New</option>
                                        <option value="growing" selected>Growing</option>
                                        <option value="mature">Mature</option>
                                        <option value="declining">Declining</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="p-6">
                                <button type="submit"
                                    class="btn-analyze w-full flex items-center justify-center gap-2 text-white py-4 rounded-2xl font-extrabold text-sm uppercase tracking-widest shadow-xl active:scale-95 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
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
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-navy-800">Decision Engine</h3>
                                    <p class="text-xs text-navy-500">Gunakan panel di samping untuk menganalisis
                                        kelayakan bisnis.</p>
                                </div>
                            </div>
                            <a href="{{ route('hpp.index') }}"
                                class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-widest text-orange-500 hover:text-orange-600 transition-colors">
                                Lihat Daftar HPP
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Decision Engine Results Container -->
                    <div id="resultsContainer" class="h-full flex flex-col items-center justify-center bg-white rounded-3xl border-2 border-dashed border-orange-200 p-12 text-center empty-state">
                        <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-orange-400 animate-spin" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h4 class="text-2xl font-black text-navy-800 mb-2">Siap Menganalisis Bisnis Anda?</h4>
                        <p class="text-gray-400 max-w-sm">Masukkan variabel harga dan biaya di sisi kiri. ClarityLabs akan
                            menghitung profitabilitas batch Anda secara instan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-orange-100 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="text-xl font-extrabold text-navy-800 mb-4 italic">
                <span class="text-gradient-orange\">Clarity</span>Labs
            </div>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">© 2026 Developed by Muhammad Ziyad
                • ITENAS Bandung</p>
        </div>
    </footer>

    <script>
        // ============= DECISION ENGINE CALCULATION (PDF 1) =============
        
        // 1. GET TOTAL COST
        function getTotalCost(cost) {
            return (
                cost.hpp +
                cost.admin +
                cost.ads +
                cost.affiliate +
                cost.promo +
                cost.overhead +
                cost.tax
            );
        }

        // 2. GET NET MARGIN
        function getNetMargin(totalCost) {
            return (1 - totalCost);
        }

        // 3. GET STATUS
        function getStatus(netMargin) {
            if (netMargin < 0.1) return "CRITICAL";
            if (netMargin < 0.25) return "FRAGILE";
            return "HEALTHY";
        }

        // 4. HERO DECISION
        function getHeroDecision(status) {
            switch (status) {
                case "CRITICAL":
                    return {
                        title: "STOP OR DO NOT PROCEED",
                        subtext: "Your cost structure is killing your profit."
                    };
                case "FRAGILE":
                    return {
                        title: "SWITCH TO PRE ORDER",
                        subtext: "Margin not strong enough for stock-based selling."
                    };
                case "HEALTHY":
                    return {
                        title: "SAFE TO SCALE",
                        subtext: "Your margins can support growth."
                    };
            }
        }

        // 5. STRATEGY MODE
        function getStrategy(status, business) {
            if (status === "CRITICAL") return "SURVIVAL";
            if (status === "FRAGILE") {
                if (business.cashflow === "tight") return "EFFICIENCY";
                return "CONTROLLED";
            }
            if (status === "HEALTHY") {
                if (business.demand === "high") return "GROWTH";
                return "BALANCED";
            }
        }

        // 6. PRODUCTION DECISION
        function getProductionDecision(status, business) {
            if (status === "CRITICAL") {
                return {
                    model: "NO PRODUCTION",
                    batch: 0
                };
            }
            if (status === "FRAGILE") {
                return {
                    model: "PRE ORDER / HYBRID",
                    batch: 60
                };
            }
            if (status === "HEALTHY") {
                if (business.demand === "high") {
                    return {
                        model: "READY STOCK",
                        batch: 180
                    };
                }
                return {
                    model: "HYBRID",
                    batch: 120
                };
            }
        }

        // 7. ADS INSIGHT
        function getAdsInsight(cost, netMargin) {
            if (cost.ads > 0.2 && netMargin < 0.25) {
                return {
                    status: "DANGEROUS",
                    message: "Ads is killing your margin"
                };
            }
            if (cost.ads > 0.15) {
                return {
                    status: "PRESSURING",
                    message: "Ads starting to pressure profit"
                };
            }
            return {
                status: "HEALTHY",
                message: "Ads still within safe range"
            };
        }

        // 8. TOP COSTS
        function getTopCosts(cost) {
            const entries = Object.entries(cost);
            return entries
                .sort((a, b) => b[1] - a[1])
                .slice(0, 3);
        }

        // 9. RISK ANALYSIS
        function getRisk(status, cost, business) {
            let risks = [];
            if (status === "CRITICAL") {
                risks.push("Product is not profitable");
                risks.push("Cashflow drain risk");
            }
            if (cost.ads > 0.15) {
                risks.push("High dependency on ads");
            }
            if (business.stock === "overstock") {
                risks.push("Inventory risk");
            }
            if (cost.promo > 0.1) {
                risks.push("High promo dependency");
            }
            return risks;
        }

        // 10. ACTION PLAN
        function getActionPlan(status) {
            if (status === "CRITICAL") {
                return [
                    "Stop ads",
                    "Recalculate pricing",
                    "Reduce cost structure"
                ];
            }
            if (status === "FRAGILE") {
                return [
                    "Optimize ads",
                    "Use PO system",
                    "Avoid large production"
                ];
            }
            return [
                "Scale ads gradually",
                "Increase production",
                "Expand channels"
            ];
        }

        // 11. CONFIDENCE SCORE
        function getConfidence(netMargin, business, cost) {
            let score = 50;
            if (netMargin > 0.25) score += 15;
            if (business.demand === "high") score += 10;
            if (cost.ads > 0.2) score -= 10;
            if (business.cashflow === "tight") score -= 5;
            return Math.max(50, Math.min(95, score));
        }

        // 12. FINAL ENGINE
        function runDecisionEngine(data) {
            const totalCost = getTotalCost(data.cost);
            const netMargin = getNetMargin(totalCost);
            const status = getStatus(netMargin);

            return {
                hero: getHeroDecision(status),
                netMargin,
                totalCost,
                status,
                strategy: getStrategy(status, data.business),
                production: getProductionDecision(status, data.business),
                ads: getAdsInsight(data.cost, netMargin),
                topCosts: getTopCosts(data.cost),
                risks: getRisk(status, data.cost, data.business),
                actions: getActionPlan(status),
                confidence: getConfidence(netMargin, data.business, data.cost),
                cost: data.cost,
                costBreakdown: {
                    hpp: (data.cost.hpp * 100).toFixed(1),
                    admin: (data.cost.admin * 100).toFixed(1),
                    ads: (data.cost.ads * 100).toFixed(1),
                    affiliate: (data.cost.affiliate * 100).toFixed(1),
                    promo: (data.cost.promo * 100).toFixed(1),
                    overhead: (data.cost.overhead * 100).toFixed(1),
                    tax: (data.cost.tax * 100).toFixed(1),
                    total: (totalCost * 100).toFixed(1),
                    netProfit: (netMargin * 100).toFixed(1)
                }
            };
        }

        // Real-time calculation
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('decisionEngineForm');
            const sellPriceInput = document.querySelector('input[name="selling_price"]');
            const hppInput = document.querySelector('input[name="hpp"]');
            const adminFeeInput = document.querySelector('input[name="admin_fee_percent"]');
            const overheadInput = document.querySelector('input[name="overhead_percent"]');
            const taxInput = document.querySelector('input[name="tax_percent"]');
            const promoInput = document.querySelector('input[name="promo_percent"]');
            const adsInput = document.querySelector('input[name="ads_percent"]');
            const affiliateInput = document.querySelector('input[name="affiliate_percent"]');

            const updateResults = () => {
                const sellPrice = parseFloat(sellPriceInput.value) || 0;
                const hpp = parseFloat(hppInput.value) || 0;
                const adminFee = (parseFloat(adminFeeInput.value) || 0) / 100;
                const overhead = (parseFloat(overheadInput.value) || 0) / 100;
                const tax = (parseFloat(taxInput.value) || 0) / 100;
                const promo = (parseFloat(promoInput.value) || 0) / 100;
                const ads = (parseFloat(adsInput.value) || 0) / 100;
                const affiliate = (parseFloat(affiliateInput.value) || 0) / 100;

                if (sellPrice <= 0) return;

                const data = {
                    selling_price: sellPrice,
                    cost: {
                        hpp: hpp / sellPrice,
                        admin: adminFee,
                        ads: ads,
                        affiliate: affiliate,
                        promo: promo,
                        overhead: overhead,
                        tax: tax
                    },
                    business: {
                        demand: "medium",
                        cashflow: "healthy",
                        stock: "normal"
                    }
                };

                const result = runDecisionEngine(data);
                displayResults(result);
            };

            // Form submission handler - only calculate on button click
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                updateResults();
            });

            // Toggle functionality
            const productToggles = document.querySelectorAll('.product-toggle');
            const productTypeInput = document.getElementById('productType');
            const sectionC = document.getElementById('section-c');
            const sectionD = document.getElementById('section-d');
            const existingProductSelect = document.getElementById('existing-product-select');

            // Initialize visibility based on default product type
            const initializeVisibility = (type) => {
                if (type === 'existing') {
                    sectionC?.classList.add('hidden');
                    sectionD?.classList.add('hidden');
                    existingProductSelect?.classList.remove('hidden');
                } else {
                    sectionC?.classList.remove('hidden');
                    sectionD?.classList.remove('hidden');
                    existingProductSelect?.classList.add('hidden');
                }
            };

            initializeVisibility(productTypeInput.value);

            productToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const type = this.dataset.type;

                    productToggles.forEach(t => {
                        t.classList.remove('active', 'bg-gradient-orange', 'text-white');
                        t.classList.add('bg-orange-100', 'text-orange-600');
                    });
                    
                    this.classList.add('active', 'bg-gradient-orange', 'text-white');
                    this.classList.remove('bg-orange-100', 'text-orange-600');

                    productTypeInput.value = type;

                    // Always show/hide sections based on product type
                    if (type === 'existing') {
                        sectionC?.classList.add('hidden');
                        sectionD?.classList.add('hidden');
                        existingProductSelect?.classList.remove('hidden');
                    } else {
                        sectionC?.classList.remove('hidden');
                        sectionD?.classList.remove('hidden');
                        existingProductSelect?.classList.add('hidden');
                    }
                });
            });

            // HPP auto-fill (without triggering calculation)
            const hppSelect = document.getElementById('hppSelect');
            if (hppSelect) {
                hppSelect.addEventListener('change', function() {
                    if (this.value) {
                        hppInput.value = this.value;
                    }
                });
            }

        });

        function displayResults(result) {
            const statusColor = result.status === 'CRITICAL' ? 'text-red-600' : result.status === 'FRAGILE' ? 'text-amber-600' : 'text-green-600';
            const statusBg = result.status === 'CRITICAL' ? 'bg-red-50' : result.status === 'FRAGILE' ? 'bg-amber-50' : 'bg-green-50';
            const statusBadgeBg = result.status === 'CRITICAL' ? 'bg-red-100' : result.status === 'FRAGILE' ? 'bg-amber-100' : 'bg-green-100';

            const html = `
                <div class="space-y-6 result-card">
                    <!-- 1. HERO SECTION -->
                    <div class="result-section bg-gradient-orange rounded-3xl p-8 shadow-md border border-orange-200">
                        <div class="text-white">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="section-number">1</span>
                                <span class="text-xs font-bold uppercase tracking-wider">Hero Section</span>
                            </div>
                            <div class="text-3xl font-black mb-3">➜ ${result.hero.title}</div>
                            <p class="text-white/90 text-base leading-relaxed">${result.hero.subtext}</p>
                        </div>
                    </div>

                    <!-- 2. PROFIT REALITY -->
                    <div class="result-section bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="section-number">2</span>
                            <h3 class="section-title" style="margin: 0; border: none; padding: 0;">Profit Reality</h3>
                        </div>
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <div class="text-sm font-semibold text-gray-600 mb-2">Net Margin</div>
                            <div class="flex items-baseline gap-3">
                                <div class="text-5xl font-black ${statusColor}">${(result.netMargin * 100).toFixed(1)}%</div>
                                <div class="inline-block px-4 py-2 rounded-full ${statusBadgeBg} text-sm font-bold ${statusColor}">${result.status}</div>
                            </div>
                        </div>
                        
                        <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-4">Cost Breakdown:</div>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm"><span class="text-gray-700">Revenue</span><span class="font-bold">100%</span></div>
                                <div class="flex justify-between text-sm"><span class="text-gray-700">HPP</span><span class="font-bold">${result.costBreakdown.hpp}%</span></div>
                                <div class="flex justify-between text-sm"><span class="text-gray-700">Admin Fee</span><span class="font-bold">${result.costBreakdown.admin}%</span></div>
                                <div class="flex justify-between text-sm"><span class="text-gray-700">Ads</span><span class="font-bold">${result.costBreakdown.ads}%</span></div>
                                <div class="flex justify-between text-sm"><span class="text-gray-700">Affiliate</span><span class="font-bold">${result.costBreakdown.affiliate}%</span></div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm"><span class="text-gray-700">Promo</span><span class="font-bold">${result.costBreakdown.promo}%</span></div>
                                <div class="flex justify-between text-sm"><span class="text-gray-700">Overhead</span><span class="font-bold">${result.costBreakdown.overhead}%</span></div>
                                <div class="flex justify-between text-sm"><span class="text-gray-700">Tax</span><span class="font-bold">${result.costBreakdown.tax}%</span></div>
                                <div class="border-t border-gray-300 pt-2">
                                    <div class="flex justify-between text-sm font-bold"><span>Total Cost</span><span>${result.costBreakdown.total}%</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-orange-50 border border-orange-200 rounded-xl p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-gray-700">Net Profit</span>
                                <span class="text-2xl font-black ${statusColor}">${result.costBreakdown.netProfit}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. COST PRESSURE DETECTOR -->
                    <div class="result-section bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="section-number">3</span>
                            <h3 class="section-title" style="margin: 0; border: none; padding: 0;">Cost Pressure Detector</h3>
                        </div>
                        <div class="mb-6">
                            <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-4">Biggest Cost Drivers:</div>
                            <div class="space-y-3">
                                ${result.topCosts.map((cost, idx) => `
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 flex items-center justify-center bg-orange-100 text-orange-700 font-bold rounded-full text-sm">${idx + 1}</span>
                                            <span class="text-gray-700 font-semibold capitalize">${cost[0]}</span>
                                        </div>
                                        <span class="font-bold text-lg">${(parseFloat(cost[1]) * 100).toFixed(1)}%</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="text-xs font-bold text-blue-900 uppercase tracking-wider mb-2">Insight:</div>
                            <p class="text-sm text-blue-900">${result.status === 'CRITICAL' ? 'Cost structure terlalu berat bahkan sebelum scaling dimulai.' : result.status === 'FRAGILE' ? 'Margin tertekan oleh kombinasi ads + platform fee.' : 'Cost structure masih dalam batas sehat dan scalable.'}</p>
                        </div>
                    </div>

                    <!-- 4. RISK ANALYSIS -->
                    <div class="result-section bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="section-number">4</span>
                            <h3 class="section-title" style="margin: 0; border: none; padding: 0;">Risk Analysis</h3>
                        </div>
                        <div class="space-y-2">
                            ${result.risks.length > 0 ? result.risks.map(risk => `
                                <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg border border-red-200">
                                    <span class="text-red-600 font-bold text-lg mt-0.5">•</span>
                                    <span class="text-red-900 text-sm">${risk}</span>
                                </div>
                            `).join('') : '<p class="text-gray-700">No significant risks identified.</p>'}
                        </div>
                    </div>

                    <!-- 5. STRATEGY DIRECTION -->
                    <div class="result-section bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="section-number">5</span>
                            <h3 class="section-title" style="margin: 0; border: none; padding: 0;">Strategy Direction</h3>
                        </div>
                        <div class="bg-orange-50 border border-orange-200 rounded-xl p-6">
                            <div class="text-sm font-bold text-orange-700 uppercase tracking-wider mb-2">Operating Mode</div>
                            <div class="text-3xl font-black text-orange-600 mb-4">${result.strategy}</div>
                            <p class="text-gray-700 font-semibold">Focus: ${result.status === 'CRITICAL' ? 'memperbaiki unit economics, bukan jualan' : result.status === 'FRAGILE' ? 'jaga margin & cashflow' : 'scale & expansion'}</p>
                        </div>
                    </div>

                    <!-- 6. PRODUCTION DECISION -->
                    <div class="result-section bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="section-number">6</span>
                            <h3 class="section-title" style="margin: 0; border: none; padding: 0;">Production Decision</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                                <div class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Production Model</div>
                                <div class="text-lg font-bold text-navy-800">${result.production.model}</div>
                            </div>
                            <div class="bg-orange-50 border border-orange-200 rounded-xl p-4">
                                <div class="text-xs font-bold text-orange-700 uppercase tracking-wider mb-2">Recommended Batch</div>
                                <div class="text-2xl font-black text-orange-600">${result.production.batch} <span class="text-sm">pcs</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- 7. ADS INSIGHT -->
                    <div class="result-section bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="section-number">7</span>
                            <h3 class="section-title" style="margin: 0; border: none; padding: 0;">Ads Insight</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                <span class="text-gray-700 font-semibold">Ads Cost</span>
                                <span class="text-2xl font-black text-orange-600">${(result.cost.ads * 100).toFixed(1)}%</span>
                            </div>
                            <div class="p-4 rounded-xl ${result.ads.status === 'DANGEROUS' ? 'bg-red-50 border border-red-200' : result.ads.status === 'PRESSURING' ? 'bg-amber-50 border border-amber-200' : 'bg-green-50 border border-green-200'}">
                                <div class="text-xs font-bold uppercase tracking-wider mb-2 ${result.ads.status === 'DANGEROUS' ? 'text-red-700' : result.ads.status === 'PRESSURING' ? 'text-amber-700' : 'text-green-700'}">Status: ${result.ads.status}</div>
                                <p class="text-sm ${result.ads.status === 'DANGEROUS' ? 'text-red-900' : result.ads.status === 'PRESSURING' ? 'text-amber-900' : 'text-green-900'}">${result.ads.message}</p>
                            </div>
                        </div>
                    </div>

                    <!-- 8. ACTION PLAN -->
                    <div class="result-section bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="section-number">8</span>
                            <h3 class="section-title" style="margin: 0; border: none; padding: 0;">Action Plan</h3>
                        </div>
                        <div class="space-y-2">
                            ${result.actions.map((action, idx) => `
                                <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg border border-green-200">
                                    <span class="text-green-600 font-bold">✓</span>
                                    <span class="text-green-900 text-sm">${action}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>

                    <!-- 9. DECISION CONFIDENCE -->
                    <div class="result-section bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="section-number">9</span>
                            <h3 class="section-title" style="margin: 0; border: none; padding: 0;">Decision Confidence</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="text-5xl font-black text-orange-600">${result.confidence}%</div>
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden border border-gray-300">
                                <div class="bg-gradient-orange h-3 rounded-full" style="width: ${result.confidence}%"></div>
                            </div>
                            <p class="text-sm text-gray-700">Confidence level untuk keputusan ini berdasarkan data yang tersedia dan kondisi pasar saat ini.</p>
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
                                <div class="text-xl font-bold text-white">${result.status}</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                                <div class="text-xs font-bold text-orange-300 uppercase tracking-wider mb-2">Mode</div>
                                <div class="text-xl font-bold text-white">${result.strategy}</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                                <div class="text-xs font-bold text-orange-300 uppercase tracking-wider mb-2">Production</div>
                                <div class="text-xl font-bold text-white">${result.production.model}</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                                <div class="text-xs font-bold text-orange-300 uppercase tracking-wider mb-2">Net Margin</div>
                                <div class="text-2xl font-bold text-orange-300">${(result.netMargin * 100).toFixed(1)}%</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur rounded-xl p-4 col-span-2">
                                <div class="text-xs font-bold text-orange-300 uppercase tracking-wider mb-2">Risk Level</div>
                                <div class="text-xl font-bold text-white">${result.status === 'CRITICAL' ? 'Extreme' : result.status === 'FRAGILE' ? 'Medium - High' : 'Controlled'}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Print Button -->
                    <div class="result-section flex gap-4 sticky bottom-0 bg-white rounded-3xl p-6 shadow-lg border border-orange-100">
                        <button onclick="window.print()" class="flex-1 btn-pdf flex items-center justify-center gap-2 text-white py-3 rounded-xl text-sm font-bold uppercase tracking-wider">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print Report
                        </button>
                    </div>
                </div>
            `;

            document.getElementById('resultsContainer').innerHTML = html;
        }
    </script>
</x-app-layout>