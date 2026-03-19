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
                        Pilih menu di bawah untuk mengelola HPP, data produk, persediaan, dan bill of material.
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('hpp.create') }}" class="bg-yellow-400 px-5 py-3 rounded-xl font-black text-xs uppercase tracking-widest text-black hover:bg-black hover:text-white transition">+ Buat HPP Baru</a>
                </div>
            </div>

            @include('business.partials.hpp_nav')

            <div class="mb-10 bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h2 class="text-xl font-black text-gray-900">Ringkasan HPP</h2>
                <p class="mt-2 text-sm text-gray-500">Gunakan menu <span class="font-bold">Bahan</span> untuk menambahkan dan mengelola persediaan bahan, lalu buat perhitungan HPP dari menu <span class="font-bold">Hitung HPP</span>.</p>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                @if($hppCalculations->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada perhitungan HPP. Silakan buat HPP baru untuk menyimpan dan mencetak laporan.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="text-xs uppercase text-gray-500">
                                    <th class="py-3">ID</th>
                                    <th class="py-3">Nama</th>
                                    <th class="py-3">Kategori</th>
                                    <th class="py-3">Tanggal</th>
                                    <th class="py-3 text-right">HPP/Unit</th>
                                    <th class="py-3">Status Cetak</th>
                                    <th class="py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($hppCalculations as $hpp)
                                    <tr>
                                        <td class="py-3 font-black">{{ $hpp->hpp_id }}</td>
                                        <td class="py-3">{{ $hpp->name }}</td>
                                        <td class="py-3">{{ $hpp->category }}</td>
                                        <td class="py-3">{{ $hpp->created_at->format('d M Y') }}</td>
                                        <td class="py-3 text-right">Rp{{ number_format($hpp->total_hpp_per_unit, 0, ',', '.') }}</td>
                                        <td class="py-3">
                                            @if($hpp->printed_at)
                                                <span class="text-xs font-black text-green-500">Dicetak</span>
                                            @else
                                                <span class="text-xs font-black text-gray-400">Belum</span>
                                            @endif
                                        </td>
                                        <td class="py-3 text-right">
                                            <a href="{{ route('hpp.show', $hpp->id) }}" class="text-xs font-black uppercase tracking-widest text-blue-600 hover:text-blue-400 mr-4">Detail</a>
                                            @if(!$hpp->printed_at)
                                                <a href="{{ route('hpp.print', $hpp->id) }}" class="text-xs font-black uppercase tracking-widest text-yellow-500 hover:text-yellow-300">Cetak</a>
                                            @endif
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
