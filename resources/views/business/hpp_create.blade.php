{{-- File: hpp-calculator.blade.php --}}
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

        .btn-primary {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid rgba(249, 115, 22, 0.3);
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background: rgba(249, 115, 22, 0.1);
            border-color: rgba(249, 115, 22, 0.5);
        }

        .table-row-hover:hover {
            background: rgba(249, 115, 22, 0.05);
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
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
    </style>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-navy-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 fade-in-up">

            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between border-b border-orange-200/50 pb-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="text-gradient-orange">Kalkulator</span>
                                <span class="text-navy-800">HPP</span>
                            </h1>
                            <p class="mt-2 text-sm text-navy-600 max-w-2xl">
                                Input detail produksi untuk menghitung Harga Pokok Penjualan secara presisi.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    @include('business.partials.back_button')
                </div>
            </div>

            <!-- Main Form -->
            <form action="{{ route('hpp.store') }}" method="POST" id="hppForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    <!-- LEFT SIDE: IDENTITY & SERVICES -->
                    <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-8">

                        <!-- Identity Card -->
                        <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">01</span>
                                </div>
                                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-wider">Identitas Project</h3>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">ID Produk</label>
                                    <input type="text" name="hpp_id"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all"
                                        placeholder="Contoh: BZS-001"
                                        value="{{ old('hpp_id', 'BZS-' . strtoupper(uniqid())) }}">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Nama Produk</label>
                                    <input type="text" name="name" required
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all"
                                        placeholder="Contoh: Kemeja Tactical V1" value="{{ old('name') }}">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Kategori Bisnis</label>
                                    <select name="category"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all">
                                        <option value="Fashion" {{ old('category') === 'Fashion' ? 'selected' : '' }}>Fashion & Apparel</option>
                                        <option value="F&B" {{ old('category') === 'F&B' ? 'selected' : '' }}>Culinary / F&B</option>
                                        <option value="Furniture" {{ old('category') === 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                        <option value="Digital" {{ old('category') === 'Digital' ? 'selected' : '' }}>Digital Product</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Material Calculator Card -->
                        <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-200">
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">02</span>
                                </div>
                                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-wider">Kalkulator Kebutuhan Bahan</h3>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Pilih Bahan</label>
                                    <select id="calcMaterialSelect" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all">
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach($materialsByName as $material)
                                            <option value="{{ json_encode($material) }}" data-unit="{{ $material['unit'] }}" data-name="{{ $material['name'] }}">
                                                {{ $material['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Warna</label>
                                    <select id="calcColorSelect" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all" disabled>
                                        <option value="">-- Pilih Warna --</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Panjang (cm)</label>
                                    <input type="number" id="calcLength" placeholder="0" step="0.01" min="0"
                                        class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all text-center">
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Lebar (cm)</label>
                                    <input type="number" id="calcWidth" placeholder="0" step="0.01" min="0"
                                        class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all text-center">
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">QTY</label>
                                    <input type="number" id="calcQty" placeholder="0" step="0.01" min="0"
                                        class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all text-center">
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Satuan</label>
                                    <select id="calcUnit" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all" disabled>
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
                                </div>

                                <!-- Result Section -->
                                <div class="grid grid-cols-1 gap-2 pt-3 border-t border-gray-200">
                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                                        <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Luas Bahan</div>
                                        <div class="text-lg font-bold text-orange-600" id="calcLuasBahan">0</div>
                                        <div class="text-xs font-semibold text-gray-500">
                                            <span id="calcLuasBahanUnit">-</span>
                                        </div>
                                    </div>

                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                                        <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Kebutuhan</div>
                                        <div class="text-lg font-bold text-orange-600" id="calcKebutuhan">0</div>
                                    </div>

                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                                        <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Hasil</div>
                                        <div class="text-lg font-bold text-orange-600" id="calcResult">0</div>
                                        <div class="text-xs font-semibold text-gray-500">
                                            <span id="calcResultUnit2">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE: MATERIALS TABLE -->
                    <div class="lg:col-span-8">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-gray-200">
                            <!-- Table Header -->
                            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b border-gray-200">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">03</span>
                                    </div>
                                    <h3 class="text-xs font-bold text-navy-800 uppercase tracking-wider">Komponen Material (Bahan Baku)</h3>
                                </div>
                                <button type="button" id="addRow"
                                    class="btn-secondary inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider text-orange-600 hover:text-orange-700 transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Baris
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left" id="materialsTable">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-center w-12">No</th>
                                            <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Jenis</th>
                                            <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Bahan</th>
                                            <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Warna</th>
                                            <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-center">Kebutuhan</th>
                                            <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-right">Harga</th>
                                            <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-right">Volume Beli</th>
                                            <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Satuan</th>
                                            <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-right">Harga Satuan</th>
                                            <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-center w-12">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="material-row table-row-hover transition-colors">
                                            <td class="px-4 py-4 text-center">
                                                <span class="row-number text-sm font-bold text-navy-700">1</span>
                                            </td>
                                            <td class="px-4 py-4">
                                                <span class="type-display text-xs font-semibold text-gray-600">-</span>
                                            </td>
                                            <td class="px-4 py-4">
                                                <select class="material-name-select w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all">
                                                    <option value="">-- Pilih Bahan --</option>
                                                    @foreach($materialsByName as $material)
                                                        <option value="{{ json_encode($material) }}" data-name="{{ $material['name'] }}">{{ $material['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-4">
                                                <select name="material_ids[]"
                                                    class="material-color-select w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all" disabled>
                                                    <option value="">-- Pilih Warna --</option>
                                                </select>
                                            </td>
                                            <td class="px-4 py-4">
                                                <input type="number" step="0.01" name="usage_amounts[]"
                                                    class="usage-input w-20 text-center bg-gray-50 border border-gray-200 rounded-lg px-2 py-2 font-bold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all"
                                                    value="0">
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                <span class="price-display text-sm font-bold text-navy-700">Rp 0</span>
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                <span class="volume-display text-sm font-bold text-navy-700">-</span>
                                            </td>
                                            <td class="px-4 py-4">
                                                <span class="unit-display text-xs font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded-lg">-</span>
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                <span class="unit-price-display text-sm font-bold text-orange-600">Rp 0</span>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <button type="button"
                                                    class="remove-row text-red-400 hover:text-red-600 font-bold text-xl transition-colors"
                                                    aria-label="Hapus baris">×</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary & Pricing Section -->
                            <div class="border-t border-gray-200 px-6 py-6 bg-gray-50">
                                <div class="flex items-center gap-2 mb-6">
                                    <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">04</span>
                                    </div>
                                    <h3 class="text-xs font-bold text-navy-800 uppercase tracking-wider">Perhitungan HPP & Harga Jual</h3>
                                </div>

                                <!-- Total Bahan Baku Display -->
                                <div class="mb-6 p-4 bg-white border border-orange-200 rounded-lg">
                                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Total Bahan Baku</div>
                                    <div class="text-2xl font-bold text-orange-600" id="totalMaterialDisplay">Rp 0</div>
                                </div>

                                <!-- Service Fees Input -->
                                <div class="mb-6">
                                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Biaya Tambahan</h4>
                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                                        <div>
                                            <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Jasa Sablon / Unit</label>
                                            <div class="relative">
                                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                                <input type="number" name="screen_printing_fee"
                                                    class="fee-input w-full pl-9 bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all"
                                                    value="{{ old('screen_printing_fee', 0) }}" min="0" placeholder="0">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Jasa Jahit / Unit</label>
                                            <div class="relative">
                                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                                <input type="number" name="sewing_fee"
                                                    class="fee-input w-full pl-9 bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all"
                                                    value="{{ old('sewing_fee', 0) }}" min="0" placeholder="0">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Biaya Lainnya</label>
                                            <div class="relative">
                                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                                <input type="number" name="other_fees"
                                                    class="fee-input w-full pl-9 bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all"
                                                    value="{{ old('other_fees', 0) }}" min="0" placeholder="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total HPP Display -->
                                <div class="mb-6 p-4 bg-white border border-orange-200 rounded-lg">
                                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Total HPP (Bahan + Biaya)</div>
                                    <div class="text-2xl font-bold text-orange-600" id="totalHppCalculatedDisplay">Rp 0</div>
                                </div>

                                <!-- Target Margin Input -->
                                <div class="mb-6">
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Target Margin (%)</label>
                                    <div class="relative">
                                        <input type="number" name="target_margin_percent" id="targetMarginInput"
                                            class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all text-right"
                                            value="{{ old('target_margin_percent', 50) }}" min="0" max="100" placeholder="50" step="0.01">
                                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                    </div>
                                </div>

                                <!-- Target Margin Amount Display -->
                                <div class="mb-6 p-4 bg-white border border-orange-200 rounded-lg">
                                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Target Margin (Rp)</div>
                                    <div class="text-2xl font-bold text-orange-600" id="targetMarginAmountDisplay">Rp 0</div>
                                </div>

                                <!-- Harga Jual Display -->
                                <div class="mb-6 p-4 bg-gradient-orange rounded-lg">
                                    <div class="text-xs font-bold text-white/80 uppercase tracking-wider mb-2">Harga Jual (Final Price)</div>
                                    <div class="text-3xl font-bold text-white" id="finalPriceDisplay">Rp 0</div>
                                </div>
                            </div>

                            <div class="bg-orange-50 border-t border-gray-200 px-6 py-6 flex flex-col md:flex-row items-center justify-between gap-6">
                                <div>
                                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Estimasi HPP Per Unit</div>
                                    <div class="text-4xl font-bold text-orange-600" id="totalHppDisplay">Rp 0</div>
                                </div>
                                <button type="submit"
                                    class="btn-primary inline-flex items-center gap-2 px-8 py-3 rounded-lg font-bold uppercase tracking-wider text-sm text-white shadow-md hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Perhitungan
                                </button>
                            </div>

                            <!-- Unit Converter Section -->
                            <div class="border-t border-gray-200 px-6 py-6 bg-gray-50">
                                <div class="flex items-center gap-2 mb-6">
                                    <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">05</span>
                                    </div>
                                    <h3 class="text-xs font-bold text-navy-800 uppercase tracking-wider">Kalkulator Konversi Satuan</h3>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                                    <div>
                                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Dari Satuan</label>
                                        <select id="converterFromUnit" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all">
                                            <option value="meter">Meter</option>
                                            <option value="cm">Sentimeter</option>
                                            <option value="kg">Kilogram</option>
                                            <option value="gr">Gram</option>
                                            <option value="L">Liter</option>
                                            <option value="mL">Mililiter</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Nilai</label>
                                        <input type="number" id="converterValue" placeholder="0" step="0.01" min="0"
                                            class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all text-center">
                                    </div>

                                    <div>
                                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Ke Satuan</label>
                                        <select id="converterToUnit" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all">
                                            <option value="cm">Sentimeter</option>
                                            <option value="meter">Meter</option>
                                            <option value="gr">Gram</option>
                                            <option value="kg">Kilogram</option>
                                            <option value="mL">Mililiter</option>
                                            <option value="L">Liter</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4 bg-white border border-orange-200 rounded-lg p-4">
                                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Hasil Konversi</div>
                                    <div class="text-2xl font-bold text-orange-600" id="converterResult">0</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <h3 class="text-sm font-bold text-gray-600">Hasil Perhitungan HPP</h3>
                            <a href="{{ route('hpp.index') }}"
                                class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-widest text-orange-600 hover:text-orange-700 transition-colors">
                                Lihat Daftar HPP
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Perhitungan Live -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableBody = document.querySelector('#materialsTable tbody');
            const totalHppDisplay = document.getElementById('totalHppDisplay');
            const feeInputs = document.querySelectorAll('.fee-input');

            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            }

            function refreshRowNumbers() {
                document.querySelectorAll('.material-row').forEach((row, index) => {
                    const numEl = row.querySelector('.row-number');
                    if (numEl) numEl.innerText = index + 1;
                });
            }

            function calculateTotals() {
                let totalMaterials = 0;

                document.querySelectorAll('.material-row').forEach(row => {
                    const select = row.querySelector('.material-color-select');
                    const usage = parseFloat(row.querySelector('.usage-input').value) || 0;
                    const selected = select.selectedOptions[0];

                    const price = parseFloat(selected?.dataset.price || 0) || 0;
                    const purchaseVolume = parseFloat(selected?.dataset.purchaseVolume || 0) || 0;
                    const materialUnitPrice = purchaseVolume > 0 ? (price / purchaseVolume) : 0;
                    const unitPrice = materialUnitPrice * usage;

                    const subtotal = unitPrice;

                    const priceEl = row.querySelector('.price-display');
                    const volumeEl = row.querySelector('.volume-display');
                    const unitPriceEl = row.querySelector('.unit-price-display');

                    if (priceEl) priceEl.innerText = formatRupiah(price);
                    if (volumeEl) volumeEl.innerText = purchaseVolume > 0 ? purchaseVolume : '-';
                    if (unitPriceEl) unitPriceEl.innerText = formatRupiah(unitPrice);

                    totalMaterials += subtotal;
                });

                let totalFees = 0;
                feeInputs.forEach(input => {
                    totalFees += parseFloat(input.value) || 0;
                });

                const grandTotal = totalMaterials + totalFees;
                
                // Update displays
                const totalMaterialDisplay = document.getElementById('totalMaterialDisplay');
                const totalHppCalculatedDisplay = document.getElementById('totalHppCalculatedDisplay');
                const targetMarginInput = document.getElementById('targetMarginInput');
                const targetMarginAmountDisplay = document.getElementById('targetMarginAmountDisplay');
                const finalPriceDisplay = document.getElementById('finalPriceDisplay');

                if (totalMaterialDisplay) totalMaterialDisplay.innerText = formatRupiah(totalMaterials);
                if (totalHppCalculatedDisplay) totalHppCalculatedDisplay.innerText = formatRupiah(grandTotal);
                
                // Calculate Target Margin Amount
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
                
                totalHppDisplay.innerText = formatRupiah(grandTotal);
            }

            function syncRow(row) {
                const colorSelect = row.querySelector('.material-color-select');
                const selected = colorSelect.selectedOptions[0];

                const typeEl = row.querySelector('.type-display');
                const unitEl = row.querySelector('.unit-display');

                if (!selected || !selected.value) {
                    if (typeEl) typeEl.innerText = '-';
                    if (unitEl) unitEl.innerText = '-';
                } else {
                    if (typeEl) typeEl.innerText = selected.dataset.type || '-';
                    if (unitEl) unitEl.innerText = selected.dataset.unit || '-';
                }

                refreshRowNumbers();
                calculateTotals();
            }

            // Handle material name selection
            tableBody.addEventListener('change', (e) => {
                if (e.target.classList.contains('material-name-select')) {
                    const row = e.target.closest('.material-row');
                    const colorSelect = row.querySelector('.material-color-select');
                    const typeEl = row.querySelector('.type-display');

                    // Reset color dropdown
                    colorSelect.innerHTML = '<option value="">-- Pilih Warna --</option>';
                    colorSelect.disabled = true;
                    if (typeEl) typeEl.innerText = '-';

                    if (e.target.value) {
                        try {
                            const materialData = JSON.parse(e.target.value);
                            
                            // Set type display
                            if (typeEl) typeEl.innerText = materialData.type || '-';

                            // Populate color dropdown
                            materialData.colors.forEach(colorItem => {
                                const option = document.createElement('option');
                                option.value = colorItem.id;
                                option.textContent = colorItem.color;
                                option.setAttribute('data-type', materialData.type);
                                option.setAttribute('data-color', colorItem.color);
                                option.setAttribute('data-unit', materialData.unit);
                                option.setAttribute('data-price', colorItem.price);
                                option.setAttribute('data-purchase-volume', colorItem.purchase_volume || 1);
                                colorSelect.appendChild(option);
                            });

                            colorSelect.disabled = false;
                        } catch (e) {
                            console.error('Error parsing material data:', e);
                        }
                    }
                }
            });

            // Handle color selection
            tableBody.addEventListener('change', (e) => {
                if (e.target.classList.contains('material-color-select')) {
                    syncRow(e.target.closest('.material-row'));
                }
            });

            tableBody.addEventListener('input', (e) => {
                if (e.target.classList.contains('usage-input')) {
                    calculateTotals();
                }
            });

            feeInputs.forEach(input => {
                input.addEventListener('input', calculateTotals);
            });

            // Add event listener for Target Margin percentage input
            const targetMarginInput = document.getElementById('targetMarginInput');
            if (targetMarginInput) {
                targetMarginInput.addEventListener('input', calculateTotals);
            }

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

            document.querySelectorAll('.material-row').forEach((row) => attachRemoveHandler(row));

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

            // Material Calculator Logic
            const calcMaterialSelect = document.getElementById('calcMaterialSelect');
            const calcColorSelect = document.getElementById('calcColorSelect');
            const calcLength = document.getElementById('calcLength');
            const calcWidth = document.getElementById('calcWidth');
            const calcQty = document.getElementById('calcQty');
            const calcUnit = document.getElementById('calcUnit');
            const calcLuasBahan = document.getElementById('calcLuasBahan');
            const calcKebutuhan = document.getElementById('calcKebutuhan');
            const calcResult = document.getElementById('calcResult');
            const calcLuasBahanUnit = document.getElementById('calcLuasBahanUnit');
            const calcResultUnit2 = document.getElementById('calcResultUnit2');

            function performCalculation() {
                const length = parseFloat(calcLength.value) || 0;
                const width = parseFloat(calcWidth.value) || 0;
                const qty = parseFloat(calcQty.value) || 0;
                
                const selectedUnit = calcUnit.value || '-';
                
                const luasBahan = length * width;
                let kebutuhan = 0;
                try {
                    kebutuhan = qty;
                    if (!isFinite(kebutuhan)) {
                        kebutuhan = 0;
                    }
                } catch (e) {
                    kebutuhan = 0;
                }
                
                let hasil = 0;
                try {
                    hasil = luasBahan * qty;
                    if (!isFinite(hasil)) {
                        hasil = 0;
                    }
                } catch (e) {
                    hasil = 0;
                }
                
                calcLuasBahan.innerText = luasBahan > 0 ? luasBahan.toFixed(2) : '0';
                calcKebutuhan.innerText = kebutuhan > 0 ? kebutuhan.toFixed(2) : '0';
                calcResult.innerText = hasil > 0 ? hasil.toFixed(2) : '0';
                
                if (selectedUnit === '-') {
                    calcLuasBahanUnit.innerText = '-';
                    calcResultUnit2.innerText = '-';
                } else {
                    calcLuasBahanUnit.innerText = selectedUnit + '²';
                    calcResultUnit2.innerText = selectedUnit + '²';
                }
            }

            calcMaterialSelect.addEventListener('change', function() {
                calcColorSelect.innerHTML = '<option value="">-- Pilih Warna --</option>';
                calcUnit.disabled = true;
                calcColorSelect.disabled = true;
                calcLuasBahanUnit.innerText = '-';
                calcResultUnit2.innerText = '-';
                
                if (this.value) {
                    try {
                        const materialData = JSON.parse(this.value);
                        const colors = materialData.colors;
                        
                        colors.forEach(function(colorItem) {
                            const option = document.createElement('option');
                            option.value = colorItem.id;
                            option.textContent = colorItem.color;
                            option.setAttribute('data-color', colorItem.color);
                            option.setAttribute('data-price', colorItem.price);
                            calcColorSelect.appendChild(option);
                        });
                        
                        calcColorSelect.disabled = false;
                        calcUnit.disabled = false;
                        calcUnit.value = materialData.unit;
                        
                        performCalculation();
                    } catch (e) {
                        console.error('Error parsing material data:', e);
                    }
                }
            });

            calcColorSelect.addEventListener('change', performCalculation);
            calcLength.addEventListener('input', performCalculation);
            calcWidth.addEventListener('input', performCalculation);
            calcQty.addEventListener('input', performCalculation);
            calcUnit.addEventListener('change', performCalculation);
            
            performCalculation();

            // Unit Converter Logic
            const converterFromUnit = document.getElementById('converterFromUnit');
            const converterToUnit = document.getElementById('converterToUnit');
            const converterValue = document.getElementById('converterValue');
            const converterResult = document.getElementById('converterResult');

            const conversionRates = {
                'meter_cm': 100,
                'cm_meter': 0.01,
                'kg_gr': 1000,
                'gr_kg': 0.001,
                'L_mL': 1000,
                'mL_L': 0.001
            };

            function performConversion() {
                const value = parseFloat(converterValue.value) || 0;
                const fromUnit = converterFromUnit.value;
                const toUnit = converterToUnit.value;

                if (value === 0 || fromUnit === toUnit) {
                    converterResult.innerText = '0';
                    return;
                }

                const key = `${fromUnit}_${toUnit}`;
                const rate = conversionRates[key];

                if (rate) {
                    const result = value * rate;
                    converterResult.innerText = result.toFixed(4);
                } else {
                    converterResult.innerText = '0';
                }
            }

            converterFromUnit.addEventListener('change', performConversion);
            converterToUnit.addEventListener('change', performConversion);
            converterValue.addEventListener('input', performConversion);
        });
    </script>
</x-app-layout>
