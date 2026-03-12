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
                        Ubah data mentah menjadi keputusan bisnis yang matang. Masukkan angka penting Anda dan biarkan mesin BizSight menganalisis kelayakannya.
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="bg-white border px-4 py-2 rounded-full text-xs font-bold text-gray-500 uppercase tracking-widest shadow-sm">
                        Enterprise Edition v1.0
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden sticky top-8">
                        <div class="bg-gray-900 px-6 py-5 flex items-center justify-between">
                            <h3 class="font-bold text-white flex items-center tracking-wide">
                                <span class="bg-yellow-400 text-black w-6 h-6 rounded-full flex items-center justify-center mr-3 text-xs">A</span>
                                Business Variables
                            </h3>
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        </div>
                        
                        <form action="{{ route('calculate') }}" method="POST" class="p-8 space-y-6">
                            @csrf
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Product Name</label>
                                <input type="text" name="product_name" required
                                    class="w-full bg-gray-50 border-gray-200 rounded-xl py-3 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-all font-semibold"
                                    placeholder="Contoh: Sayur Organik X">
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">HPP & Selling Price</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                            <input type="number" name="hpp" required class="w-full pl-9 border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-bold focus:ring-yellow-400" value="85000" placeholder="HPP">
                                        </div>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                            <input type="number" name="selling_price" required class="w-full pl-9 border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-bold focus:ring-yellow-400" value="175000" placeholder="Jual">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Ads & Batch Quantity</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                                            <input type="number" name="ads_per_unit" required class="w-full pl-9 border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-bold focus:ring-yellow-400" value="30000">
                                        </div>
                                        <div class="relative">
                                            <input type="number" name="est_batch_quantity" required class="w-full pr-10 border-gray-200 bg-gray-50 rounded-xl py-3 text-sm font-bold focus:ring-yellow-400" value="100">
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 text-[10px] font-bold">PCS</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit" 
                                    class="w-full bg-yellow-400 text-black py-4 rounded-2xl font-extrabold text-sm uppercase tracking-widest hover:bg-black hover:text-white transition-all duration-300 shadow-xl shadow-yellow-200 hover:shadow-none active:scale-95">
                                    Analyze Viability
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-8">
                    @if($calculations->count() > 0)
                        @php $latest = $calculations->first(); @endphp
                        
                        <div class="space-y-8">
                            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-6 flex items-center">
                                    <span class="bg-yellow-100 text-yellow-600 w-6 h-6 rounded-full flex items-center justify-center mr-3 text-xs">B</span>
                                    Financial Breakdown
                                </h3>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                                    <div class="p-4 bg-gray-50 rounded-2xl">
                                        <div class="text-[10px] font-black text-gray-400 uppercase mb-2">Margin/Unit</div>
                                        <div class="text-lg font-bold text-gray-900">Rp{{ number_format($latest->selling_price - $latest->hpp, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="p-4 bg-gray-50 rounded-2xl">
                                        <div class="text-[10px] font-black text-gray-400 uppercase mb-2">Total Ads Cost</div>
                                        <div class="text-lg font-bold text-gray-900">Rp{{ number_format($latest->ads_per_unit * $latest->est_batch_quantity, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="p-4 bg-gray-50 rounded-2xl">
                                        <div class="text-[10px] font-black text-gray-400 uppercase mb-2">Batch Revenue</div>
                                        <div class="text-lg font-bold text-gray-900">Rp{{ number_format($latest->selling_price * $latest->est_batch_quantity, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="p-4 bg-yellow-50 border border-yellow-100 rounded-2xl">
                                        <div class="text-[10px] font-black text-yellow-600 uppercase mb-2">Net Profit/Unit</div>
                                        <div class="text-lg font-black text-gray-900">Rp{{ number_format($latest->net_profit, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-900 rounded-[2.5rem] p-1 shadow-2xl overflow-hidden">
                                <div class="bg-white rounded-[2.3rem] overflow-hidden">
                                    <div class="bg-gray-900 px-8 py-5 flex justify-between items-center text-white">
                                        <h3 class="font-bold tracking-wide flex items-center">
                                            <span class="bg-yellow-400 text-black w-6 h-6 rounded-full flex items-center justify-center mr-3 text-xs italic">C</span>
                                            The Verdict
                                        </h3>
                                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">BizSight Analysis Result</span>
                                    </div>

                                    <div class="p-10">
                                        <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-10 pb-10 border-b border-gray-100">
                                            <div>
                                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Health Status</div>
                                                <div class="text-5xl font-black text-gray-900 tracking-tighter">{{ $latest->status_label }}</div>
                                            </div>
                                            <div class="flex space-x-4">
                                                <div class="text-right">
                                                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Net Margin</div>
                                                    <div class="text-3xl font-black text-yellow-500">{{ number_format($latest->net_margin_percent, 1) }}%</div>
                                                </div>
                                                <div class="h-12 w-px bg-gray-100"></div>
                                                <div>
                                                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">BEP Unit</div>
                                                    <div class="text-3xl font-black text-gray-900">{{ $latest->bep_unit }} <span class="text-xs text-gray-300">pcs</span></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid md:grid-cols-2 gap-10 mb-10">
                                            <div class="space-y-3">
                                                <div class="text-xs font-black text-gray-400 uppercase tracking-[0.1em]">Logic Reasoning</div>
                                                <p class="text-xl text-gray-800 font-bold italic leading-snug">"{{ $latest->logic_reason }}"</p>
                                            </div>
                                            <div class="space-y-3">
                                                <div class="text-xs font-black text-gray-400 uppercase tracking-[0.1em]">Action Required</div>
                                                <div class="bg-gray-900 text-white p-6 rounded-3xl shadow-lg relative overflow-hidden group">
                                                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-yellow-400 rounded-full opacity-10 group-hover:scale-150 transition-all duration-700"></div>
                                                    <p class="text-sm font-semibold leading-relaxed relative z-10">{{ $latest->action_required }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex gap-4">
                                            <a href="{{ route('print.pdf', $latest->id) }}" class="flex-1 bg-yellow-400 py-4 rounded-2xl text-center text-xs font-black uppercase tracking-widest text-black hover:bg-black hover:text-white transition-all shadow-lg shadow-yellow-100">
                                                Generate PDF Report
                                            </a>
                                            <button onclick="window.print()" class="px-6 border-2 border-gray-900 rounded-2xl hover:bg-gray-50 transition-all">
                                                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="h-full flex flex-col items-center justify-center bg-white rounded-[2.5rem] border-2 border-dashed border-gray-100 p-20 text-center">
                            <div class="w-24 h-24 bg-yellow-50 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <h4 class="text-2xl font-black text-gray-900 mb-2">Siap Menganalisis Bisnis Anda?</h4>
                            <p class="text-gray-400 max-w-sm">Masukkan variabel harga dan biaya di sisi kiri. BizSight akan menghitung profitabilitas batch Anda secara instan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="text-xl font-extrabold text-gray-900 mb-4 italic">BizSight</div>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">© 2026 Developed by Muhammad Ziyad • ITENAS Bandung</p>
        </div>
    </footer>
</x-app-layout>