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

        .btn-accent {
            background: transparent;
            border: 1px solid rgba(59, 130, 246, 0.3);
            transition: all 0.2s ease;
        }

        .btn-accent:hover {
            background: rgba(59, 130, 246, 0.08);
            border-color: rgba(59, 130, 246, 0.5);
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
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .fade-in-up { animation: fadeInUp 0.5s ease-out; }

        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .calc-card { animation: slideInDown 0.3s ease-out; }
    </style>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-navy-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 fade-in-up">

            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between border-b border-orange-200/50 pb-6">
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
                <div class="space-y-8">

                    <!-- TOP SECTION: IDENTITY + CONVERTER (2 COLUMNS) -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Identity Card -->
                        <div class="bg-white rounded-2xl p-4 shadow-md border border-gray-200">
                            <div class="flex items-center gap-2 mb-5">
                                <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">01</span>
                                </div>
                                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-wider">Identitas Project</h3>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">ID Produk</label>
                                    <input type="text" name="hpp_id"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all"
                                        placeholder="Contoh: BZS-001"
                                        value="{{ old('hpp_id', 'BZS-' . strtoupper(uniqid())) }}">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Nama Produk</label>
                                    <input type="text" name="name" required
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all"
                                        placeholder="Contoh: Kemeja Tactical V1" value="{{ old('name') }}">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Kategori Bisnis</label>
                                    <select name="category"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all">
                                        <option value="Fashion" {{ old('category') === 'Fashion' ? 'selected' : '' }}>Fashion & Apparel</option>
                                        <option value="F&B" {{ old('category') === 'F&B' ? 'selected' : '' }}>Culinary / F&B</option>
                                        <option value="Furniture" {{ old('category') === 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                        <option value="Digital" {{ old('category') === 'Digital' ? 'selected' : '' }}>Digital Product</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Unit Converter Card -->
                        <div class="bg-white rounded-2xl p-4 shadow-md border border-gray-200">
                            <div class="flex items-center gap-2 mb-5">
                                <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">+-</span>
                                </div>
                                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-wider">Konversi Satuan</h3>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Dari Satuan</label>
                                    <select id="converterFromUnit"
                                        class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all">
                                        <option value="meter">Meter</option>
                                        <option value="cm">Sentimeter</option>
                                        <option value="kg">Kilogram</option>
                                        <option value="gr">Gram</option>
                                        <option value="L">Liter</option>
                                        <option value="mL">Mililiter</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Nilai</label>
                                    <input type="number" id="converterValue" placeholder="0" step="0.01" min="0"
                                        class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all text-center">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Ke Satuan</label>
                                    <select id="converterToUnit"
                                        class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all">
                                        <option value="cm">Sentimeter</option>
                                        <option value="meter">Meter</option>
                                        <option value="gr">Gram</option>
                                        <option value="kg">Kilogram</option>
                                        <option value="mL">Mililiter</option>
                                        <option value="L">Liter</option>
                                    </select>
                                </div>
                                <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Hasil Konversi</div>
                                    <div class="text-xl font-bold text-orange-600" id="converterResult">0</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT SECTIONS (FULL WIDTH) -->
                    <div class="space-y-8">

                        <!-- SECTION 02: KALKULATOR KEBUTUHAN BAHAN — multi-card -->
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">02</span>
                                    </div>
                                    <h3 class="text-xs font-bold text-navy-800 uppercase tracking-wider">Kalkulator Kebutuhan Bahan</h3>
                                </div>
                                <button type="button" id="addCalcCard"
                                    class="btn-accent inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider text-blue-600 hover:text-blue-700 transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Card
                                </button>
                            </div>

                            <div class="space-y-4" id="calcCardsContainer">

                                <!-- First Card -->
                                <div class="calc-card bg-white rounded-2xl overflow-hidden shadow-md border border-gray-200">
                                    <div class="bg-gray-50 px-5 py-3 flex justify-between items-center border-b border-gray-200">
                                        <span class="calc-card-label text-xs font-bold text-gray-500 uppercase tracking-wider">Bahan #1</span>
                                        <div class="flex items-center gap-2">
                                            <button type="button"
                                                class="add-calc-row-btn btn-secondary inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider text-orange-600 hover:text-orange-700 transition-all">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Tambah Baris
                                            </button>
                                            <button type="button"
                                                class="remove-calc-card text-red-400 hover:text-red-600 font-bold text-lg transition-colors leading-none px-1"
                                                aria-label="Hapus card">×</button>
                                        </div>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left calc-card-table">
                                            <thead class="bg-gray-50 border-b border-gray-200">
                                                <tr>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-center w-10">No</th>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Deskripsi</th>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Bahan</th>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Warna</th>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-center">Panjang (cm)</th>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-center">Lebar (cm)</th>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-center">QTY</th>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-right">Hasil</th>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-center">Luas Bahan</th>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-right">Kebutuhan</th>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Satuan</th>
                                                    <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider text-center w-10">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 calc-card-tbody">
                                                <tr class="calc-row table-row-hover transition-colors">
                                                    <td class="px-4 py-3 text-center">
                                                        <span class="calc-row-number text-sm font-bold text-navy-700">1</span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <input type="text" class="calc-description-input w-full bg-white border border-gray-200 rounded-lg px-2 py-2 text-xs font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all" placeholder="Deskripsi">
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <select class="calc-material-select w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all">
                                                            <option value="">-- Pilih Bahan --</option>
                                                            @foreach($materialsByName as $material)
                                                                <option value="{{ json_encode($material) }}" data-unit="{{ $material['unit'] }}" data-name="{{ $material['name'] }}">
                                                                    {{ $material['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <select class="calc-color-select w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all" disabled>
                                                            <option value="">-- Pilih Warna --</option>
                                                        </select>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <input type="number" class="calc-length w-full text-center bg-gray-50 border border-gray-200 rounded-lg px-2 py-2 font-bold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all" placeholder="0" step="0.01" min="0">
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <input type="number" class="calc-width w-full text-center bg-gray-50 border border-gray-200 rounded-lg px-2 py-2 font-bold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all" placeholder="0" step="0.01" min="0">
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <input type="number" class="calc-qty-input w-full text-center bg-white border border-gray-200 rounded-lg px-2 py-2 font-bold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all" placeholder="0" step="0.01" min="0">
                                                    </td>
                                                    <td class="px-4 py-3 text-right">
                                                        <span class="calc-hasil-display text-sm font-bold text-orange-600">0</span>
                                                        <span class="calc-hasil-unit text-xs text-gray-500 ml-1">-</span>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <input type="number" class="calc-luas-bahan-input w-full text-center bg-white border border-gray-200 rounded-lg px-2 py-2 font-bold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all" placeholder="0" step="0.01" min="0">
                                                    </td>
                                                    <td class="px-4 py-3 text-right">
                                                        <span class="calc-kebutuhan-display text-sm font-bold text-navy-700">0</span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <select class="calc-unit w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all" disabled>
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
                                                    <td class="px-4 py-3 text-center">
                                                        <button type="button" class="calc-remove-row text-red-400 hover:text-red-600 font-bold text-xl transition-colors" aria-label="Hapus baris">×</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Total Requirement Summary -->
                                    <div class="border-t border-gray-200 px-5 py-4 bg-orange-50">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Total Kebutuhan Card Ini</span>
                                            <span class="calc-card-total-kebutuhan text-lg font-bold text-orange-600">0</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- END FIRST CARD -->

                            </div>
                        </div>

                        <!-- SECTION 03: MATERIALS TABLE -->
                        <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-gray-200">
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

                                <div class="mb-6 p-4 bg-white border border-orange-200 rounded-lg">
                                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Total Bahan Baku</div>
                                    <div class="text-2xl font-bold text-orange-600" id="totalMaterialDisplay">Rp 0</div>
                                </div>

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

                                <div class="mb-6 p-4 bg-white border border-orange-200 rounded-lg">
                                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Total HPP (Bahan + Biaya)</div>
                                    <div class="text-2xl font-bold text-orange-600" id="totalHppCalculatedDisplay">Rp 0</div>
                                </div>

                                <div class="mb-6">
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Target Margin (%)</label>
                                    <div class="relative">
                                        <input type="number" name="target_margin_percent" id="targetMarginInput"
                                            class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-0 transition-all text-right"
                                            value="{{ old('target_margin_percent', 50) }}" min="0" max="100" placeholder="50" step="0.01">
                                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-xs font-bold">%</span>
                                    </div>
                                </div>

                                <div class="mb-6 p-4 bg-white border border-orange-200 rounded-lg">
                                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Target Margin (Rp)</div>
                                    <div class="text-2xl font-bold text-orange-600" id="targetMarginAmountDisplay">Rp 0</div>
                                </div>

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

                    console.log(`calculateTotals row ${rowIdx}: purchaseVolume=${purchaseVolume}, selected?.dataset.purchaseVolume=${selected?.dataset.purchaseVolume}, getAttribute=${selected?.getAttribute('data-purchase-volume')}`);

                    const priceEl = row.querySelector('.price-display');
                    const volumeEl = row.querySelector('.volume-display');
                    const unitPriceEl = row.querySelector('.unit-price-display');

                    if (priceEl) priceEl.innerText = formatRupiah(price);
                    if (volumeEl) {
                        console.log(`calculateTotals updating volume-display: ${purchaseVolume > 0 ? purchaseVolume : '-'}`);
                        volumeEl.innerText = purchaseVolume > 0 ? purchaseVolume : '-';
                    }
                    if (unitPriceEl) unitPriceEl.innerText = formatRupiah(unitPrice);

                    totalMaterials += unitPrice;
                });

                let totalFees = 0;
                feeInputs.forEach(input => { totalFees += parseFloat(input.value) || 0; });

                const grandTotal = totalMaterials + totalFees;

                const totalMaterialDisplay = document.getElementById('totalMaterialDisplay');
                const totalHppCalculatedDisplay = document.getElementById('totalHppCalculatedDisplay');
                const targetMarginInput = document.getElementById('targetMarginInput');
                const targetMarginAmountDisplay = document.getElementById('targetMarginAmountDisplay');
                const finalPriceDisplay = document.getElementById('finalPriceDisplay');

                if (totalMaterialDisplay) totalMaterialDisplay.innerText = formatRupiah(totalMaterials);
                if (totalHppCalculatedDisplay) totalHppCalculatedDisplay.innerText = formatRupiah(grandTotal);

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
                const volumeEl = row.querySelector('.volume-display');

                console.log('syncRow called. Selected option:', selected);
                console.log('Selected data-purchase-volume (raw):', selected?.getAttribute('data-purchase-volume'));
                console.log('Selected dataset.purchaseVolume:', selected?.dataset.purchaseVolume);

                if (!selected || !selected.value) {
                    if (typeEl) typeEl.innerText = '-';
                    if (unitEl) unitEl.innerText = '-';
                    if (volumeEl) volumeEl.innerText = '-';
                } else {
                    if (typeEl) typeEl.innerText = selected.dataset.type || '-';
                    if (unitEl) unitEl.innerText = selected.dataset.unit || '-';
                    if (volumeEl) {
                        const volume = parseFloat(selected.dataset.purchaseVolume || 0);
                        console.log(`syncRow set volume to: ${volume}`);
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
                            console.log('Material Data from backend:', materialData);
                            console.log('Purchase Volume dari materialData:', materialData.purchase_volume);
                            
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
                                console.log(`Setting data-purchase-volume untuk ${colorItem.color}: ${volumeToSet} (materialData=${materialData.purchase_volume}, colorItem=${colorItem.purchase_volume})`);
                                
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
                
                // Parse nilai
                const panjang = lengthInput ? parseFloat(lengthInput.value) : 0;
                const lebar = widthInput ? parseFloat(widthInput.value) : 0;
                const qty = qtyInput ? parseFloat(qtyInput.value) : 0;
                const luasBahan = luasBahanInput ? parseFloat(luasBahanInput.value) : 0;
                const selectedUnit = row.querySelector('.calc-unit').value || '';

                // Hasil = Panjang × Lebar × QTY
                let hasil = 0;
                if (!isNaN(panjang) && !isNaN(lebar) && !isNaN(qty)) {
                    hasil = panjang * lebar * qty;
                    if (!isFinite(hasil) || isNaN(hasil)) {
                        hasil = 0;
                    }
                }
                
                // Kebutuhan = Hasil / Luas Bahan (IFERROR pattern)
                let kebutuhan = 0;
                try {
                    if (!isNaN(luasBahan) && luasBahan > 0) {
                        kebutuhan = hasil / luasBahan;
                        // Validasi hasil bagi
                        if (!isFinite(kebutuhan) || isNaN(kebutuhan)) {
                            kebutuhan = 0;
                        }
                    } else {
                        kebutuhan = 0;
                    }
                } catch (e) {
                    kebutuhan = 0;
                }

                // Update display hasil tanpa trailing zeros
                const hasilDisplay = hasil > 0 ? hasil.toFixed(4).replace(/\.?0+$/, '') : '0';
                row.querySelector('.calc-hasil-display').innerText = hasilDisplay;
                
                // Kebutuhan: pembulatan ke atas (ceiling) ke 2 desimal
                const kebutuhanRounded = kebutuhan > 0 ? Math.ceil(kebutuhan * 100) / 100 : 0;
                row.querySelector('.calc-kebutuhan-display').innerText = kebutuhanRounded > 0 ? kebutuhanRounded.toFixed(2) : '0';

                const unitSuffix = selectedUnit ? selectedUnit : '-';
                row.querySelector('.calc-hasil-unit').innerText = unitSuffix;

                // Update card total kebutuhan
                updateCardTotalKebutuhan(row.closest('.calc-card'));
            }

            function updateCardTotalKebutuhan(card) {
                let totalKebutuhan = 0;
                card.querySelectorAll('.calc-row').forEach(row => {
                    const kebutuhanText = row.querySelector('.calc-kebutuhan-display').innerText;
                    const kebutuhan = parseFloat(kebutuhanText) || 0;
                    if (!isNaN(kebutuhan) && isFinite(kebutuhan)) {
                        totalKebutuhan += kebutuhan;
                    }
                });
                // Pembulatan ke atas total kebutuhan ke 2 desimal
                const totalKebutuhanRounded = totalKebutuhan > 0 ? Math.ceil(totalKebutuhan * 100) / 100 : 0;
                const totalEl = card.querySelector('.calc-card-total-kebutuhan');
                if (totalEl) {
                    totalEl.innerText = totalKebutuhanRounded > 0 ? totalKebutuhanRounded.toFixed(2) : '0';
                }
            }

            function resetCalcRow(row) {
                row.querySelector('.calc-description-input').value = '';
                row.querySelector('.calc-material-select').value = '';
                row.querySelector('.calc-color-select').innerHTML = '<option value="">-- Pilih Warna --</option>';
                row.querySelector('.calc-color-select').disabled = true;
                row.querySelector('.calc-unit').disabled = true;
                row.querySelector('.calc-unit').value = '';
                row.querySelector('.calc-length').value = '';
                row.querySelector('.calc-width').value = '';
                row.querySelector('.calc-qty-input').value = '';
                row.querySelector('.calc-luas-bahan-input').value = '';
                row.querySelector('.calc-hasil-display').innerText = '0';
                row.querySelector('.calc-hasil-unit').innerText = '-';
                row.querySelector('.calc-kebutuhan-display').innerText = '0';
            }

            function attachCalcRowHandlers(row) {
                row.querySelector('.calc-material-select').addEventListener('change', function () {
                    const colorSelect = row.querySelector('.calc-color-select');
                    const unitSelect  = row.querySelector('.calc-unit');
                    colorSelect.innerHTML = '<option value="">-- Pilih Warna --</option>';
                    colorSelect.disabled = true;
                    unitSelect.disabled  = true;
                    unitSelect.value = '';

                    if (this.value) {
                        try {
                            const materialData = JSON.parse(this.value);
                            materialData.colors.forEach(function (colorItem) {
                                const option = document.createElement('option');
                                option.value = colorItem.id;
                                option.textContent = colorItem.color;
                                option.setAttribute('data-color', colorItem.color);
                                option.setAttribute('data-price', colorItem.price);
                                option.setAttribute('data-purchase-volume', materialData.purchase_volume || colorItem.purchase_volume || 1);
                                colorSelect.appendChild(option);
                            });
                            colorSelect.disabled = false;
                            unitSelect.disabled  = false;
                            unitSelect.value = materialData.unit;
                            performCalcRowCalculation(row);
                        } catch (err) { console.error('Error parsing material data:', err); }
                    } else {
                        performCalcRowCalculation(row);
                    }
                });

                row.querySelector('.calc-color-select').addEventListener('change', () => performCalcRowCalculation(row));
                row.querySelector('.calc-length').addEventListener('input', () => performCalcRowCalculation(row));
                row.querySelector('.calc-width').addEventListener('input', () => performCalcRowCalculation(row));
                row.querySelector('.calc-qty-input').addEventListener('input', () => performCalcRowCalculation(row));
                row.querySelector('.calc-luas-bahan-input').addEventListener('input', () => performCalcRowCalculation(row));
                row.querySelector('.calc-unit').addEventListener('change', () => performCalcRowCalculation(row));

                const removeBtn = row.querySelector('.calc-remove-row');
                if (removeBtn) {
                    removeBtn.addEventListener('click', function () {
                        const tbody = row.closest('.calc-card-tbody');
                        const card = row.closest('.calc-card');
                        const rowCount = tbody.querySelectorAll('.calc-row').length;
                        if (rowCount <= 1) {
                            resetCalcRow(row);
                            performCalcRowCalculation(row);
                            return;
                        }
                        row.remove();
                        refreshCalcRowNumbersInCard(tbody);
                        updateCardTotalKebutuhan(card);
                    });
                }
            }

            function attachCalcCardHandlers(card) {
                const tbody = card.querySelector('.calc-card-tbody');

                card.querySelector('.add-calc-row-btn').addEventListener('click', () => {
                    const firstRow = tbody.querySelector('.calc-row');
                    const newRow = firstRow.cloneNode(true);
                    resetCalcRow(newRow);
                    attachCalcRowHandlers(newRow);
                    tbody.appendChild(newRow);
                    refreshCalcRowNumbersInCard(tbody);
                    updateCardTotalKebutuhan(card);
                });

                card.querySelector('.remove-calc-card').addEventListener('click', () => {
                    const cardCount = calcCardsContainer.querySelectorAll('.calc-card').length;
                    if (cardCount <= 1) {
                        // Reset to single empty row
                        tbody.querySelectorAll('.calc-row:not(:first-child)').forEach(r => r.remove());
                        const firstRow = tbody.querySelector('.calc-row');
                        resetCalcRow(firstRow);
                        performCalcRowCalculation(firstRow);
                        refreshCalcRowNumbersInCard(tbody);
                        updateCardTotalKebutuhan(card);
                        return;
                    }
                    card.remove();
                    refreshCalcCardLabels();
                });

                tbody.querySelectorAll('.calc-row').forEach(row => {
                    attachCalcRowHandlers(row);
                    performCalcRowCalculation(row);
                });

                refreshCalcRowNumbersInCard(tbody);
                updateCardTotalKebutuhan(card);
            }

            // Init first card
            calcCardsContainer.querySelectorAll('.calc-card').forEach(card => attachCalcCardHandlers(card));
            refreshCalcCardLabels();

            // Add new card
            document.getElementById('addCalcCard').addEventListener('click', () => {
                const firstCard = calcCardsContainer.querySelector('.calc-card');
                const newCard = firstCard.cloneNode(true);

                // Strip extra rows, keep only first
                newCard.querySelectorAll('.calc-card-tbody .calc-row:not(:first-child)').forEach(r => r.remove());
                resetCalcRow(newCard.querySelector('.calc-row'));

                attachCalcCardHandlers(newCard);
                calcCardsContainer.appendChild(newCard);
                refreshCalcCardLabels();
                newCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            });

            // =============================================
            // Unit Converter
            // =============================================
            const converterFromUnit = document.getElementById('converterFromUnit');
            const converterToUnit   = document.getElementById('converterToUnit');
            const converterValue    = document.getElementById('converterValue');
            const converterResult   = document.getElementById('converterResult');

            const conversionRates = {
                'meter_cm': 100, 'cm_meter': 0.01,
                'kg_gr': 1000,   'gr_kg': 0.001,
                'L_mL': 1000,    'mL_L': 0.001
            };

            function performConversion() {
                const value    = parseFloat(converterValue.value) || 0;
                const fromUnit = converterFromUnit.value;
                const toUnit   = converterToUnit.value;

                if (value === 0 || fromUnit === toUnit) { converterResult.innerText = '0'; return; }

                const key  = `${fromUnit}_${toUnit}`;
                const rate = conversionRates[key];
                converterResult.innerText = rate ? (value * rate).toFixed(4) : '0';
            }

            converterFromUnit.addEventListener('change', performConversion);
            converterToUnit.addEventListener('change',   performConversion);
            converterValue.addEventListener('input',     performConversion);
        });
    </script>
</x-app-layout>