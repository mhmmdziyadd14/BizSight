{{-- File: materials-management.blade.php --}}
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
        
        .delete-btn {
            transition: all 0.2s ease;
        }
        
        .delete-btn:hover {
            transform: translateX(2px);
            color: #EF4444;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .slide-in {
            animation: slideIn 0.4s ease-out;
        }
        
        .success-message {
            animation: slideIn 0.4s ease-out;
        }
        
        .material-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-utama {
            background: linear-gradient(135deg, #FEF3C7, #FFEDD5);
            color: #F97316;
        }
        
        .badge-pendukung {
            background: linear-gradient(135deg, #F1F5F9, #E2E8F0);
            color: #475569;
        }
        
        .badge-lainnya {
            background: linear-gradient(135deg, #FEF3C7, #FFEDD5);
            color: #F59E0B;
        }
    </style>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-navy-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between border-b pb-6 border-orange-200/50 slide-in">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="text-gradient-orange">Clarity</span>
                                <span class="text-navy-800">Profit</span>
                            </h1>
                            <p class="mt-2 text-sm text-navy-600 max-w-2xl">
                                Kelola bahan baku dan catat biaya pembelian sehingga bisa langsung dipakai saat bikin HPP.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('hpp.create') }}" class="btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl font-black text-xs uppercase tracking-widest text-white shadow-md hover:shadow-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        + Buat HPP Baru
                    </a>
                </div>
            </div>

            @include('business.partials.hpp_nav')

            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-green-500/30 bg-green-500/10 backdrop-blur-sm px-6 py-4 success-message slide-in">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-green-700 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Header with Button -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 slide-in">
                <div>
                    <h2 class="text-2xl md:text-3xl font-black text-navy-900">Daftar Bahan Baku</h2>
                    <p class="text-sm text-navy-600 mt-2">Kelola dan hapus bahan yang sudah tidak digunakan.</p>
                </div>
                <a href="{{ route('materials.index') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-xl font-black text-sm uppercase tracking-widest text-white shadow-md hover:shadow-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Bahan Baku
                </a>
            </div>

            <!-- Quick Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-3xl shadow-lg p-8 border border-orange-200 slide-in">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-black text-orange-600 uppercase tracking-wider">Total Bahan</p>
                            <p class="text-4xl font-black text-orange-700">{{ $materials->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl shadow-lg p-8 border border-blue-200 slide-in">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-black text-blue-600 uppercase tracking-wider">Total Investasi</p>
                            <p class="text-2xl font-black text-blue-700">Rp{{ number_format($materials->sum(fn($m) => $m->price * $m->purchase_volume), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materials List Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden slide-in">
                <div class="bg-gradient-navy px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-black text-white">Tabel Bahan</h2>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    @if($materials->isEmpty())
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <p class="text-navy-400 font-medium">Belum ada bahan baku. Tambahkan bahan terlebih dahulu.</p>
                        </div>
                    @else
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gradient-to-r from-orange-50/50 to-orange-50 border-b border-orange-200">
                                <tr class="text-[11px] font-black text-navy-700 uppercase tracking-wider">
                                    <th class="py-4 px-6">Nama Bahan</th>
                                    <th class="py-4 px-6">Jenis</th>
                                    <th class="py-4 px-6">Satuan</th>
                                    <th class="py-4 px-6 text-right">Harga</th>
                                    <th class="py-4 px-6 text-right">Volume</th>
                                    <th class="py-4 px-6 text-right">Total</th>
                                    <th class="py-4 px-6 text-center">Aksi</th>
                                 </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($materials as $material)
                                    <tr class="table-row-hover hover:bg-orange-50/30">
                                        <td class="py-4 px-6 font-bold text-navy-800">{{ $material->name }}</td>
                                        <td class="py-4 px-6">
                                            @php
                                                $badgeClass = 'badge-utama';
                                                if($material->type === 'Bahan Pendukung') $badgeClass = 'badge-pendukung';
                                                if($material->type === 'Bahan Lainnya') $badgeClass = 'badge-lainnya';
                                            @endphp
                                            <span class="material-badge {{ $badgeClass }}">
                                                {{ $material->type }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="inline-flex px-3 py-1 rounded-lg bg-navy-50 text-navy-600 text-[10px] font-bold uppercase tracking-wider border border-navy-100">{{ $material->unit }}</span>
                                        </td>
                                        <td class="py-4 px-6 text-right font-mono font-bold text-orange-600">Rp{{ number_format($material->price, 0, ',', '.') }}</td>
                                        <td class="py-4 px-6 text-right font-mono font-bold text-navy-700">{{ number_format($material->purchase_volume, 2, ',', '.') }}</td>
                                        <td class="py-4 px-6 text-right font-mono font-bold text-navy-800">Rp{{ number_format($material->price * $material->purchase_volume, 0, ',', '.') }}</td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex items-center justify-center gap-3">
                                                <a href="{{ route('materials.edit', $material->id) }}" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-black uppercase tracking-wider text-orange-500 hover:text-white hover:bg-orange-500 rounded-lg transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Hapus bahan {{ $material->name }}?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-black uppercase tracking-wider text-red-500 hover:text-white hover:bg-red-500 rounded-lg transition-all">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>