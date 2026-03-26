{{-- File: bill-of-material.blade.php --}}
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
        
        .bom-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .bom-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
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
        
        .color-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="text-gradient-orange">Biz</span>
                                <span class="text-navy-900">Sight</span>
                            </h1>
                            <p class="mt-2 text-sm text-navy-600 max-w-2xl">
                                Bill of Material (BOM) menampilkan bahan yang digunakan pada setiap produk HPP.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('hpp.create') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl font-black text-xs uppercase tracking-widest text-white shadow-md hover:shadow-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat HPP Baru
                    </a>
                </div>
            </div>

            @include('business.partials.hpp_nav')

            <!-- BOM Content -->
            <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden fade-in-up">
                @if($bomList->isEmpty())
                    <div class="p-16 text-center empty-state">
                        <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-navy-800 mb-2">Belum Ada Bill of Material</h3>
                        <p class="text-sm text-navy-500 max-w-md mx-auto">
                            Belum ada Bill of Material karena belum ada perhitungan HPP. Buat HPP untuk melihat BOM.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('hpp.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-orange text-white rounded-xl text-xs font-black uppercase tracking-wider hover:shadow-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buat HPP Sekarang
                            </a>
                        </div>
                    </div>
                @else
                    <div class="space-y-8 p-6">
                        @foreach($bomList as $index => $hpp)
                            <div class="bom-card border border-orange-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all">
                                <!-- Card Header -->
                                <div class="bg-gradient-navy px-8 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                                            <span class="text-white font-black text-lg">{{ $index + 1 }}</span>
                                        </div>
                                        <div>
                                            <div class="text-[10px] font-black text-orange-300 uppercase tracking-wider">Produk</div>
                                            <div class="text-xl font-black text-white">
                                                {{ $hpp->name }}
                                                <span class="text-xs text-orange-300/70 font-mono ml-2">({{ $hpp->hpp_id }})</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('hpp.show', $hpp->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider text-orange-300 hover:text-orange-200 border border-orange-500/30 hover:border-orange-400 transition-all group">
                                        <span>Lihat Detail</span>
                                        <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                                
                                <!-- Table -->
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-sm">
                                        <thead class="bg-orange-50/70 border-b border-orange-100">
                                            <tr class="text-[10px] font-black text-navy-600 uppercase tracking-wider">
                                                <th class="py-4 px-6">Bahan</th>
                                                <th class="py-4 px-6">Warna</th>
                                                <th class="py-4 px-6 text-right">Kebutuhan</th>
                                                <th class="py-4 px-6 text-right">Harga/Unit</th>
                                                <th class="py-4 px-6 text-right">Subtotal</th>
                                                <th class="py-4 px-6">Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-orange-50">
                                            @foreach($hpp->items as $item)
                                                <tr class="table-row-hover transition-colors">
                                                    <td class="py-4 px-6 font-bold text-navy-800">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center">
                                                                <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                                </svg>
                                                            </div>
                                                            {{ $item->material->name }}
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        @if($item->material->color && $item->material->color !== '-')
                                                            <div class="flex items-center gap-2">
                                                                <span class="color-dot" style="background-color: {{ $item->material->color }};"></span>
                                                                <span class="text-sm text-navy-600">{{ $item->material->color }}</span>
                                                            </div>
                                                        @else
                                                            <span class="text-gray-400 text-xs">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="py-4 px-6 text-right font-mono font-bold text-navy-700">
                                                        {{ number_format($item->usage_amount, 2, ',', '.') }}
                                                    </td>
                                                    <td class="py-4 px-6 text-right font-mono font-bold text-navy-700">
                                                        Rp{{ number_format($item->material->price, 0, ',', '.') }}
                                                    </td>
                                                    <td class="py-4 px-6 text-right font-mono font-bold text-orange-600">
                                                        Rp{{ number_format($item->subtotal_cost, 0, ',', '.') }}
                                                    </td>
                                                    <td class="py-4 px-6">
                                                        <span class="inline-flex px-2 py-1 rounded-lg bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wider">
                                                            {{ $item->material->unit }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <!-- Footer with total cost -->
                                        @php
                                            $totalCost = $hpp->items->sum('subtotal_cost');
                                        @endphp
                                        <tfoot class="bg-orange-50/30 border-t border-orange-100">
                                            <tr>
                                                <td colspan="4" class="py-4 px-6 text-right font-black text-navy-700 uppercase tracking-wider text-xs">
                                                    Total Bahan Baku:
                                                </td>
                                                <td class="py-4 px-6 text-right font-black text-orange-600 text-base">
                                                    Rp{{ number_format($totalCost, 0, ',', '.') }}
                                                </td>
                                                <td class="py-4 px-6"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Summary Stats (when BOM exists) -->
            @if(!$bomList->isEmpty())
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-5 fade-in-up">
                    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total Produk</p>
                                <p class="text-2xl font-black text-navy-900 mt-1">{{ $bomList->count() }}</p>
                            </div>
                            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total Bahan</p>
                                <p class="text-2xl font-black text-navy-900 mt-1">{{ $bomList->sum(function($hpp) { return $hpp->items->count(); }) }}</p>
                            </div>
                            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total Nilai BOM</p>
                                <p class="text-2xl font-black text-orange-600 mt-1">
                                    Rp{{ number_format($bomList->sum(function($hpp) { return $hpp->items->sum('subtotal_cost'); }), 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>