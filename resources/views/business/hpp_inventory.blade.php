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
                        Data persediaan bahan. Lihat stok awal, masuk, keluar, dan stok akhir secara otomatis.
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('materials.index') }}" class="bg-yellow-400 px-5 py-3 rounded-xl font-black text-xs uppercase tracking-widest text-black hover:bg-black hover:text-white transition">Kelola Bahan</a>
                </div>
            </div>

            @include('business.partials.hpp_nav')

            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                @if($materials->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada data bahan. Tambahkan bahan di halaman Bahan Baku.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="text-xs uppercase text-gray-500">
                                    <th class="py-3">Nama Bahan</th>
                                    <th class="py-3">Warna</th>
                                    <th class="py-3 text-right">Stock Awal</th>
                                    <th class="py-3 text-right">Masuk</th>
                                    <th class="py-3 text-right">Keluar</th>
                                    <th class="py-3 text-right">Stock Akhir</th>
                                    <th class="py-3">Satuan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($materials as $material)
                                    @php
                                        $stockEnd = ($material->stock_initial ?? 0) + ($material->stock_in ?? 0) - ($material->stock_out ?? 0);
                                    @endphp
                                    <tr>
                                        <td class="py-3 font-black">{{ $material->name }}</td>
                                        <td class="py-3">{{ $material->color }}</td>
                                        <td class="py-3 text-right">{{ number_format($material->stock_initial ?? 0, 2, ',', '.') }}</td>
                                        <td class="py-3 text-right">{{ number_format($material->stock_in ?? 0, 2, ',', '.') }}</td>
                                        <td class="py-3 text-right">{{ number_format($material->stock_out ?? 0, 2, ',', '.') }}</td>
                                        <td class="py-3 text-right">{{ number_format($stockEnd, 2, ',', '.') }}</td>
                                        <td class="py-3">{{ $material->unit }}</td>
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
