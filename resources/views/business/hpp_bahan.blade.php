{{-- File: product-materials.blade.php --}}
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
            background: linear-gradient(90deg, rgba(254, 243, 199, 0.1) 0%, rgba(255, 247, 237, 0.05) 100%);
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
        
        .success-message {
            animation: slideIn 0.4s ease-out;
        }
        
        .empty-state {
            animation: fadeInUp 0.4s ease-out;
        }
    </style>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-orange-100/20 dark:from-navy-800 dark:via-navy-900 dark:to-navy-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 fade-in-up">
            
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between border-b pb-6 border-orange-500/10 dark:border-orange-500/30">
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
                                <span class="text-navy-900 dark:text-white">Profit</span>
                            </h1>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-300 max-w-2xl">
                                Kelola data bahan baku secara terpusat untuk akurasi perhitungan HPP.
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
                        <span class="text-green-700 dark:text-green-400 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Summary Stats -->
            @if(!$materials->isEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 fade-in-up">
                    <!-- Total Bahan Card -->
                    <div class="stat-card bg-white dark:bg-gradient-to-br dark:from-navy-900 dark:to-navy-950 rounded-3xl shadow-sm border border-orange-200/60 dark:border-orange-500/20 p-6 card-hover transition-all">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-orange-500 dark:text-orange-400 uppercase tracking-[0.2em]">Total Bahan</p>
                                <p class="text-4xl font-black text-slate-900 dark:text-white mt-1">{{ $materials->count() }}</p>
                            </div>
                            <div class="w-14 h-14 bg-orange-100 dark:bg-orange-500/10 rounded-2xl flex items-center justify-center shadow-inner">
                                <svg class="w-7 h-7 text-orange-600 dark:text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Investasi Card -->
                    <div class="stat-card bg-white dark:bg-gradient-to-br dark:from-navy-900 dark:to-navy-950 rounded-3xl shadow-sm border border-blue-200/60 dark:border-blue-500/20 p-6 card-hover transition-all">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-blue-500 dark:text-blue-400 uppercase tracking-[0.2em]">Total Investasi</p>
                                <p class="text-4xl font-black text-blue-700 dark:text-blue-400 mt-1">Rp{{ number_format($materials->sum('price'), 0, ',', '.') }}</p>
                            </div>
                            <div class="w-14 h-14 bg-blue-100 dark:bg-blue-500/10 rounded-2xl flex items-center justify-center shadow-inner">
                                <svg class="w-7 h-7 text-blue-600 dark:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Materials Table Card -->
            <div class="bg-white dark:bg-navy-900 rounded-3xl shadow-sm border border-orange-200/60 dark:border-orange-500/20 overflow-hidden fade-in-up transition-all">
                <div class="bg-orange-50 dark:bg-navy-950 px-6 py-5 flex justify-between items-center border-b border-orange-200/60 dark:border-orange-500/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-navy-900 dark:text-white text-base tracking-wide">Tambah Bahan Baru</h3>
                    </div>
                </div>
                
                <div class="p-8">
                    <form action="{{ route('materials.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Tanggal Pembelian</label>
                                <input type="date" name="purchase_date" value="{{ old('purchase_date', now()->toDateString()) }}" required
                                    class="w-full bg-gray-50 dark:bg-navy-950 border border-orange-100 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white input-focus-ring transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Jenis</label>
                                <select name="type" id="typeSelect" required
                                    class="w-full bg-gray-50 dark:bg-navy-950 border border-orange-100 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white input-focus-ring transition-all">
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="Bahan Utama">Bahan Utama</option>
                                    <option value="Bahan Pendukung">Bahan Pendukung</option>
                                    <option value="Bahan Lainnya">Bahan Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Nama Bahan</label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="materialNameInput" 
                                        placeholder="Ketik atau pilih..."
                                        value="{{ old('name') }}"
                                        autocomplete="off"
                                        class="w-full bg-gray-50 dark:bg-navy-950 border border-orange-100 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white input-focus-ring transition-all peer">
                                    <input type="hidden" name="name" id="materialNameValue" required>
                                    <select 
                                        id="materialNameSelect" 
                                        class="hidden peer-focus:block absolute top-full left-0 right-0 mt-1 bg-white dark:bg-navy-950 border border-orange-100 dark:border-white/10 rounded-xl z-10 max-h-64 overflow-y-auto shadow-2xl">
                                        <option value="">-- Pilih dari daftar --</option>
                                        @foreach($materials->unique('name') as $m)
                                            <option value="{{ $m->name }}" data-type="{{ $m->type }}" data-unit="{{ $m->unit }}">{{ $m->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Warna (opsional)</label>
                                <input type="text" name="color" value="{{ old('color') }}" placeholder="Contoh: Putih, Merah"
                                    class="w-full bg-gray-50 dark:bg-navy-950 border border-orange-100 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white input-focus-ring transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Harga Pembelian</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-bold text-xs">Rp</span>
                                    <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="0.01" required
                                        class="w-full pl-10 bg-gray-50 dark:bg-navy-950 border border-orange-100 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white input-focus-ring transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Volume Beli</label>
                                <input type="number" name="purchase_volume" value="{{ old('purchase_volume', 1) }}" min="0" step="0.01" required
                                    class="w-full bg-gray-50 dark:bg-navy-950 border border-orange-100 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white input-focus-ring transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-orange-500 uppercase tracking-wider mb-2">Satuan</label>
                                <select name="unit" required
                                    class="w-full bg-gray-50 dark:bg-navy-950 border border-orange-100 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white input-focus-ring transition-all">
                                    <option value="">-- Pilih Satuan --</option>
                                    @foreach(['mL','L','gr','kg','buah','pcs','lembar','meter','cm','roll','yard'] as $u)
                                        <option value="{{ $u }}" {{ old('unit') === $u ? 'selected' : '' }}>{{ $u }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="btn-primary w-full flex items-center justify-center gap-2 py-3.5 rounded-xl text-xs font-black uppercase tracking-widest text-white shadow-lg transition-all h-12">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Bahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="h-px bg-orange-100 dark:bg-white/5 mx-8"></div>

                <div class="bg-orange-50 dark:bg-navy-950 px-6 py-5 flex justify-between items-center border-b border-orange-200/60 dark:border-orange-500/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-navy-900 dark:text-white text-base tracking-wide">Master Data Bahan</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-orange-400 uppercase tracking-widest">{{ $materials->count() }} Bahan Terdaftar</span>
                    </div>
                </div>

                @if($materials->isEmpty())
                    <div class="p-16 text-center empty-state">
                        <div class="w-24 h-24 bg-orange-50 dark:bg-navy-950 rounded-full flex items-center justify-center mx-auto mb-6 transition-colors">
                            <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-navy-900 dark:text-white mb-2">Belum Ada Data Bahan</h3>
                        <p class="text-sm text-slate-400 max-w-md mx-auto">
                            Klik tombol "Tambah Bahan Baru" untuk mulai memasukkan database bahan baku Anda.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-orange-50 dark:bg-navy-950 border-b border-orange-200/60 dark:border-orange-500/10 transition-colors">
                                <tr class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-wider">
                                    <th class="py-4 px-6">Bahan</th>
                                    <th class="py-4 px-6">Jenis</th>
                                    <th class="py-4 px-6">Warna</th>
                                    <th class="py-4 px-6 text-right">Harga Beli</th>
                                    <th class="py-4 px-6 text-center">Satuan</th>
                                    <th class="py-4 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-500/10">
                                @foreach($materials as $material)
                                    <tr class="table-row-hover hover:bg-orange-500/5 transition-colors">
                                        <td class="py-4 px-6">
                                            <p class="font-bold text-navy-900 dark:text-white">{{ $material->name }}</p>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="inline-flex px-2 py-1 rounded-lg bg-orange-50 dark:bg-navy-950 text-orange-600 dark:text-orange-400 text-[10px] font-black uppercase tracking-wider border border-orange-500/10">
                                                {{ $material->type }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-3 h-3 rounded-full border border-orange-500/20" style="background-color: {{ $material->color }};"></span>
                                                <span class="text-slate-500 dark:text-slate-400 text-xs">{{ $material->color ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <span class="font-mono font-bold text-navy-900 dark:text-white">Rp{{ number_format($material->price, 0, ',', '.') }}</span>
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500 ml-0.5">/{{ $material->purchase_volume }} {{ $material->unit }}</span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase">{{ $material->unit }}</span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex items-center justify-center gap-3">
                                                <form action="{{ route('materials.destroy', $material->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus bahan ini?');">
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
                    
                    <div class="bg-orange-50 dark:bg-navy-950 px-6 py-4 border-t border-orange-200/60 dark:border-orange-500/10 text-center transition-colors">
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Database Materials v1.2 • Auto-update Active</p>
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const materialNameInput = document.getElementById('materialNameInput');
            const materialNameSelect = document.getElementById('materialNameSelect');
            const materialNameValue = document.getElementById('materialNameValue');
            const typeSelect = document.getElementById('typeSelect');
            const unitSelect = document.querySelector('select[name="unit"]');
            
            // Map of existing materials
            const materialsData = [
                @foreach($materials->unique('name') as $m)
                    {
                        name: '{{ $m->name }}',
                        type: '{{ $m->type }}',
                        unit: '{{ $m->unit }}'
                    },
                @endforeach
            ];

            function findMaterialByName(name) {
                return materialsData.find(m => m.name.toLowerCase() === name.toLowerCase());
            }

            function updateTypeAndUnit(value) {
                const material = findMaterialByName(value);
                if (material) {
                    if (typeSelect) typeSelect.value = material.type;
                    if (unitSelect) unitSelect.value = material.unit;
                }
            }

            if (materialNameInput) {
                materialNameInput.addEventListener('input', function() {
                    const searchValue = this.value.toLowerCase();
                    const options = materialNameSelect.querySelectorAll('option');
                    let visibleCount = 0;
                    
                    options.forEach((option, index) => {
                        if (index === 0) return;
                        const optionText = option.textContent.toLowerCase();
                        const shouldShow = optionText.includes(searchValue) && searchValue !== '';
                        
                        if (shouldShow) {
                            option.style.display = 'block';
                            visibleCount++;
                        } else {
                            option.style.display = 'none';
                        }
                    });
                    
                    if (materialNameValue) materialNameValue.value = this.value;
                    
                    if (this.value && visibleCount > 0) {
                        materialNameSelect.classList.remove('hidden');
                    } else {
                        materialNameSelect.classList.add('hidden');
                    }
                });

                materialNameInput.addEventListener('focus', function() {
                    if (this.value === '') {
                        const options = materialNameSelect.querySelectorAll('option');
                        options.forEach((option, index) => {
                            if (index === 0) return;
                            option.style.display = 'block';
                        });
                        materialNameSelect.classList.remove('hidden');
                    }
                });
            }

            if (materialNameSelect) {
                materialNameSelect.addEventListener('change', function() {
                    if (materialNameInput && this.value) {
                        materialNameInput.value = this.value;
                        materialNameValue.value = this.value;
                        updateTypeAndUnit(this.value);
                        this.classList.add('hidden');
                    }
                });
            }

            document.addEventListener('click', function(e) {
                if (!e.target.closest('#materialNameInput') && !e.target.closest('#materialNameSelect')) {
                    if (materialNameSelect) materialNameSelect.classList.add('hidden');
                }
            });

            const form = document.querySelector('form');
            if (form && materialNameInput && materialNameValue) {
                form.addEventListener('submit', function(e) {
                    materialNameValue.value = materialNameInput.value.trim();
                });
            }
        });
    </script>
</x-app-layout>