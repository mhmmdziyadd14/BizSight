<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">Bahan Baku</h1>
                    <p class="mt-2 text-sm text-gray-400">Tambahkan bahan baku yang akan digunakan pada perhitungan HPP.</p>
                </div>
                <a href="{{ route('hpp.create') }}" class="inline-flex items-center justify-center rounded-full bg-yellow-400 px-6 py-3 text-sm font-black uppercase tracking-widest text-black hover:bg-white transition">Kembali ke HPP</a>
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
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nama Bahan</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Satuan</label>
                            <input type="text" name="unit" value="{{ old('unit') }}" required
                                class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Harga / Unit (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="0.01" required
                                class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Warna (opsional)</label>
                            <input type="text" name="color" value="{{ old('color') }}"
                                class="w-full bg-black/40 border border-gray-800 rounded-2xl px-4 py-3 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400">
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
                                        <th class="py-3">Nama</th>
                                        <th class="py-3">Satuan</th>
                                        <th class="py-3 text-right">Harga (Rp)</th>
                                        <th class="py-3 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                    @foreach($materials as $material)
                                        <tr>
                                            <td class="py-3">{{ $material->name }}</td>
                                            <td class="py-3">{{ $material->unit }}</td>
                                            <td class="py-3 text-right">{{ number_format($material->price, 0, ',', '.') }}</td>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
