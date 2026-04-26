{{-- File: hpp-calculator.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .bg-gradient-orange { background: linear-gradient(135deg, #F97316 0%, #EA580C 100%); }
        .text-gradient-orange { background: linear-gradient(135deg, #F97316 0%, #F59E0B 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }

        .btn-primary { background: linear-gradient(135deg, #F97316 0%, #EA580C 100%); transition: all 0.2s ease; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25); }

        .btn-secondary { background: transparent; border: 1px solid rgba(249, 115, 22, 0.3); transition: all 0.2s ease; }
        .btn-secondary:hover { background: rgba(249, 115, 22, 0.1); border-color: rgba(249, 115, 22, 0.5); }

        .btn-accent { background: transparent; border: 1px solid rgba(59, 130, 246, 0.3); transition: all 0.2s ease; }
        .btn-accent:hover { background: rgba(59, 130, 246, 0.08); border-color: rgba(59, 130, 246, 0.5); }

        .table-row-hover:hover { background: rgba(249, 115, 22, 0.05); }
        .dark .table-row-hover:hover { background: rgba(249, 115, 22, 0.1); }

        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in-up { animation: fadeInUp 0.5s ease-out; }

        @keyframes slideInDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
        .calc-card { animation: slideInDown 0.3s ease-out; }
    </style>

    <div class="py-10 bg-gray-50 dark:bg-navy-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 fade-in-up">

            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between border-b border-gray-200 dark:border-white/5 pb-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-black tracking-tight text-navy-900 dark:text-white">
                                <span class="text-gradient-orange">Kalkulator</span> HPP
                            </h1>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-2xl font-medium">
                                Input detail produksi untuk menghitung Harga Pokok Penjualan secara presisi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <form action="{{ route('hpp.store') }}" method="POST" id="hppForm">
                @csrf
                <div class="space-y-8">

                    <!-- TOP SECTION: IDENTITY + CONVERTER (2 COLUMNS) -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Identity Card -->
                        <div class="bg-white dark:bg-navy-900 rounded-2xl p-6 shadow-md border border-gray-200 dark:border-white/5 transition-colors">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">01</span>
                                </div>
                                <h3 class="text-xs font-black text-navy-800 dark:text-gray-300 uppercase tracking-widest">Identitas Project</h3>
                            </div>
                            <div class="space-y-5">
                                <div>
                                    <label class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest block mb-2 ml-1">ID Produk</label>
                                    <input type="text" name="hpp_id"
                                        class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all"
                                        placeholder="Contoh: BZS-001"
                                        value="{{ old('hpp_id', 'BZS-' . strtoupper(uniqid())) }}">
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest block mb-2 ml-1">Nama Produk</label>
                                    <input type="text" name="name" required
                                        class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all"
                                        placeholder="Contoh: Kemeja Tactical V1" value="{{ old('name') }}">
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest block mb-2 ml-1">Kategori Bisnis</label>
                                    <select name="category"
                                        class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                        <option value="Fashion" {{ old('category') === 'Fashion' ? 'selected' : '' }}>Fashion & Apparel</option>
                                        <option value="F&B" {{ old('category') === 'F&B' ? 'selected' : '' }}>Culinary / F&B</option>
                                        <option value="Furniture" {{ old('category') === 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                        <option value="Digital" {{ old('category') === 'Digital' ? 'selected' : '' }}>Digital Product</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Unit Converter Card -->
                        <div class="bg-white dark:bg-navy-900 rounded-2xl p-6 shadow-md border border-gray-200 dark:border-white/5 transition-colors">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">+-</span>
                                </div>
                                <h3 class="text-xs font-black text-navy-800 dark:text-gray-300 uppercase tracking-widest">Konversi Satuan</h3>
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest block mb-2 ml-1">Dari Satuan</label>
                                        <select id="converterFromUnit"
                                            class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                            <option value="meter">Meter</option>
                                            <option value="cm">Sentimeter</option>
                                            <option value="kg">Kilogram</option>
                                            <option value="gr">Gram</option>
                                            <option value="L">Liter</option>
                                            <option value="mL">Mililiter</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest block mb-2 ml-1">Ke Satuan</label>
                                        <select id="converterToUnit"
                                            class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                            <option value="cm">Sentimeter</option>
                                            <option value="meter">Meter</option>
                                            <option value="gr">Gram</option>
                                            <option value="kg">Kilogram</option>
                                            <option value="mL">Mililiter</option>
                                            <option value="L">Liter</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest block mb-2 ml-1">Nilai Input</label>
                                    <input type="number" id="converterValue" placeholder="0" step="0.01" min="0"
                                        class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-4 py-3 text-lg font-black text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all text-center">
                                </div>
                                <div class="bg-orange-50 dark:bg-orange-500/5 border border-orange-200 dark:border-orange-500/20 rounded-2xl p-5 transition-colors">
                                    <div class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-widest mb-2">Hasil Konversi</div>
                                    <div class="text-3xl font-black text-orange-600 dark:text-orange-500" id="converterResult">0</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT SECTIONS (FULL WIDTH) -->
                    <div class="space-y-8">

                        <!-- SECTION 02: KALKULATOR KEBUTUHAN BAHAN — multi-card -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center shadow-md">
                                        <span class="text-white text-xs font-bold">02</span>
                                    </div>
                                    <h3 class="text-sm font-black text-navy-800 dark:text-white uppercase tracking-widest">Kalkulator Kebutuhan Bahan</h3>
                                </div>
                                <button type="button" id="addCalcCard"
                                    class="bg-navy dark:bg-orange-500 text-white inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider hover:shadow-lg transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Card
                                </button>
                            </div>

                            <div class="space-y-6" id="calcCardsContainer">

                                <!-- First Card -->
                                <div class="calc-card bg-white dark:bg-navy-900 rounded-[32px] overflow-hidden shadow-xl border border-gray-100 dark:border-white/5 transition-colors">
                                    <div class="bg-gray-50 dark:bg-navy-950 px-8 py-5 flex justify-between items-center border-b border-gray-100 dark:border-white/5 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                                            <span class="calc-card-label text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Bahan #1</span>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <button type="button"
                                                class="add-calc-row-btn bg-orange-500/10 text-orange-600 dark:text-orange-400 inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-orange-500/20 transition-all border border-orange-500/20">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Tambah Baris
                                            </button>
                                            <button type="button"
                                                class="remove-calc-card text-red-500 hover:text-red-600 font-bold text-2xl transition-colors leading-none"
                                                aria-label="Hapus card">×</button>
                                        </div>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left calc-card-table">
                                            <thead class="bg-gray-50 dark:bg-navy-950/50 border-b border-gray-100 dark:border-white/5">
                                                <tr class="text-[9px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">
                                                    <th class="px-6 py-4 text-center w-12">No</th>
                                                    <th class="px-6 py-4">Deskripsi</th>
                                                    <th class="px-6 py-4">Bahan</th>
                                                    <th class="px-6 py-4">Warna</th>
                                                    <th class="px-6 py-4 text-center">Panjang (cm)</th>
                                                    <th class="px-6 py-4 text-center">Lebar (cm)</th>
                                                    <th class="px-6 py-4 text-center">QTY</th>
                                                    <th class="px-6 py-4 text-right">Hasil</th>
                                                    <th class="px-6 py-4 text-center">Luas Bahan</th>
                                                    <th class="px-6 py-4 text-right">Kebutuhan</th>
                                                    <th class="px-6 py-4">Satuan</th>
                                                    <th class="px-6 py-4 text-center w-12">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-50 dark:divide-white/5 calc-card-tbody">
                                                <tr class="calc-row table-row-hover transition-colors">
                                                    <td class="px-6 py-4 text-center">
                                                        <span class="calc-row-number text-xs font-black text-navy-700 dark:text-gray-400">1</span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <input type="text" class="calc-description-input w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2.5 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" placeholder="Deskripsi">
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <select class="calc-material-select w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2.5 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                                            <option value="">-- Pilih Bahan --</option>
                                                            @foreach($materialsByName as $material)
                                                                <option value="{{ json_encode($material) }}" data-unit="{{ $material['unit'] }}" data-name="{{ $material['name'] }}">
                                                                    {{ $material['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <select class="calc-color-select w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2.5 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" disabled>
                                                            <option value="">-- Pilih Warna --</option>
                                                        </select>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <input type="number" class="calc-length w-full text-center bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-2 py-2.5 font-black text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" placeholder="0" step="0.01" min="0">
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <input type="number" class="calc-width w-full text-center bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-2 py-2.5 font-black text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" placeholder="0" step="0.01" min="0">
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
                                                        <input type="number" class="calc-qty-input w-full text-center bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-2 py-2.5 font-black text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" placeholder="0" step="0.01" min="0">
                                                    </td>
                                                    <td class="px-6 py-4 text-right">
                                                        <span class="calc-hasil-display text-sm font-black text-orange-600 dark:text-orange-500">0</span>
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
                                                        <input type="number" class="calc-luas-bahan-input w-full text-center bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-2 py-2.5 font-black text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" placeholder="0" step="0.01" min="0">
                                                    </td>
                                                    <td class="px-6 py-4 text-right">
                                                        <span class="calc-kebutuhan-display text-sm font-black text-navy-700 dark:text-gray-300">0</span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <select class="calc-unit w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2.5 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" disabled>
                                                            <option value="">-</option>
                                                            <option value="mL">mL</option>
                                                            <option value="L">L</option>
                                                            <option value="gr">gr</option>
                                                            <option value="kg">kg</option>
                                                            <option value="buah">buah</option>
                                                            <option value="pcs">pcs</option>
                                                            <option value="lembar">lembar</option>
                                                            <option value="meter">meter</option>
                                                            <option value="cm">cm</option>
                                                            <option value="roll">roll</option>
                                                            <option value="yard">yard</option>
                                                        </select>
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
                                                        <button type="button" class="calc-remove-row text-red-500 hover:text-red-700 font-bold text-2xl transition-colors" aria-label="Hapus baris">×</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Total Requirement Summary -->
                                    <div class="border-t border-gray-100 dark:border-white/5 px-8 py-5 bg-orange-50/50 dark:bg-orange-500/5 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Estimasi Total Bahan Card Ini</span>
                                            <span class="calc-card-total-kebutuhan text-xl font-black text-orange-600 dark:text-orange-500">Rp 0</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- END FIRST CARD -->

                            </div>
                        </div>

                        <!-- SECTION 03: MATERIALS TABLE -->
                        <div class="bg-white dark:bg-navy-900 rounded-[32px] overflow-hidden shadow-xl border border-gray-100 dark:border-white/5 transition-colors">
                            <div class="bg-gray-50 dark:bg-navy-950 px-8 py-5 flex justify-between items-center border-b border-gray-100 dark:border-white/5 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center shadow-md">
                                        <span class="text-white text-xs font-bold">03</span>
                                    </div>
                                    <h3 class="text-sm font-black text-navy-800 dark:text-white uppercase tracking-widest">Komponen Material (Bahan Baku)</h3>
                                </div>
                                <button type="button" id="addRow"
                                    class="bg-orange-500 text-white inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider hover:shadow-lg transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Baris
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left" id="materialsTable">
                                    <thead class="bg-gray-50 dark:bg-navy-950/50 border-b border-gray-100 dark:border-white/5">
                                        <tr class="text-[9px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">
                                            <th class="px-6 py-4 text-center w-12">No</th>
                                            <th class="px-6 py-4">Jenis</th>
                                            <th class="px-6 py-4">Bahan</th>
                                            <th class="px-6 py-4">Warna</th>
                                            <th class="px-6 py-4 text-center">Kebutuhan</th>
                                            <th class="px-6 py-4 text-right">Harga Beli</th>
                                            <th class="px-6 py-4 text-right">Vol Beli</th>
                                            <th class="px-6 py-4">Satuan</th>
                                            <th class="px-6 py-4 text-right">HPP Bahan</th>
                                            <th class="px-6 py-4 text-center w-12">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50 dark:divide-white/5 bg-white dark:bg-navy-900 transition-colors">
                                        <tr class="material-row table-row-hover transition-colors">
                                            <td class="px-6 py-5 text-center">
                                                <span class="row-number text-xs font-black text-navy-700 dark:text-gray-400">1</span>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="type-display text-[10px] font-black text-gray-500 bg-gray-100 dark:bg-navy-950 px-2 py-1 rounded-lg uppercase tracking-wider">-</span>
                                            </td>
                                            <td class="px-6 py-5">
                                                <select class="material-name-select w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2.5 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                                    <option value="">-- Pilih Bahan --</option>
                                                    @foreach($materialsByName as $material)
                                                        <option value="{{ json_encode($material) }}" data-name="{{ $material['name'] }}">{{ $material['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-6 py-5">
                                                <select name="material_ids[]"
                                                    class="material-color-select w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2.5 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" disabled>
                                                    <option value="">-- Pilih Warna --</option>
                                                </select>
                                            </td>
                                            <td class="px-6 py-5">
                                                <input type="number" step="0.01" name="usage_amounts[]"
                                                    class="usage-input w-20 text-center bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-2 py-2.5 font-black text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all"
                                                    value="0">
                                            </td>
                                            <td class="px-6 py-5 text-right font-mono text-xs font-bold text-navy-700 dark:text-gray-300">
                                                <span class="price-display">Rp 0</span>
                                            </td>
                                            <td class="px-6 py-5 text-right font-mono text-xs font-bold text-navy-700 dark:text-gray-300">
                                                <span class="volume-display">-</span>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="unit-display text-[10px] font-black text-orange-500 uppercase">-</span>
                                            </td>
                                            <td class="px-6 py-5 text-right">
                                                <span class="unit-price-display text-sm font-black text-orange-600 dark:text-orange-500">Rp 0</span>
                                            </td>
                                            <td class="px-6 py-5 text-center">
                                                <button type="button"
                                                    class="remove-row text-red-500 hover:text-red-700 font-bold text-2xl transition-colors"
                                                    aria-label="Hapus baris">×</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary & Pricing Section -->
                            <div class="border-t border-gray-100 dark:border-white/5 px-8 py-8 bg-gray-50 dark:bg-navy-950/50 transition-colors">
                                <div class="flex items-center gap-3 mb-8">
                                    <div class="w-8 h-8 bg-navy dark:bg-orange-500 rounded-lg flex items-center justify-center shadow-md">
                                        <span class="text-white text-xs font-bold">04</span>
                                    </div>
                                    <h3 class="text-sm font-black text-navy-800 dark:text-white uppercase tracking-widest">Perhitungan HPP & Harga Jual</h3>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                                    <!-- Fees Breakdown -->
                                    <div class="space-y-6">
                                        <h4 class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] mb-4">Operational Costs (Per Unit)</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                            <div>
                                                <label class="text-[10px] font-black text-navy-800 dark:text-gray-300 uppercase tracking-widest block mb-2 ml-1">Jasa Sablon</label>
                                                <div class="relative">
                                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                                    <input type="number" name="screen_printing_fee"
                                                        class="fee-input w-full pl-10 bg-white dark:bg-navy-900 border border-gray-200 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all"
                                                        value="{{ old('screen_printing_fee', 0) }}" min="0" placeholder="0">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="text-[10px] font-black text-navy-800 dark:text-gray-300 uppercase tracking-widest block mb-2 ml-1">Jasa Jahit</label>
                                                <div class="relative">
                                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                                    <input type="number" name="sewing_fee"
                                                        class="fee-input w-full pl-10 bg-white dark:bg-navy-900 border border-gray-200 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all"
                                                        value="{{ old('sewing_fee', 0) }}" min="0" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="text-[10px] font-black text-navy-800 dark:text-gray-300 uppercase tracking-widest block mb-2 ml-1">Biaya Lainnya (Aksesoris/Kancing/dll)</label>
                                                <div class="relative">
                                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                                    <input type="number" name="other_fees"
                                                        class="fee-input w-full pl-10 bg-white dark:bg-navy-900 border border-gray-200 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all"
                                                        value="{{ old('other_fees', 0) }}" min="0" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Profit Simulation -->
                                    <div class="bg-white dark:bg-navy-900 p-8 rounded-[32px] border border-gray-100 dark:border-white/5 shadow-sm space-y-6">
                                        <div class="flex justify-between items-center">
                                            <label class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Target Margin (%)</label>
                                            <span class="px-3 py-1 bg-orange-500/10 text-orange-600 dark:text-orange-500 rounded-lg text-lg font-black" id="currentMarginText">50%</span>
                                        </div>
                                        <input type="range" id="targetMarginInput" min="5" max="90" step="5" value="50" class="w-full h-2 bg-gray-200 dark:bg-navy-950 rounded-lg appearance-none cursor-pointer accent-orange-500">
                                        <input type="hidden" name="target_margin_percent" id="targetMarginValueInput" value="50">
                                        
                                        <div class="pt-6 border-t border-gray-100 dark:border-white/5 grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Bahan Baku</p>
                                                <p class="text-base font-bold text-navy-900 dark:text-white" id="totalMaterialDisplay">Rp 0</p>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Target Margin (Rp)</p>
                                                <p class="text-base font-bold text-navy-900 dark:text-white" id="targetMarginAmountDisplay">Rp 0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Final Result Card -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
                                    <div class="bg-white dark:bg-navy-900 p-8 rounded-[32px] border border-gray-100 dark:border-white/5 shadow-sm flex flex-col justify-center">
                                        <div class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] mb-2">Estimasi HPP Final Per Unit</div>
                                        <div class="text-5xl font-black text-orange-600 dark:text-orange-500" id="totalHppDisplay">Rp 0</div>
                                        <p class="text-[10px] font-bold text-gray-400 mt-2 italic">*Total biaya produksi per satu produk</p>
                                    </div>

                                    <div class="bg-gradient-orange p-8 rounded-[32px] shadow-2xl shadow-orange-500/30 flex flex-col justify-center">
                                        <div class="text-[10px] font-black text-white/70 uppercase tracking-[0.2em] mb-2">Harga Jual Rekomendasi (Final)</div>
                                        <div class="text-5xl font-black text-white" id="finalPriceDisplay">Rp 0</div>
                                        <input type="hidden" name="target_selling_price" id="targetSellingPriceInput" value="0">
                                        <div class="mt-4 flex items-center gap-2 text-white/80">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                                            <span class="text-[10px] font-bold uppercase tracking-widest">Optimized for Market Scalability</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-10 flex flex-col md:flex-row items-center justify-between gap-6 bg-navy dark:bg-navy-900 p-8 rounded-[32px] transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-black text-white tracking-tight">Finalisasi Kalkulasi HPP</p>
                                        <p class="text-xs text-gray-400 font-medium">Simpan data ini ke dalam database cloud Anda untuk monitoring berkelanjutan.</p>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="w-full md:w-auto bg-orange-500 hover:bg-orange-600 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-orange-500/20 transition-all active:scale-95">
                                    Simpan & Lihat Hasil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Scripts remain unchanged as per request, just ensuring variables match IDs --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // =============================================
            // Helpers
            // =============================================
            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
            }

            // =============================================
            // Section 03 — Komponen Material (Bahan Baku)
            // =============================================
            const tableBody = document.querySelector('#materialsTable tbody');
            const totalHppDisplay = document.getElementById('totalHppDisplay');
            const feeInputs = document.querySelectorAll('.fee-input');

            function refreshRowNumbers() {
                document.querySelectorAll('.material-row').forEach((row, index) => {
                    const numEl = row.querySelector('.row-number');
                    if (numEl) numEl.innerText = index + 1;
                });
            }

            function calculateTotals() {
                let totalMaterials = 0;

                document.querySelectorAll('.material-row').forEach((row, rowIdx) => {
                    const select = row.querySelector('.material-color-select');
                    const usage = parseFloat(row.querySelector('.usage-input').value) || 0;
                    const selected = select.selectedOptions[0];

                    const price = parseFloat(selected?.dataset.price || 0) || 0;
                    const purchaseVolume = parseFloat(selected?.dataset.purchaseVolume || 0) || 0;
                    const materialUnitPrice = purchaseVolume > 0 ? (price / purchaseVolume) : 0;
                    const unitPrice = materialUnitPrice * usage;

                    const priceEl = row.querySelector('.price-display');
                    const volumeEl = row.querySelector('.volume-display');
                    const unitPriceEl = row.querySelector('.unit-price-display');

                    if (priceEl) priceEl.innerText = formatRupiah(price);
                    if (volumeEl) {
                        volumeEl.innerText = purchaseVolume > 0 ? purchaseVolume : '-';
                    }
                    if (unitPriceEl) unitPriceEl.innerText = formatRupiah(unitPrice);

                    totalMaterials += unitPrice;
                });

                let totalFees = 0;
                feeInputs.forEach(input => { totalFees += parseFloat(input.value) || 0; });

                const grandTotal = totalMaterials + totalFees;

                const totalMaterialDisplay = document.getElementById('totalMaterialDisplay');
                // const totalHppCalculatedDisplay = document.getElementById('totalHppCalculatedDisplay'); // Removed as per new layout structure
                const targetMarginInput = document.getElementById('targetMarginInput');
                const targetMarginAmountDisplay = document.getElementById('targetMarginAmountDisplay');
                const finalPriceDisplay = document.getElementById('finalPriceDisplay');

                if (totalMaterialDisplay) totalMaterialDisplay.innerText = formatRupiah(totalMaterials);
                // if (totalHppCalculatedDisplay) totalHppCalculatedDisplay.innerText = formatRupiah(grandTotal);

                const targetMarginPercent = parseFloat(targetMarginInput?.value || 50) / 100;
                let targetMarginAmount = 0;
                let finalPrice = 0;

                if (targetMarginPercent < 1) {
                    targetMarginAmount = (grandTotal / (1 - targetMarginPercent)) - grandTotal;
                    finalPrice = Math.ceil((grandTotal + targetMarginAmount) / 100) * 100;
                } else {
                    targetMarginAmount = 0;
                    finalPrice = grandTotal;
                }

                if (targetMarginAmountDisplay) targetMarginAmountDisplay.innerText = formatRupiah(targetMarginAmount);
                if (finalPriceDisplay) finalPriceDisplay.innerText = formatRupiah(finalPrice);
                if (document.getElementById('currentMarginText')) document.getElementById('currentMarginText').innerText = (targetMarginInput?.value || 50) + '%';
                
                const targetSellingPriceInput = document.getElementById('targetSellingPriceInput');
                if (targetSellingPriceInput) targetSellingPriceInput.value = finalPrice;

                if (totalHppDisplay) totalHppDisplay.innerText = formatRupiah(grandTotal);
            }

            function syncRow(row) {
                const colorSelect = row.querySelector('.material-color-select');
                const selected = colorSelect.selectedOptions[0];
                const typeEl = row.querySelector('.type-display');
                const unitEl = row.querySelector('.unit-display');
                const volumeEl = row.querySelector('.volume-display');

                if (!selected || !selected.value) {
                    if (typeEl) typeEl.innerText = '-';
                    if (unitEl) unitEl.innerText = '-';
                    if (volumeEl) volumeEl.innerText = '-';
                } else {
                    if (typeEl) typeEl.innerText = selected.dataset.type || '-';
                    if (unitEl) unitEl.innerText = selected.dataset.unit || '-';
                    if (volumeEl) {
                        const volume = parseFloat(selected.dataset.purchaseVolume || 0);
                        volumeEl.innerText = volume > 0 ? volume : '-';
                    }
                }

                refreshRowNumbers();
                calculateTotals();
            }

            tableBody.addEventListener('change', (e) => {
                if (e.target.classList.contains('material-name-select')) {
                    const row = e.target.closest('.material-row');
                    const colorSelect = row.querySelector('.material-color-select');
                    const typeEl = row.querySelector('.type-display');

                    colorSelect.innerHTML = '<option value="">-- Pilih Warna --</option>';
                    colorSelect.disabled = true;
                    if (typeEl) typeEl.innerText = '-';

                    if (e.target.value) {
                        try {
                            const materialData = JSON.parse(e.target.value);
                            if (typeEl) typeEl.innerText = materialData.type || '-';
                            materialData.colors.forEach(colorItem => {
                                const option = document.createElement('option');
                                option.value = colorItem.id;
                                option.textContent = colorItem.color;
                                option.setAttribute('data-type', materialData.type);
                                option.setAttribute('data-color', colorItem.color);
                                option.setAttribute('data-unit', materialData.unit);
                                option.setAttribute('data-price', colorItem.price);
                                
                                const volumeToSet = materialData.purchase_volume || colorItem.purchase_volume || 1;
                                option.setAttribute('data-purchase-volume', volumeToSet);
                                colorSelect.appendChild(option);
                            });
                            colorSelect.disabled = false;
                        } catch (err) { console.error('Error parsing material data:', err); }
                    }
                }
            });

            tableBody.addEventListener('change', (e) => {
                if (e.target.classList.contains('material-color-select')) {
                    syncRow(e.target.closest('.material-row'));
                }
            });

            tableBody.addEventListener('input', (e) => {
                if (e.target.classList.contains('usage-input')) calculateTotals();
            });

            feeInputs.forEach(input => input.addEventListener('input', calculateTotals));

            const targetMarginInput = document.getElementById('targetMarginInput');
            if (targetMarginInput) targetMarginInput.addEventListener('input', calculateTotals);

            function attachRemoveHandler(row) {
                const btn = row.querySelector('.remove-row');
                if (!btn) return;
                btn.addEventListener('click', () => {
                    const rowCount = tableBody.querySelectorAll('.material-row').length;
                    if (rowCount <= 1) {
                        row.querySelector('.material-name-select').value = '';
                        row.querySelector('.material-color-select').value = '';
                        row.querySelector('.material-color-select').disabled = true;
                        row.querySelector('.material-color-select').innerHTML = '<option value="">-- Pilih Warna --</option>';
                        row.querySelector('.type-display').innerText = '-';
                        row.querySelector('.unit-display').innerText = '-';
                        row.querySelector('.usage-input').value = 0;
                        row.querySelector('.price-display').innerText = 'Rp 0';
                        row.querySelector('.volume-display').innerText = '-';
                        row.querySelector('.unit-price-display').innerText = 'Rp 0';
                        calculateTotals();
                        return;
                    }
                    row.remove();
                    refreshRowNumbers();
                    calculateTotals();
                });
            }

            document.querySelectorAll('.material-row').forEach(row => attachRemoveHandler(row));

            document.getElementById('addRow').addEventListener('click', () => {
                const firstRow = tableBody.querySelector('.material-row');
                const newRow = firstRow.cloneNode(true);
                newRow.querySelector('.material-name-select').value = '';
                newRow.querySelector('.material-color-select').value = '';
                newRow.querySelector('.material-color-select').disabled = true;
                newRow.querySelector('.material-color-select').innerHTML = '<option value="">-- Pilih Warna --</option>';
                newRow.querySelector('.type-display').innerText = '-';
                newRow.querySelector('.unit-display').innerText = '-';
                newRow.querySelector('.usage-input').value = 0;
                newRow.querySelector('.price-display').innerText = 'Rp 0';
                newRow.querySelector('.volume-display').innerText = '-';
                newRow.querySelector('.unit-price-display').innerText = 'Rp 0';
                attachRemoveHandler(newRow);
                tableBody.appendChild(newRow);
                refreshRowNumbers();
                calculateTotals();
            });

            refreshRowNumbers();
            calculateTotals();

            // =============================================
            // Section 02 — Kalkulator Kebutuhan Bahan (multi-card)
            // =============================================
            const calcCardsContainer = document.getElementById('calcCardsContainer');

            function refreshCalcCardLabels() {
                calcCardsContainer.querySelectorAll('.calc-card').forEach((card, index) => {
                    const label = card.querySelector('.calc-card-label');
                    if (label) label.innerText = 'Bahan #' + (index + 1);
                });
            }

            function refreshCalcRowNumbersInCard(tbody) {
                tbody.querySelectorAll('.calc-row').forEach((row, index) => {
                    const numEl = row.querySelector('.calc-row-number');
                    if (numEl) numEl.innerText = index + 1;
                });
            }

            function performCalcRowCalculation(row) {
                const lengthInput = row.querySelector('.calc-length');
                const widthInput = row.querySelector('.calc-width');
                const qtyInput = row.querySelector('.calc-qty-input');
                const luasBahanInput = row.querySelector('.calc-luas-bahan-input');
                const panjang = lengthInput ? parseFloat(lengthInput.value) : 0;
                const lebar = widthInput ? parseFloat(widthInput.value) : 0;
                const qty = qtyInput ? parseFloat(qtyInput.value) : 0;
                const luasBahan = luasBahanInput ? parseFloat(luasBahanInput.value) : 0;
                let hasil = 1;
                let hasInput = false;
                if (!isNaN(panjang) && panjang > 0) { hasil *= panjang; hasInput = true; }
                if (!isNaN(lebar) && lebar > 0) { hasil *= lebar; hasInput = true; }
                if (!isNaN(qty) && qty > 0) { hasil *= qty; hasInput = true; }
                if (!hasInput) hasil = 0;
                let kebutuhan = 0;
                if (!isNaN(luasBahan) && luasBahan > 0) {
                    kebutuhan = hasil / luasBahan;
                }
                const hasilEl = row.querySelector('.calc-hasil-display');
                if (hasilEl) hasilEl.innerText = hasil.toFixed(2);
                const kebutuhanEl = row.querySelector('.calc-kebutuhan-display');
                if (kebutuhanEl) kebutuhanEl.innerText = kebutuhan.toFixed(3);
                calculateCardTotal(row.closest('.calc-card'));
            }

            function calculateCardTotal(card) {
                let totalKebutuhan = 0;
                let unit = '';
                card.querySelectorAll('.calc-row').forEach(row => {
                    const materialSelect = row.querySelector('.calc-material-select');
                    const colorSelect = row.querySelector('.calc-color-select');
                    const unitSelect = row.querySelector('.calc-unit');
                    const selectedMaterial = materialSelect.selectedOptions[0];
                    const selectedColor = colorSelect.selectedOptions[0];
                    if (selectedColor && selectedColor.value) {
                        const usage = parseFloat(row.querySelector('.calc-kebutuhan-display').innerText) || 0;
                        const price = parseFloat(selectedColor.dataset.price) || 0;
                        const vol = parseFloat(selectedColor.dataset.purchaseVolume) || 1;
                        totalKebutuhan += (price / vol) * usage;
                        unit = unitSelect.value || '';
                    }
                });
                const totalEl = card.querySelector('.calc-card-total-kebutuhan');
                if (totalEl) totalEl.innerText = formatRupiah(totalKebutuhan);
            }

            calcCardsContainer.addEventListener('input', (e) => {
                if (e.target.classList.contains('calc-length') || e.target.classList.contains('calc-width') || 
                    e.target.classList.contains('calc-qty-input') || e.target.classList.contains('calc-luas-bahan-input')) {
                    performCalcRowCalculation(e.target.closest('.calc-row'));
                }
            });

            calcCardsContainer.addEventListener('change', (e) => {
                if (e.target.classList.contains('calc-material-select')) {
                    const row = e.target.closest('.calc-row');
                    const colorSelect = row.querySelector('.calc-color-select');
                    const unitSelect = row.querySelector('.calc-unit');
                    colorSelect.innerHTML = '<option value="">-- Pilih Warna --</option>';
                    colorSelect.disabled = true;
                    if (e.target.value) {
                        try {
                            const data = JSON.parse(e.target.value);
                            data.colors.forEach(c => {
                                const opt = document.createElement('option');
                                opt.value = c.id;
                                opt.textContent = c.color;
                                opt.dataset.price = c.price;
                                opt.dataset.purchaseVolume = data.purchase_volume || c.purchase_volume || 1;
                                colorSelect.appendChild(opt);
                            });
                            colorSelect.disabled = false;
                            if (unitSelect) unitSelect.value = data.unit;
                        } catch (err) {}
                    }
                }
                if (e.target.classList.contains('calc-color-select')) {
                    performCalcRowCalculation(e.target.closest('.calc-row'));
                }
            });

            function attachCalcRowHandlers(row) {
                row.querySelector('.calc-remove-row').addEventListener('click', () => {
                    const tbody = row.closest('tbody');
                    const card = row.closest('.calc-card');
                    if (tbody.querySelectorAll('.calc-row').length > 1) {
                        row.remove();
                        refreshCalcRowNumbersInCard(tbody);
                        calculateCardTotal(card);
                    }
                });
            }

            document.querySelectorAll('.calc-row').forEach(row => attachCalcRowHandlers(row));

            calcCardsContainer.addEventListener('click', (e) => {
                if (e.target.closest('.add-calc-row-btn')) {
                    const card = e.target.closest('.calc-card');
                    const tbody = card.querySelector('tbody');
                    const firstRow = tbody.querySelector('.calc-row');
                    const newRow = firstRow.cloneNode(true);
                    newRow.querySelectorAll('input').forEach(i => i.value = '');
                    newRow.querySelector('.calc-hasil-display').innerText = '0';
                    newRow.querySelector('.calc-kebutuhan-display').innerText = '0';
                    newRow.querySelector('.calc-color-select').innerHTML = '<option value="">-- Pilih Warna --</option>';
                    newRow.querySelector('.calc-color-select').disabled = true;
                    newRow.querySelector('.calc-material-select').value = '';
                    attachCalcRowHandlers(newRow);
                    tbody.appendChild(newRow);
                    refreshCalcRowNumbersInCard(tbody);
                }
                if (e.target.classList.contains('remove-calc-card')) {
                    if (calcCardsContainer.querySelectorAll('.calc-card').length > 1) {
                        e.target.closest('.calc-card').remove();
                        refreshCalcCardLabels();
                    }
                }
            });

            document.getElementById('addCalcCard').addEventListener('click', () => {
                const firstCard = calcCardsContainer.querySelector('.calc-card');
                const newCard = firstCard.cloneNode(true);
                const tbody = newCard.querySelector('tbody');
                while (tbody.children.length > 1) tbody.removeChild(tbody.lastChild);
                tbody.querySelectorAll('input').forEach(i => i.value = '');
                newCard.querySelector('.calc-card-total-kebutuhan').innerText = 'Rp 0';
                newCard.querySelector('.calc-hasil-display').innerText = '0';
                newCard.querySelector('.calc-kebutuhan-display').innerText = '0';
                newCard.querySelector('.calc-color-select').innerHTML = '<option value="">-- Pilih Warna --</option>';
                newCard.querySelector('.calc-color-select').disabled = true;
                newCard.querySelector('.calc-material-select').value = '';
                newCard.querySelectorAll('.calc-row').forEach(row => attachCalcRowHandlers(row));
                calcCardsContainer.appendChild(newCard);
                refreshCalcCardLabels();
            });

            // =============================================
            // Unit Converter
            // =============================================
            const valInput = document.getElementById('converterValue');
            const fromUnit = document.getElementById('converterFromUnit');
            const toUnit = document.getElementById('converterToUnit');
            const resDisplay = document.getElementById('converterResult');

            function convert() {
                const val = parseFloat(valInput.value) || 0;
                const f = fromUnit.value;
                const t = toUnit.value;
                let res = 0;
                if (f === t) res = val;
                else if (f === 'meter' && t === 'cm') res = val * 100;
                else if (f === 'cm' && t === 'meter') res = val / 100;
                else if (f === 'kg' && t === 'gr') res = val * 1000;
                else if (f === 'gr' && t === 'kg') res = val / 1000;
                else if (f === 'L' && t === 'mL') res = val * 1000;
                else if (f === 'mL' && t === 'L') res = val / 1000;
                resDisplay.innerText = res.toFixed(2);
            }
            valInput.addEventListener('input', convert);
            fromUnit.addEventListener('change', convert);
            toUnit.addEventListener('change', convert);
        });
    </script>
</x-app-layout>