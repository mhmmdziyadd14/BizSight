{{-- File: hpp-detail.blade.php --}}
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
        
        .btn-primary {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
        }
        
        .btn-secondary {
            background: #FEF3C7;
            color: #F97316;
            transition: all 0.2s ease;
        }
        
        .btn-secondary:hover {
            background: #FFEDD5;
            transform: translateY(-1px);
        }
        
        .btn-outline {
            border: 2px solid #F97316;
            color: #F97316;
            transition: all 0.2s ease;
        }
        
        .btn-outline:hover {
            background: #F97316;
            color: white;
            transform: translateY(-1px);
        }
        
        .stat-card {
            background: white;
            border: 1px solid rgba(249, 115, 22, 0.1);
            border-radius: 24px;
            padding: 24px;
            transition: all 0.3s ease;
        }

        .dark .stat-card {
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
            border: 1px solid rgba(249, 115, 22, 0.2);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -12px rgba(249, 115, 22, 0.2);
        }
        
        .fee-card {
            background: white;
            border: 1px solid #FEF3C7;
            border-radius: 20px;
            padding: 20px;
            transition: all 0.2s ease;
        }
        
        .dark .fee-card {
            background: #1E293B;
            border-color: rgba(249, 115, 22, 0.2);
        }

        .fee-card:hover {
            border-color: #F97316;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.1);
        }
        
        .table-row-hover {
            transition: all 0.2s ease;
        }
        
        .table-row-hover:hover {
            background: linear-gradient(90deg, rgba(254, 243, 199, 0.1) 0%, rgba(255, 247, 237, 0.05) 100%);
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
        
        .print-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #F1F5F9;
            border-radius: 40px;
            font-size: 11px;
            font-weight: 700;
            color: #475569;
        }

        .dark .print-badge {
            background: #0F172A;
            color: #94A3B8;
        }
    </style>

    <div x-data="{
        multiplier: 1,
        editModalOpen: false,
        name: {{ json_encode($hpp->name) }},
        category: {{ json_encode($hpp->category) }},
        target_selling_price: {{ (float) $hpp->target_selling_price }},
        screen_printing_fee: {{ (float) $hpp->screen_printing_fee }},
        sewing_fee: {{ (float) $hpp->sewing_fee }},
        other_fees: {{ (float) $hpp->other_fees }},
        
        materialsByName: {{ json_encode($materialsByName) }},
        
        items: [
            @foreach($hpp->items as $item)
            {
                material_name: {{ json_encode($item->material->name) }},
                color_id: {{ $item->material_id }},
                usage_amount: {{ $item->usage_amount }},
                unit: {{ json_encode($item->material->unit) }},
                unit_price: {{ $item->material->purchase_volume > 0 ? ($item->material->price / $item->material->purchase_volume) : $item->material->price }},
                subtotal: {{ $item->subtotal_cost }}
            },
            @endforeach
        ],

        formatRp(num) {
            return 'Rp ' + Math.round(num).toLocaleString('id-ID');
        },
        formatNum(num) {
            return Number(num).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        },

        addBomRow() {
            this.items.push({
                material_name: '',
                color_id: '',
                usage_amount: 0,
                unit: '-',
                unit_price: 0,
                subtotal: 0
            });
        },

        removeBomRow(index) {
            this.items.splice(index, 1);
        },

        onMaterialChange(item) {
            item.color_id = '';
            item.unit = '-';
            item.unit_price = 0;
            item.subtotal = 0;

            const mat = this.materialsByName.find(m => m.name === item.material_name);
            if (mat) {
                item.unit = mat.unit || '-';
                if (mat.colors && mat.colors.length === 1) {
                    item.color_id = mat.colors[0].id;
                    this.onColorChange(item);
                }
            }
        },

        onColorChange(item) {
            const mat = this.materialsByName.find(m => m.name === item.material_name);
            if (mat && item.color_id) {
                const col = mat.colors.find(c => String(c.id) === String(item.color_id));
                if (col) {
                    const vol = parseFloat(mat.purchase_volume || col.purchase_volume || 1);
                    item.unit_price = vol > 0 ? (col.price / vol) : col.price;
                    item.subtotal = item.unit_price * parseFloat(item.usage_amount || 0);
                }
            } else {
                item.unit_price = 0;
                item.subtotal = 0;
            }
        },

        onUsageChange(item) {
            item.subtotal = item.unit_price * parseFloat(item.usage_amount || 0);
        },

        getLiveRawCost() {
            return this.items.reduce((sum, item) => sum + parseFloat(item.subtotal || 0), 0);
        },

        getLiveTotalHpp() {
            return this.getLiveRawCost() +
                   parseFloat(this.screen_printing_fee || 0) +
                   parseFloat(this.sewing_fee || 0) +
                   parseFloat(this.other_fees || 0);
        },

        getLiveProfit() {
            return parseFloat(this.target_selling_price || 0) - this.getLiveTotalHpp();
        },

        getLiveMargin() {
            const selling = parseFloat(this.target_selling_price || 0);
            if (selling > 0) {
                return (this.getLiveProfit() / selling) * 100;
            }
            return 0;
        }
    }" class="py-10 bg-gradient-to-br from-orange-50 via-white to-orange-100/20 dark:from-navy-800 dark:via-navy-900 dark:to-navy-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 fade-in-up">
            
            @include('business.partials.hpp_nav')

            <!-- Navigation -->
            <div class="mb-6">
                <a href="{{ route('hpp.index') }}" class="inline-flex items-center gap-2 group text-slate-500 hover:text-orange-600 transition-all">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-navy-900 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-black uppercase tracking-widest">Kembali ke Dashboard</span>
                </a>
            </div>

            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between border-b pb-6 border-orange-500/10 dark:border-orange-500/30">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="text-gradient-orange">Detail</span>
                                <span class="text-navy-900 dark:text-white">HPP</span>
                            </h1>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300 max-w-2xl">
                                Laporan rincian perhitungan Harga Pokok Penjualan untuk produk <span class="font-bold text-orange-600 dark:text-orange-400">{{ $hpp->name }}</span>.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <button @click="editModalOpen = true" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-xl font-black text-xs uppercase tracking-wider hover:shadow-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Data
                    </button>
                    @if($hpp->printed_at)
                        <div class="print-badge">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Dicetak: <span class="local-time" data-utc="{{ $hpp->printed_at->toIso8601String() }}" data-format="d M Y H:i">{{ $hpp->printed_at->format('d M Y H:i') }}</span>
                        </div>
                        <a :href="`{{ route('hpp.print', $hpp->id) }}?qty=${multiplier}`" class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 text-white rounded-xl font-black text-xs uppercase tracking-wider hover:bg-orange-600 transition-all shadow-md">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak HPP
                        </a>
                        <a :href="`{{ route('hpp.bom.print', $hpp->id) }}?qty=${multiplier}`" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-500 text-white rounded-xl font-black text-xs uppercase tracking-wider hover:bg-blue-600 transition-all shadow-md">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Cetak BOM
                        </a>
                        
                    @else
                        <a :href="`{{ route('hpp.print', $hpp->id) }}?qty=${multiplier}`" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-xl font-black text-xs uppercase tracking-wider hover:shadow-lg transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak HPP
                        </a>
                        <a :href="`{{ route('hpp.bom.print', $hpp->id) }}?qty=${multiplier}`" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-500 text-white rounded-xl font-black text-xs uppercase tracking-wider hover:bg-blue-600 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Cetak BOM
                        </a>
                    @endif
                </div>
            </div>

            <!-- Identity Card -->
            <div class="bg-white dark:bg-navy-900 rounded-3xl shadow-xl border border-orange-500/10 dark:border-orange-500/20 overflow-hidden mb-8 transition-all">
                <div class="bg-navy-900 dark:bg-navy-950 px-6 py-4 flex justify-between items-center border-b border-white/5">
                    <h3 class="font-black text-white text-sm tracking-widest flex items-center gap-2 uppercase">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Ringkasan Finansial Produk
                    </h3>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $hpp->hpp_id }}</span>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-orange-50/30 dark:bg-navy-950/50 p-4 rounded-2xl border border-orange-500/10">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Harga HPP/Unit</p>
                        <p class="text-xl font-black text-navy-900 dark:text-white">Rp{{ number_format($hpp->total_hpp_per_unit, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-green-50/30 dark:bg-green-900/10 p-4 rounded-2xl border border-green-500/10">
                        <p class="text-[10px] font-black text-green-600 dark:text-green-400 uppercase tracking-widest mb-1">Harga Jual</p>
                        <p class="text-xl font-black text-green-600 dark:text-green-500">Rp{{ number_format($hpp->target_selling_price, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-orange-50/30 dark:bg-navy-950/50 p-4 rounded-2xl border border-orange-500/10">
                        @php
                            $profit = $hpp->target_selling_price - $hpp->total_hpp_per_unit;
                            $margin = $hpp->target_selling_price > 0 ? ($profit / $hpp->target_selling_price) * 100 : 0;
                        @endphp
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Profit Bersih/Unit</p>
                        <p class="text-xl font-black {{ $profit >= 0 ? 'text-navy-900 dark:text-white' : 'text-red-500' }}">
                            Rp{{ number_format($profit, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-orange-50/30 dark:bg-navy-950/50 p-4 rounded-2xl border border-orange-500/10">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Margin Profit</p>
                        <p class="text-xl font-black {{ $margin >= 0 ? 'text-green-600' : 'text-red-500' }}">{{ number_format($margin, 1) }}%</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="stat-card">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-orange-50 dark:bg-navy-900 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Total Bahan Baku</div>
                            <div class="text-3xl font-black text-navy-900 dark:text-white">Rp {{ number_format($hpp->total_raw_material_cost, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-white/80 uppercase tracking-wider">Total HPP / Unit</div>
                            <div class="text-3xl font-black text-white">Rp {{ number_format($hpp->total_hpp_per_unit, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-white/80 uppercase tracking-wider">Harga Jual (Final Price)</div>
                            <div class="text-3xl font-black text-white">Rp {{ number_format($hpp->target_selling_price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Fees Section -->
            <div class="mt-8 mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-6 h-6 bg-white dark:bg-navy-900 rounded-lg flex items-center justify-center shadow-sm border border-orange-500/10">
                        <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-xs font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">Rincian Biaya Tambahan</div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="fee-card">
                        <div class="text-[10px] font-black text-slate-500 uppercase tracking-wider mb-2">Biaya Sablon</div>
                        <div class="text-2xl font-black text-navy-900 dark:text-white">Rp {{ number_format($hpp->screen_printing_fee, 0, ',', '.') }}</div>
                    </div>
                    <div class="fee-card">
                        <div class="text-[10px] font-black text-slate-500 uppercase tracking-wider mb-2">Biaya Jahit</div>
                        <div class="text-2xl font-black text-navy-900 dark:text-white">Rp {{ number_format($hpp->sewing_fee, 0, ',', '.') }}</div>
                    </div>
                    <div class="fee-card">
                        <div class="text-[10px] font-black text-slate-500 uppercase tracking-wider mb-2">Biaya Lainnya</div>
                        <div class="text-2xl font-black text-navy-900 dark:text-white">Rp {{ number_format($hpp->other_fees, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Profit Analysis -->
            @php
                $profit = $hpp->target_selling_price - $hpp->total_hpp_per_unit;
                $profitMargin = $hpp->target_selling_price > 0 ? ($profit / $hpp->target_selling_price) * 100 : 0;
            @endphp
            <div class="mt-8 mb-8 bg-white dark:bg-navy-900 rounded-2xl p-6 border border-orange-500/10 dark:border-orange-500/20 transition-all shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider mb-1">Target Harga Jual</div>
                        <div class="text-2xl font-black text-navy-900 dark:text-white">Rp {{ number_format($hpp->target_selling_price, 0, ',', '.') }}</div>
                    </div>
                    <div class="w-px h-12 bg-orange-100 dark:bg-navy-700 hidden md:block"></div>
                    <div>
                        <div class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider mb-1">Estimasi Profit per Unit</div>
                        <div class="text-2xl font-black {{ $profit >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            Rp {{ number_format($profit, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="w-px h-12 bg-orange-100 dark:bg-navy-700 hidden md:block"></div>
                    <div>
                        <div class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider mb-1">Profit Margin</div>
                        <div class="text-2xl font-black {{ $profitMargin >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ number_format($profitMargin, 1) }}%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materials Table Card -->
            <div class="bg-white dark:bg-navy-900 rounded-3xl shadow-xl border border-orange-500/10 dark:border-orange-500/20 overflow-hidden mb-8 transition-all">
                <div class="bg-orange-50/50 dark:bg-navy-950 px-6 py-4 flex justify-between items-center border-b border-orange-500/10">
                    <h3 class="font-bold text-navy-900 dark:text-white text-base tracking-wide flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Detail Bill of Material
                    </h3>
                    <div class="flex items-center gap-2 bg-white dark:bg-navy-900 rounded-lg p-1.5 border border-orange-200 dark:border-orange-500/20 shadow-sm">
                        <label class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-2">Kuantitas Cetak</label>
                        <input type="number" x-model.number="multiplier" min="1" class="w-16 h-7 text-center text-xs font-bold text-navy-900 dark:text-white bg-orange-50 dark:bg-navy-950 border-none rounded focus:ring-0" style="padding: 0;">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-orange-50/30 dark:bg-navy-950 border-b border-orange-500/10 dark:border-orange-500/20">
                            <tr class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">
                                <th class="py-4 px-6">Bahan</th>
                                <th class="py-4 px-6 text-center">Pemakaian</th>
                                <th class="py-4 px-6 text-right">Harga Satuan</th>
                                <th class="py-4 px-6 text-right">Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-orange-500/10">
                            @foreach($hpp->items as $material)
                                @php
                                    $unitPrice = $material->material->price;
                                    $usageAmount = $material->usage_amount;
                                    $totalCost = $material->subtotal_cost;
                                @endphp
                                <tr class="table-row-hover hover:bg-orange-500/5 transition-colors">
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-navy-900 dark:text-white">{{ $material->material->name }}</p>
                                        <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ $material->material->unit ?? 'Tanpa Warna' }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="font-mono font-bold text-navy-900 dark:text-white">
                                            <span x-text="formatNum({{ $usageAmount }} * (multiplier || 1))">{{ number_format($usageAmount, 2, ',', '.') }}</span>
                                        </span>
                                        <span class="text-[10px] text-slate-500 ml-0.5">{{ $material->material->unit }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-right font-mono text-slate-500 dark:text-slate-400">
                                        Rp{{ number_format($unitPrice, 2, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-right font-mono font-black text-navy-900 dark:text-white">
                                        <span x-text="formatRp({{ $totalCost }} * (multiplier || 1))">Rp{{ number_format($totalCost, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-orange-50/50 dark:bg-navy-950/50">
                            <tr>
                                <td colspan="3" class="py-4 px-6 text-right text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Subtotal Bahan</td>
                                <td class="py-4 px-6 text-right font-mono font-black text-orange-600 dark:text-orange-500">
                                    <span x-text="formatRp({{ $hpp->total_raw_material_cost }} * (multiplier || 1))">Rp{{ number_format($hpp->total_raw_material_cost, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
            
            <!-- EDIT MODAL -->
            <div x-show="editModalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
                 x-cloak>
                
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-navy-950/40 dark:bg-black/60 backdrop-blur-md" @click="editModalOpen = false"></div>
                
                <!-- Modal Box -->
                <div class="relative bg-white dark:bg-navy-900 w-full max-w-4xl rounded-3xl shadow-2xl border border-orange-100 dark:border-white/5 overflow-hidden z-10 flex flex-col my-8 transition-colors max-h-[90vh]">
                    
                    <!-- Modal Header -->
                    <div class="bg-navy-900 px-6 py-5 flex items-center justify-between border-b border-white/5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-white tracking-wide">Edit Perhitungan HPP & BOM</h3>
                        </div>
                        <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body / Form -->
                    <form action="{{ route('hpp.update', $hpp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan perubahan data HPP dan BOM ini?')" class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Section 1: Info & Price -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Nama Produk</label>
                                <input type="text" name="name" x-model="name" required
                                    class="w-full border border-gray-200 dark:border-white/5 bg-gray-50 dark:bg-navy-950 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Kategori</label>
                                <input type="text" name="category" x-model="category" required
                                    class="w-full border border-gray-200 dark:border-white/5 bg-gray-50 dark:bg-navy-950 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Target Harga Jual (Rp)</label>
                                <input type="number" name="target_selling_price" x-model.number="target_selling_price" required
                                    class="w-full border border-gray-200 dark:border-white/5 bg-gray-50 dark:bg-navy-950 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                            </div>
                        </div>

                        <!-- Section 2: Biaya Tambahan -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Biaya Sablon (Rp)</label>
                                <input type="number" name="screen_printing_fee" x-model.number="screen_printing_fee"
                                    class="w-full border border-gray-200 dark:border-white/5 bg-gray-50 dark:bg-navy-950 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Biaya Jahit (Rp)</label>
                                <input type="number" name="sewing_fee" x-model.number="sewing_fee"
                                    class="w-full border border-gray-200 dark:border-white/5 bg-gray-50 dark:bg-navy-950 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Biaya Lainnya (Rp)</label>
                                <input type="number" name="other_fees" x-model.number="other_fees"
                                    class="w-full border border-gray-200 dark:border-white/5 bg-gray-50 dark:bg-navy-950 rounded-xl px-4 py-3 text-sm font-semibold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                            </div>
                        </div>

                        <!-- Section 3: Bill of Materials Editor -->
                        <div class="border-t border-orange-100 dark:border-white/5 pt-6">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-sm font-black text-navy-900 dark:text-white uppercase tracking-wider">Bill of Materials</h4>
                                <button type="button" @click="addBomRow()" class="px-4 py-2 bg-gradient-orange text-white rounded-xl font-black text-[10px] uppercase tracking-wider transition-all hover:shadow-md hover:scale-[1.01]">
                                    + Tambah Bahan
                                </button>
                            </div>

                            <div class="overflow-x-auto border border-gray-100 dark:border-white/5 rounded-2xl">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-orange-50/30 dark:bg-navy-950 border-b border-orange-500/10 dark:border-orange-500/20">
                                        <tr class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">
                                            <th class="py-3 px-4 w-12 text-center">No</th>
                                            <th class="py-3 px-4 w-1/3">Bahan</th>
                                            <th class="py-3 px-4 w-1/4">Warna</th>
                                            <th class="py-3 px-4 text-center">Kebutuhan</th>
                                            <th class="py-3 px-4 text-right">Subtotal</th>
                                            <th class="py-3 px-4 w-12 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-orange-500/10">
                                        <template x-for="(item, index) in items" :key="index">
                                            <tr class="hover:bg-orange-500/5 transition-colors">
                                                <td class="py-3 px-4 text-center text-xs font-black text-slate-500" x-text="index + 1"></td>
                                                <td class="py-3 px-4">
                                                    <select x-model="item.material_name" @change="onMaterialChange(item)" required
                                                        class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                                        <option value="">-- Pilih Bahan --</option>
                                                        <template x-for="mat in materialsByName" :key="mat.name">
                                                            <option :value="mat.name" x-text="mat.name" :selected="mat.name === item.material_name"></option>
                                                        </template>
                                                    </select>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <select name="material_ids[]" x-model="item.color_id" @change="onColorChange(item)" :disabled="!item.material_name" required
                                                        class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all disabled:opacity-50">
                                                        <option value="">-- Pilih Warna --</option>
                                                        <template x-if="item.material_name">
                                                            <template x-for="col in (materialsByName.find(m => m.name === item.material_name)?.colors || [])" :key="col.id">
                                                                <option :value="col.id" x-text="col.color ? col.color : 'Tanpa Warna'" :selected="String(col.id) === String(item.color_id)"></option>
                                                            </template>
                                                        </template>
                                                    </select>
                                                </td>
                                                <td class="py-3 px-4 flex items-center justify-center gap-1.5">
                                                    <input type="number" step="0.01" name="usage_amounts[]" x-model.number="item.usage_amount" @input="onUsageChange(item)" required
                                                        class="w-20 text-center bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-2 py-2 text-xs font-black text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider" x-text="item.unit"></span>
                                                </td>
                                                <td class="py-3 px-4 text-right font-mono text-xs font-black text-navy-900 dark:text-white" x-text="formatRp(item.subtotal)"></td>
                                                <td class="py-3 px-4 text-center">
                                                    <button type="button" @click="removeBomRow(index)" class="w-8 h-8 rounded-lg bg-red-50 dark:bg-red-500/10 flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                        <template x-if="items.length === 0">
                                            <tr>
                                                <td colspan="6" class="py-8 text-center text-xs text-slate-400">Belum ada bahan baku. Silakan klik "+ Tambah Bahan".</td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Section 4: Live Recalculated Summary -->
                        <div class="bg-navy-900 dark:bg-navy-950 rounded-2xl p-6 border border-orange-500/20 space-y-4 text-white shadow-md transition-colors">
                            <h5 class="text-xs font-black text-orange-400 uppercase tracking-widest mb-2 border-b border-white/5 pb-2">Estimasi Hasil Analisis Baru</h5>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Total Bahan Baku</div>
                                    <div class="text-base font-black text-white" x-text="formatRp(getLiveRawCost())"></div>
                                </div>
                                <div>
                                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Total HPP / Unit</div>
                                    <div class="text-base font-black text-orange-400" x-text="formatRp(getLiveTotalHpp())"></div>
                                </div>
                                <div>
                                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Estimasi Profit / Unit</div>
                                    <div class="text-base font-black" :class="getLiveProfit() >= 0 ? 'text-green-400' : 'text-red-400'" x-text="formatRp(getLiveProfit())"></div>
                                </div>
                                <div>
                                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Profit Margin</div>
                                    <div class="text-base font-black" :class="getLiveMargin() >= 0 ? 'text-green-400' : 'text-red-400'" x-text="formatNum(getLiveMargin()) + '%'"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Actions -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-orange-100 dark:border-white/5">
                            <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-navy-950 dark:hover:bg-navy-900 text-slate-700 dark:text-slate-300 rounded-xl font-black text-xs uppercase tracking-wider border border-transparent dark:border-white/5 transition-all">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-gradient-orange hover:shadow-lg text-white rounded-xl font-black text-xs uppercase tracking-wider transition-all shadow-md">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>