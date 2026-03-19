<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kalkulasi HPP') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('business.partials.hpp_nav')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-2xl font-black">{{ $hpp->name }}</h3>
                            <p class="text-sm text-gray-500">Kategori: {{ $hpp->category }}</p>
                            <p class="text-sm text-gray-500">ID HPP: {{ $hpp->hpp_id }}</p>
                            <p class="text-sm text-gray-500">Dibuat: {{ $hpp->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3">
                            <a href="{{ route('hpp.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition">Buat Baru</a>
                            @if($hpp->printed_at)
                                <div class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold text-xs uppercase tracking-widest">
                                    Sudah dicetak: {{ $hpp->printed_at->format('d M Y H:i') }}
                                </div>
                                <a href="{{ route('hpp.print', $hpp->id) }}" class="px-6 py-3 bg-yellow-400 text-black rounded-xl font-black text-xs uppercase tracking-widest hover:bg-yellow-300 transition">Cetak Ulang</a>
                            @else
                                <a href="{{ route('hpp.print', $hpp->id) }}" class="px-6 py-3 bg-yellow-400 text-black rounded-xl font-black text-xs uppercase tracking-widest hover:bg-yellow-300 transition">Cetak PDF</a>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 bg-gray-50 p-8 rounded-3xl shadow-inner">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <div class="text-xs font-black uppercase tracking-widest text-gray-500">Total Bahan Baku</div>
                                <div class="text-3xl font-black text-gray-900">Rp {{ number_format($hpp->total_raw_material_cost, 0, ',', '.') }}</div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-xs font-black uppercase tracking-widest text-gray-500">Total HPP / Unit</div>
                                <div class="text-3xl font-black text-yellow-500">Rp {{ number_format($hpp->total_hpp_per_unit, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <div class="text-sm font-black uppercase tracking-widest text-gray-500 mb-3">Rincian Biaya Tambahan</div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="bg-white p-6 rounded-2xl shadow-sm">
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Biaya Sablon</div>
                                    <div class="text-xl font-black">Rp {{ number_format($hpp->screen_printing_fee, 0, ',', '.') }}</div>
                                </div>
                                <div class="bg-white p-6 rounded-2xl shadow-sm">
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Biaya Jahit</div>
                                    <div class="text-xl font-black">Rp {{ number_format($hpp->sewing_fee, 0, ',', '.') }}</div>
                                </div>
                                <div class="bg-white p-6 rounded-2xl shadow-sm">
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Biaya Lainnya</div>
                                    <div class="text-xl font-black">Rp {{ number_format($hpp->other_fees, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 bg-white rounded-3xl shadow-lg overflow-hidden">
                        <div class="p-8 border-b border-gray-100">
                            <div class="text-sm font-black uppercase tracking-widest text-gray-500">Detail Komponen Bahan</div>
                        </div>
                        <table class="w-full text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest">Bahan</th>
                                    <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest">Satuan</th>
                                    <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest text-right">Harga / Unit</th>
                                    <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest text-right">Qty</th>
                                    <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($hpp->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-black text-gray-900">{{ $item->material->name }}</td>
                                        <td class="px-6 py-4 text-sm font-black text-gray-900">{{ $item->material->unit }}</td>
                                        <td class="px-6 py-4 text-sm font-black text-gray-900 text-right">Rp {{ number_format($item->material->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm font-black text-gray-900 text-right">{{ $item->usage_amount }}</td>
                                        <td class="px-6 py-4 text-sm font-black text-gray-900 text-right">Rp {{ number_format($item->subtotal_cost, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
