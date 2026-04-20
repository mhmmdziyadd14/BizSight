<x-app-layout>
    <style>
        .sidebar-item.active {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            color: white !important;
        }
        .progress-bar {
            height: 6px;
            background: #E5E7EB;
            border-radius: 10px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: #F97316;
            width: 13%; /* Dinamis */
        }
        .preview-box {
            background: #0F172A;
            border-radius: 20px;
            padding: 40px;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
        }
    </style>

    <div class="py-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center text-white shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-navy-900 uppercase italic">Visual <span class="text-orange-500">Clarity</span> Pack</h1>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Enterprise Design System v1.0</p>
                    </div>
                </div>
                <button onclick="window.location.href='{{ route('download.template') }}'" class="bg-navy-900 text-white px-6 py-3 rounded-xl font-bold text-sm flex items-center gap-2 hover:bg-black transition-all shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    DOWNLOAD PDF — A3
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                        <div class="mb-6">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-xs font-black text-navy-800 uppercase">Progress</span>
                                <span class="text-xs font-black text-orange-500">13%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>
                        </div>

                        <nav class="space-y-2">
                            @php
                                $steps = [
                                    ['id' => 1, 'name' => 'Cover Page'],
                                    ['id' => 2, 'name' => 'Technical Sheet'],
                                    ['id' => 3, 'name' => 'Revision Log'],
                                    ['id' => 4, 'name' => 'Bill of Materials'],
                                    ['id' => 5, 'name' => 'Packaging Spec'],
                                    ['id' => 6, 'name' => 'Care Instruction'],
                                    ['id' => 7, 'name' => 'Sample Checklist'],
                                    ['id' => 8, 'name' => 'Production Timeline'],
                                ];
                            @endphp

                            @foreach($steps as $step)
                            <a href="#" class="sidebar-item {{ $step['id'] == 1 ? 'active' : 'text-gray-500' }} flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all hover:bg-orange-50 group">
                                <span class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center text-[10px]">{{ $step['id'] }}</span>
                                {{ $step['name'] }}
                            </a>
                            @endforeach
                        </nav>
                    </div>
                </div>

                <div class="lg:col-span-9 space-y-6">
                    
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-orange-50 px-8 py-4 border-b border-orange-100">
                            <span class="text-[10px] font-black text-orange-600 uppercase tracking-widest bg-white px-3 py-1 rounded-full shadow-sm">Halaman 1 dari 8</span>
                            <h2 class="text-xl font-black text-navy-900 mt-2">Cover Page</h2>
                            <p class="text-sm text-gray-500">Identitas utama dokumen — Nama brand, logo, dan tujuan dokumen.</p>
                        </div>

                        <div class="p-8 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <label class="block text-xs font-black text-navy-800 uppercase tracking-wider italic border-l-4 border-orange-500 pl-3">Identitas Brand</label>
                                    <div>
                                        <label class="block text-[10px] text-gray-400 font-bold uppercase mb-1">Nama Brand</label>
                                        <input type="text" class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-orange-500 focus:border-orange-500 font-bold" placeholder="Masukkan Nama Brand">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-gray-400 font-bold uppercase mb-1">Ditujukan Untuk</label>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach(['Client', 'Vendor', 'Supplier', 'Internal'] as $target)
                                            <button class="px-4 py-2 rounded-lg border border-gray-200 text-xs font-bold hover:bg-orange-500 hover:text-white transition-all">{{ $target }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <label class="block text-xs font-black text-navy-800 uppercase tracking-wider italic border-l-4 border-orange-500 pl-3">Upload Logo</label>
                                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 flex flex-col items-center justify-center bg-gray-50 hover:bg-orange-50 transition-all cursor-pointer group">
                                        <svg class="w-10 h-10 text-gray-300 group-hover:text-orange-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs font-bold text-gray-400 uppercase">PNG / SVG • Maks 2MB</span>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <div class="space-y-4">
                                <label class="block text-xs font-black text-navy-800 uppercase tracking-wider italic border-l-4 border-orange-500 pl-3">Preview Cover</label>
                                <div class="preview-box shadow-2xl overflow-hidden relative group">
                                    <div class="absolute top-6 left-6 bg-orange-500/20 text-orange-500 px-4 py-2 rounded-lg text-[10px] font-black tracking-widest border border-orange-500/30 backdrop-blur">TECHNICAL PACKAGE</div>
                                    
                                    <h3 id="previewBrandName" class="text-6xl font-black tracking-tighter uppercase opacity-90">BRAND NAME</h3>
                                    
                                    <div class="mt-8 flex flex-col items-center gap-2">
                                        <div class="w-16 h-1 w-16 bg-orange-500 rounded-full mb-2"></div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em]">Document for :</p>
                                        <p class="text-xs font-black text-orange-400">[Client, Vendors, Suppliers]</p>
                                    </div>

                                    <div class="absolute bottom-0 left-0 right-0 h-12 bg-black/40 backdrop-blur-md flex items-center justify-between px-8 text-[9px] font-bold text-white/50 border-t border-white/10 uppercase tracking-widest">
                                        <span>Visual Clarity Pack — ClarityLabs System</span>
                                        <span>claritylab.id</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 flex justify-between border-t border-gray-100">
                            <button class="px-6 py-3 rounded-xl border border-gray-200 font-black text-xs text-gray-400 uppercase">← Back</button>
                            <button class="bg-gradient-orange text-white px-8 py-3 rounded-xl font-black text-xs uppercase shadow-lg hover:shadow-orange-200 transition-all flex items-center gap-2">
                                Technical Sheet →
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>