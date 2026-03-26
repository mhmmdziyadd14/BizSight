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
        
        .card-dark {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(249, 115, 22, 0.2);
        }
        
        .input-dark {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(249, 115, 22, 0.3);
            transition: all 0.2s ease;
            color: #F1F5F9;
        }
        
        .input-dark:focus {
            border-color: #F97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
            outline: none;
            background: rgba(0, 0, 0, 0.6);
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
        
        .btn-back {
            transition: all 0.2s ease;
        }
        
        .btn-back:hover {
            transform: translateX(-2px);
            background: #F97316;
            color: white;
        }
        
        .table-row-hover {
            transition: all 0.2s ease;
        }
        
        .table-row-hover:hover {
            background: rgba(249, 115, 22, 0.1);
        }
        
        .delete-btn {
            transition: all 0.2s ease;
        }
        
        .delete-btn:hover {
            transform: translateX(2px);
            color: #F97316;
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
        
        .converter-card {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            border: 1px solid rgba(249, 115, 22, 0.3);
        }
        
        .result-card {
            background: rgba(249, 115, 22, 0.1);
            border: 1px solid rgba(249, 115, 22, 0.3);
        }
        
        .type-badge {
            display: inline-flex;
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

    @php
        $unitOptions = ['mL','L','gr','kg','buah','pcs','lembar','meter','cm','roll','yard'];
        $typeOptions = ['Bahan Utama','Bahan Pendukung','Bahan Lainnya'];
    @endphp

    <div class="py-12 bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10 fade-in-up">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-white tracking-tight">Bahan Baku</h1>
                        <p class="mt-1 text-sm text-orange-300/70">Tambahkan bahan baku yang akan digunakan pada perhitungan HPP.</p>
                    </div>
                </div>
                <a href="{{ route('hpp.index') }}" class="btn-back inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm border border-orange-500/30 rounded-xl text-sm font-black uppercase tracking-wider text-orange-400 hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke HPP
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-green-500/30 bg-green-500/10 backdrop-blur-sm px-6 py-4 fade-in-up">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-green-200 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Add Material Form -->
                <div class="card-dark rounded-3xl p-8 fade-in-up">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-black text-white">Tambah Bahan Baru</h2>
                    </div>
                    
                    <form action="{{ route('materials.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black text-orange-400 uppercase tracking-wider mb-2">Tanggal Pembelian</label>
                            <input type="date" name="purchase_date" value="{{ old('purchase_date', now()->toDateString()) }}" required
                                class="w-full input-dark rounded-xl px-4 py-3 text-sm font-semibold text-white focus:border-orange-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-orange-400 uppercase tracking-wider mb-2">Jenis</label>
                            <select name="type" required
                                class="w-full input-dark rounded-xl px-4 py-3 text-sm font-semibold text-white focus:border-orange-400 transition-all">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($typeOptions as $type)
                                    <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-orange-400 uppercase tracking-wider mb-2">Nama Bahan</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                placeholder="Contoh: Tepung Terigu"
                                class="w-full input-dark rounded-xl px-4 py-3 text-sm font-semibold text-white focus:border-orange-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-orange-400 uppercase tracking-wider mb-2">Warna (opsional)</label>
                            <input type="text" name="color" value="{{ old('color') }}"
                                placeholder="Contoh: Putih, Merah"
                                class="w-full input-dark rounded-xl px-4 py-3 text-sm font-semibold text-white focus:border-orange-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-orange-400 uppercase tracking-wider mb-2">Harga Pembelian (Rp)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="0.01" required
                                    class="w-full pl-9 input-dark rounded-xl px-4 py-3 text-sm font-semibold text-white focus:border-orange-400 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-orange-400 uppercase tracking-wider mb-2">Volume Beli</label>
                            <input type="number" name="purchase_volume" value="{{ old('purchase_volume', 1) }}" min="0" step="0.01" required
                                class="w-full input-dark rounded-xl px-4 py-3 text-sm font-semibold text-white focus:border-orange-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-orange-400 uppercase tracking-wider mb-2">Satuan</label>
                            <select name="unit" required
                                class="w-full input-dark rounded-xl px-4 py-3 text-sm font-semibold text-white focus:border-orange-400 transition-all">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach($unitOptions as $unit)
                                    <option value="{{ $unit }}" {{ old('unit') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn-primary w-full flex items-center justify-center gap-2 py-3.5 rounded-xl text-sm font-black uppercase tracking-wider text-white shadow-md transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Bahan
                        </button>
                    </form>
                </div>

                <!-- Materials List & Converter -->
                <div class="space-y-8">
                    <!-- Materials List -->
                    <div class="card-dark rounded-3xl p-8 fade-in-up">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h2 class="text-lg font-black text-white">Daftar Bahan</h2>
                        </div>
                        
                        @if($materials->isEmpty())
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-orange-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-400">Belum ada bahan baku. Tambahkan bahan terlebih dahulu untuk dapat menggunakannya di kalkulator HPP.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead>
                                        <tr class="text-[10px] font-black text-orange-400 uppercase tracking-wider border-b border-orange-500/30">
                                            <th class="py-3">Tanggal</th>
                                            <th class="py-3">Jenis</th>
                                            <th class="py-3">Nama</th>
                                            <th class="py-3">Warna</th>
                                            <th class="py-3 text-right">Harga</th>
                                            <th class="py-3 text-right">Volume</th>
                                            <th class="py-3">Satuan</th>
                                            <th class="py-3 text-right">Aksi</th>
                                         </tr>
                                    </thead>
                                    <tbody class="divide-y divide-orange-500/20">
                                        @foreach($materials as $material)
                                            <tr class="table-row-hover transition-colors">
                                                <td class="py-3 text-gray-300">{{ \Carbon\Carbon::parse($material->purchase_date)->format('d M Y') }}</td>
                                                <td class="py-3">
                                                    @php
                                                        $badgeClass = 'badge-utama';
                                                        if($material->type === 'Bahan Pendukung') $badgeClass = 'badge-pendukung';
                                                        if($material->type === 'Bahan Lainnya') $badgeClass = 'badge-lainnya';
                                                    @endphp
                                                    <span class="type-badge {{ $badgeClass }}">
                                                        {{ $material->type }}
                                                    </span>
                                                </td>
                                                <td class="py-3 font-semibold text-white">{{ $material->name }}</td>
                                                <td class="py-3 text-gray-400">{{ $material->color ?? '-' }}</td>
                                                <td class="py-3 text-right font-mono text-white">Rp{{ number_format($material->price, 0, ',', '.') }}</td>
                                                <td class="py-3 text-right font-mono text-white">{{ number_format($material->purchase_volume, 2, ',', '.') }}</td>
                                                <td class="py-3"><span class="px-2 py-1 rounded-lg bg-gray-800 text-orange-400 text-xs font-bold">{{ $material->unit }}</span></td>
                                                <td class="py-3 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <a href="{{ route('materials.edit', $material->id) }}" class="text-xs font-black uppercase tracking-wider text-orange-400 hover:text-orange-300 transition-colors">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Hapus bahan {{ $material->name }}?');" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="delete-btn text-xs font-black uppercase tracking-wider text-red-400 hover:text-red-300 transition-colors">
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
                        @endif
                    </div>

                    <!-- Unit Converter -->
                    <div class="converter-card rounded-3xl p-8 fade-in-up">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                </svg>
                            </div>
                            <h2 class="text-lg font-black text-white">Kalkulator Konversi Satuan</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="text-[10px] font-black text-orange-400 uppercase tracking-wider mb-2 block">Nilai</label>
                                <input type="number" id="convertValue" value="1" step="0.01" 
                                    class="w-full input-dark rounded-xl px-4 py-3 text-sm font-semibold text-white focus:border-orange-400 transition-all">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-orange-400 uppercase tracking-wider mb-2 block">Dari</label>
                                <select id="convertFrom" class="w-full input-dark rounded-xl px-4 py-3 text-sm font-semibold text-white focus:border-orange-400 transition-all">
                                    @foreach($unitOptions as $unit)
                                        <option value="{{ $unit }}">{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-orange-400 uppercase tracking-wider mb-2 block">Ke</label>
                                <select id="convertTo" class="w-full input-dark rounded-xl px-4 py-3 text-sm font-semibold text-white focus:border-orange-400 transition-all">
                                    @foreach($unitOptions as $unit)
                                        <option value="{{ $unit }}" {{ $unit === 'meter' ? 'selected' : '' }}>{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 result-card rounded-2xl p-5">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <div>
                                    <div class="text-[9px] font-black text-orange-400 uppercase tracking-wider">Hasil Konversi</div>
                                    <div id="conversionResult" class="text-xl font-black text-white mt-1">-</div>
                                </div>
                                <button type="button" id="convertButton" class="px-6 py-2.5 bg-gradient-orange text-white rounded-xl font-black text-xs uppercase tracking-wider hover:shadow-lg transition-all">
                                    Konversi
                                </button>
                            </div>
                            <p class="mt-3 text-[10px] text-gray-400">Catatan: hanya konversi antar jenis satuan yang sama (mL ⇄ L, gr ⇄ kg, cm ⇄ meter, pcs/lembar/roll/buah).</p>
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
            [valueInput, fromInput, toInput].forEach(el => el.addEventListener('input', updateConversion));

            updateConversion();
        });
    </script>
</x-app-layout>