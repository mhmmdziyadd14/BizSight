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
            background: linear-gradient(135deg, #FEF3C7 0%, #FFEDD5 100%);
            border-radius: 24px;
            padding: 24px;
            transition: all 0.3s ease;
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
        
        .fee-card:hover {
            border-color: #F97316;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.1);
        }
        
        .table-row-hover {
            transition: all 0.2s ease;
        }
        
        .table-row-hover:hover {
            background: linear-gradient(90deg, #FEF3C7 0%, #FFF7ED 100%);
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
    </style>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="font-extrabold text-xl text-navy-800 leading-tight tracking-tight">
                {{ __('Detail Kalkulasi HPP') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-orange-50 via-white to-navy-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('business.partials.hpp_nav')
            
            <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden fade-in-up mt-6">
                <div class="p-8">
                    <!-- Header Section -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 pb-6 border-b border-orange-100">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-navy-800">{{ $hpp->name }}</h3>
                            </div>
                            <div class="flex flex-wrap gap-4 mt-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                    </svg>
                                    <span class="text-sm text-navy-600">ID HPP: <strong class="font-mono font-black">{{ $hpp->hpp_id }}</strong></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                    <span class="text-sm text-navy-600">Kategori: <strong>{{ $hpp->category }}</strong></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm text-navy-600">Dibuat: <strong>{{ $hpp->created_at->format('d M Y H:i') }}</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <a href="{{ route('hpp.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-xl font-black text-xs uppercase tracking-wider hover:shadow-lg transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buat Baru
                            </a>
                            @if($hpp->printed_at)
                                <div class="print-badge">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Dicetak: {{ $hpp->printed_at->format('d M Y H:i') }}
                                </div>
                                <a href="{{ route('hpp.print', $hpp->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 text-white rounded-xl font-black text-xs uppercase tracking-wider hover:bg-orange-600 transition-all shadow-md">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Cetak Ulang
                                </a>
                            @else
                                <a href="{{ route('hpp.print', $hpp->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-xl font-black text-xs uppercase tracking-wider hover:shadow-lg transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Cetak PDF
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Main Stats Section -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="stat-card">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black text-orange-600 uppercase tracking-wider">Total Bahan Baku</div>
                                    <div class="text-3xl font-black text-navy-800">Rp {{ number_format($hpp->total_raw_material_cost, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card" style="background: linear-gradient(135deg, #F97316 0%, #F59E0B 100%);">
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
                    </div>

                    <!-- Additional Fees Section -->
                    <div class="mt-8">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="text-xs font-black text-orange-600 uppercase tracking-wider">Rincian Biaya Tambahan</div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="fee-card">
                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-2">Biaya Sablon</div>
                                <div class="text-2xl font-black text-navy-800">Rp {{ number_format($hpp->screen_printing_fee, 0, ',', '.') }}</div>
                            </div>
                            <div class="fee-card">
                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-2">Biaya Jahit</div>
                                <div class="text-2xl font-black text-navy-800">Rp {{ number_format($hpp->sewing_fee, 0, ',', '.') }}</div>
                            </div>
                            <div class="fee-card">
                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-2">Biaya Lainnya</div>
                                <div class="text-2xl font-black text-navy-800">Rp {{ number_format($hpp->other_fees, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Profit Analysis (if target selling price exists) -->
                    @if($hpp->target_selling_price > 0)
                        @php
                            $profit = $hpp->target_selling_price - $hpp->total_hpp_per_unit;
                            $profitMargin = ($profit / $hpp->target_selling_price) * 100;
                        @endphp
                        <div class="mt-8 bg-gradient-to-r from-orange-50 to-orange-100/50 rounded-2xl p-6 border border-orange-200">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <div class="text-[10px] font-black text-orange-600 uppercase tracking-wider mb-1">Target Harga Jual</div>
                                    <div class="text-2xl font-black text-navy-800">Rp {{ number_format($hpp->target_selling_price, 0, ',', '.') }}</div>
                                </div>
                                <div class="w-px h-12 bg-orange-200 hidden md:block"></div>
                                <div>
                                    <div class="text-[10px] font-black text-orange-600 uppercase tracking-wider mb-1">Estimasi Profit per Unit</div>
                                    <div class="text-2xl font-black {{ $profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($profit, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="w-px h-12 bg-orange-200 hidden md:block"></div>
                                <div>
                                    <div class="text-[10px] font-black text-orange-600 uppercase tracking-wider mb-1">Profit Margin</div>
                                    <div class="text-2xl font-black {{ $profitMargin >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($profitMargin, 1) }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Materials Table -->
                    <div class="mt-10 bg-white rounded-2xl overflow-hidden border border-orange-100">
                        <div class="bg-gradient-navy px-6 py-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <div class="text-xs font-black text-white uppercase tracking-wider">Detail Komponen Bahan</div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-orange-50/70 border-b border-orange-100">
                                    <tr class="text-[10px] font-black text-navy-600 uppercase tracking-wider">
                                        <th class="px-6 py-4">Bahan</th>
                                        <th class="px-6 py-4">Satuan</th>
                                        <th class="px-6 py-4 text-right">Harga / Unit</th>
                                        <th class="px-6 py-4 text-right">Qty</th>
                                        <th class="px-6 py-4 text-right">Subtotal</th>
                                     </tr>
                                </thead>
                                <tbody class="divide-y divide-orange-50">
                                    @foreach($hpp->items as $item)
                                        <tr class="table-row-hover transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm font-bold text-navy-800">{{ $item->material->name }}</span>
                                                </div>
                                             </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex px-2 py-1 rounded-lg bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wider">{{ $item->material->unit }}</span>
                                             </td>
                                            <td class="px-6 py-4 text-right font-mono font-bold text-navy-700">Rp {{ number_format($item->material->price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-right font-mono font-bold text-navy-700">{{ number_format($item->usage_amount, 2, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-right font-mono font-bold text-orange-600">Rp {{ number_format($item->subtotal_cost, 0, ',', '.') }}</td>
                                         </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-orange-50/30 border-t border-orange-100">
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-right font-black text-navy-700 uppercase tracking-wider text-xs">Total Bahan Baku:</td>
                                        <td class="px-6 py-4 text-right font-black text-orange-600 text-base">Rp {{ number_format($hpp->total_raw_material_cost, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>