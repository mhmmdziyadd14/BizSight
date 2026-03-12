<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-lg mb-4">Monitoring Produk User (AVS Store)</h3>
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Pemilik</th>
                            <th class="border p-2">Nama Produk</th>
                            <th class="border p-2">HPP</th>
                            <th class="border p-2">Harga Jual</th>
                            <th class="border p-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calculations as $calc)
                        <tr>
                            <td class="border p-2">{{ $calc->user->name }}</td>
                            <td class="border p-2">{{ $calc->product_name }}</td>
                            <td class="border p-2">Rp{{ number_format($calc->hpp, 0, ',', '.') }}</td>
                            <td class="border p-2">Rp{{ number_format($calc->selling_price, 0, ',', '.') }}</td>
                            <td class="border p-2 font-bold">{{ $calc->status_label }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>