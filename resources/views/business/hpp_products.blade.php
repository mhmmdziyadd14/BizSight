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
                        Data produk (HPP master) yang sudah disimpan. Gunakan ini sebagai referensi untuk analisis atau pencetakan laporan.
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('hpp.create') }}" class="bg-yellow-400 px-5 py-3 rounded-xl font-black text-xs uppercase tracking-widest text-black hover:bg-black hover:text-white transition">+ Buat HPP Baru</a>
                </div>
            </div>

            @include('business.partials.hpp_nav')

            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                @if($products->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada data produk. Buat HPP baru untuk menyimpan detail produk.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="text-xs uppercase text-gray-500">
                                    <th class="py-3">ID</th>
                                    <th class="py-3">Nama ID</th>
                                    <th class="py-3">Kategori</th>
                                    <th class="py-3 text-right">HPP/Unit</th>
                                    <th class="py-3 text-right">Harga Jual</th>
                                    <th class="py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($products as $product)
                                    <tr>
                                        <td class="py-3 font-black">{{ $product->hpp_id }}</td>
                                        <td class="py-3">{{ $product->name }}</td>
                                        <td class="py-3">{{ $product->category }}</td>
                                        <td class="py-3 text-right">Rp{{ number_format($product->total_hpp_per_unit, 0, ',', '.') }}</td>
                                        <td class="py-3 text-right">Rp{{ number_format($product->target_selling_price, 0, ',', '.') }}</td>
                                        <td class="py-3">
                                            <a href="{{ route('hpp.show', $product->id) }}" class="text-xs font-black uppercase tracking-widest text-blue-600 hover:text-blue-400">Detail</a>
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
