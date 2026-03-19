<x-app-layout>
    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-black text-white">Edit Bahan Baku</h1>
                <a href="{{ route('materials.index') }}" class="px-4 py-2 bg-yellow-400 text-black rounded-full font-black uppercase tracking-widest text-xs">Kembali</a>
            </div>

            @if(session('error'))
                <div class="mb-6 rounded-lg bg-red-500/20 border border-red-500 text-red-100 px-4 py-3">{{ session('error') }}</div>
            @endif

            <form action="{{ route('materials.update', $material->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase mb-1">Tanggal Pembelian</label>
                    <input type="date" name="purchase_date" required value="{{ old('purchase_date', $material->purchase_date) }}" class="w-full rounded-xl border border-gray-700 bg-gray-900 text-white px-4 py-2">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase mb-1">Jenis</label>
                    <input type="text" name="type" required value="{{ old('type', $material->type) }}" class="w-full rounded-xl border border-gray-700 bg-gray-900 text-white px-4 py-2">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase mb-1">Nama</label>
                    <input type="text" name="name" required value="{{ old('name', $material->name) }}" class="w-full rounded-xl border border-gray-700 bg-gray-900 text-white px-4 py-2">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase mb-1">Warna (opsional)</label>
                    <input type="text" name="color" value="{{ old('color', $material->color) }}" class="w-full rounded-xl border border-gray-700 bg-gray-900 text-white px-4 py-2">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase mb-1">Harga</label>
                    <input type="number" name="price" min="0" step="0.01" required value="{{ old('price', $material->price) }}" class="w-full rounded-xl border border-gray-700 bg-gray-900 text-white px-4 py-2">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase mb-1">Volume Pembelian</label>
                    <input type="number" name="purchase_volume" min="0" step="0.01" required value="{{ old('purchase_volume', $material->purchase_volume) }}" class="w-full rounded-xl border border-gray-700 bg-gray-900 text-white px-4 py-2">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase mb-1">Satuan</label>
                    <input type="text" name="unit" required value="{{ old('unit', $material->unit) }}" class="w-full rounded-xl border border-gray-700 bg-gray-900 text-white px-4 py-2">
                </div>

                <button type="submit" class="w-full rounded-2xl bg-yellow-400 text-black py-3 font-black uppercase tracking-widest">Perbarui Material</button>
            </form>
        </div>
    </div>
</x-app-layout>
