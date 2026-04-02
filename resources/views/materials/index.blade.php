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

    <div class="py-12 bg-gradient-to-br from-orange-50 via-white to-navy-50/30 min-h-screen">
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
                        <h1 class="text-3xl font-black text-navy-900 tracking-tight">Kelola Bahan Baku</h1>
                        <p class="mt-1 text-sm text-navy-600">Tambahkan bahan baku yang akan digunakan pada perhitungan HPP.</p>
                    </div>
                </div>
                <a href="{{ route('hpp.bahan') }}" class="btn-back inline-flex items-center gap-2 px-6 py-3 bg-white border border-orange-300 rounded-xl text-sm font-black uppercase tracking-wider text-orange-600 hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Bahan
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-green-500/30 bg-green-500/10 backdrop-blur-sm px-6 py-4 fade-in-up">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-green-700 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Add Material Form - Full Width -->
            <div class="bg-white rounded-3xl shadow-xl border border-orange-100 p-10 fade-in-up mb-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-navy-900">Tambah Bahan Baru</h2>
                </div>
                
                <form action="{{ route('materials.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div>
                            <label class="block text-[11px] font-black text-orange-600 uppercase tracking-wider mb-3">Tanggal Pembelian</label>
                            <input type="date" name="purchase_date" value="{{ old('purchase_date', now()->toDateString()) }}" required
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-orange-600 uppercase tracking-wider mb-3">Jenis</label>
                            <select name="type" id="typeSelect" required
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($typeOptions as $type)
                                    <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-orange-600 uppercase tracking-wider mb-3">Nama Bahan</label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="materialNameInput" 
                                    placeholder="-- Pilih atau ketik nama bahan baru --"
                                    value="{{ old('name') }}"
                                    autocomplete="off"
                                    class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all peer">
                                <input 
                                    type="hidden" 
                                    name="name" 
                                    id="materialNameValue"
                                    required>
                                <select 
                                    id="materialNameSelect" 
                                    class="hidden peer-focus:block absolute top-full left-0 right-0 mt-1 bg-white border border-orange-300 rounded-xl z-10 max-h-64 overflow-y-auto">
                                    <option value="">-- Pilih dari daftar --</option>
                                    @php
                                        $uniqueMaterials = $materials->unique('name')->sortBy('name');
                                    @endphp
                                    @foreach($uniqueMaterials as $material)
                                        <option value="{{ $material->name }}" data-type="{{ $material->type }}" data-unit="{{ $material->unit }}">{{ $material->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-orange-600 uppercase tracking-wider mb-3">Warna (opsional)</label>
                            <input type="text" name="color" value="{{ old('color') }}" placeholder="Contoh: Putih, Merah"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div>
                            <label class="block text-[11px] font-black text-orange-600 uppercase tracking-wider mb-3">Harga Pembelian (Rp)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 text-xs font-bold">Rp</span>
                                <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="0.01" required
                                    class="w-full pl-10 bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-orange-600 uppercase tracking-wider mb-3">Volume Beli</label>
                            <input type="number" name="purchase_volume" value="{{ old('purchase_volume', 1) }}" min="0" step="0.01" required
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-orange-600 uppercase tracking-wider mb-3">Satuan</label>
                            <select name="unit" required
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach($unitOptions as $unit)
                                    <option value="{{ $unit }}" {{ old('unit') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="btn-primary w-full flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-black uppercase tracking-wider text-white shadow-md transition-all h-12">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Bahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Materials List - Full Width -->
            <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden fade-in-up mb-10">
                <div class="bg-gradient-navy px-10 py-6">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-black text-white">Daftar Bahan</h2>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    @if($materials->isEmpty())
                        <div class="text-center py-12 px-6">
                            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <p class="text-navy-600 font-medium">Belum ada bahan baku. Tambahkan bahan terlebih dahulu untuk dapat menggunakannya di kalkulator HPP.</p>
                        </div>
                    @else
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gradient-to-r from-orange-50/50 to-orange-50 border-b border-orange-200">
                                <tr class="text-[11px] font-black text-navy-700 uppercase tracking-wider">
                                    <th class="py-4 px-6">Tanggal</th>
                                    <th class="py-4 px-6">Jenis</th>
                                    <th class="py-4 px-6">Nama</th>
                                    <th class="py-4 px-6">Warna</th>
                                    <th class="py-4 px-6 text-right">Harga</th>
                                    <th class="py-4 px-6 text-right">Volume</th>
                                    <th class="py-4 px-6">Satuan</th>
                                    <th class="py-4 px-6 text-center">Aksi</th>
                                 </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($materials as $material)
                                    <tr class="table-row-hover hover:bg-orange-50/30 transition-colors">
                                        <td class="py-4 px-6 text-navy-700 font-medium">{{ \Carbon\Carbon::parse($material->purchase_date)->format('d M Y') }}</td>
                                        <td class="py-4 px-6">
                                            @php
                                                $badgeClass = 'badge-utama';
                                                if($material->type === 'Bahan Pendukung') $badgeClass = 'badge-pendukung';
                                                if($material->type === 'Bahan Lainnya') $badgeClass = 'badge-lainnya';
                                            @endphp
                                            <span class="type-badge {{ $badgeClass }}">
                                                {{ $material->type }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 font-bold text-navy-800">{{ $material->name }}</td>
                                        <td class="py-4 px-6 text-navy-600">{{ $material->color ?? '-' }}</td>
                                        <td class="py-4 px-6 text-right font-mono font-bold text-orange-600">Rp{{ number_format($material->price, 0, ',', '.') }}</td>
                                        <td class="py-4 px-6 text-right font-mono font-bold text-navy-700">{{ number_format($material->purchase_volume, 2, ',', '.') }}</td>
                                        <td class="py-4 px-6"><span class="px-3 py-1 rounded-lg bg-navy-100 text-navy-700 text-xs font-bold uppercase tracking-wider">{{ $material->unit }}</span></td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex items-center justify-center gap-3">
                                                <a href="{{ route('materials.edit', $material->id) }}" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-black uppercase tracking-wider text-orange-600 hover:text-white hover:bg-orange-600 rounded-lg transition-all">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Hapus bahan ini?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-black uppercase tracking-wider text-red-600 hover:text-white hover:bg-red-600 rounded-lg transition-all">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    @endif
                </div>
            </div>

            <!-- Unit Converter -->
            <div class="bg-white rounded-3xl shadow-xl border border-orange-100 p-8 fade-in-up">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-navy-900">Kalkulator Konversi Satuan</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-[11px] font-black text-orange-600 uppercase tracking-wider mb-3">Nilai</label>
                        <input type="number" id="convertValue" value="1" step="0.01" 
                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-orange-600 uppercase tracking-wider mb-3">Dari</label>
                        <select id="convertFrom" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all">
                            @foreach($unitOptions as $unit)
                                <option value="{{ $unit }}">{{ $unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-orange-600 uppercase tracking-wider mb-3">Ke</label>
                        <select id="convertTo" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm font-semibold text-navy-900 focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all">
                            @foreach($unitOptions as $unit)
                                <option value="{{ $unit }}" {{ $unit === 'meter' ? 'selected' : '' }}>{{ $unit }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-2xl p-6">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <div class="text-[10px] font-black text-orange-600 uppercase tracking-wider">Hasil Konversi</div>
                            <div id="conversionResult" class="text-2xl font-black text-navy-900 mt-2">-</div>
                        </div>
                        <button type="button" id="convertButton" class="px-8 py-3 bg-gradient-orange text-white rounded-xl font-black text-sm uppercase tracking-wider hover:shadow-lg transition-all">
                            Konversi
                        </button>
                    </div>
                    <p class="mt-3 text-xs text-navy-600">Catatan: hanya konversi antar jenis satuan yang sama (mL ⇄ L, gr ⇄ kg, cm ⇄ meter, pcs/lembar/roll/buah).</p>
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
                @php
                    $uniqueMaterials = $materials->unique('name')->sortBy('name');
                @endphp
                @foreach($uniqueMaterials as $material)
                    {
                        name: '{{ $material->name }}',
                        type: '{{ $material->type }}',
                        unit: '{{ $material->unit }}'
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
                } else {
                    if (typeSelect) typeSelect.value = '';
                    if (unitSelect) unitSelect.value = '';
                }
            }

            // Handle input typing
            if (materialNameInput) {
                materialNameInput.addEventListener('input', function() {
                    const searchValue = this.value.toLowerCase();
                    
                    // Filter and show dropdown options
                    const options = materialNameSelect.querySelectorAll('option');
                    let visibleCount = 0;
                    
                    options.forEach((option, index) => {
                        if (index === 0) return; // Skip the default option
                        const optionText = option.textContent.toLowerCase();
                        const shouldShow = optionText.includes(searchValue) && searchValue !== '';
                        
                        if (shouldShow) {
                            option.style.display = 'block';
                            visibleCount++;
                        } else {
                            option.style.display = 'none';
                        }
                    });
                    
                    // Update hidden value
                    if (materialNameValue) {
                        materialNameValue.value = this.value;
                    }
                    
                    // Show/hide dropdown based on input
                    if (this.value && visibleCount > 0) {
                        materialNameSelect.classList.remove('hidden');
                    } else {
                        materialNameSelect.classList.add('hidden');
                    }
                });

                // Handle click on input to show all options
                materialNameInput.addEventListener('focus', function() {
                    if (this.parentElement.querySelector('select:not(.hidden)')) {
                        return;
                    }
                    // Show all options when focused and empty
                    const options = materialNameSelect.querySelectorAll('option');
                    options.forEach((option, index) => {
                        if (index === 0) return;
                        option.style.display = 'block';
                    });
                    if (this.value === '') {
                        materialNameSelect.classList.remove('hidden');
                    }
                });
            }

            // Handle selection from dropdown
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

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#materialNameInput') && !e.target.closest('#materialNameSelect')) {
                    if (materialNameSelect) {
                        materialNameSelect.classList.add('hidden');
                    }
                }
            });

            // Handle form submission
            const form = document.querySelector('form');
            if (form && materialNameInput && materialNameValue) {
                form.addEventListener('submit', function(e) {
                    const inputValue = materialNameInput.value.trim();
                    
                    if (!inputValue) {
                        e.preventDefault();
                        alert('Mohon isi nama bahan');
                        return;
                    }
                    
                    // Set the hidden input value for form submission
                    materialNameValue.value = inputValue;
                    
                    // Check if it's an existing material and auto-update type/unit if not already filled
                    const material = findMaterialByName(inputValue);
                    if (material && !typeSelect.value) {
                        e.preventDefault();
                        // Auto-fill and let user verify
                        typeSelect.value = material.type;
                        unitSelect.value = material.unit;
                        // Optional: show alert or re-enable form
                        return false;
                    }
                });
            }

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