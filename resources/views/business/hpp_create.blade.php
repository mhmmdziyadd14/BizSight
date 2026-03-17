<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0F172A; }
    </style>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between border-b border-gray-800 pb-10">
                <div>
                    <h1 class="text-5xl font-black text-white tracking-tighter uppercase italic">
                        Kalkulator <span class="text-yellow-400">HPP</span>
                    </h1>
                    <p class="mt-4 text-gray-500 font-medium max-w-xl">
                        Mode Preview Aktif: Tamu dapat menghitung simulasi secara bebas. Login diperlukan untuk menyimpan data ke database.
                    </p>
                </div>
                <div class="mt-6 md:mt-0">
                    <span class="bg-gray-800 text-yellow-400 px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border border-gray-700">
                        BizSight Precision Engine v1.0
                    </span>
                </div>
            </div>

            <form action="{{ auth()->check() ? route('hpp.store') : '#' }}" method="POST" id="hppForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    
                    <!-- INPUT IDENTITAS & JASA (LEFT) -->
                    <div class="lg:col-span-4 space-y-8 lg:sticky lg:top-8">
                        <!-- ID Card -->
                        <div class="bg-gray-900 border border-gray-800 p-8 rounded-[2.5rem] shadow-2xl">
                            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-8">01. Identitas Project</h3>
                            <div class="space-y-6">
                                <div>
                                    <label class="text-[9px] font-black text-gray-600 uppercase tracking-widest block mb-2">Nama Produk</label>
                                    <input type="text" name="name" class="w-full bg-black/40 border-gray-800 rounded-2xl py-4 text-sm font-bold text-white focus:ring-yellow-400" placeholder="Kemeja Tactical V1">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-gray-600 uppercase tracking-widest block mb-2">Kategori Bisnis</label>
                                    <select name="category" class="w-full bg-black/40 border-gray-800 rounded-2xl py-4 text-sm font-bold text-white focus:ring-yellow-400">
                                        <option>Fashion & Apparel</option>
                                        <option>Culinary / F&B</option>
                                        <option>Furniture</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Jasa Card -->
                        <div class="bg-yellow-400 p-8 rounded-[2.5rem] shadow-xl shadow-yellow-400/5">
                            <h3 class="text-[10px] font-black text-black uppercase tracking-[0.3em] mb-8">02. Biaya Jasa / Makloon</h3>
                            <div class="space-y-6">
                                <div>
                                    <label class="text-[9px] font-black text-black/40 uppercase tracking-widest block mb-2">Jasa Sablon / Unit</label>
                                    <input type="number" name="screen_printing_fee" class="w-full bg-white/30 border-none rounded-2xl py-4 text-lg font-black text-black focus:ring-black" value="0">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-black/40 uppercase tracking-widest block mb-2">Jasa Jahit / Unit</label>
                                    <input type="number" name="sewing_fee" class="w-full bg-white/30 border-none rounded-2xl py-4 text-lg font-black text-black focus:ring-black" value="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TABEL BAHAN BAKU (RIGHT) -->
                    <div class="lg:col-span-8">
                        <div class="bg-white rounded-[3rem] overflow-hidden shadow-2xl">
                            <div class="bg-gray-50 px-10 py-8 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="text-[10px] font-black text-gray-900 uppercase tracking-[0.3em]">03. Komponen Material</h3>
                                <button type="button" id="addRow" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">+ Tambah Baris</button>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-left" id="materialsTable">
                                    <thead>
                                        <tr class="bg-gray-50/50">
                                            <th class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest">Bahan Baku</th>
                                            <th class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-center">Qty Pakai</th>
                                            <th class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        <tr class="material-row group">
                                            <td class="px-10 py-8">
                                                <select name="materials[]" class="w-full border-none bg-transparent text-sm font-bold text-gray-900 focus:ring-0 p-0 material-select">
                                                    <option value="" data-price="0">- Pilih dari Database -</option>
                                                    @foreach($materials as $mat)
                                                        <option value="{{ $mat->id }}" data-price="{{ $mat->unit_price }}" data-unit="{{ $mat->unit }}">
                                                            {{ $mat->name }} (Rp{{ number_format($mat->unit_price,0) }}/{{ $mat->unit }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-[10px] text-gray-400 mt-2 font-bold uppercase unit-label">Satuan: -</div>
                                            </td>
                                            <td class="px-10 py-8">
                                                <div class="flex items-center justify-center bg-gray-50 rounded-xl px-4 py-2 border border-transparent focus-within:border-yellow-400 transition-all">
                                                    <input type="number" step="0.01" name="usage[]" class="w-16 bg-transparent border-none text-center font-black text-gray-900 focus:ring-0 usage-input" value="0">
                                                </div>
                                            </td>
                                            <td class="px-10 py-8 text-right font-mono font-bold text-gray-900 subtotal-display">Rp 0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Final Calculation Summary -->
                            <div class="p-10 bg-gray-900 flex flex-col md:flex-row items-center justify-between gap-8">
                                <div>
                                    <div class="text-[9px] font-black text-gray-500 uppercase tracking-[0.3em] mb-2">Total HPP Produksi / Unit</div>
                                    <div class="text-4xl font-black text-yellow-400 tracking-tighter" id="totalHppDisplay">Rp 0</div>
                                </div>
                                <div class="flex gap-4">
                                    @auth
                                        <button type="submit" class="bg-yellow-400 text-black px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-white transition-all shadow-xl shadow-yellow-400/20">
                                            Simpan Perhitungan
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}" class="bg-white/10 text-white px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-xs border border-white/10 hover:bg-yellow-400 hover:text-black transition-all">
                                            Login untuk Simpan
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Live Calculation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('#materialsTable tbody');
            const totalHppDisplay = document.getElementById('totalHppDisplay');

            function calculateTotals() {
                let totalMaterials = 0;
                document.querySelectorAll('.material-row').forEach(row => {
                    const select = row.querySelector('.material-select');
                    const usage = parseFloat(row.querySelector('.usage-input').value) || 0;
                    const price = parseFloat(select.options[select.selectedIndex]?.dataset.price) || 0;
                    const subtotal = usage * price;
                    
                    row.querySelector('.subtotal-display').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
                    totalMaterials += subtotal;
                });

                const printing = parseFloat(document.querySelector('[name="screen_printing_fee"]').value) || 0;
                const sewing = parseFloat(document.querySelector('[name="sewing_fee"]').value) || 0;

                const grandTotal = totalMaterials + printing + sewing;
                totalHppDisplay.innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
            }

            tableBody.addEventListener('change', (e) => {
                if(e.target.classList.contains('material-select')) {
                    const row = e.target.closest('tr');
                    const option = e.target.options[e.target.selectedIndex];
                    row.querySelector('.unit-label').innerText = 'Satuan: ' + (option.dataset.unit || '-');
                    calculateTotals();
                }
            });

            tableBody.addEventListener('input', (e) => {
                if(e.target.classList.contains('usage-input')) calculateTotals();
            });

            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', calculateTotals);
            });

            document.getElementById('addRow').addEventListener('click', () => {
                const newRow = tableBody.querySelector('tr').cloneNode(true);
                newRow.querySelector('.usage-input').value = 0;
                newRow.querySelector('.subtotal-display').innerText = 'Rp 0';
                tableBody.appendChild(newRow);
            });
        });
    </script>
</x-app-layout>