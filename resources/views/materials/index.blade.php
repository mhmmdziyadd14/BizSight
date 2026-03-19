<x-app-layout>
    @php
        $unitOptions = ['mL','L','gr','kg','buah','pcs','lembar','meter','cm','roll','yard'];
        $typeOptions = ['Bahan Utama','Bahan Pendukung','Bahan Lainnya'];
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">Bahan Baku</h1>
                    <p class="mt-2 text-sm text-gray-400">Tambahkan bahan baku yang akan digunakan pada perhitungan HPP.</p>
                </div>
                <a href="{{ route('hpp.index') }}" class="inline-flex items-center justify-center rounded-full bg-yellow-400 px-6 py-3 text-sm font-black uppercase tracking-widest text-black hover:bg-white transition">Kembali ke HPP</a>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-green-500/30 bg-green-500/10 px-6 py-4 text-green-100">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8">
                    <h2 class="text-lg font-black text-white mb-4">Tambah Bahan Baru</h2>
                    <form action="{{ route('materials.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Tanggal Pembelian</label>
                            <input type="date" name="purchase_date" value="{{ old('purchase_date', now()->toDateString()) }}" required
                                class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Jenis</label>
                            <select name="type" required
                                class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($typeOptions as $type)
                                    <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nama Bahan</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Warna (opsional)</label>
                            <input type="text" name="color" value="{{ old('color') }}"
                                class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Harga Pembelian (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="0.01" required
                                class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Volume Beli</label>
                            <input type="number" name="purchase_volume" value="{{ old('purchase_volume', 1) }}" min="0" step="0.01" required
                                class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Satuan</label>
                            <select name="unit" required
                                class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach($unitOptions as $unit)
                                    <option value="{{ $unit }}" {{ old('unit') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full rounded-2xl bg-yellow-400 py-3 text-sm font-black uppercase tracking-widest text-black hover:bg-white transition">Simpan Bahan</button>
                    </form>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8">
                    <h2 class="text-lg font-black text-white mb-4">Daftar Bahan</h2>
                    @if($materials->isEmpty())
                        <p class="text-sm text-gray-400">Belum ada bahan baku. Tambahkan bahan terlebih dahulu untuk dapat menggunakannya di kalkulator HPP.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="text-xs uppercase text-gray-500">
                                        <th class="py-3">Tanggal Beli</th>
                                        <th class="py-3">Jenis</th>
                                        <th class="py-3">Nama</th>
                                        <th class="py-3">Warna</th>
                                        <th class="py-3 text-right">Harga (Rp)</th>
                                        <th class="py-3 text-right">Volume Beli</th>
                                        <th class="py-3">Satuan</th>
                                        <th class="py-3 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                    @foreach($materials as $material)
                                        <tr>
                                            <td class="py-3">{{ \Carbon\Carbon::parse($material->purchase_date)->format('d M Y') }}</td>
                                            <td class="py-3">{{ $material->type }}</td>
                                            <td class="py-3">{{ $material->name }}</td>
                                            <td class="py-3">{{ $material->color ?? '-' }}</td>
                                            <td class="py-3 text-right">{{ number_format($material->price, 0, ',', '.') }}</td>
                                            <td class="py-3 text-right">{{ number_format($material->purchase_volume, 2, ',', '.') }}</td>
                                            <td class="py-3">{{ $material->unit }}</td>
                                            <td class="py-3 text-right">
                                                <form action="{{ route('materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Hapus bahan ini?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs font-black uppercase tracking-widest text-red-400 hover:text-red-200">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="mt-10 bg-gray-900 border border-gray-800 rounded-3xl p-8">
                        <h2 class="text-lg font-black text-white mb-4">Kalkulator Konversi Satuan</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="text-xs font-black text-gray-500 uppercase tracking-widest mb-2 block">Nilai</label>
                                <input type="number" id="convertValue" value="1" step="0.01" class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-500 uppercase tracking-widest mb-2 block">Dari</label>
                                <select id="convertFrom" class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                                    @foreach($unitOptions as $unit)
                                        <option value="{{ $unit }}">{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-black text-gray-500 uppercase tracking-widest mb-2 block">Ke</label>
                                <select id="convertTo" class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                                    @foreach($unitOptions as $unit)
                                        <option value="{{ $unit }}" {{ $unit === 'meter' ? 'selected' : '' }}>{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-8 p-6 bg-gray-800 border border-gray-700 rounded-3xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-black text-gray-500 uppercase tracking-widest">Hasil Konversi</div>
                                    <div id="conversionResult" class="text-2xl font-black text-white mt-2">-</div>
                                </div>
                                <button type="button" id="convertButton" class="px-6 py-3 bg-yellow-400 text-black rounded-2xl font-black uppercase tracking-widest hover:bg-white transition">Konversi</button>
                            </div>
                            <p class="mt-4 text-xs text-gray-400">Catatan: hanya konversi antar jenis satuan yang sama (misal: mL ⇄ L, gr ⇄ kg, cm ⇄ meter, pcs/lembar/roll/ buah).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const unitCategories = {
                volume: { mL: 1, L: 1000 },
                weight: { gr: 1, kg: 1000 },
                length: { cm: 0.01, meter: 1, yard: 0.9144 },
                count: { buah: 1, pcs: 1, lembar: 1, roll: 1 }
            };

            const valueInput = document.getElementById('convertValue');
            const fromInput = document.getElementById('convertFrom');
            const toInput = document.getElementById('convertTo');
            const resultEl = document.getElementById('conversionResult');
            const convertButton = document.getElementById('convertButton');

            function getCategory(unit) {
                return Object.keys(unitCategories).find(category => Object.prototype.hasOwnProperty.call(unitCategories[category], unit));
            }

            function formatNumber(value) {
                return new Intl.NumberFormat('id-ID', { maximumFractionDigits: 6 }).format(value);
            }

            function updateConversion() {
                const value = parseFloat(valueInput.value) || 0;
                const fromUnit = fromInput.value;
                const toUnit = toInput.value;

                const fromCategory = getCategory(fromUnit);
                const toCategory = getCategory(toUnit);

                if (!fromCategory || !toCategory) {
                    resultEl.innerText = 'Unit tidak dikenali';
                    return;
                }

                if (fromCategory !== toCategory) {
                    resultEl.innerText = 'Tidak dapat konversi antar kategori unit berbeda';
                    return;
                }

                const factorFrom = unitCategories[fromCategory][fromUnit];
                const factorTo = unitCategories[toCategory][toUnit];
                const converted = value * (factorFrom / factorTo);

                resultEl.innerText = `${formatNumber(value)} ${fromUnit} = ${formatNumber(converted)} ${toUnit}`;
            }

            convertButton.addEventListener('click', updateConversion);
            [valueInput, fromInput, toInput].forEach(el => el.addEventListener('change', updateConversion));

            updateConversion();
        });
    </script>
</x-app-layout>
