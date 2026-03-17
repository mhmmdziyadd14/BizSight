<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0F172A; }
        .glass-card { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Bagian Header -->
            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between border-b border-gray-800 pb-10">
                <div>
                    <h1 class="text-5xl font-black text-white tracking-tighter uppercase italic">
                        Kalkulator <span class="text-yellow-400">HPP</span>
                    </h1>
                    <p class="mt-4 text-gray-500 font-medium max-w-xl italic">
                        Input detail produksi Anda. BizSight akan menghitung Harga Pokok Penjualan secara presisi sebelum Anda menentukan harga jual.
                    </p>
                </div>
                <div class="mt-6 md:mt-0">
                    <span class="bg-gray-800 text-yellow-400 px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border border-gray-700">
                        BizSight Precision Engine v1.0
                    </span>
                </div>
            </div>

            <!-- Form Utama -->
            <form action="{{ route('hpp.store') }}" method="POST" id="hppForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    
                    <!-- SISI KIRI: IDENTITAS & JASA -->
                    <div class="lg:col-span-4 space-y-8 lg:sticky lg:top-8">
                        
                        <!-- Card Identitas -->
                        <div class="bg-gray-900 border border-gray-800 p-8 rounded-[2.5rem] shadow-2xl">
                            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-8">01. Identitas Project</h3>
                            <div class="space-y-6">
                                <div>
                                    <label class="text-[9px] font-black text-gray-600 uppercase tracking-widest block mb-2">Nama Produk</label>
                                    <input type="text" name="product_name" required 
                                        class="w-full bg-black/40 border-gray-800 rounded-2xl py-4 text-sm font-bold text-white focus:ring-yellow-400 focus:border-yellow-400 transition-all" 
                                        placeholder="Contoh: Kemeja Tactical V1">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-gray-600 uppercase tracking-widest block mb-2">Kategori Bisnis</label>
                                    <select name="category" class="w-full bg-black/40 border-gray-800 rounded-2xl py-4 text-sm font-bold text-white focus:ring-yellow-400">
                                        <option value="Fashion">Fashion & Apparel</option>
                                        <option value="F&B">Culinary / F&B</option>
                                        <option value="Furniture">Furniture</option>
                                        <option value="Digital">Digital Product</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Card Jasa -->
                        <div class="bg-yellow-400 p-8 rounded-[2.5rem] shadow-xl shadow-yellow-400/5">
                            <h3 class="text-[10px] font-black text-black uppercase tracking-[0.3em] mb-8">02. Biaya Jasa / Makloon</h3>
                            <div class="space-y-6">
                                <div>
                                    <label class="text-[9px] font-black text-black/40 uppercase tracking-widest block mb-2">Jasa Sablon / Unit (Rp)</label>
                                    <input type="number" name="screen_printing_fee" 
                                        class="fee-input w-full bg-white/30 border-none rounded-2xl py-4 text-lg font-black text-black focus:ring-black" 
                                        value="0" min="0">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-black/40 uppercase tracking-widest block mb-2">Jasa Jahit / Unit (Rp)</label>
                                    <input type="number" name="sewing_fee" 
                                        class="fee-input w-full bg-white/30 border-none rounded-2xl py-4 text-lg font-black text-black focus:ring-black" 
                                        value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SISI KANAN: TABEL KOMPONEN MATERIAL -->
                    <div class="lg:col-span-8">
                        <div class="bg-white rounded-[3rem] overflow-hidden shadow-2xl">
                            <div class="bg-gray-50 px-10 py-8 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="text-[10px] font-black text-gray-900 uppercase tracking-[0.3em]">03. Komponen Material (Bahan Baku)</h3>
                                <button type="button" id="addRow" class="bg-blue-600 text-white px-5 py-2 rounded-full text-[9px] font-black uppercase tracking-widest hover:bg-black transition-all">
                                    + Tambah Baris
                                </button>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-left" id="materialsTable">
                                    <thead>
                                        <tr class="bg-gray-50/50">
                                            <th class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest w-1/2">Nama Bahan</th>
                                            <th class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-center">Qty Pakai</th>
                                            <th class="px-10 py-5 text-[9px] font-black text-gray-400 uppercase tracking-widest text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        <!-- Row Bahan Baku -->
                                        <tr class="material-row group">
                                            <td class="px-10 py-8">
                                                <input type="text" name="material_names[]" required 
                                                    class="w-full border-none bg-transparent text-sm font-bold text-gray-900 focus:ring-0 p-0" 
                                                    placeholder="Contoh: Kain Cotton Combed 30s">
                                                <div class="flex items-center mt-2 space-x-3">
                                                    <span class="text-[8px] font-black text-gray-400 uppercase">Harga/Satuan: Rp</span>
                                                    <input type="number" name="material_prices[]" 
                                                        class="price-input w-24 bg-transparent border-none p-0 text-[10px] font-black text-blue-600 focus:ring-0" 
                                                        value="0">
                                                </div>
                                            </td>
                                            <td class="px-10 py-8">
                                                <div class="flex items-center justify-center bg-gray-50 rounded-xl px-4 py-2 border border-transparent focus-within:border-yellow-400 transition-all">
                                                    <input type="number" step="0.01" name="material_usages[]" 
                                                        class="usage-input w-16 bg-transparent border-none text-center font-black text-gray-900 focus:ring-0" 
                                                        value="0">
                                                </div>
                                            </td>
                                            <td class="px-10 py-8 text-right font-mono font-bold text-gray-900 subtotal-display">
                                                Rp 0
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Total Ringkasan -->
                            <div class="p-10 bg-gray-900 flex flex-col md:flex-row items-center justify-between gap-8">
                                <div>
                                    <div class="text-[9px] font-black text-gray-500 uppercase tracking-[0.3em] mb-2">Estimasi HPP Per Unit</div>
                                    <div class="text-5xl font-black text-yellow-400 tracking-tighter" id="totalHppDisplay">Rp 0</div>
                                </div>
                                <div class="flex gap-4">
                                    <button type="submit" class="bg-yellow-400 text-black px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-white transition-all shadow-xl shadow-yellow-400/20 active:scale-95">
                                        Simpan Perhitungan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Perhitungan Live -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('#materialsTable tbody');
            const totalHppDisplay = document.getElementById('totalHppDisplay');
            const feeInputs = document.querySelectorAll('.fee-input');

            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            }

            function calculateTotals() {
                let totalMaterials = 0;
                
                // Hitung setiap baris material
                document.querySelectorAll('.material-row').forEach(row => {
                    const price = parseFloat(row.querySelector('.price-input').value) || 0;
                    const usage = parseFloat(row.querySelector('.usage-input').value) || 0;
                    const subtotal = price * usage;
                    
                    row.querySelector('.subtotal-display').innerText = formatRupiah(subtotal);
                    totalMaterials += subtotal;
                });

                // Tambahkan biaya jasa
                let totalFees = 0;
                feeInputs.forEach(input => {
                    totalFees += parseFloat(input.value) || 0;
                });

                const grandTotal = totalMaterials + totalFees;
                totalHppDisplay.innerText = formatRupiah(grandTotal);
            }

            // Event Listener untuk input yang sudah ada
            tableBody.addEventListener('input', (e) => {
                if (e.target.classList.contains('price-input') || e.target.classList.contains('usage-input')) {
                    calculateTotals();
                }
            });

            feeInputs.forEach(input => {
                input.addEventListener('input', calculateTotals);
            });

            // Tambah baris baru
            document.getElementById('addRow').addEventListener('click', () => {
                const firstRow = tableBody.querySelector('tr');
                const newRow = firstRow.cloneNode(true);
                
                // Reset input di baris baru
                newRow.querySelectorAll('input').forEach(input => {
                    if (input.type === 'number') input.value = 0;
                    else input.value = '';
                });
                newRow.querySelector('.subtotal-display').innerText = 'Rp 0';
                
                // Tambahkan tombol hapus jika baris lebih dari satu
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.innerHTML = '×';
                deleteBtn.className = 'ml-2 text-red-500 font-bold hover:text-red-700';
                deleteBtn.onclick = function() {
                    newRow.remove();
                    calculateTotals();
                };
                
                // Masukkan tombol hapus ke kolom terakhir jika diperlukan atau buat kolom baru
                tableBody.appendChild(newRow);
            });
            
            // Inisialisasi awal
            calculateTotals();
        });
    </script>
</x-app-layout>