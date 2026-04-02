{{-- File: hpp-index.blade.php --}}
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
        
        .badge-printed {
            background: linear-gradient(135deg, #10B98110 0%, #05966920 100%);
            color: #059669;
            border: 1px solid #10B98130;
        }
        
        .badge-unprinted {
            background: linear-gradient(135deg, #6B728010 0%, #9CA3AF20 100%);
            color: #6B7280;
            border: 1px solid #9CA3AF30;
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
        
        .info-card {
            animation: slideIn 0.4s ease-out;
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="text-gradient-orange">Clarity</span>
                                <span class="text-navy-800">Profit</span>
                            </h1>
                            <p class="mt-2 text-sm text-navy-600 max-w-2xl">
                                Pilih menu di bawah untuk mengelola HPP, data produk, persediaan, dan bill of material.
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

            <!-- Info Card -->
            <div class="mb-10 bg-gradient-to-r from-orange-500/10 via-orange-400/5 to-transparent rounded-3xl p-6 border border-orange-200/50 info-card">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-navy-800">Ringkasan HPP</h2>
                        <p class="mt-1 text-sm text-navy-600">
                            Gunakan menu <span class="font-bold text-orange-600">Bahan</span> untuk menambahkan dan mengelola persediaan bahan, 
                            lalu buat perhitungan HPP dari menu <span class="font-bold text-orange-600">Hitung HPP</span>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            @if(!$hppCalculations->isEmpty())
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-10 fade-in-up">
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total HPP</p>
                            <p class="text-2xl font-black text-navy-900 mt-1">{{ $hppCalculations->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Sudah Dicetak</p>
                            <p class="text-2xl font-black text-green-600 mt-1">{{ $hppCalculations->whereNotNull('printed_at')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Belum Dicetak</p>
                            <p class="text-2xl font-black text-orange-500 mt-1">{{ $hppCalculations->whereNull('printed_at')->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Rata-rata HPP</p>
                            <p class="text-xl font-black text-navy-900 mt-1">Rp{{ number_format($hppCalculations->avg('total_hpp_per_unit') ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-10 h-10 bg-navy-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-navy-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- HPP Table Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden fade-in-up">
                <div class="bg-gradient-navy px-6 py-5 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white text-base tracking-wide">Daftar Perhitungan HPP</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[9px] font-bold text-orange-300 uppercase tracking-wider">{{ $hppCalculations->count() }} Data</span>
                    </div>
                </div>

                @if($hppCalculations->isEmpty())
                    <div class="p-16 text-center empty-state">
                        <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-navy-800 mb-2">Belum Ada Perhitungan HPP</h3>
                        <p class="text-sm text-navy-500 max-w-md mx-auto">
                            Silakan buat HPP baru untuk menyimpan dan mencetak laporan perhitungan Harga Pokok Penjualan.
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
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-orange-50/70 border-b border-orange-100">
                                <tr class="text-[10px] font-black text-navy-600 uppercase tracking-wider">
                                    <th class="py-4 px-6">ID</th>
                                    <th class="py-4 px-6">Nama</th>
                                    <th class="py-4 px-6">Kategori</th>
                                    <th class="py-4 px-6">Tanggal</th>
                                    <th class="py-4 px-6 text-right">HPP/Unit</th>
                                    <th class="py-4 px-6 text-center">Status Cetak</th>
                                    <th class="py-4 px-6 text-right">Aksi</th>
                                 </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-50">
                                @foreach($hppCalculations as $hpp)
                                    <tr class="table-row-hover transition-colors">
                                        <td class="py-4 px-6">
                                            <span class="font-mono font-black text-navy-800 text-sm">{{ $hpp->hpp_id }}</span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 bg-gradient-orange rounded-lg flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                                <span class="font-bold text-navy-800">{{ $hpp->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-orange-100 text-orange-700">
                                                {{ $hpp->category }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-navy-600">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3 h-3 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $hpp->created_at->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <span class="font-mono font-black text-orange-600 text-base">Rp{{ number_format($hpp->total_hpp_per_unit, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($hpp->printed_at)
                                                <span class="badge-printed inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Dicetak
                                                </span>
                                            @else
                                                <span class="badge-unprinted inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Belum
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('hpp.show', $hpp->id) }}" class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-wider text-orange-500 hover:text-orange-600 transition-colors group">
                                                    <svg class="w-3.5 h-3.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Detail
                                                </a>
                                                @if(!$hpp->printed_at)
                                                    <a href="{{ route('hpp.print', $hpp->id) }}" class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-wider text-orange-500 hover:text-orange-600 transition-colors group">
                                                        <svg class="w-3.5 h-3.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                        </svg>
                                                        Cetak
                                                    </a>
                                                @endif
                                                <form action="{{ route('hpp.destroy', $hpp->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus HPP ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-wider text-red-500 hover:text-red-600 transition-colors group">
                                                        <svg class="w-3.5 h-3.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Table Footer -->
                    <div class="bg-orange-50/30 px-6 py-3 border-t border-orange-100 flex justify-between items-center">
                        <div class="text-[10px] font-semibold text-navy-500">
                            Menampilkan {{ $hppCalculations->count() }} perhitungan HPP
                        </div>
                        <div class="flex gap-3 text-[10px] font-bold">
                            <span class="flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span> 
                                {{ $hppCalculations->whereNotNull('printed_at')->count() }} Dicetak
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-gray-400"></span> 
                                {{ $hppCalculations->whereNull('printed_at')->count() }} Belum
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>