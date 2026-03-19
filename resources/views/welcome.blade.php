<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BizSight | SME Intelligence</title>
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Alpine.js for Modals -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #0F172A; 
        }
        .glass-nav { 
            background: rgba(15, 23, 42, 0.8); 
            backdrop-filter: blur(15px); 
            border-bottom: 1px solid rgba(255, 255, 255, 0.05); 
        }
        .modal-bg { 
            background: rgba(0, 0, 0, 0.9); 
            backdrop-filter: blur(10px); 
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased text-white overflow-x-hidden" x-data="{ openModal: false, activeFeature: {} }">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="text-3xl font-black italic tracking-tighter transition-all hover:scale-105">
                <span class="text-yellow-400">Biz</span>Sight
            </a>

            <!-- Menu Kanan -->
            <div class="flex items-center">
                <a href="#features" class="text-[10px] font-black text-gray-500 hover:text-yellow-400 uppercase tracking-[0.3em] transition-all hidden md:block mr-10">
                    Fitur Utama
                </a>
                
                <div class="h-4 w-px bg-white/10 hidden md:block mr-8"></div>

                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <!-- Tampilan User Aktif -->
                            <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-2xl border border-white/10 group hover:border-yellow-400 transition-all">
                                <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center text-black text-xs font-black shadow-lg shadow-yellow-400/20">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-gray-500 uppercase leading-none mb-1">User Active</span>
                                    <a href="{{ route('profile.edit') }}" class="text-[10px] font-black uppercase tracking-[0.1em] text-white hover:text-yellow-400 transition-all leading-none">
                                        {{ Auth::user()->name }}
                                    </a>
                                </div>
                                <span class="text-gray-700 px-1">|</span>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-black text-yellow-400 uppercase tracking-widest hover:text-white transition-all bg-gray-800 px-3 py-1.5 rounded-lg">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Menu Guest -->
                            <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 hover:text-white transition-all px-2">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-yellow-400 text-black px-6 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-white transition-all shadow-xl shadow-yellow-400/10">Daftar Akun</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="pt-56 pb-24 text-center relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 relative z-10">
            <div class="inline-flex items-center px-4 py-2 rounded-full border border-yellow-400/20 bg-yellow-400/5 text-yellow-400 text-[9px] font-black uppercase tracking-[0.3em] mb-8">
                🔥 SME Intelligence Dashboard
            </div>
            <h1 class="text-7xl md:text-9xl font-black tracking-tighter mb-8 leading-[0.85] uppercase italic">
                Cek <span class="text-yellow-400">Profit</span><br>Tanpa <span class="text-blue-500 underline decoration-blue-500/20">Ribet</span>.
            </h1>
            <p class="text-gray-500 text-lg md:text-xl max-w-xl mx-auto mb-14 font-medium leading-relaxed uppercase tracking-tight italic">
                Kuasai Harga Pokok Penjualan dan Analisis kelayakan bisnis UMKM Anda bersama BizSight.
            </p>
            <a href="#features" class="inline-block bg-white/5 border border-white/10 px-14 py-5 rounded-[2.5rem] text-[10px] font-black uppercase tracking-[0.3em] hover:bg-yellow-400 hover:text-black transition-all group shadow-2xl">
                <span class="group-hover:mr-2 transition-all italic">Mulai Analisis</span> ↓
            </a>
        </div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-yellow-400/5 rounded-full blur-[140px] -z-10"></div>
    </header>

    <!-- Fitur Section -->
    <section id="features" class="py-36 bg-[#0a101e]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                
                <!-- Fitur 1: HPP -->
                <div @click="openModal = true; activeFeature = { 
                        title: 'Kalkulator HPP Detail', 
                        desc: 'Input bahan baku dari gudang Anda, tambahkan jasa sablon, bordir, hingga jahit. Dapatkan hasil HPP per unit yang sangat presisi.',
                        url: '{{ route('hpp.bahan') }}',
                        icon: 'HPP',
                        theme: 'yellow'
                    }" 
                    class="bg-gray-900 border border-white/5 p-12 rounded-[4rem] hover:border-yellow-400/40 transition-all cursor-pointer group shadow-2xl relative overflow-hidden">
                    <div class="text-yellow-400 font-black text-5xl mb-10 italic opacity-10 group-hover:opacity-100 transition-all duration-500">01</div>
                    <h4 class="text-2xl font-black mb-4 uppercase tracking-tighter italic text-white">Hitung <span class="text-yellow-400">HPP</span></h4>
                    <p class="text-gray-600 text-xs leading-relaxed mb-8 font-bold uppercase tracking-wider">Mendetailkan biaya variabel produksi.</p>
                    <span class="text-[9px] font-black text-yellow-400 uppercase tracking-widest border-b border-yellow-400/10 pb-1 group-hover:border-yellow-400 transition-all">Buka Informasi</span>
                </div>

                <!-- Fitur 2: Biz Checker -->
                <div @click="openModal = true; activeFeature = { 
                        title: 'Viability Checker', 
                        desc: 'Analisis kesehatan bisnis Anda secara visual. Masukkan harga jual dan biaya operasional untuk melihat BEP dan Net Margin.',
                        url: '{{ route('business.index') }}',
                        icon: 'CHECKER',
                        theme: 'blue'
                    }"
                    class="bg-gray-900 border border-white/5 p-12 rounded-[4rem] hover:border-blue-500/40 transition-all cursor-pointer group shadow-2xl relative overflow-hidden">
                    <div class="text-blue-500 font-black text-5xl mb-10 italic opacity-10 group-hover:opacity-100 transition-all duration-500">02</div>
                    <h4 class="text-2xl font-black mb-4 uppercase tracking-tighter italic text-white">Business <span class="text-blue-500">Checker</span></h4>
                    <p class="text-gray-600 text-xs leading-relaxed mb-8 font-bold uppercase tracking-wider">Uji kesehatan finansial project.</p>
                    <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest border-b border-blue-500/10 pb-1 group-hover:border-blue-500 transition-all">Buka Informasi</span>
                </div>

                <!-- Fitur 3: Starter Kit -->
                <div @click="openModal = true; activeFeature = { 
                        title: 'Starter Kit Bundle', 
                        desc: 'Unduh aset pendukung operasional berupa template manajemen, format laporan, dan panduan keuangan UMKM.',
                        url: '{{ route('download.template') }}',
                        icon: 'KIT',
                        theme: 'white'
                    }"
                    class="bg-gray-900 border border-white/5 p-12 rounded-[4rem] hover:border-white/20 transition-all cursor-pointer group shadow-2xl relative overflow-hidden">
                    <div class="text-white font-black text-5xl mb-10 italic opacity-10 group-hover:opacity-100 transition-all duration-500">03</div>
                    <h4 class="text-2xl font-black mb-4 uppercase tracking-tighter italic text-white">Starter <span class="text-gray-400">Kit</span></h4>
                    <p class="text-gray-600 text-xs leading-relaxed mb-8 font-bold uppercase tracking-wider">Aset pendukung operasional.</p>
                    <span class="text-[9px] font-black text-white uppercase tracking-widest border-b border-white/10 pb-1 group-hover:border-white transition-all">Unduh Resource</span>
                </div>

            </div>
        </div>
    </section>

    <!-- Modal Penjelasan -->
    <div x-show="openModal" 
         class="fixed inset-0 z-[60] flex items-center justify-center p-6 modal-bg" 
         x-transition.opacity 
         x-cloak>
        <div class="bg-gray-900 border border-white/10 w-full max-w-2xl rounded-[4rem] p-16 shadow-2xl relative overflow-hidden" @click.away="openModal = false">
            <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full blur-[100px] opacity-20" :class="'bg-' + activeFeature.theme + '-400'"></div>
            <div class="mb-12 relative z-10">
                <span class="text-[10px] font-black text-yellow-400 uppercase tracking-[0.6em]" x-text="'Engine Module: ' + activeFeature.icon"></span>
                <h3 class="text-5xl font-black italic tracking-tighter mt-6 uppercase text-white" x-text="activeFeature.title"></h3>
            </div>
            <p class="text-gray-400 text-xl leading-relaxed mb-16 relative z-10 font-medium italic" x-text="activeFeature.desc"></p>
            <div class="flex flex-col sm:flex-row gap-5 relative z-10">
                <a :href="activeFeature.url" class="flex-1 bg-yellow-400 text-black py-6 rounded-[2rem] text-center text-xs font-black uppercase tracking-[0.2em] hover:bg-white transition-all shadow-2xl shadow-yellow-400/20 active:scale-95">
                    Aktifkan Fitur Sekarang
                </a>
                <button @click="openModal = false" class="px-10 border border-white/10 rounded-[2rem] text-xs font-black uppercase tracking-widest hover:bg-white/5 transition-all text-white">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <footer class="bg-[#0a101e] border-t border-white/5 py-32 text-center">
        <div class="text-2xl font-black italic text-gray-800 tracking-[0.3em] mb-6 uppercase tracking-tighter">BIZSIGHT • COMMAND CENTER</div>
        <div class="h-px w-20 bg-yellow-400/20 mx-auto mb-12"></div>
        <p class="text-xs text-gray-600 font-bold uppercase tracking-[0.2em]">
            Developed by Muhammad Ziyad • ITENAS Bandung
        </p>
    </footer>

</body>
</html>