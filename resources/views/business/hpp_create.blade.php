{{-- File: hpp-calculator.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
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

        .glass-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(249, 115, 22, 0.2);
        }

        .input-dark {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(249, 115, 22, 0.3);
            transition: all 0.2s ease;
        }

        .input-dark:focus {
            border-color: #F97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: rgba(249, 115, 22, 0.1);
            border: 1px solid rgba(249, 115, 22, 0.3);
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background: rgba(249, 115, 22, 0.2);
            border-color: rgba(249, 115, 22, 0.5);
            transform: translateY(-1px);
        }

        .fee-card {
            background: linear-gradient(135deg, #F97316 0%, #F59E0B 100%);
        }

        .table-header {
            background: linear-gradient(135deg, #FEF3C7 0%, #FFEDD5 100%);
        }

        .table-row-hover:hover {
            background: linear-gradient(90deg, #FEF3C7 0%, #FFF7ED 100%);
        }

        .total-card {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            border: 1px solid rgba(249, 115, 22, 0.3);
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

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }
    </style>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 fade-in-up">

            <!-- Header Section -->
            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between border-b border-orange-500/30 pb-10">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-14 h-14 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-xl">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-black tracking-tight">
                                <span class="text-gradient-orange">Kalkulator</span>
                                <span class="text-white">HPP</span>
                            </h1>
                            <p class="mt-2 text-gray-400 font-medium max-w-xl">
                                Input detail produksi Anda. BizSight akan menghitung Harga Pokok Penjualan secara presisi
                                sebelum Anda menentukan harga jual.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 inline-flex items-center gap-3 rounded-2xl bg-orange-500/10 border border-orange-500/20 px-5 py-3">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xs text-gray-300">Jika belum memiliki daftar bahan, silakan tambah di menu 
                            <a href="{{ route('materials.index') }}" class="underline text-orange-400 hover:text-orange-300 font-semibold">Bahan Baku</a>
                        </p>
                    </div>
                </div>
                <div class="mt-6 md:mt-0 flex flex-col items-end gap-3">
                    @include('business.partials.back_button')
                    <span class="inline-flex items-center gap-2 bg-navy-800/50 text-orange-400 px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border border-orange-500/30">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                        </span>
                        BizSight Precision Engine v2.0
                    </span>
                </div>
            </div>

            <!-- Main Form -->
            <form action="{{ route('hpp.store') }}" method="POST" id="hppForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    <!-- LEFT SIDE: IDENTITY & SERVICES -->
                    <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-8">

                        <!-- Identity Card -->
                        <div class="glass-card rounded-3xl p-6 shadow-xl">
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                                    <span class="text-white text-xs font-black">01</span>
                                </div>
                                <h3 class="text-[10px] font-black text-orange-400 uppercase tracking-[0.2em]">Identitas Project</h3>
                            </div>
                            <div class="space-y-5">
                                <div>
                                    <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest block mb-2">ID Produk</label>
                                    <input type="text" name="hpp_id"
                                        class="w-full input-dark rounded-xl px-4 py-3 text-sm font-bold text-white focus:border-orange-400 transition-all"
                                        placeholder="Contoh: BZS-001"
                                        value="{{ old('hpp_id', 'BZS-' . strtoupper(uniqid())) }}">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest block mb-2">Nama Produk</label>
                                    <input type="text" name="name" required
                                        class="w-full input-dark rounded-xl px-4 py-3 text-sm font-bold text-white focus:border-orange-400 transition-all"
                                        placeholder="Contoh: Kemeja Tactical V1" value="{{ old('name') }}">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest block mb-2">Kategori Bisnis</label>
                                    <select name="category"
                                        class="w-full input-dark rounded-xl px-4 py-3 text-sm font-bold text-white focus:border-orange-400 transition-all">
                                        <option value="Fashion" {{ old('category') === 'Fashion' ? 'selected' : '' }}>Fashion & Apparel</option>
                                        <option value="F&B" {{ old('category') === 'F&B' ? 'selected' : '' }}>Culinary / F&B</option>
                                        <option value="Furniture" {{ old('category') === 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                        <option value="Digital" {{ old('category') === 'Digital' ? 'selected' : '' }}>Digital Product</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest block mb-2">Harga Jual Target (per unit)</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                        <input type="number" name="target_selling_price" min="0" step="0.01"
                                            value="{{ old('target_selling_price', 0) }}"
                                            class="w-full pl-9 input-dark rounded-xl px-4 py-3 text-sm font-bold text-white focus:border-orange-400 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Service Fees Card -->
                        <div class="fee-card rounded-3xl p-6 shadow-xl">
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                                    <span class="text-white text-xs font-black">02</span>
                                </div>
                                <h3 class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Biaya Tambahan</h3>
                            </div>
                            <div class="space-y-5">
                                <div>
                                    <label class="text-[9px] font-black text-white/60 uppercase tracking-widest block mb-2">Jasa Sablon / Unit (Rp)</label>
                                    <input type="number" name="screen_printing_fee"
                                        class="fee-input w-full bg-white/20 border-none rounded-xl py-3 px-4 text-lg font-black text-white focus:ring-2 focus:ring-white/50 transition-all"
                                        value="{{ old('screen_printing_fee', 0) }}" min="0" placeholder="0">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-white/60 uppercase tracking-widest block mb-2">Jasa Jahit / Unit (Rp)</label>
                                    <input type="number" name="sewing_fee"
                                        class="fee-input w-full bg-white/20 border-none rounded-xl py-3 px-4 text-lg font-black text-white focus:ring-2 focus:ring-white/50 transition-all"
                                        value="{{ old('sewing_fee', 0) }}" min="0" placeholder="0">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-white/60 uppercase tracking-widest block mb-2">Biaya Lainnya (Rp)</label>
                                    <input type="number" name="other_fees"
                                        class="fee-input w-full bg-white/20 border-none rounded-xl py-3 px-4 text-lg font-black text-white focus:ring-2 focus:ring-white/50 transition-all"
                                        value="{{ old('other_fees', 0) }}" min="0" placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE: MATERIALS TABLE -->
                    <div class="lg:col-span-8">
                        <div class="bg-white rounded-3xl overflow-hidden shadow-2xl">
                            <!-- Table Header -->
                            <div class="table-header px-6 py-5 flex justify-between items-center border-b border-orange-200">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                                        <span class="text-white text-xs font-black">03</span>
                                    </div>
                                    <h3 class="text-[10px] font-black text-navy-800 uppercase tracking-[0.2em]">Komponen Material (Bahan Baku)</h3>
                                </div>
                                <button type="button" id="addRow"
                                    class="btn-secondary inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider text-orange-600 hover:text-orange-700 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Baris
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left" id="materialsTable">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-[9px] font-black text-gray-500 uppercase tracking-wider text-center w-12">No</th>
                                            <th class="px-4 py-3 text-[9px] font-black text-gray-500 uppercase tracking-wider">Jenis</th>
                                            <th class="px-4 py-3 text-[9px] font-black text-gray-500 uppercase tracking-wider">Bahan</th>
                                            <th class="px-4 py-3 text-[9px] font-black text-gray-500 uppercase tracking-wider">Warna</th>
                                            <th class="px-4 py-3 text-[9px] font-black text-gray-500 uppercase tracking-wider text-center">Kebutuhan</th>
                                            <th class="px-4 py-3 text-[9px] font-black text-gray-500 uppercase tracking-wider text-right">Harga</th>
                                            <th class="px-4 py-3 text-[9px] font-black text-gray-500 uppercase tracking-wider text-right">Volume Beli</th>
                                            <th class="px-4 py-3 text-[9px] font-black text-gray-500 uppercase tracking-wider">Satuan</th>
                                            <th class="px-4 py-3 text-[9px] font-black text-gray-500 uppercase tracking-wider text-right">Harga Satuan</th>
                                            <th class="px-4 py-3 text-[9px] font-black text-gray-500 uppercase tracking-wider text-center w-12">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <tr class="material-row table-row-hover transition-colors">
                                            <td class="px-4 py-5 text-center">
                                                <span class="row-number text-sm font-black text-navy-700">1</span>
                                            </td>
                                            <td class="px-4 py-5">
                                                <span class="type-display text-xs font-bold text-gray-600">-</span>
                                            </td>
                                            <td class="px-4 py-5">
                                                <select name="material_ids[]"
                                                    class="material-select w-full bg-transparent border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-navy-800 focus:border-orange-400 focus:ring-orange-200 transition-all">
                                                    <option value="">-- Pilih Bahan --</option>
                                                    @foreach($materials as $material)
                                                        <option value="{{ $material->id }}"
                                                            data-type="{{ $material->type }}"
                                                            data-color="{{ $material->color }}"
                                                            data-unit="{{ $material->unit }}"
                                                            data-price="{{ $material->price }}"
                                                            data-purchase-volume="{{ $material->purchase_volume }}">
                                                            {{ $material->name }} {{ $material->color ? '(' . $material->color . ')' : '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-5">
                                                <span class="color-display text-xs font-bold text-gray-600">-</span>
                                            </td>
                                            <td class="px-4 py-5">
                                                <input type="number" step="0.01" name="usage_amounts[]"
                                                    class="usage-input w-20 text-center bg-gray-50 border border-gray-200 rounded-lg px-2 py-2 font-bold text-navy-800 focus:border-orange-400 focus:ring-orange-200 transition-all"
                                                    value="0">
                                            </td>
                                            <td class="px-4 py-5 text-right">
                                                <span class="price-display text-sm font-bold text-navy-700">Rp 0</span>
                                            </td>
                                            <td class="px-4 py-5 text-right">
                                                <span class="volume-display text-sm font-bold text-navy-700">-</span>
                                            </td>
                                            <td class="px-4 py-5">
                                                <span class="unit-display text-xs font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded-lg">-</span>
                                            </td>
                                            <td class="px-4 py-5 text-right">
                                                <span class="unit-price-display text-sm font-bold text-orange-600">Rp 0</span>
                                            </td>
                                            <td class="px-4 py-5 text-center">
                                                <button type="button"
                                                    class="remove-row text-red-400 hover:text-red-600 font-bold text-xl transition-colors"
                                                    aria-label="Hapus baris">×</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Total Summary -->
                            <div class="total-card p-6 flex flex-col md:flex-row items-center justify-between gap-6">
                                <div>
                                    <div class="text-[9px] font-black text-orange-400 uppercase tracking-[0.2em] mb-2">Estimasi HPP Per Unit</div>
                                    <div class="text-5xl font-black text-orange-400 tracking-tighter pulse-animation" id="totalHppDisplay">Rp 0</div>
                                </div>
                                <button type="submit"
                                    class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-xl font-black uppercase tracking-wider text-sm text-white shadow-xl active:scale-95 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Perhitungan
                                </button>
                            </div>
                        </div>

                        <!-- Footer Link -->
                        <div class="flex items-center justify-between mt-6">
                            <h3 class="text-sm font-bold text-gray-300">Hasil Perhitungan HPP</h3>
                            <a href="{{ route('hpp.index') }}"
                                class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-widest text-orange-400 hover:text-orange-300 transition-colors">
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
                    const select = row.querySelector('.material-select');
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
                totalHppDisplay.innerText = formatRupiah(grandTotal);
            }

            function syncRow(row) {
                const select = row.querySelector('.material-select');
                const selected = select.selectedOptions[0];

                const typeEl = row.querySelector('.type-display');
                const colorEl = row.querySelector('.color-display');
                const unitEl = row.querySelector('.unit-display');

                if (!selected || !selected.value) {
                    if (typeEl) typeEl.innerText = '-';
                    if (colorEl) colorEl.innerText = '-';
                    if (unitEl) unitEl.innerText = '-';
                } else {
                    if (typeEl) typeEl.innerText = selected.dataset.type || '-';
                    if (colorEl) colorEl.innerText = selected.dataset.color || '-';
                    if (unitEl) unitEl.innerText = selected.dataset.unit || '-';
                }

                refreshRowNumbers();
                calculateTotals();
            }

            tableBody.addEventListener('change', (e) => {
                if (e.target.classList.contains('material-select')) {
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

            function attachRemoveHandler(row) {
                const btn = row.querySelector('.remove-row');
                if (!btn) return;

                btn.addEventListener('click', () => {
                    const rowCount = tableBody.querySelectorAll('.material-row').length;
                    if (rowCount <= 1) {
                        row.querySelector('.material-select').value = '';
                        row.querySelector('.type-display').innerText = '-';
                        row.querySelector('.color-display').innerText = '-';
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

                newRow.querySelector('.material-select').value = '';
                newRow.querySelector('.type-display').innerText = '-';
                newRow.querySelector('.color-display').innerText = '-';
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
        });
    </script>
</x-app-layout>