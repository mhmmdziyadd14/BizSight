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
                        Bill of Material (BOM) menampilkan bahan yang digunakan pada setiap produk HPP.
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('hpp.create') }}" class="bg-yellow-400 px-5 py-3 rounded-xl font-black text-xs uppercase tracking-widest text-black hover:bg-black hover:text-white transition">Buat HPP Baru</a>
                </div>
            </div>

            @include('business.partials.hpp_nav')

            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                @if($bomList->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada Bill of Material karena belum ada perhitungan HPP. Buat HPP untuk melihat BOM.</p>
                @else
                    <div class="space-y-10">
                        @foreach($bomList as $hpp)
                            <div class="border border-gray-100 rounded-3xl">
                                <div class="px-8 py-6 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                                    <div>
                                        <div class="text-xs font-black text-gray-400 uppercase tracking-widest">Produk</div>
                                        <div class="text-lg font-black text-gray-900">{{ $hpp->name }} <span class="text-xs text-gray-400">({{ $hpp->hpp_id }})</span></div>
                                    </div>
                                    <a href="{{ route('hpp.show', $hpp->id) }}" class="text-xs font-black uppercase tracking-widest text-blue-600 hover:text-blue-400">Lihat Detail</a>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-sm">
                                        <thead>
                                            <tr class="text-xs uppercase text-gray-500">
                                                <th class="py-3">Bahan</th>
                                                <th class="py-3">Warna</th>
                                                <th class="py-3 text-right">Kebutuhan</th>
                                                <th class="py-3 text-right">Harga/Unit</th>
                                                <th class="py-3 text-right">Subtotal</th>
                                                <th class="py-3">Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach($hpp->items as $item)
                                                <tr>
                                                    <td class="py-3 font-black">{{ $item->material->name }}</td>
                                                    <td class="py-3">{{ $item->material->color }}</td>
                                                    <td class="py-3 text-right">{{ $item->usage_amount }}</td>
                                                    <td class="py-3 text-right">Rp{{ number_format($item->material->price, 0, ',', '.') }}</td>
                                                    <td class="py-3 text-right">Rp{{ number_format($item->subtotal_cost, 0, ',', '.') }}</td>
                                                    <td class="py-3">{{ $item->material->unit }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
