<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>

    <div class="py-10 bg-[#F9FAFB] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between border-b pb-6 border-gray-200">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight flex items-center">
                        <span class="bg-yellow-400 text-black px-3 py-1 rounded-lg mr-3 text-2xl italic">Biz</span>Sight
                    </h1>
                    <p class="mt-2 text-base text-gray-500 max-w-2xl">
                        Kelola bahan baku dan catat biaya pembelian sehingga bisa langsung dipakai saat bikin HPP.
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('hpp.create') }}" class="bg-yellow-400 px-5 py-3 rounded-xl font-black text-xs uppercase tracking-widest text-black hover:bg-black hover:text-white transition">+ Buat HPP Baru</a>
                </div>
            </div>

            @include('business.partials.hpp_nav')

            <div class="mb-10 bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
                    <div>
                        <h2 class="text-xl font-black text-gray-900">Tambah Bahan Baku</h2>
                        <p class="text-sm text-gray-500">Simpan bahan di sini agar bisa langsung dipakai saat membuat HPP.</p>
                    </div>
                    <a href="{{ route('materials.index') }}" class="text-xs font-black uppercase tracking-widest text-yellow-600 hover:text-yellow-400">Kelola Bahan Lengkap</a>
                </div>

                @if(session('success'))
                    <div class="mb-6 rounded-2xl border border-green-500/30 bg-green-500/10 px-6 py-4 text-green-100">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('materials.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Tanggal Pembelian</label>
                        <input type="date" name="purchase_date" value="{{ old('purchase_date', now()->toDateString()) }}" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm font-bold text-gray-900 focus:ring-yellow-400 focus:border-yellow-400">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Jenis</label>
                        <select name="type" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm font-bold text-gray-900 focus:ring-yellow-400 focus:border-yellow-400">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Bahan Utama" {{ old('type') === 'Bahan Utama' ? 'selected' : '' }}>Bahan Utama</option>
                            <option value="Bahan Pendukung" {{ old('type') === 'Bahan Pendukung' ? 'selected' : '' }}>Bahan Pendukung</option>
                            <option value="Bahan Lainnya" {{ old('type') === 'Bahan Lainnya' ? 'selected' : '' }}>Bahan Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nama Bahan</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm font-bold text-gray-900 focus:ring-yellow-400 focus:border-yellow-400">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Warna (opsional)</label>
                        <input type="text" name="color" value="{{ old('color') }}"
                            class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm font-bold text-gray-900 focus:ring-yellow-400 focus:border-yellow-400">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Harga Pembelian (Rp)</label>
                        <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="0.01" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm font-bold text-gray-900 focus:ring-yellow-400 focus:border-yellow-400">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Volume Beli</label>
                        <input type="number" name="purchase_volume" value="{{ old('purchase_volume', 1) }}" min="0" step="0.01" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm font-bold text-gray-900 focus:ring-yellow-400 focus:border-yellow-400">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Satuan</label>
                        <select name="unit" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm font-bold text-gray-900 focus:ring-yellow-400 focus:border-yellow-400">
                            <option value="">-- Pilih Satuan --</option>
                            <option value="mL" {{ old('unit') === 'mL' ? 'selected' : '' }}>mL</option>
                            <option value="L" {{ old('unit') === 'L' ? 'selected' : '' }}>L</option>
                            <option value="gr" {{ old('unit') === 'gr' ? 'selected' : '' }}>gr</option>
                            <option value="kg" {{ old('unit') === 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="buah" {{ old('unit') === 'buah' ? 'selected' : '' }}>buah</option>
                            <option value="pcs" {{ old('unit') === 'pcs' ? 'selected' : '' }}>pcs</option>
                            <option value="lembar" {{ old('unit') === 'lembar' ? 'selected' : '' }}>lembar</option>
                            <option value="meter" {{ old('unit') === 'meter' ? 'selected' : '' }}>meter</option>
                            <option value="cm" {{ old('unit') === 'cm' ? 'selected' : '' }}>cm</option>
                            <option value="roll" {{ old('unit') === 'roll' ? 'selected' : '' }}>roll</option>
                            <option value="yard" {{ old('unit') === 'yard' ? 'selected' : '' }}>yard</option>
                        </select>
                    </div>
                    <div class="lg:col-span-3">
                        <button type="submit" class="w-full rounded-2xl bg-yellow-400 py-3 text-sm font-black uppercase tracking-widest text-black hover:bg-white transition">Simpan Bahan</button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-black text-gray-900">Daftar Bahan</h2>
                        <p class="text-sm text-gray-500">Kelola dan hapus bahan yang sudah tidak digunakan.</p>
                    </div>
                    <a href="{{ route('materials.index') }}" class="text-xs font-black uppercase tracking-widest text-yellow-600 hover:text-yellow-400">Lihat daftar lengkap</a>
                </div>

                @if($materials->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada bahan baku. Tambahkan bahan terlebih dahulu.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="text-xs uppercase text-gray-500">
                                    <th class="py-3">Nama</th>
                                    <th class="py-3">Jenis</th>
                                    <th class="py-3">Satuan</th>
                                    <th class="py-3 text-right">Harga</th>
                                    <th class="py-3 text-right">Volume</th>
                                    <th class="py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($materials as $material)
                                    <tr>
                                        <td class="py-3 font-black text-gray-900">{{ $material->name }}</td>
                                        <td class="py-3 text-gray-500">{{ $material->type }}</td>
                                        <td class="py-3 text-gray-500">{{ $material->unit }}</td>
                                        <td class="py-3 text-right text-gray-900">{{ number_format($material->price, 0, ',', '.') }}</td>
                                        <td class="py-3 text-right text-gray-900">{{ number_format($material->purchase_volume, 2, ',', '.') }}</td>
                                        <td class="py-3">
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
            </div>
        </div>
    </div>
</x-app-layout>
