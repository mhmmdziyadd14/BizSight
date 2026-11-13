{{-- File: hpp-calculator.blade.php --}}
<x-app-layout>
    <style>
        * { font-family: 'Outfit', sans-serif; }

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
                                    <label class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest block mb-2 ml-1">Kategori</label>
                                    <select name="category"
                                        class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-4 py-3 text-sm font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                        <option value="Apparel & Clothing" {{ old('category') === 'Apparel & Clothing' ? 'selected' : '' }}>Apparel & Clothing</option>
                                        <option value="Bags & Carry Goods" {{ old('category') === 'Bags & Carry Goods' ? 'selected' : '' }}>Bags & Carry Goods</option>
                                        <option value="Footwear & Headwear" {{ old('category') === 'Footwear & Headwear' ? 'selected' : '' }}>Footwear & Headwear</option>
                                        <option value="Tectical Gear & Accesories" {{ old('category') === 'Tectical Gear & Accesories' ? 'selected' : '' }}>Tectical Gear & Accesories</option>
                                        <option value="Home Textile" {{ old('category') === 'Home Textile' ? 'selected' : '' }}>Home Textile</option>
                                        <option value="Outdoor Gear" {{ old('category') === 'Outdoor Gear' ? 'selected' : '' }}>Outdoor Gear</option>
                                        <option value="Creative Services" {{ old('category') === 'Creative Services' ? 'selected' : '' }}>Creative Services</option>
                                        <option value="Digital Goods" {{ old('category') === 'Digital Goods' ? 'selected' : '' }}>Digital Goods</option>
                                        <option value="Custom order/ CMT" {{ old('category') === 'Custom order/ CMT' ? 'selected' : '' }}>Custom order/ CMT</option>
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
                                            <option value="yard">Yard</option>
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
                                            <option value="yard">Yard</option>
                                            <option value="meter">Meter</option>
                                            <option value="cm">Sentimeter</option>
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

                        <style>
                        /* ========================================================
                           RESPONSIVE SECTION 02 & SECTION 03 (HYBRID DESKTOP/MOBILE)
                           ======================================================== */

                        /* --- Base Form & Bubble Components --- */
                        .calc-dim-box {
                            display: flex !important;
                            align-items: center !important;
                            justify-content: space-between !important;
                            position: relative !important;
                            height: 2.5rem !important; /* 40px */
                            box-sizing: border-box !important;
                        }
                        .calc-dim-box input {
                            flex: 1 1 0% !important;
                            width: 100% !important;
                            min-width: 0 !important;
                        }
                        .calc-unit-hint {
                            user-select: none !important;
                            white-space: nowrap !important;
                        }

                        .mat-usage-box {
                            display: flex !important;
                            align-items: center !important;
                            justify-content: space-between !important;
                            position: relative !important;
                            height: 2.5rem !important; /* 40px */
                            box-sizing: border-box !important;
                        }
                        .mat-usage-box input {
                            flex: 1 1 0% !important;
                            width: 100% !important;
                            min-width: 0 !important;
                        }
                        .mat-mobile-unit {
                            user-select: none !important;
                            white-space: nowrap !important;
                        }

                        /* Currency Input Prefix & Box */
                        .input-currency-box {
                            display: flex !important;
                            align-items: center !important;
                        }
                        .input-currency-prefix {
                            flex-shrink: 0 !important;
                            margin-right: 0.75rem !important;
                            user-select: none !important;
                        }
                        .input-currency-box input {
                            flex: 1 1 0% !important;
                            width: 100% !important;
                        }

                        /* --- SECTION 02: KALKULATOR KEBUTUHAN BAHAN --- */
                        @media (min-width: 1024px) {
                            .calc-mobile-header {
                                display: none !important;
                            }
                            .calc-desktop-delete {
                                display: block !important;
                            }
                            .calc-row {
                                padding-right: 3.5rem !important;
                            }
                            .calc-grid-row-1 {
                                display: grid !important;
                                grid-template-columns: 3.5rem 1fr 1fr 12rem !important;
                                gap: 1rem !important;
                            }
                            .calc-col-no {
                                display: block !important;
                            }
                            .calc-grid-row-2 {
                                display: grid !important;
                                grid-template-columns: 2.2fr 3.8fr !important;
                                gap: 1rem !important;
                                align-items: end !important;
                            }
                            .calc-sub-dimensi {
                                display: grid !important;
                                grid-template-columns: 1fr 1fr 0.8fr !important;
                                gap: 0.75rem !important;
                            }
                            .calc-sub-hasil {
                                display: grid !important;
                                grid-template-columns: 1fr 1fr 1fr 0.8fr !important;
                                gap: 0.75rem !important;
                            }
                            .calc-unit-hint {
                                display: none !important;
                            }
                            .calc-dim-box input {
                                text-align: center !important;
                            }
                        }

                        @media (max-width: 1023px) {
                            .calc-mobile-header {
                                display: flex !important;
                            }
                            .calc-desktop-delete {
                                display: none !important;
                            }
                            .calc-col-no {
                                display: none !important;
                            }
                            .calc-grid-row-1 {
                                display: flex !important;
                                flex-direction: column !important;
                                gap: 0.75rem !important;
                            }
                            .calc-grid-row-2 {
                                display: flex !important;
                                flex-direction: column !important;
                                gap: 0.75rem !important;
                            }
                            .calc-sub-dimensi {
                                display: grid !important;
                                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                                gap: 0.5rem !important;
                                background: rgba(255, 255, 255, 0.03);
                                padding: 0.75rem;
                                border-radius: 0.75rem;
                                border: 1px solid rgba(255, 255, 255, 0.05);
                            }
                            .calc-sub-hasil {
                                display: grid !important;
                                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                                gap: 0.5rem !important;
                                background: rgba(249, 115, 22, 0.05);
                                padding: 0.75rem;
                                border-radius: 0.75rem;
                                border: 1px solid rgba(249, 115, 22, 0.1);
                            }
                            .calc-unit-hint {
                                display: inline-block !important;
                                flex-shrink: 0 !important;
                                margin-left: 0.25rem !important;
                                font-size: 10px !important;
                            }
                            .calc-dim-box input {
                                text-align: right !important;
                                padding-right: 0.25rem !important;
                            }
                        }

                        /* --- SECTION 03: KOMPONEN MATERIAL TABLE --- */
                        @media (min-width: 1024px) {
                            #materialsTable {
                                display: table !important;
                                width: 100% !important;
                            }
                            #materialsTable thead.mat-desktop-thead {
                                display: table-header-group !important;
                            }
                            #materialsTable tbody {
                                display: table-row-group !important;
                                padding: 0 !important;
                            }
                            #materialsTable tr.material-row {
                                display: table-row !important;
                                padding: 0 !important;
                                background: transparent !important;
                                border: none !important;
                                box-shadow: none !important;
                            }
                            #materialsTable td {
                                display: table-cell !important;
                                background: transparent !important;
                                border: none !important;
                                box-shadow: none !important;
                            }
                            #materialsTable td.mat-mobile-header-cell,
                            .mat-mobile-header-cell {
                                display: none !important;
                            }
                            .mat-mobile-label {
                                display: none !important;
                            }
                            .mat-mobile-unit {
                                display: none !important;
                            }
                            .mat-col-no,
                            .mat-col-jenis,
                            .mat-col-satuan,
                            .mat-col-aksi {
                                display: table-cell !important;
                            }
                            .mat-kebutuhan-wrap {
                                display: flex !important;
                                flex-direction: column !important;
                                align-items: center !important;
                                gap: 0.5rem !important;
                            }
                            .mat-usage-box {
                                width: 6rem !important;
                                margin: 0 auto !important;
                            }
                            .mat-usage-box input {
                                text-align: center !important;
                            }
                        }

                        @media (max-width: 1023px) {
                            #materialsTable thead.mat-desktop-thead {
                                display: none !important;
                            }
                            #materialsTable {
                                display: block !important;
                                width: 100% !important;
                            }
                            #materialsTable tbody {
                                display: flex !important;
                                flex-direction: column !important;
                                gap: 1rem !important;
                                padding: 0.5rem 0 !important;
                            }
                            #materialsTable tr.material-row {
                                display: flex !important;
                                flex-direction: column !important;
                                gap: 0.85rem !important;
                                padding: 1.25rem !important;
                                border-radius: 1.25rem !important;
                                background: rgba(15, 23, 42, 0.7) !important;
                                border: 1px solid rgba(255, 255, 255, 0.08) !important;
                                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
                            }
                            #materialsTable td.mat-mobile-header-cell,
                            .mat-mobile-header-cell {
                                display: block !important;
                                padding: 0 !important;
                                border: none !important;
                            }
                            .mat-col-no,
                            .mat-col-jenis,
                            .mat-col-satuan,
                            .mat-col-aksi {
                                display: none !important;
                            }
                            .mat-col-bahan,
                            .mat-col-warna,
                            .mat-col-kebutuhan {
                                display: block !important;
                                padding: 0 !important;
                                width: 100% !important;
                                border: none !important;
                            }
                            .mat-kebutuhan-wrap {
                                display: flex !important;
                                flex-direction: row !important;
                                align-items: center !important;
                                gap: 0.5rem !important;
                            }
                            .mat-col-harga,
                            .mat-col-vol,
                            .mat-col-hpp {
                                display: flex !important;
                                justify-content: space-between !important;
                                align-items: center !important;
                                padding: 0.65rem 1rem !important;
                                border-radius: 0.75rem !important;
                                border: none !important;
                            }
                            .mat-col-harga {
                                background: rgba(255, 255, 255, 0.03) !important;
                                border: 1px solid rgba(255, 255, 255, 0.05) !important;
                            }
                            .mat-col-vol {
                                background: rgba(255, 255, 255, 0.03) !important;
                                border: 1px solid rgba(255, 255, 255, 0.05) !important;
                            }
                            .mat-col-hpp {
                                background: rgba(249, 115, 22, 0.08) !important;
                                border: 1px solid rgba(249, 115, 22, 0.15) !important;
                            }
                            .mat-mobile-label {
                                display: inline-block !important;
                                margin-bottom: 0 !important;
                            }
                            .mat-mobile-unit {
                                display: inline-block !important;
                                flex-shrink: 0 !important;
                                margin-left: 0.35rem !important;
                                font-size: 10px !important;
                            }
                            .mat-usage-box {
                                width: 100% !important;
                            }
                            .mat-usage-box input {
                                text-align: right !important;
                                padding-right: 0.25rem !important;
                            }
                        }
                        </style>

                        <!-- SECTION 02: KALKULATOR KEBUTUHAN BAHAN — multi-card -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-orange rounded-lg flex items-center justify-center shadow-md">
                                        <span class="text-white text-xs font-bold">02</span>
                                    </div>
                                    <h3 class="text-sm font-black text-navy-800 dark:text-white uppercase tracking-widest">Kalkulator Kebutuhan Bahan</h3>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button type="button" class="btn-sync-materials bg-gray-100 dark:bg-navy-800 hover:bg-orange-500 hover:text-white text-navy-800 dark:text-gray-300 inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all" title="Sinkronkan bahan terbaru dari database">
                                        <svg class="sync-materials-icon w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        <span>Sinkron Bahan</span>
                                    </button>
                                    <button type="button" id="addCalcCard"
                                        class="bg-navy-900 dark:bg-orange-500 text-white inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider hover:shadow-lg transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Tambah Card
                                    </button>
                                </div>
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

                                    <div class="calc-card-table px-4 sm:px-8 py-6">
                                        <div class="calc-card-tbody space-y-6">
                                            <div class="calc-row bg-white dark:bg-navy-950 p-5 sm:p-6 rounded-2xl border border-gray-100 dark:border-white/5 relative shadow-sm transition-all mb-4">
                                                <!-- Desktop Delete Button (Hidden on Mobile) -->
                                                <button type="button" class="calc-remove-row calc-desktop-delete absolute top-6 right-6 text-red-500 hover:text-red-700 font-bold text-2xl transition-colors leading-none" aria-label="Hapus baris">×</button>

                                                <!-- Mobile Header (Row Number, Title & Delete Button - Hidden on Desktop) -->
                                                <div class="calc-mobile-header flex items-center justify-between pb-3 mb-4 border-b border-gray-200/70 dark:border-white/5">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-6 h-6 rounded-lg bg-orange-500/10 text-orange-600 dark:text-orange-400 font-black text-xs flex items-center justify-center">
                                                            <span class="calc-row-number">1</span>
                                                        </div>
                                                        <span class="text-xs font-black text-navy-800 dark:text-white uppercase tracking-wider">Potongan / Pola Bahan</span>
                                                    </div>
                                                    <button type="button" class="calc-remove-row text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-500/10 p-1.5 rounded-lg text-lg font-bold transition-all" title="Hapus baris" aria-label="Hapus baris">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>

                                                <!-- Row 1: Identitas Pola -->
                                                <div class="calc-grid-row-1 mb-4">
                                                    <div class="calc-col-no">
                                                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-2">No.</label>
                                                        <div class="h-10 flex items-center justify-center bg-gray-50 dark:bg-navy-900 rounded-xl font-black text-navy-700 dark:text-gray-400">
                                                            <span class="calc-row-number">1</span>
                                                        </div>
                                                    </div>
                                                    <div class="calc-col-desc">
                                                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-2">Deskripsi Pola</label>
                                                        <input type="text" class="calc-description-input w-full bg-gray-50 dark:bg-navy-900 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2.5 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" placeholder="Misal: Badan Depan / Lengan">
                                                    </div>
                                                    <div class="calc-col-bahan">
                                                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-2">Pilih Bahan</label>
                                                        <select class="calc-material-select w-full bg-gray-50 dark:bg-navy-900 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2.5 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                                            <option value="">-- Pilih Bahan --</option>
                                                            @foreach($materialsByName as $material)
                                                                <option value="{{ json_encode($material) }}" data-unit="{{ $material['unit'] }}" data-name="{{ $material['name'] }}">
                                                                    {{ $material['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="calc-col-warna">
                                                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-2">Pilih Warna</label>
                                                        <select class="calc-color-select w-full bg-gray-50 dark:bg-navy-900 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2.5 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" disabled>
                                                            <option value="">-- Pilih Warna --</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Row 2: Dimensi & Hasil -->
                                                <div class="calc-grid-row-2">
                                                    <div class="calc-sub-dimensi">
                                                        <div class="calc-col-p">
                                                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1.5 text-center">Panjang (P)</label>
                                                            <div class="calc-dim-box bg-gray-50 dark:bg-navy-900 border border-gray-200 dark:border-white/10 rounded-xl px-2.5 transition-all focus-within:border-orange-500 focus-within:ring-1 focus-within:ring-orange-500/20">
                                                                <input type="number" onfocus="this.select()" class="calc-length w-full bg-transparent border-0 p-0 text-xs font-black text-navy-800 dark:text-white focus:outline-none focus:ring-0" style="border:none!important;outline:none!important;box-shadow:none!important;background:transparent!important;" placeholder="0" step="0.01" min="0">
                                                                <span class="calc-unit-hint text-[10px] font-bold text-gray-400 dark:text-gray-400 select-none">cm</span>
                                                            </div>
                                                        </div>
                                                        <div class="calc-col-l">
                                                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1.5 text-center">Lebar (L)</label>
                                                            <div class="calc-dim-box bg-gray-50 dark:bg-navy-900 border border-gray-200 dark:border-white/10 rounded-xl px-2.5 transition-all focus-within:border-orange-500 focus-within:ring-1 focus-within:ring-orange-500/20">
                                                                <input type="number" onfocus="this.select()" class="calc-width w-full bg-transparent border-0 p-0 text-xs font-black text-navy-800 dark:text-white focus:outline-none focus:ring-0" style="border:none!important;outline:none!important;box-shadow:none!important;background:transparent!important;" placeholder="0" step="0.01" min="0">
                                                                <span class="calc-unit-hint text-[10px] font-bold text-gray-400 dark:text-gray-400 select-none">cm</span>
                                                            </div>
                                                        </div>
                                                        <div class="calc-col-qty">
                                                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1.5 text-center">Qty Pcs</label>
                                                            <div class="calc-dim-box bg-gray-50 dark:bg-navy-900 border border-gray-200 dark:border-white/10 rounded-xl px-2.5 transition-all focus-within:border-orange-500 focus-within:ring-1 focus-within:ring-orange-500/20">
                                                                <input type="number" onfocus="this.select()" class="calc-qty-input w-full bg-transparent border-0 p-0 text-xs font-black text-navy-800 dark:text-white focus:outline-none focus:ring-0" style="border:none!important;outline:none!important;box-shadow:none!important;background:transparent!important;" placeholder="0" step="0.01" min="0">
                                                                <span class="calc-unit-hint text-[10px] font-bold text-gray-400 dark:text-gray-400 select-none">pcs</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="calc-sub-hasil">
                                                        <div class="calc-col-hasil">
                                                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-2 text-center">Hasil</label>
                                                            <div class="h-10 flex items-center justify-center bg-gray-50 dark:bg-navy-900 rounded-xl px-1">
                                                                <span class="calc-hasil-display text-sm font-black text-orange-600 dark:text-orange-500 truncate">0</span>
                                                            </div>
                                                        </div>
                                                        <div class="calc-col-luas">
                                                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-2 text-center">Lebar Kain (cm)</label>
                                                            <input type="number" onfocus="this.select()" class="calc-luas-bahan-input w-full h-10 text-center bg-gray-50 dark:bg-navy-900 border border-gray-200 dark:border-white/5 rounded-xl px-1 text-xs font-black text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" placeholder="0" step="0.01" min="0">
                                                        </div>
                                                        <div class="calc-col-kebutuhan">
                                                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-2 text-center">Kebutuhan</label>
                                                            <div class="h-10 flex items-center justify-center bg-gray-50 dark:bg-navy-900 rounded-xl px-1">
                                                                <span class="calc-kebutuhan-display text-sm font-black text-navy-700 dark:text-gray-300 truncate">0</span>
                                                            </div>
                                                        </div>
                                                        <div class="calc-col-satuan">
                                                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-2 text-center">Satuan</label>
                                                            <select class="calc-unit w-full h-10 bg-gray-50 dark:bg-navy-900 border border-gray-200 dark:border-white/5 rounded-xl px-1 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all text-center" disabled>
                                                                <option value="">-</option>
                                                                <option value="mL">mL</option>
                                                                <option value="L">L</option>
                                                                <option value="gr">gr</option>
                                                                <option value="kg">kg</option>
                                                                <option value="buah">buah</option>
                                                                <option value="pcs">pcs</option>
                                                                <option value="lembar">lembar</option>
                                                                <option value="meter">m</option>
                                                                <option value="cm">cm</option>
                                                                <option value="roll">roll</option>
                                                                <option value="yard">yard</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Requirement Summary -->
                                    <div class="border-t border-gray-100 dark:border-white/5 px-8 py-5 bg-orange-50/50 dark:bg-orange-500/5 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Estimasi Total Bahan Card Ini</span>
                                            <span class="calc-card-total-kebutuhan text-xl font-black text-orange-600 dark:text-orange-500">0.00</span>
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
                                <div class="flex items-center gap-3">
                                    <button type="button" class="btn-sync-materials bg-gray-100 dark:bg-navy-800 hover:bg-orange-500 hover:text-white text-navy-800 dark:text-gray-300 inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all" title="Sinkronkan bahan terbaru dari database">
                                        <svg class="sync-materials-icon w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        <span>Sinkron Bahan</span>
                                    </button>
                                    <button type="button" id="addRow"
                                        class="bg-orange-500 text-white inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider hover:shadow-lg transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Tambah Baris
                                    </button>
                                </div>
                            </div>

                            <div class="overflow-x-auto custom-scrollbar">
                                <table class="w-full text-left" id="materialsTable">
                                    <thead class="mat-desktop-thead bg-gray-50 dark:bg-navy-950/50 border-b border-gray-100 dark:border-white/5">
                                        <tr class="text-[9px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">
                                            <th class="px-6 py-4 text-center w-12">No</th>
                                            <th class="px-6 py-4">Jenis</th>
                                            <th class="px-6 py-4 min-w-[180px]">Bahan</th>
                                            <th class="px-6 py-4 min-w-[150px]">Warna</th>
                                            <th class="px-6 py-4 text-center min-w-[180px]">Kebutuhan</th>
                                            <th class="px-6 py-4 text-right">Harga Beli</th>
                                            <th class="px-6 py-4 text-center">Vol Beli</th>
                                            <th class="px-6 py-4 text-center">Satuan</th>
                                            <th class="px-6 py-4 text-right">HPP Bahan</th>
                                            <th class="px-6 py-4 text-center w-12">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="materialsBody" class="mat-tbody divide-y divide-gray-50 dark:divide-white/5 bg-white dark:bg-navy-900 transition-colors">
                                        <tr class="material-row table-row-hover transition-colors">
                                            <!-- Mobile Header Cell (Hidden on Desktop) -->
                                            <td colspan="10" class="mat-mobile-header-cell">
                                                <div class="flex items-center justify-between w-full pb-3 border-b border-gray-200/70 dark:border-white/5">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-6 h-6 rounded-lg bg-orange-500/10 text-orange-600 dark:text-orange-400 font-black text-xs flex items-center justify-center">
                                                            <span class="row-number">1</span>
                                                        </div>
                                                        <span class="text-xs font-black text-navy-800 dark:text-white uppercase tracking-wider">Komponen Bahan Baku</span>
                                                        <span class="type-display text-[9px] font-black text-gray-500 dark:text-gray-400 bg-gray-200/80 dark:bg-navy-900 px-2 py-0.5 rounded-md uppercase tracking-wider">-</span>
                                                    </div>
                                                    <button type="button" class="remove-row text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-500/10 p-1.5 rounded-lg text-lg font-bold transition-all" title="Hapus baris" aria-label="Hapus baris">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>
                                            </td>

                                            <!-- Col No (Desktop only) -->
                                            <td class="mat-col-no px-6 py-5 text-center">
                                                <span class="row-number text-xs font-black text-navy-700 dark:text-gray-400">1</span>
                                            </td>

                                            <!-- Col Jenis (Desktop only) -->
                                            <td class="mat-col-jenis px-6 py-5">
                                                <span class="type-display text-[10px] font-black text-gray-500 bg-gray-100 dark:bg-navy-950 px-2 py-1 rounded-lg uppercase tracking-wider whitespace-nowrap">-</span>
                                            </td>

                                            <!-- Col Bahan -->
                                            <td class="mat-col-bahan px-6 py-5">
                                                <label class="mat-mobile-label text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest block mb-1.5 ml-1">Pilih Bahan</label>
                                                <select class="material-name-select w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2.5 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                                    <option value="">-- Pilih Bahan --</option>
                                                    @foreach($materialsByName as $material)
                                                        <option value="{{ json_encode($material) }}" data-name="{{ $material['name'] }}">{{ $material['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <!-- Col Warna -->
                                            <td class="mat-col-warna px-6 py-5">
                                                <label class="mat-mobile-label text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest block mb-1.5 ml-1">Pilihan Warna</label>
                                                <select name="material_ids[]"
                                                    class="material-color-select w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-3 py-2.5 text-xs font-bold text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all" disabled>
                                                    <option value="">-- Pilih Warna --</option>
                                                </select>
                                            </td>

                                            <!-- Col Kebutuhan -->
                                            <td class="mat-col-kebutuhan px-6 py-5">
                                                <label class="mat-mobile-label text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest block mb-1.5 ml-1">Kebutuhan Bahan per Unit</label>
                                                <div class="mat-kebutuhan-wrap w-full">
                                                    <select class="source-card-select w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-2 py-1.5 text-[9px] font-bold text-navy-800 dark:text-gray-400 focus:border-orange-500 focus:ring-0 transition-all">
                                                        <option value="">- Manual -</option>
                                                        <option value="0">Bahan #1</option>
                                                    </select>
                                                    <div class="mat-usage-box bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/10 rounded-xl px-3 py-1.5 transition-all focus-within:border-orange-500">
                                                        <input type="number" step="0.01" name="usage_amounts[]"
                                                            class="usage-input w-full bg-transparent border-0 p-0 text-xs font-black text-navy-800 dark:text-white focus:outline-none focus:ring-0"
                                                            style="border: none !important; outline: none !important; box-shadow: none !important; background: transparent !important;"
                                                            value="" placeholder="0" onfocus="this.select()">
                                                        <span class="unit-display mat-mobile-unit text-[10px] font-black text-orange-500 uppercase select-none">-</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Col Harga Beli -->
                                            <td class="mat-col-harga px-6 py-5 text-right font-bold text-xs text-navy-800 dark:text-gray-200">
                                                <span class="mat-mobile-label text-[9px] font-black text-gray-400 uppercase tracking-widest">Harga Beli</span>
                                                <span class="price-display">Rp 0</span>
                                            </td>

                                            <!-- Col Vol Beli -->
                                            <td class="mat-col-vol px-6 py-5 text-center font-bold text-xs text-navy-800 dark:text-gray-200">
                                                <span class="mat-mobile-label text-[9px] font-black text-gray-400 uppercase tracking-widest">Vol Beli</span>
                                                <span class="volume-display">-</span>
                                            </td>

                                            <!-- Col Satuan (Desktop only) -->
                                            <td class="mat-col-satuan px-6 py-5 text-center">
                                                <span class="unit-display font-black text-xs text-orange-500 uppercase">-</span>
                                            </td>

                                            <!-- Col HPP Bahan -->
                                            <td class="mat-col-hpp px-6 py-5 text-right font-black text-sm text-orange-600 dark:text-orange-500">
                                                <span class="mat-mobile-label text-[9px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-widest">HPP Bahan Ini</span>
                                                <span class="unit-price-display">Rp 0</span>
                                            </td>

                                            <!-- Col Aksi (Desktop only) -->
                                            <td class="mat-col-aksi px-6 py-5 text-center">
                                                <button type="button" class="remove-row text-red-500 hover:text-red-700 font-bold text-xl transition-colors leading-none" aria-label="Hapus baris">×</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary & Pricing Section -->
                            <div class="border-t border-gray-100 dark:border-white/5 px-8 py-8 bg-gray-50 dark:bg-navy-950/50 transition-colors">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 bg-navy-900 dark:bg-orange-500 rounded-lg flex items-center justify-center shadow-md">
                                        <span class="text-white text-xs font-bold">04</span>
                                    </div>
                                    <h3 class="text-sm font-black text-navy-800 dark:text-white uppercase tracking-widest">Perhitungan HPP & Harga Jual</h3>
                                </div>

                                <!-- Mode Selection: Dari Perhitungan Bahan vs HPP Manual Vendor -->
                                <div class="mb-8">
                                    <label class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] block mb-3">Pilih Sumber / Metode HPP</label>
                                    <div class="p-1.5 bg-gray-200/70 dark:bg-navy-950 rounded-2xl inline-flex flex-col sm:flex-row items-center gap-1.5 w-full sm:w-auto border border-gray-200 dark:border-white/5 shadow-inner">
                                        <button type="button" id="btnModeCalculated" class="hpp-calc-mode-btn w-full sm:w-auto py-2.5 px-5 rounded-xl text-xs font-black uppercase tracking-wider transition-all bg-white dark:bg-navy-900 text-orange-600 dark:text-orange-400 shadow-sm flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            <span>1. Hitung Otomatis dari Bahan</span>
                                        </button>
                                        <button type="button" id="btnModeManual" class="hpp-calc-mode-btn w-full sm:w-auto py-2.5 px-5 rounded-xl text-xs font-black uppercase tracking-wider transition-all text-gray-500 hover:text-navy-900 dark:hover:text-white flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <span>2. HPP Sudah Ada (Vendor / Jahit)</span>
                                        </button>
                                    </div>
                                    <input type="hidden" name="calculation_type" id="calculationTypeInput" value="calculated">
                                </div>

                                <!-- Box Input HPP Manual (Tampil jika mode manual aktif) -->
                                <div id="manualHppContainer" class="hidden mb-8 bg-orange-500/10 dark:bg-orange-500/15 p-5 sm:p-6 rounded-3xl border border-orange-500/30 transition-all">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-7 h-7 rounded-xl bg-orange-500 text-white flex items-center justify-center font-black text-xs shadow-md shrink-0">Rp</div>
                                        <label class="text-xs font-black text-navy-900 dark:text-white uppercase tracking-wider">HPP Pokok dari Vendor / Konveksi (Per Unit)</label>
                                    </div>
                                    <p class="text-[11px] text-gray-600 dark:text-gray-300 mb-4 sm:ml-10">Masukkan modal per unit yang sudah Anda dapatkan langsung dari vendor (misal makloon/jahit putus). Tidak perlu merinci potongan bahan jika sudah beli jadi.</p>
                                    <div class="input-currency-box w-full sm:max-w-md sm:ml-10 rounded-2xl bg-white dark:bg-navy-900 border border-orange-300 dark:border-orange-500/30 focus-within:border-orange-500 focus-within:ring-2 focus-within:ring-orange-500/20 shadow-sm transition-all px-4 py-1">
                                        <span class="input-currency-prefix text-sm font-black text-orange-500 select-none mr-3">Rp</span>
                                        <input type="number" name="manual_hpp" id="manualHppInput"
                                            class="w-full bg-transparent input-transparent border-0 focus:ring-0 focus:outline-none p-0 text-lg font-black text-navy-800 dark:text-white py-2"
                                            style="border: none !important; outline: none !important; box-shadow: none !important; background-color: transparent !important; -webkit-appearance: none !important; -webkit-text-fill-color: currentColor !important;"
                                            value="{{ old('manual_hpp') }}" min="0" placeholder="0" onfocus="this.select()">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                                    <!-- Fees Breakdown -->
                                    <div class="space-y-6">
                                        <h4 class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] mb-4">Operational Costs (Per Unit)</h4>
                                        <div>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <!-- Biaya Jahit (Mode 1 / Calculated) -->
                                                <div id="sewingFeeContainer">
                                                    <label class="text-[10px] font-black text-navy-800 dark:text-gray-300 uppercase tracking-widest block mb-2 ml-1">Biaya Jahit</label>
                                                    <div class="input-currency-box rounded-xl bg-white dark:bg-navy-900 border border-gray-200 dark:border-white/10 focus-within:border-orange-500 focus-within:ring-2 focus-within:ring-orange-500/20 shadow-sm transition-all px-4 py-0.5">
                                                        <span class="input-currency-prefix text-xs font-bold text-gray-400 select-none mr-3">Rp</span>
                                                        <input type="number" name="sewing_fee" id="sewingFeeInput"
                                                            class="fee-input w-full bg-transparent input-transparent border-0 focus:ring-0 focus:outline-none p-0 text-sm font-bold text-navy-800 dark:text-white py-2.5"
                                                            style="border: none !important; outline: none !important; box-shadow: none !important; background-color: transparent !important; -webkit-appearance: none !important; -webkit-text-fill-color: currentColor !important;"
                                                            value="{{ old('sewing_fee') }}" min="0" placeholder="0" onfocus="this.select()">
                                                    </div>
                                                    <p class="text-[9px] text-gray-400 mt-1.5 ml-1">Ongkos jahit / CMT per unit.</p>
                                                </div>

                                                <!-- Biaya Branding (Mode 1 & Mode 2) -->
                                                <div id="brandingFeeContainer">
                                                    <label class="text-[10px] font-black text-navy-800 dark:text-gray-300 uppercase tracking-widest block mb-2 ml-1">Biaya Branding</label>
                                                    <div class="input-currency-box rounded-xl bg-white dark:bg-navy-900 border border-gray-200 dark:border-white/10 focus-within:border-orange-500 focus-within:ring-2 focus-within:ring-orange-500/20 shadow-sm transition-all px-4 py-0.5">
                                                        <span class="input-currency-prefix text-xs font-bold text-gray-400 select-none mr-3">Rp</span>
                                                        <input type="number" name="branding_fee" id="brandingFeeInput"
                                                            class="fee-input w-full bg-transparent input-transparent border-0 focus:ring-0 focus:outline-none p-0 text-sm font-bold text-navy-800 dark:text-white py-2.5"
                                                            style="border: none !important; outline: none !important; box-shadow: none !important; background-color: transparent !important; -webkit-appearance: none !important; -webkit-text-fill-color: currentColor !important;"
                                                            value="{{ old('branding_fee', old('screen_printing_fee')) }}" min="0" placeholder="0" onfocus="this.select()">
                                                    </div>
                                                    <p class="text-[9px] text-gray-400 mt-1.5 ml-1">Mencakup sablon, bordir, dtf, etc.</p>
                                                </div>
                                            </div>

                                            <div class="mt-4 border-t border-gray-100 dark:border-white/5 pt-6">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <div class="w-5 h-5 bg-navy-800 dark:bg-gray-700 text-white rounded-full flex items-center justify-center text-[10px] font-bold">2</div>
                                                    <label class="text-xs font-black text-navy-800 dark:text-gray-300 uppercase tracking-widest">OVERHEAD INTELLIGENCE</label>
                                                </div>
                                                <p class="text-[10px] text-gray-500 mb-4">Pilih estimasi overhead per unit</p>
                                                
                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                                    <button type="button" class="overhead-btn border border-gray-200 dark:border-white/5 rounded-xl p-3 text-center transition-all bg-white dark:bg-navy-950" data-pct="0.10">
                                                        <div class="flex justify-center mb-1"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
                                                        <div class="text-lg font-black text-navy-800 dark:text-white overhead-pct-text">10%</div>
                                                        <div class="text-[9px] text-gray-500 overhead-desc-text">High Efficiency<br>(High Volume)</div>
                                                    </button>
                                                    <button type="button" class="overhead-btn border border-gray-200 dark:border-white/5 rounded-xl p-3 text-center transition-all bg-white dark:bg-navy-950" data-pct="0.15">
                                                        <div class="flex justify-center mb-1"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg></div>
                                                        <div class="text-lg font-black text-navy-800 dark:text-white overhead-pct-text">15%</div>
                                                        <div class="text-[9px] text-gray-500 overhead-desc-text">Lean<br>Operation</div>
                                                    </button>
                                                    <button type="button" class="overhead-btn border border-orange-500 rounded-xl p-3 text-center transition-all bg-orange-50 dark:bg-orange-500/10 active-overhead relative" data-pct="0.25">
                                                        <div class="text-lg font-black text-orange-600 dark:text-orange-500 overhead-pct-text">25%</div>
                                                        <div class="text-[9px] text-orange-500 overhead-desc-text">Recommended</div>
                                                    </button>
                                                    <button type="button" class="overhead-btn border border-gray-200 dark:border-white/5 rounded-xl p-3 text-center transition-all bg-white dark:bg-navy-950" data-pct="0.35">
                                                        <div class="flex justify-center mb-1"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></div>
                                                        <div class="text-lg font-black text-navy-800 dark:text-white overhead-pct-text">35%</div>
                                                        <div class="text-[9px] text-gray-500 overhead-desc-text">Early Stage<br>(Inefficiencies)</div>
                                                    </button>
                                                </div>

                                                <div class="bg-orange-50 dark:bg-orange-500/5 rounded-xl p-3 mb-4 flex gap-3 items-start border border-orange-100 dark:border-orange-500/20">
                                                    <svg class="w-4 h-4 text-orange-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <p class="text-[9px] text-gray-600 dark:text-gray-400">Overhead mencakup biaya listrik, bahan pendukung kecil, tenaga kerja tidak langsung, maintenance, dll.</p>
                                                </div>

                                                <div class="flex justify-between items-center border-t border-gray-100 dark:border-white/5 pt-4">
                                                    <span class="text-[10px] font-black text-navy-800 dark:text-gray-300 uppercase tracking-widest">OVERHEAD PER UNIT</span>
                                                    <div class="text-right">
                                                        <div class="text-xl font-black text-orange-600 dark:text-orange-500" id="overheadAmountDisplay">Rp 0</div>
                                                        <div class="text-[10px] font-bold text-gray-400 mt-1" id="overheadCalculationDetail">(25% × Rp 0)</div>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="other_fees" id="overheadInput" value="0" class="fee-input">
                                                <input type="hidden" id="overheadPctInput" value="0.25">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Profit Simulation -->
                                    <div class="bg-white dark:bg-navy-900 p-8 rounded-[32px] border border-gray-100 dark:border-white/5 shadow-sm space-y-6">
                                        <div class="flex justify-between items-center">
                                            <label class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em]">Target Margin (%)</label>
                                        </div>
                                        <div class="relative">
                                            <input type="number" id="targetMarginInput" min="0" max="100" step="1" value="" placeholder="50" onfocus="this.select()" class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-white/5 rounded-xl px-4 py-3 text-lg font-black text-navy-800 dark:text-white focus:border-orange-500 focus:ring-0 transition-all text-center">
                                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">%</span>
                                        </div>
                                        <input type="hidden" name="target_margin_percent" id="targetMarginValueInput" value="50">
                                        
                                        <div class="pt-6 border-t border-gray-100 dark:border-white/5 grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1" id="baseCostLabel">Bahan Baku</p>
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

                            <div class="mt-10 flex flex-col md:flex-row items-center justify-between gap-6 bg-navy-900 dark:bg-navy-900 p-8 rounded-[32px] transition-colors">
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
            // Calculation Mode (Hitung dari Bahan vs HPP Manual Vendor)
            // =============================================
            const btnModeCalculated = document.getElementById('btnModeCalculated');
            const btnModeManual = document.getElementById('btnModeManual');
            const calculationTypeInput = document.getElementById('calculationTypeInput');
            const manualHppContainer = document.getElementById('manualHppContainer');
            const manualHppInput = document.getElementById('manualHppInput');
            const sewingFeeContainer = document.getElementById('sewingFeeContainer');
            const sewingFeeInput = document.getElementById('sewingFeeInput');
            const brandingFeeContainer = document.getElementById('brandingFeeContainer');
            const brandingFeeInput = document.getElementById('brandingFeeInput');
            const baseCostLabel = document.getElementById('baseCostLabel');

            function setCalculationMode(mode) {
                if (!calculationTypeInput) return;
                calculationTypeInput.value = mode;

                if (mode === 'manual') {
                    if (btnModeManual) {
                        btnModeManual.className = 'hpp-calc-mode-btn w-full sm:w-auto py-2.5 px-5 rounded-xl text-xs font-black uppercase tracking-wider transition-all bg-white dark:bg-navy-900 text-orange-600 dark:text-orange-400 shadow-sm flex items-center justify-center gap-2';
                    }
                    if (btnModeCalculated) {
                        btnModeCalculated.className = 'hpp-calc-mode-btn w-full sm:w-auto py-2.5 px-5 rounded-xl text-xs font-black uppercase tracking-wider transition-all text-gray-500 hover:text-navy-900 dark:hover:text-white flex items-center justify-center gap-2';
                    }
                    if (manualHppContainer) {
                        manualHppContainer.classList.remove('hidden');
                    }
                    if (sewingFeeContainer) {
                        sewingFeeContainer.classList.add('hidden');
                    }
                    if (baseCostLabel) {
                        baseCostLabel.innerText = 'HPP Vendor (Manual)';
                    }
                } else {
                    if (btnModeCalculated) {
                        btnModeCalculated.className = 'hpp-calc-mode-btn w-full sm:w-auto py-2.5 px-5 rounded-xl text-xs font-black uppercase tracking-wider transition-all bg-white dark:bg-navy-900 text-orange-600 dark:text-orange-400 shadow-sm flex items-center justify-center gap-2';
                    }
                    if (btnModeManual) {
                        btnModeManual.className = 'hpp-calc-mode-btn w-full sm:w-auto py-2.5 px-5 rounded-xl text-xs font-black uppercase tracking-wider transition-all text-gray-500 hover:text-navy-900 dark:hover:text-white flex items-center justify-center gap-2';
                    }
                    if (manualHppContainer) {
                        manualHppContainer.classList.add('hidden');
                    }
                    if (sewingFeeContainer) {
                        sewingFeeContainer.classList.remove('hidden');
                    }
                    if (baseCostLabel) {
                        baseCostLabel.innerText = 'Bahan Baku';
                    }
                }
                calculateTotals();
            }

            if (btnModeCalculated) {
                btnModeCalculated.addEventListener('click', () => setCalculationMode('calculated'));
            }
            if (btnModeManual) {
                btnModeManual.addEventListener('click', () => setCalculationMode('manual'));
            }
            if (manualHppInput) {
                manualHppInput.addEventListener('input', calculateTotals);
            }
            if (sewingFeeInput) {
                sewingFeeInput.addEventListener('input', calculateTotals);
            }
            if (brandingFeeInput) {
                brandingFeeInput.addEventListener('input', calculateTotals);
            }

            // =============================================
            // Section 03 — Komponen Material (Bahan Baku)
            // =============================================
            const tableBody = document.getElementById('materialsBody') || document.querySelector('#materialsTable tbody') || document.getElementById('materialsTable');
            const totalHppDisplay = document.getElementById('totalHppDisplay');
            const feeInputs = document.querySelectorAll('.fee-input');

            function refreshRowNumbers() {
                document.querySelectorAll('.material-row').forEach((row, index) => {
                    row.querySelectorAll('.row-number').forEach(numEl => {
                        numEl.innerText = index + 1;
                    });
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

                const calcType = calculationTypeInput ? calculationTypeInput.value : 'calculated';
                const isManual = (calcType === 'manual');
                let baseCost = 0;
                let operationalFees = 0;

                if (isManual) {
                    baseCost = parseFloat(manualHppInput?.value) || 0;
                    operationalFees = parseFloat(brandingFeeInput?.value) || 0;
                } else {
                    baseCost = totalMaterials;
                    const brandingFee = parseFloat(brandingFeeInput?.value) || 0;
                    const sewingFee = parseFloat(sewingFeeInput?.value) || 0;
                    operationalFees = brandingFee + sewingFee;
                }

                const baseHpp = baseCost + operationalFees;
                
                const overheadPctInput = document.getElementById('overheadPctInput');
                let overheadAmount = 0;
                if (overheadPctInput) {
                    const overheadPct = parseFloat(overheadPctInput.value) || 0;
                    overheadAmount = baseHpp * overheadPct;
                    const overheadInput = document.getElementById('overheadInput');
                    if (overheadInput) overheadInput.value = overheadAmount;
                    
                    const overheadDisplay = document.getElementById('overheadAmountDisplay');
                    if (overheadDisplay) overheadDisplay.innerText = formatRupiah(overheadAmount);
                    
                    const overheadDetail = document.getElementById('overheadCalculationDetail');
                    if (overheadDetail) overheadDetail.innerText = `(${(overheadPct * 100)}% × ${formatRupiah(baseHpp)})`;
                }

                const grandTotal = baseCost + operationalFees + overheadAmount;

                const totalMaterialDisplay = document.getElementById('totalMaterialDisplay');
                const targetMarginInput = document.getElementById('targetMarginInput');
                const targetMarginAmountDisplay = document.getElementById('targetMarginAmountDisplay');
                const finalPriceDisplay = document.getElementById('finalPriceDisplay');

                if (totalMaterialDisplay) totalMaterialDisplay.innerText = formatRupiah(baseCost);

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
                
                const targetMarginValueInput = document.getElementById('targetMarginValueInput');
                if (targetMarginValueInput) targetMarginValueInput.value = targetMarginInput?.value || 50;
                
                const targetSellingPriceInput = document.getElementById('targetSellingPriceInput');
                if (targetSellingPriceInput) targetSellingPriceInput.value = finalPrice;

                if (totalHppDisplay) totalHppDisplay.innerText = formatRupiah(grandTotal);
            }
            function syncRow(row) {
                const colorSelect = row.querySelector('.material-color-select');
                const selected = colorSelect.selectedOptions[0];
                const typeEls = row.querySelectorAll('.type-display');
                const unitEls = row.querySelectorAll('.unit-display');
                const volumeEls = row.querySelectorAll('.volume-display');

                if (!selected || !selected.value) {
                    unitEls.forEach(el => el.innerText = '-');
                    volumeEls.forEach(el => el.innerText = '-');
                } else {
                    const typeText = selected.getAttribute('data-type') || selected.dataset.type || '-';
                    typeEls.forEach(el => el.innerText = typeText);
                    const unitText = selected.getAttribute('data-unit') || selected.dataset.unit || '-';
                    unitEls.forEach(el => el.innerText = unitText);
                    const volume = parseFloat(selected.getAttribute('data-purchase-volume') || selected.dataset.purchaseVolume || 0);
                    volumeEls.forEach(el => el.innerText = volume > 0 ? volume : '-');
                }

                refreshRowNumbers();
                calculateTotals();
            }

            tableBody.addEventListener('change', (e) => {
                if (e.target.classList.contains('material-name-select')) {
                    const row = e.target.closest('.material-row');
                    const colorSelect = row.querySelector('.material-color-select');
                    const typeEls = row.querySelectorAll('.type-display');
                    const unitEls = row.querySelectorAll('.unit-display');
                    const volumeEls = row.querySelectorAll('.volume-display');

                    colorSelect.innerHTML = '<option value="">-- Pilih Warna --</option>';
                    colorSelect.disabled = true;
                    typeEls.forEach(el => el.innerText = '-');
                    unitEls.forEach(el => el.innerText = '-');
                    volumeEls.forEach(el => el.innerText = '-');

                    if (e.target.value) {
                        try {
                            const materialData = JSON.parse(e.target.value);
                            typeEls.forEach(el => el.innerText = materialData.type || '-');
                            unitEls.forEach(el => el.innerText = materialData.unit || '-');
                            
                            materialData.colors.forEach(colorItem => {
                                const option = document.createElement('option');
                                option.value = colorItem.id;
                                option.textContent = colorItem.color ? colorItem.color : 'Tanpa Warna';
                                
                                const typeVal = colorItem.type || materialData.type || '-';
                                const unitVal = colorItem.unit || materialData.unit || '-';
                                const volumeVal = colorItem.purchase_volume || materialData.purchase_volume || 1;

                                option.setAttribute('data-type', typeVal);
                                option.dataset.type = typeVal;
                                option.setAttribute('data-color', colorItem.color || 'Tanpa Warna');
                                option.dataset.color = colorItem.color || 'Tanpa Warna';
                                option.setAttribute('data-unit', unitVal);
                                option.dataset.unit = unitVal;
                                option.setAttribute('data-price', colorItem.price);
                                option.dataset.price = colorItem.price;
                                option.setAttribute('data-purchase-volume', volumeVal);
                                option.dataset.purchaseVolume = volumeVal;
                                colorSelect.appendChild(option);
                            });
                            colorSelect.disabled = false;

                            if (materialData.colors.length === 1) {
                                colorSelect.selectedIndex = 1;
                                syncRow(row);
                            } else {
                                calculateTotals();
                            }
                        } catch (err) { console.error('Error parsing material data:', err); }
                    } else {
                        calculateTotals();
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

            document.querySelectorAll('.overhead-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const target = e.currentTarget;
                    document.querySelectorAll('.overhead-btn').forEach(b => {
                        b.classList.remove('border-orange-500', 'bg-orange-50', 'dark:bg-orange-500/10', 'active-overhead');
                        b.classList.add('border-gray-200', 'dark:border-white/5', 'bg-white', 'dark:bg-navy-950');
                        
                        const pctText = b.querySelector('.overhead-pct-text');
                        if(pctText) {
                            pctText.classList.remove('text-orange-600', 'dark:text-orange-500');
                            pctText.classList.add('text-navy-800', 'dark:text-white');
                        }
                        
                        const descText = b.querySelector('.overhead-desc-text');
                        if(descText) {
                            descText.classList.remove('text-orange-500');
                            descText.classList.add('text-gray-500');
                        }
                    });
                    
                    target.classList.remove('border-gray-200', 'dark:border-white/5', 'bg-white', 'dark:bg-navy-950');
                    target.classList.add('border-orange-500', 'bg-orange-50', 'dark:bg-orange-500/10', 'active-overhead');
                    
                    const tgtPctText = target.querySelector('.overhead-pct-text');
                    if(tgtPctText) {
                        tgtPctText.classList.remove('text-navy-800', 'dark:text-white');
                        tgtPctText.classList.add('text-orange-600', 'dark:text-orange-500');
                    }
                    
                    const tgtDescText = target.querySelector('.overhead-desc-text');
                    if(tgtDescText) {
                        tgtDescText.classList.remove('text-gray-500');
                        tgtDescText.classList.add('text-orange-500');
                    }
                    
                    document.getElementById('overheadPctInput').value = target.dataset.pct;
                    calculateTotals();
                });
            });

            function refreshCardSelects() {
                const cards = document.querySelectorAll('.calc-card');
                document.querySelectorAll('.source-card-select').forEach(select => {
                    const currentVal = select.value;
                    select.innerHTML = '<option value="">- Manual -</option>';
                    cards.forEach((card, idx) => {
                        const opt = document.createElement('option');
                        opt.value = idx;
                        opt.text = 'Bahan #' + (idx + 1);
                        select.appendChild(opt);
                    });
                    if (currentVal && select.querySelector(`option[value="${currentVal}"]`)) {
                        select.value = currentVal;
                    }
                });
            }

            tableBody.addEventListener('change', (e) => {
                if (e.target.classList.contains('source-card-select')) {
                    const cardIndex = e.target.value;
                    if (cardIndex !== "") {
                        const card = document.querySelectorAll('.calc-card')[cardIndex];
                        if (card) {
                            const totalEl = card.querySelector('.calc-card-total-kebutuhan');
                            const val = parseFloat(totalEl.innerText) || 0;
                            const row = e.target.closest('.material-row');
                            row.querySelector('.usage-input').value = val.toFixed(2);
                            calculateTotals();
                        }
                    }
                }
            });

            function attachRemoveHandler(row) {
                row.querySelectorAll('.remove-row').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const rowCount = tableBody.querySelectorAll('.material-row').length;
                        if (rowCount <= 1) {
                            row.querySelector('.material-name-select').value = '';
                            row.querySelector('.material-color-select').value = '';
                            row.querySelector('.material-color-select').disabled = true;
                            row.querySelector('.material-color-select').innerHTML = '<option value="">-- Pilih Warna --</option>';
                            row.querySelectorAll('.type-display').forEach(el => el.innerText = '-');
                            row.querySelectorAll('.unit-display').forEach(el => el.innerText = '-');
                            row.querySelector('.usage-input').value = '';
                            row.querySelectorAll('.price-display').forEach(el => el.innerText = 'Rp 0');
                            row.querySelectorAll('.volume-display').forEach(el => el.innerText = '-');
                            row.querySelectorAll('.unit-price-display').forEach(el => el.innerText = 'Rp 0');
                            calculateTotals();
                            return;
                        }
                        row.remove();
                        refreshRowNumbers();
                        calculateTotals();
                    });
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
                newRow.querySelectorAll('.type-display').forEach(el => el.innerText = '-');
                newRow.querySelectorAll('.unit-display').forEach(el => el.innerText = '-');
                newRow.querySelector('.usage-input').value = '';
                newRow.querySelectorAll('.price-display').forEach(el => el.innerText = 'Rp 0');
                newRow.querySelectorAll('.volume-display').forEach(el => el.innerText = '-');
                newRow.querySelectorAll('.unit-price-display').forEach(el => el.innerText = 'Rp 0');
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
                    row.querySelectorAll('.calc-row-number').forEach(numEl => {
                        numEl.innerText = index + 1;
                    });
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
                        totalKebutuhan += usage;
                        unit = unitSelect.value || '';
                    }
                });
                const totalEl = card.querySelector('.calc-card-total-kebutuhan');
                if (totalEl) totalEl.innerText = totalKebutuhan.toFixed(2);

                const cardIndex = Array.from(document.querySelectorAll('.calc-card')).indexOf(card);
                document.querySelectorAll('.material-row').forEach(row => {
                    const sourceSelect = row.querySelector('.source-card-select');
                    if (sourceSelect && sourceSelect.value === String(cardIndex)) {
                        const usageInput = row.querySelector('.usage-input');
                        if (usageInput) {
                            usageInput.value = totalKebutuhan.toFixed(2);
                            calculateTotals();
                        }
                    }
                });
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
                                opt.textContent = c.color ? c.color : 'Tanpa Warna';
                                opt.setAttribute('data-price', c.price);
                                opt.dataset.price = c.price;
                                const volumeToSet = c.purchase_volume || data.purchase_volume || 1;
                                opt.setAttribute('data-purchase-volume', volumeToSet);
                                opt.dataset.purchaseVolume = volumeToSet;
                                const unitToSet = c.unit || data.unit || '';
                                opt.setAttribute('data-unit', unitToSet);
                                opt.dataset.unit = unitToSet;
                                colorSelect.appendChild(opt);
                            });
                            colorSelect.disabled = false;
                            if (unitSelect) unitSelect.value = data.unit;

                            if (data.colors.length === 1) {
                                colorSelect.selectedIndex = 1;
                                if (unitSelect && data.colors[0].unit) {
                                    unitSelect.value = data.colors[0].unit;
                                }
                                performCalcRowCalculation(row);
                            }
                        } catch (err) {}
                    }
                }
                if (e.target.classList.contains('calc-color-select')) {
                    const row = e.target.closest('.calc-row');
                    const selected = e.target.selectedOptions[0];
                    const unitSelect = row.querySelector('.calc-unit');
                    if (selected && unitSelect) {
                        const u = selected.getAttribute('data-unit') || selected.dataset.unit;
                        if (u) unitSelect.value = u;
                    }
                    performCalcRowCalculation(row);
                }
            });

            function attachCalcRowHandlers(row) {
                row.querySelectorAll('.calc-remove-row').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const tbody = row.closest('.calc-card-tbody');
                        const card = row.closest('.calc-card');
                        if (tbody.querySelectorAll('.calc-row').length > 1) {
                            row.remove();
                            refreshCalcRowNumbersInCard(tbody);
                            calculateCardTotal(card);
                        }
                    });
                });
            }

            document.querySelectorAll('.calc-row').forEach(row => attachCalcRowHandlers(row));

            calcCardsContainer.addEventListener('click', (e) => {
                if (e.target.closest('.add-calc-row-btn')) {
                    const card = e.target.closest('.calc-card');
                    const tbody = card.querySelector('.calc-card-tbody');
                    const firstRow = tbody.querySelector('.calc-row');
                    const newRow = firstRow.cloneNode(true);
                    newRow.querySelectorAll('input').forEach(i => i.value = '');
                    newRow.querySelectorAll('.calc-hasil-display').forEach(el => el.innerText = '0');
                    newRow.querySelectorAll('.calc-kebutuhan-display').forEach(el => el.innerText = '0');
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
                const tbody = newCard.querySelector('.calc-card-tbody');
                while (tbody.children.length > 1) tbody.removeChild(tbody.lastChild);
                tbody.querySelectorAll('input').forEach(i => i.value = '');
                newCard.querySelector('.calc-card-total-kebutuhan').innerText = '0.00';
                newCard.querySelectorAll('.calc-hasil-display').forEach(el => el.innerText = '0');
                newCard.querySelectorAll('.calc-kebutuhan-display').forEach(el => el.innerText = '0');
                newCard.querySelector('.calc-color-select').innerHTML = '<option value="">-- Pilih Warna --</option>';
                newCard.querySelector('.calc-color-select').disabled = true;
                newCard.querySelector('.calc-material-select').value = '';
                newCard.querySelectorAll('.calc-row').forEach(row => attachCalcRowHandlers(row));
                calcCardsContainer.appendChild(newCard);
                refreshCalcCardLabels();
                refreshCardSelects();
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
                else if (f === 'meter' && t === 'yard') res = val / 0.9144;
                else if (f === 'yard' && t === 'meter') res = val * 0.9144;
                else if (f === 'yard' && t === 'cm') res = val * 91.44;
                else if (f === 'cm' && t === 'yard') res = val / 91.44;
                else if (f === 'kg' && t === 'gr') res = val * 1000;
                else if (f === 'gr' && t === 'kg') res = val / 1000;
                else if (f === 'L' && t === 'mL') res = val * 1000;
                else if (f === 'mL' && t === 'L') res = val / 1000;
                resDisplay.innerText = res.toFixed(3);
            }
            valInput.addEventListener('input', convert);
            fromUnit.addEventListener('change', convert);
            toUnit.addEventListener('change', convert);

            // =============================================
            // Auto-Save & Restore Form State
            // (Riwayat isian form tidak hilang saat berpindah halaman kecuali di-refresh)
            // =============================================
            const DRAFT_STORAGE_KEY = 'hpp_create_form_draft_v1';

            function isPageReloaded() {
                try {
                    const nav = performance.getEntriesByType('navigation');
                    if (nav && nav.length > 0) {
                        return nav[0].type === 'reload';
                    }
                    return window.performance && window.performance.navigation && window.performance.navigation.type === 1;
                } catch (e) {
                    return false;
                }
            }

            function clearDraft() {
                try {
                    sessionStorage.removeItem(DRAFT_STORAGE_KEY);
                } catch (e) {}
            }

            function saveDraft() {
                try {
                    const data = {
                        hpp_id: document.querySelector('input[name="hpp_id"]')?.value || '',
                        name: document.querySelector('input[name="name"]')?.value || '',
                        category: document.querySelector('select[name="category"]')?.value || '',
                        calculation_type: document.getElementById('calculationTypeInput')?.value || 'calculated',
                        manual_hpp: document.getElementById('manualHppInput')?.value || '',
                        branding_fee: document.getElementById('brandingFeeInput')?.value || '',
                        sewing_fee: document.getElementById('sewingFeeInput')?.value || '',
                        overhead_pct: document.getElementById('overheadPctInput')?.value || '0.25',
                        target_margin: document.getElementById('targetMarginInput')?.value || '50',
                        cards: [],
                        materials: []
                    };

                    // Cards (Section 02)
                    document.querySelectorAll('#calcCardsContainer .calc-card').forEach(card => {
                        const cardData = { rows: [] };
                        card.querySelectorAll('.calc-row').forEach(row => {
                            cardData.rows.push({
                                desc: row.querySelector('.calc-description-input')?.value || '',
                                mat_val: row.querySelector('.calc-material-select')?.value || '',
                                color_id: row.querySelector('.calc-color-select')?.value || '',
                                length: row.querySelector('.calc-length')?.value || '',
                                width: row.querySelector('.calc-width')?.value || '',
                                qty: row.querySelector('.calc-qty-input')?.value || '',
                                luas: row.querySelector('.calc-luas-bahan-input')?.value || '',
                            });
                        });
                        data.cards.push(cardData);
                    });

                    // Materials (Section 03)
                    document.querySelectorAll('.material-row').forEach(row => {
                        data.materials.push({
                            mat_val: row.querySelector('.material-name-select')?.value || '',
                            color_id: row.querySelector('.material-color-select')?.value || '',
                            source_card: row.querySelector('.source-card-select')?.value || '',
                            usage: row.querySelector('.usage-input')?.value || '0',
                        });
                    });

                    sessionStorage.setItem(DRAFT_STORAGE_KEY, JSON.stringify(data));
                } catch (err) {
                    console.error('Error saving form draft:', err);
                }
            }

            let saveDraftTimeout = null;
            function triggerSaveDraft() {
                clearTimeout(saveDraftTimeout);
                saveDraftTimeout = setTimeout(saveDraft, 400);
            }

            const hppForm = document.getElementById('hppForm');
            if (hppForm) {
                hppForm.addEventListener('input', triggerSaveDraft);
                hppForm.addEventListener('change', triggerSaveDraft);
                hppForm.addEventListener('submit', () => {
                    clearDraft();
                });
            }

            function showDraftAlert() {
                const existing = document.getElementById('draftRestoredAlert');
                if (existing) existing.remove();

                const banner = document.createElement('div');
                banner.id = 'draftRestoredAlert';
                banner.className = 'bg-orange-500/10 border border-orange-500/30 text-orange-600 dark:text-orange-400 px-6 py-4 rounded-2xl flex flex-wrap items-center justify-between gap-3 text-xs font-bold mb-6 transition-all shadow-sm';
                banner.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-orange-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-black text-navy-800 dark:text-white">Riwayat Isian Dipulihkan</p>
                            <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400">Data Anda otomatis tersimpan saat Anda berpindah halaman untuk mengecek material.</p>
                        </div>
                    </div>
                    <button type="button" id="btnDiscardDraft" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all shadow-sm">
                        Kosongkan Form
                    </button>
                `;

                if (hppForm) {
                    hppForm.parentNode.insertBefore(banner, hppForm);
                }

                document.getElementById('btnDiscardDraft')?.addEventListener('click', () => {
                    clearDraft();
                    window.location.reload();
                });
            }

            function restoreDraft() {
                // Jika user menekan tombol refresh browser (F5 / reload), bersihkan draft
                if (isPageReloaded()) {
                    clearDraft();
                    return;
                }

                const raw = sessionStorage.getItem(DRAFT_STORAGE_KEY);
                if (!raw) return;

                try {
                    const data = JSON.parse(raw);
                    const hasMeaningfulData = (data.name && data.name.trim() !== '') ||
                        (data.category && data.category !== '') ||
                        (data.materials && data.materials.some(m => m.mat_val)) ||
                        (data.cards && data.cards.some(c => c.rows && c.rows.some(r => r.mat_val || r.desc)));

                    if (!hasMeaningfulData) return;

                    // 1. Basic Fields
                    if (data.calculation_type) {
                        setCalculationMode(data.calculation_type);
                    }
                    if (data.manual_hpp && document.getElementById('manualHppInput')) {
                        document.getElementById('manualHppInput').value = data.manual_hpp;
                    }
                    const savedBranding = data.branding_fee || data.screen_printing_fee;
                    if (savedBranding && document.getElementById('brandingFeeInput')) {
                        document.getElementById('brandingFeeInput').value = savedBranding;
                    }
                    if (data.sewing_fee && document.getElementById('sewingFeeInput')) {
                        document.getElementById('sewingFeeInput').value = data.sewing_fee;
                    }
                    if (data.hpp_id && document.querySelector('input[name="hpp_id"]')) {
                        document.querySelector('input[name="hpp_id"]').value = data.hpp_id;
                    }
                    if (data.name && document.querySelector('input[name="name"]')) {
                        document.querySelector('input[name="name"]').value = data.name;
                    }
                    if (data.category && document.querySelector('select[name="category"]')) {
                        document.querySelector('select[name="category"]').value = data.category;
                    }
                    if (data.target_margin && document.getElementById('targetMarginInput')) {
                        document.getElementById('targetMarginInput').value = data.target_margin;
                    }
                    if (data.overhead_pct) {
                        const targetBtn = Array.from(document.querySelectorAll('.overhead-btn')).find(b => b.dataset.pct === data.overhead_pct);
                        if (targetBtn) targetBtn.click();
                    }

                    // 2. Section 02 Cards
                    if (data.cards && data.cards.length > 0) {
                        while (calcCardsContainer.querySelectorAll('.calc-card').length < data.cards.length) {
                            document.getElementById('addCalcCard')?.click();
                        }
                        const cardEls = calcCardsContainer.querySelectorAll('.calc-card');
                        data.cards.forEach((cardData, cIdx) => {
                            const cardEl = cardEls[cIdx];
                            if (!cardEl) return;
                            const tbody = cardEl.querySelector('.calc-card-tbody');
                            const addRowBtn = cardEl.querySelector('.add-calc-row-btn');

                            while (tbody.querySelectorAll('.calc-row').length < cardData.rows.length) {
                                addRowBtn?.click();
                            }
                            const rowEls = tbody.querySelectorAll('.calc-row');
                            cardData.rows.forEach((rData, rIdx) => {
                                const row = rowEls[rIdx];
                                if (!row) return;
                                if (rData.desc && row.querySelector('.calc-description-input')) {
                                    row.querySelector('.calc-description-input').value = rData.desc;
                                }
                                if (rData.length && row.querySelector('.calc-length')) {
                                    row.querySelector('.calc-length').value = rData.length;
                                }
                                if (rData.width && row.querySelector('.calc-width')) {
                                    row.querySelector('.calc-width').value = rData.width;
                                }
                                if (rData.qty && row.querySelector('.calc-qty-input')) {
                                    row.querySelector('.calc-qty-input').value = rData.qty;
                                }
                                if (rData.luas && row.querySelector('.calc-luas-bahan-input')) {
                                    row.querySelector('.calc-luas-bahan-input').value = rData.luas;
                                }
                                if (rData.mat_val) {
                                    const matSel = row.querySelector('.calc-material-select');
                                    if (matSel) {
                                        matSel.value = rData.mat_val;
                                        matSel.dispatchEvent(new Event('change', { bubbles: true }));
                                        if (rData.color_id) {
                                            const colSel = row.querySelector('.calc-color-select');
                                            if (colSel) {
                                                colSel.value = rData.color_id;
                                                colSel.dispatchEvent(new Event('change', { bubbles: true }));
                                            }
                                        }
                                    }
                                }
                                performCalcRowCalculation(row);
                            });
                            calculateCardTotal(cardEl);
                        });
                    }

                    // 3. Section 03 Materials Table
                    if (data.materials && data.materials.length > 0) {
                        while (tableBody.querySelectorAll('.material-row').length < data.materials.length) {
                            document.getElementById('addRow')?.click();
                        }
                        const rowEls = tableBody.querySelectorAll('.material-row');
                        data.materials.forEach((mData, mIdx) => {
                            const row = rowEls[mIdx];
                            if (!row) return;
                            if (mData.mat_val) {
                                const matSel = row.querySelector('.material-name-select');
                                if (matSel) {
                                    matSel.value = mData.mat_val;
                                    matSel.dispatchEvent(new Event('change', { bubbles: true }));
                                    if (mData.color_id) {
                                        const colSel = row.querySelector('.material-color-select');
                                        if (colSel) {
                                            colSel.value = mData.color_id;
                                            colSel.dispatchEvent(new Event('change', { bubbles: true }));
                                        }
                                    }
                                }
                            }
                            if (mData.source_card !== undefined && mData.source_card !== '') {
                                const srcSel = row.querySelector('.source-card-select');
                                if (srcSel) srcSel.value = mData.source_card;
                            }
                            if (mData.usage !== undefined) {
                                const usageInp = row.querySelector('.usage-input');
                                if (usageInp) usageInp.value = mData.usage;
                            }
                            syncRow(row);
                        });
                    }

                    refreshCardSelects();
                    calculateTotals();
                    showDraftAlert();
                } catch (err) {
                    console.error('Error restoring draft:', err);
                }
            }

            // Restore draft saat halaman dibuka (jika bukan reload)
            restoreDraft();

            // =============================================
            // Real-Time Material Auto-Sync (Bahan Baru Otomatis Muncul Tanpa Refresh/Restart)
            // =============================================
            let currentMaterialsData = @json($materialsByName);

            function updateSelectOptions(selectEl, materialsList) {
                let currentVal = selectEl.value;
                let currentName = '';
                if (currentVal) {
                    try {
                        const parsed = JSON.parse(currentVal);
                        currentName = parsed.name || '';
                    } catch (e) {
                        currentName = selectEl.getAttribute('data-name') || '';
                    }
                }

                const isCalcSelect = selectEl.classList.contains('calc-material-select');
                selectEl.innerHTML = '<option value="">-- Pilih Bahan --</option>';

                let foundMatch = false;
                materialsList.forEach(material => {
                    const opt = document.createElement('option');
                    opt.value = JSON.stringify(material);
                    opt.textContent = material.name;
                    opt.setAttribute('data-name', material.name);
                    if (isCalcSelect) {
                        opt.setAttribute('data-unit', material.unit || '');
                    }
                    if (currentName && material.name.toLowerCase() === currentName.toLowerCase()) {
                        opt.selected = true;
                        foundMatch = true;
                    }
                    selectEl.appendChild(opt);
                });

                // Perbarui dropdown warna jika row sudah memiliki bahan yang cocok
                if (foundMatch) {
                    const row = selectEl.closest('.material-row') || selectEl.closest('.calc-row');
                    if (row) {
                        const colorSelect = row.querySelector('.material-color-select') || row.querySelector('.calc-color-select');
                        const currentColorId = colorSelect ? colorSelect.value : '';
                        const matchedMat = materialsList.find(m => m.name.toLowerCase() === currentName.toLowerCase());
                        
                        if (matchedMat && colorSelect && colorSelect.children.length > 1) {
                            colorSelect.innerHTML = '<option value="">-- Pilih Warna --</option>';
                            matchedMat.colors.forEach(c => {
                                const opt = document.createElement('option');
                                opt.value = c.id;
                                opt.textContent = c.color ? c.color : 'Tanpa Warna';
                                const typeVal = c.type || matchedMat.type || '-';
                                const unitVal = c.unit || matchedMat.unit || '-';
                                const volVal = c.purchase_volume || matchedMat.purchase_volume || 1;
                                opt.setAttribute('data-type', typeVal);
                                opt.dataset.type = typeVal;
                                opt.setAttribute('data-unit', unitVal);
                                opt.dataset.unit = unitVal;
                                opt.setAttribute('data-price', c.price);
                                opt.dataset.price = c.price;
                                opt.setAttribute('data-purchase-volume', volVal);
                                opt.dataset.purchaseVolume = volVal;
                                if (currentColorId && String(c.id) === String(currentColorId)) {
                                    opt.selected = true;
                                }
                                colorSelect.appendChild(opt);
                            });
                        }
                    }
                }
            }

            async function fetchAndSyncMaterials(showToast = false) {
                const icons = document.querySelectorAll('.sync-materials-icon');
                icons.forEach(i => i.classList.add('animate-spin'));

                try {
                    const res = await fetch('/api/materials/grouped?_t=' + Date.now(), {
                        cache: 'no-store',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (!res.ok) throw new Error('Network response error: ' + res.status);
                    const json = await res.json();

                    if (json && json.success && Array.isArray(json.data)) {
                        const newSignature = JSON.stringify(json.data);
                        const oldSignature = JSON.stringify(currentMaterialsData);

                        if (newSignature !== oldSignature || showToast) {
                            currentMaterialsData = json.data;

                            document.querySelectorAll('.material-name-select').forEach(sel => {
                                updateSelectOptions(sel, currentMaterialsData);
                            });

                            document.querySelectorAll('.calc-material-select').forEach(sel => {
                                updateSelectOptions(sel, currentMaterialsData);
                            });

                            if (showToast && typeof Toast !== 'undefined') {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Daftar bahan berhasil disinkronkan (' + json.data.length + ' bahan)'
                                });
                            }
                        }
                    }
                } catch (e) {
                    console.debug('Material sync notice:', e);
                } finally {
                    icons.forEach(i => i.classList.remove('animate-spin'));
                }
            }

            // Expose globally so parent iframe can call it directly
            window.fetchAndSyncMaterials = fetchAndSyncMaterials;

            // Listen to postMessage from parent or sibling tabs
            window.addEventListener('message', (e) => {
                if (e.data && (e.data.action === 'sync_materials' || e.data.action === 'material_added')) {
                    fetchAndSyncMaterials(false);
                }
            });

            // Tombol Sinkron Manual
            document.querySelectorAll('.btn-sync-materials').forEach(btn => {
                btn.addEventListener('click', () => fetchAndSyncMaterials(true));
            });

            // Sinkronkan otomatis saat tab browser dibuka / kembali aktif
            window.addEventListener('focus', () => fetchAndSyncMaterials());
            document.addEventListener('visibilitychange', () => {
                if (!document.hidden) fetchAndSyncMaterials();
            });

            // Sinkronkan instan saat ada trigger dari tab input bahan lain
            window.addEventListener('storage', (e) => {
                if (e.key === 'materials_updated_at') {
                    fetchAndSyncMaterials();
                }
            });

            // Polling background setiap 3 detik untuk memastikan bahan baru selalu tersedia
            setInterval(fetchAndSyncMaterials, 3000);
        });
    </script>
</x-app-layout>