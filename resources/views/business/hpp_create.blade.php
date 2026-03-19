<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0F172A;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Bagian Header -->

            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between border-b border-gray-800 pb-10">
                <div>
                    <h1 class="text-5xl font-black text-white tracking-tighter uppercase italic">
                        Kalkulator <span class="text-yellow-400">HPP</span>
                    </h1>
                    <p class="mt-4 text-gray-500 font-medium max-w-xl italic">
                        Input detail produksi Anda. BizSight akan menghitung Harga Pokok Penjualan secara presisi
                        sebelum Anda menentukan harga jual.
                    </p>
                    <div
                        class="mt-6 inline-flex items-center gap-3 rounded-2xl bg-yellow-400/10 border border-yellow-400/20 px-6 py-4">
                        <span class="text-xs font-black text-yellow-200 uppercase tracking-widest">Info</span>
                        <p class="text-xs text-gray-200">Jika belum memiliki daftar bahan, silakan tambah di menu HPP
                            ("Data Persediaan") atau <a href="{{ route('materials.index') }}"
                                class="underline text-yellow-300 hover:text-white">Bahan Baku</a>.</p>
                    </div>
                </div>
                <div class="mt-6 md:mt-0">
                    <div class="mt-3 md:mt-0 ">
                        @include('business.partials.back_button')
                    </div>
                    <span
                        class="bg-gray-800 text-yellow-400 px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border border-gray-700">
                        BizSight Precision Engine v1.0
                    </span>
                </div>
            </div>

            <!-- Form Utama -->
            <form action="{{ route('hpp.store') }}" method="POST" id="hppForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                    <!-- SISI KIRI: IDENTITAS & JASA -->
                    <div class="lg:col-span-4 space-y-8 lg:sticky lg:top-8">

                        <!-- Card Identitas -->
                        <div class="bg-gray-900 border border-gray-800 p-8 rounded-[2.5rem] shadow-2xl">
                            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-8">01.
                                Identitas Project</h3>
                            <div class="space-y-6">
                                <div>
                                    <label
                                        class="text-[9px] font-black text-gray-600 uppercase tracking-widest block mb-2">ID
                                        Produk</label>
                                    <input type="text" name="hpp_id"
                                        class="w-full bg-black/40 border-gray-800 rounded-2xl py-4 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400 transition-all"
                                        placeholder="Contoh: BZS-001"
                                        value="{{ old('hpp_id', 'BZS-' . strtoupper(uniqid())) }}">
                                </div>
                                <div>
                                    <label
                                        class="text-[9px] font-black text-gray-600 uppercase tracking-widest block mb-2"></label>Nama
                                    Produk</label>
                                    <input type="text" name="name" required
                                        class="w-full bg-black/40 border-gray-800 rounded-2xl py-4 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400 transition-all"
                                        placeholder="Contoh: Kemeja Tactical V1" value="{{ old('name') }}">
                                </div>
                                <div>
                                    <label
                                        class="text-[9px] font-black text-gray-600 uppercase tracking-widest block mb-2">Kategori
                                        Bisnis</label>
                                    <select name="category"
                                        class="w-full bg-black/40 border-gray-800 rounded-2xl py-4 text-sm font-bold text-white focus:ring-yellow-400">
                                        <option value="Fashion" {{ old('category') === 'Fashion' ? 'selected' : '' }}>
                                            Fashion & Apparel</option>
                                        <option value="F&B" {{ old('category') === 'F&B' ? 'selected' : '' }}>Culinary /
                                            F&B</option>
                                        <option value="Furniture" {{ old('category') === 'Furniture' ? 'selected' : '' }}>
                                            Furniture</option>
                                        <option value="Digital" {{ old('category') === 'Digital' ? 'selected' : '' }}>
                                            Digital Product</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="text-[9px] font-black text-gray-600 uppercase tracking-widest block mb-2">Harga
                                        Jual Target (per unit)</label>
                                    <input type="number" name="target_selling_price" min="0" step="0.01"
                                        value="{{ old('target_selling_price', 0) }}"
                                        class="w-full bg-black/40 border-gray-800 rounded-2xl py-4 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400 transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- Card Jasa -->
                        <div class="bg-yellow-400 p-8 rounded-[2.5rem] shadow-xl shadow-yellow-400/5">
                            <h3 class="text-[10px] font-black text-black uppercase tracking-[0.3em] mb-8">02. Biaya
                                Tambahan</h3>
                            <div class="space-y-6">
                                <div>
                                    <label
                                        class="text-[9px] font-black text-black/40 uppercase tracking-widest block mb-2">Jasa
                                        Sablon / Unit (Rp)</label>
                                    <input type="number" name="screen_printing_fee"
                                        class="fee-input w-full bg-white/30 border-none rounded-2xl py-4 text-lg font-black text-black focus:ring-black"
                                        value="{{ old('screen_printing_fee', 0) }}" min="0">
                                </div>
                                <div>
                                    <label
                                        class="text-[9px] font-black text-black/40 uppercase tracking-widest block mb-2">Jasa
                                        Jahit / Unit (Rp)</label>
                                    <input type="number" name="sewing_fee"
                                        class="fee-input w-full bg-white/30 border-none rounded-2xl py-4 text-lg font-black text-black focus:ring-black"
                                        value="{{ old('sewing_fee', 0) }}" min="0">
                                </div>
                                <div>
                                    <label
                                        class="text-[9px] font-black text-black/40 uppercase tracking-widest block mb-2">Biaya
                                        Lainnya (Rp)</label>
                                    <input type="number" name="other_fees"
                                        class="fee-input w-full bg-white/30 border-none rounded-2xl py-4 text-lg font-black text-black focus:ring-black"
                                        value="{{ old('other_fees', 0) }}" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SISI KANAN: TABEL KOMPONEN MATERIAL -->
                    <div class="lg:col-span-8">
                        <div class="bg-white rounded-[3rem] overflow-hidden shadow-2xl">
                            <div
                                class="bg-gray-50 px-10 py-8 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="text-[10px] font-black text-gray-900 uppercase tracking-[0.3em]">03. Komponen
                                    Material (Bahan Baku)</h3>
                                <button type="button" id="addRow"
                                    class="bg-blue-600 text-white px-5 py-2 rounded-full text-[9px] font-black uppercase tracking-widest hover:bg-black transition-all">
                                    + Tambah Baris
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left" id="materialsTable">
                                    <thead>
                                        <tr class="bg-gray-50/50">
                                            <th
                                                class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest">
                                                No</th>
                                            <th
                                                class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest">
                                                Jenis</th>
                                            <th
                                                class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest">
                                                Bahan</th>
                                            <th
                                                class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest">
                                                Warna</th>
                                            <th
                                                class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-center">
                                                Kebutuhan</th>
                                            <th
                                                class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-right">
                                                Harga</th>
                                            <th
                                                class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-right">
                                                Volume Beli</th>
                                            <th
                                                class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest">
                                                Satuan</th>
                                            <th
                                                class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-right">
                                                Harga Satuan</th>
                                            <th
                                                class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-right">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        <tr class="material-row group">
                                            <td class="px-10 py-8">
                                                <span class="row-number text-sm font-black text-gray-700">1</span>
                                            </td>
                                            <td class="px-10 py-8">
                                                <span class="type-display text-sm font-black text-gray-700">-</span>
                                            </td>
                                            <td class="px-10 py-8">
                                                <select name="material_ids[]"
                                                    class="material-select w-full bg-transparent border-none text-sm font-bold text-gray-900 focus:ring-0"
                                                    required>
                                                    <option value="">-- Pilih Bahan --</option>
                                                    @foreach($materials as $material)
                                                        <option value="{{ $material->id }}"
                                                            data-type="{{ $material->type }}"
                                                            data-color="{{ $material->color }}"
                                                            data-unit="{{ $material->unit }}"
                                                            data-price="{{ $material->price }}"
                                                            data-purchase-volume="{{ $material->purchase_volume }}">
                                                            {{ $material->name }} ({{ $material->color ?? '–' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-10 py-8">
                                                <span class="color-display text-sm font-black text-gray-700">-</span>
                                            </td>
                                            <td class="px-10 py-8">
                                                <div
                                                    class="flex items-center justify-center bg-gray-50 rounded-xl px-4 py-2 border border-transparent focus-within:border-yellow-400 transition-all">
                                                    <input type="number" step="0.01" name="usage_amounts[]"
                                                        class="usage-input w-16 bg-transparent border-none text-center font-black text-gray-900 focus:ring-0"
                                                        value="0">
                                                </div>
                                            </td>
                                            <td class="px-10 py-8 text-right">
                                                <span class="price-display text-sm font-black text-gray-900">Rp 0</span>
                                            </td>
                                            <td class="px-10 py-8 text-right">
                                                <span class="volume-display text-sm font-black text-gray-900">-</span>
                                            </td>
                                            <td class="px-10 py-8">
                                                <span class="unit-display text-sm font-bold text-gray-700">-</span>
                                            </td>
                                            <td class="px-10 py-8 text-right">
                                                <span class="unit-price-display text-sm font-black text-gray-900">Rp
                                                    0</span>
                                            </td>
                                            <td class="px-10 py-8 text-right">
                                                <button type="button"
                                                    class="remove-row text-red-500 font-bold hover:text-red-700"
                                                    aria-label="Hapus baris">×</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Total Ringkasan -->
                            <div class="p-10 bg-gray-900 flex flex-col md:flex-row items-center justify-between gap-8">
                                <div>
                                    <div class="text-[9px] font-black text-gray-500 uppercase tracking-[0.3em] mb-2">
                                        Estimasi HPP Per Unit</div>
                                    <div class="text-5xl font-black text-yellow-400 tracking-tighter"
                                        id="totalHppDisplay">Rp 0</div>
                                </div>
                                <div class="flex gap-4">
                                    <button type="submit"
                                        class="bg-yellow-400 text-black px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-white transition-all shadow-xl shadow-yellow-400/20 active:scale-95">
                                        Simpan Perhitungan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mb-6 mt-6">
                            <h3 class="text-lg font-black text-gray-900">Hasil Perhitungan HPP</h3>
                            <a href="{{ route('hpp.index') }}"
                                class="text-xs font-black uppercase tracking-widest text-yellow-600 hover:text-yellow-400">Lihat
                                Daftar HPP</a>
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

                // Hitung setiap baris material
                document.querySelectorAll('.material-row').forEach(row => {
                    const select = row.querySelector('.material-select');
                    const usage = parseFloat(row.querySelector('.usage-input').value) || 0;
                    const selected = select.selectedOptions[0];

                    const price = parseFloat(selected?.dataset.price || 0) || 0;
                    const purchaseVolume = parseFloat(selected?.dataset.purchaseVolume || 0) || 0;
                    const materialUnitPrice = purchaseVolume > 0 ? (price / purchaseVolume) : 0;
                    const unitPrice = materialUnitPrice * usage; // affected by kebutuhan (usage)

                    // Perhitungan HPP per unit produk
                    const subtotal = unitPrice;

                    const priceEl = row.querySelector('.price-display');
                    const volumeEl = row.querySelector('.volume-display');
                    const unitPriceEl = row.querySelector('.unit-price-display');

                    if (priceEl) priceEl.innerText = formatRupiah(price);
                    if (volumeEl) volumeEl.innerText = purchaseVolume > 0 ? purchaseVolume : '-';
                    if (unitPriceEl) unitPriceEl.innerText = formatRupiah(unitPrice);

                    totalMaterials += subtotal;
                });

                // Tambahkan biaya jasa
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

                if (!selected) {
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

            // Update ketika material dipilih
            tableBody.addEventListener('change', (e) => {
                if (e.target.classList.contains('material-select')) {
                    syncRow(e.target.closest('.material-row'));
                }
            });

            // Update ketika qty berubah
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
                        // Jika hanya tersisa satu baris, hanya reset nilainya
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

            // Pasang handler remove ke semua baris awal
            document.querySelectorAll('.material-row').forEach((row) => attachRemoveHandler(row));

            // Tambah baris baru
            document.getElementById('addRow').addEventListener('click', () => {
                const firstRow = tableBody.querySelector('.material-row');
                const newRow = firstRow.cloneNode(true);

                // Reset nilai baris baru
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

            // Inisialisasi awal
            refreshRowNumbers();
            calculateTotals();
        });
    </script>
</x-app-layout>