{{-- File: edit-material.blade.php --}}
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
        
        .input-dark {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(249, 115, 22, 0.3);
            transition: all 0.2s ease;
            color: #F1F5F9;
        }
        
        .input-dark:focus {
            border-color: #F97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
            outline: none;
            background: rgba(15, 23, 42, 1);
        }
        
        .input-dark::placeholder {
            color: rgba(241, 245, 249, 0.5);
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
        
        .btn-back {
            transition: all 0.2s ease;
        }
        
        .btn-back:hover {
            transform: translateX(-2px);
            background: #F97316;
            color: white;
            border-color: #F97316;
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
        
        .form-card {
            animation: fadeInUp 0.5s ease-out;
        }
        
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        input[type="number"] {
            -moz-appearance: textfield;
        }
        
        .bg-gradient-navy {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        }
        
        .input-focus-ring:focus {
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
            border-color: #F97316;
            outline: none;
        }
    </style>

    <div class="py-12 bg-gradient-to-br from-orange-50 via-white to-orange-100/20 dark:from-navy-800 dark:via-navy-900 dark:to-navy-950 min-h-screen transition-colors duration-500">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-8 flex items-center justify-between fade-in-up">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-navy-900 dark:text-white tracking-tight">Edit Bahan Baku</h1>
                        <p class="text-xs text-slate-500 dark:text-slate-300 mt-1">Perbarui informasi bahan baku yang tersimpan</p>
                    </div>
                </div>
                <a href="{{ request('from') === 'hpp' ? route('hpp.bahan') . '?embed=1' : route('materials.index') }}" class="btn-back inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-navy-800 border border-orange-500/30 text-orange-500 dark:text-orange-400 rounded-xl font-black text-xs uppercase tracking-wider hover:bg-orange-50 dark:hover:bg-orange-600 hover:text-orange-600 dark:hover:text-white transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 backdrop-blur-sm px-5 py-4 fade-in-up">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-red-400 font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Edit Form Card -->
            <div class="bg-white dark:bg-navy-900 rounded-3xl shadow-xl border border-orange-200 dark:border-orange-500/20 overflow-hidden form-card transition-all">
                <div class="bg-orange-50 dark:bg-navy-950 px-6 py-5 border-b border-orange-200 dark:border-orange-500/10">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <h2 class="font-bold text-navy-900 dark:text-white text-base tracking-wide">Form Edit Material</h2>
                    </div>
                </div>
                
                <form action="{{ route('materials.update', $material->id) }}{{ request('from') ? '?from=' . request('from') : '' }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Tanggal Pembelian</label>
                            <input type="date" name="purchase_date" required value="{{ old('purchase_date', $material->purchase_date) }}" 
                                class="w-full rounded-xl border border-orange-200 dark:border-orange-500/10 bg-gray-50 dark:bg-navy-950 text-navy-800 dark:text-white px-4 py-3 text-sm font-semibold focus:border-orange-500 focus:ring-0 transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Jenis</label>
                            <select name="type" required 
                                class="w-full rounded-xl border border-orange-200 dark:border-orange-500/10 bg-gray-50 dark:bg-navy-950 text-navy-800 dark:text-white px-4 py-3 text-sm font-semibold focus:border-orange-500 focus:ring-0 transition-all">
                                <option value="" class="bg-gray-50 dark:bg-navy-950">-- Pilih Jenis --</option>
                                <option value="Bahan Utama" {{ old('type', $material->type) === 'Bahan Utama' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">Bahan Utama</option>
                                <option value="Bahan Pendukung" {{ old('type', $material->type) === 'Bahan Pendukung' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">Bahan Pendukung</option>
                                <option value="Bahan Lainnya" {{ old('type', $material->type) === 'Bahan Lainnya' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">Bahan Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Nama Bahan</label>
                            <input type="text" name="name" required value="{{ old('name', $material->name) }}" 
                                placeholder="Contoh: Tepung Terigu"
                                class="w-full rounded-xl border border-orange-200 dark:border-orange-500/10 bg-gray-50 dark:bg-navy-950 text-navy-800 dark:text-white px-4 py-3 text-sm font-semibold focus:border-orange-500 focus:ring-0 transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Warna (opsional)</label>
                            <div class="flex gap-2">
                                <input type="text" name="color" value="{{ old('color', $material->color) }}" 
                                    placeholder="Contoh: Putih, Merah"
                                    class="flex-1 rounded-xl border border-orange-200 dark:border-orange-500/10 bg-gray-50 dark:bg-navy-950 text-navy-800 dark:text-white px-4 py-3 text-sm font-semibold focus:border-orange-500 focus:ring-0 transition-all">
                                @if($material->color)
                                    <div class="w-10 h-10 rounded-lg border border-orange-500/20" style="background-color: {{ $material->color }};"></div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Harga Pembelian (Rp)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-xs font-bold">Rp</span>
                                <input type="number" name="price" min="0" step="0.01" required value="{{ old('price', $material->price) }}" 
                                    class="w-full pl-9 rounded-xl border border-orange-200 dark:border-orange-500/10 bg-gray-50 dark:bg-navy-950 text-navy-800 dark:text-white px-4 py-3 text-sm font-semibold focus:border-orange-500 focus:ring-0 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Volume Pembelian</label>
                            <input type="number" name="purchase_volume" min="0" step="0.01" required value="{{ old('purchase_volume', $material->purchase_volume) }}" 
                                class="w-full rounded-xl border border-orange-200 dark:border-orange-500/10 bg-gray-50 dark:bg-navy-950 text-navy-800 dark:text-white px-4 py-3 text-sm font-semibold focus:border-orange-500 focus:ring-0 transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-wider mb-2">Satuan</label>
                            <select name="unit" required 
                                class="w-full rounded-xl border border-orange-200 dark:border-orange-500/10 bg-gray-50 dark:bg-navy-950 text-navy-800 dark:text-white px-4 py-3 text-sm font-semibold focus:border-orange-500 focus:ring-0 transition-all">
                                <option value="" class="bg-gray-50 dark:bg-navy-950">-- Pilih Satuan --</option>
                                <option value="mL" {{ old('unit', $material->unit) === 'mL' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">mL</option>
                                <option value="L" {{ old('unit', $material->unit) === 'L' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">L</option>
                                <option value="gr" {{ old('unit', $material->unit) === 'gr' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">gr</option>
                                <option value="kg" {{ old('unit', $material->unit) === 'kg' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">kg</option>
                                <option value="buah" {{ old('unit', $material->unit) === 'buah' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">buah</option>
                                <option value="pcs" {{ old('unit', $material->unit) === 'pcs' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">pcs</option>
                                <option value="lembar" {{ old('unit', $material->unit) === 'lembar' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">lembar</option>
                                <option value="meter" {{ old('unit', $material->unit) === 'meter' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">meter</option>
                                <option value="cm" {{ old('unit', $material->unit) === 'cm' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">cm</option>
                                <option value="roll" {{ old('unit', $material->unit) === 'roll' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">roll</option>
                                <option value="yard" {{ old('unit', $material->unit) === 'yard' ? 'selected' : '' }} class="bg-gray-50 dark:bg-navy-950">yard</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn-primary w-full flex items-center justify-center gap-2 py-3.5 rounded-xl text-sm font-black uppercase tracking-wider text-white shadow-md transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Perbarui Material
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Card -->
            <div class="mt-6 bg-orange-500/10 rounded-2xl p-4 border border-orange-500/30 fade-in-up transition-all">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-xs font-bold text-orange-500 dark:text-orange-400 uppercase tracking-wider">Informasi</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            Perubahan data bahan akan langsung berdampak pada perhitungan HPP yang menggunakan bahan ini. 
                            Pastikan data yang dimasukkan sudah benar sebelum menyimpan perubahan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>