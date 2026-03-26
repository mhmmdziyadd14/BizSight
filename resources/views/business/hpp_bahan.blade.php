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
                                <span class="text-gradient-orange">Biz</span>
                                <span class="text-navy-900">Sight</span>
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

            <!-- Add Material Form Card -->
            <div class="mb-10 bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden slide-in">
                <div class="bg-gradient-navy px-8 py-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-black text-white">Tambah Bahan Baku</h2>
                            </div>
                            <p class="text-sm text-orange-200/80 mt-1 ml-12">Simpan bahan di sini agar bisa langsung dipakai saat membuat HPP.</p>
                        </div>
                        <a href="{{ route('materials.index') }}" class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-widest text-orange-300 hover:text-orange-200 transition-colors">
                            Kelola Bahan Lengkap
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="m-6 rounded-2xl border border-green-500/30 bg-green-500/10 backdrop-blur-sm px-6 py-4 success-message">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-green-200 font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('materials.store') }}" method="POST" class="p-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Tanggal Pembelian</label>
                        <input type="date" name="purchase_date" value="{{ old('purchase_date', now()->toDateString()) }}" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Jenis</label>
                        <select name="type" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Bahan Utama" {{ old('type') === 'Bahan Utama' ? 'selected' : '' }}>Bahan Utama</option>
                            <option value="Bahan Pendukung" {{ old('type') === 'Bahan Pendukung' ? 'selected' : '' }}>Bahan Pendukung</option>
                            <option value="Bahan Lainnya" {{ old('type') === 'Bahan Lainnya' ? 'selected' : '' }}>Bahan Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Nama Bahan</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Tepung Terigu"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Warna (opsional)</label>
                        <input type="text" name="color" value="{{ old('color') }}" placeholder="Contoh: Putih, Merah"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Harga Pembelian (Rp)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                            <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="0.01" required
                                class="w-full pl-9 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Volume Beli</label>
                        <input type="number" name="purchase_volume" value="{{ old('purchase_volume', 1) }}" min="0" step="0.01" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Satuan</label>
                        <select name="unit" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all input-focus-ring">
                            <option value="">-- Pilih Satuan --</option>
                            <option value="mL" {{ old('unit') === 'mL' ? 'selected' : '' }}>mL</option>
                            <option value="L" {{ old('unit') === 'L' ? 'selected' : '' }}>L</option>
                            <option value="gr" {{ old('unit') === 'gr' ? 'selected' : '' }}>gr</option>
                            <option value="kg" {{ old('unit') === 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="buah" {{ old('unit') === 'buah' ? 'selected' : '' }}>buah</option>
                            <option value="pcs" {{ old('unit') === 'pcs' ? 'selected' : '' }}>pcs</option>
                            <option value="lembar" {{ old('unit') === 'lembar' ? 'selected' : '' }}>lembar</option>
                            <option value="meter" {{ old('unit') === 'meter' ? 'selected' : '' }}>meter</option>
                            <option value="cm" {{ old('unit') === 'cm' ? 'selected' : '' }}>cm</option>
                            <option value="roll" {{ old('unit') === 'roll' ? 'selected' : '' }}>roll</option>
                            <option value="yard" {{ old('unit') === 'yard' ? 'selected' : '' }}>yard</option>
                        </select>
                    </div>
                    <div class="lg:col-span-3">
                        <button type="submit" class="btn-primary w-full rounded-xl py-3 text-sm font-black uppercase tracking-wider text-white shadow-md flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Bahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Materials List Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden slide-in">
                <div class="bg-gradient-navy px-8 py-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-black text-white">Daftar Bahan</h2>
                            </div>
                            <p class="text-sm text-orange-200/80 mt-1 ml-12">Kelola dan hapus bahan yang sudah tidak digunakan.</p>
                        </div>
                        <a href="{{ route('materials.index') }}" class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-widest text-orange-300 hover:text-orange-200 transition-colors">
                            Lihat daftar lengkap
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
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
                            <thead class="bg-orange-50/70 border-b border-orange-100">
                                <tr class="text-[10px] font-black text-navy-600 uppercase tracking-wider">
                                    <th class="py-4 px-6">Nama</th>
                                    <th class="py-4 px-6">Jenis</th>
                                    <th class="py-4 px-6">Satuan</th>
                                    <th class="py-4 px-6 text-right">Harga</th>
                                    <th class="py-4 px-6 text-right">Volume</th>
                                    <th class="py-4 px-6 text-center">Aksi</th>
                                 </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-50">
                                @foreach($materials as $material)
                                    <tr class="table-row-hover transition-colors">
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
                                            <span class="inline-flex px-2 py-1 rounded-lg bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wider">{{ $material->unit }}</span>
                                        </td>
                                        <td class="py-4 px-6 text-right font-mono font-bold text-navy-700">Rp{{ number_format($material->price, 0, ',', '.') }}</td>
                                        <td class="py-4 px-6 text-right font-mono font-bold text-navy-700">{{ number_format($material->purchase_volume, 2, ',', '.') }}</td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('materials.edit', $material->id) }}" class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-wider text-orange-500 hover:text-orange-600 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Hapus bahan {{ $material->name }}?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-btn inline-flex items-center gap-1 text-xs font-black uppercase tracking-wider text-red-400 hover:text-red-600 transition-colors">
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