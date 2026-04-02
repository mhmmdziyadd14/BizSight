{{-- File: welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ClarityLabs | SME Intelligence Platform</title>
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <!-- Alpine.js for Modals -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body { 
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            overflow-x: hidden;
        }
        
        .glass-nav { 
            background: rgba(15, 23, 42, 0.9); 
            backdrop-filter: blur(12px); 
            border-bottom: 1px solid rgba(249, 115, 22, 0.2);
        }
        
        .modal-bg { 
            background: rgba(0, 0, 0, 0.85); 
            backdrop-filter: blur(12px); 
        }
        
        .bg-gradient-orange {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
        }
        
        .text-gradient-orange {
            background: linear-gradient(135deg, #F97316 0%, #F59E0B 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #F97316, #F59E0B);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(249, 115, 22, 0.5);
            box-shadow: 0 20px 35px -12px rgba(249, 115, 22, 0.2);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
        }
        
        .btn-outline {
            border: 1px solid rgba(249, 115, 22, 0.5);
            transition: all 0.2s ease;
        }
        
        .btn-outline:hover {
            background: rgba(249, 115, 22, 0.1);
            border-color: #F97316;
            transform: translateY(-2px);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .float-animation {
            animation: float 4s ease-in-out infinite;
        }
        
        @keyframes glowPulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.05); }
        }
        
        .hero-glow {
            animation: glowPulse 4s ease-in-out infinite;
        }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased text-white overflow-x-hidden" x-data="{ openModal: false, activeFeature: {} }">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="text-3xl font-black tracking-tight transition-all hover:scale-105 flex items-center gap-1">
                <span class="bg-gradient-to-r from-orange-500 to-orange-400 bg-clip-text text-transparent">Clarity</span>
                <span class="text-white">Labs</span>
            </a>

            <!-- Menu Kanan -->
            <div class="flex items-center gap-6">
                <a href="#features" class="text-[10px] font-bold text-gray-400 hover:text-orange-400 uppercase tracking-wider transition-all hidden md:block">
                    Fitur Utama
                </a>
                
                <div class="h-6 w-px bg-orange-500/30 hidden md:block"></div>

                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <!-- Tampilan User Aktif -->
                            <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-xl border border-orange-500/30 group hover:border-orange-400 transition-all">
                                <div class="w-8 h-8 bg-gradient-orange rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[8px] font-bold text-gray-500 uppercase leading-none mb-1">User Active</span>
                                    <a href="{{ route('profile.edit') }}" class="text-[10px] font-bold uppercase tracking-wide text-white hover:text-orange-400 transition-all leading-none">
                                        {{ Auth::user()->name }}
                                    </a>
                                </div>
                                <span class="text-gray-600 px-1">|</span>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-bold text-orange-400 uppercase tracking-wider hover:text-white transition-all bg-gray-800/50 px-3 py-1.5 rounded-lg">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Menu Guest -->
                            <a href="{{ route('login') }}" class="text-[10px] font-bold uppercase tracking-wider text-gray-400 hover:text-orange-400 transition-all px-2">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-primary text-white px-6 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-wider shadow-lg hover:shadow-orange-500/25 transition-all">
                                    Daftar Akun
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="pt-48 pb-28 text-center relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 relative z-10">
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full border border-orange-500/30 bg-orange-500/10 text-orange-400 text-[9px] font-bold uppercase tracking-wider mb-8">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                </span>
                SME Intelligence Dashboard
            </div>
            <h1 class="text-6xl md:text-8xl lg:text-9xl font-black tracking-tighter mb-6 leading-[0.9]">
                <span class="text-white">Cek</span>
                <span class="bg-gradient-to-r from-orange-500 to-orange-400 bg-clip-text text-transparent">Profit</span>
                <br>
                <span class="text-white">Tanpa</span>
                <span class="bg-gradient-to-r from-orange-400 to-orange-300 bg-clip-text text-transparent">Ribet</span>
                <span class="text-white">.</span>
            </h1>
            <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-12 font-medium leading-relaxed">
                Kuasai Harga Pokok Penjualan dan Analisis kelayakan bisnis UMKM Anda bersama ClarityLabs.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#features" class="btn-primary inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-sm font-black uppercase tracking-wider text-white shadow-xl transition-all">
                    <span>Mulai Analisis</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
                <a href="{{ route('business.index') }}" class="btn-outline inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-sm font-black uppercase tracking-wider text-orange-400 hover:text-orange-300 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Demo Gratis
                </a>
            </div>
        </div>
        
        <!-- Animated Background Elements -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-orange-500/10 rounded-full blur-[140px] hero-glow -z-10"></div>
        <div class="absolute top-20 right-10 w-64 h-64 bg-orange-400/5 rounded-full blur-[100px] -z-10 float-animation"></div>
        <div class="absolute bottom-20 left-10 w-80 h-80 bg-orange-600/5 rounded-full blur-[120px] -z-10 float-animation" style="animation-delay: 2s;"></div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-32 bg-gradient-to-b from-navy-900 to-navy-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-[10px] font-bold text-orange-400 uppercase tracking-wider border border-orange-500/30 px-4 py-2 rounded-full">Core Features</span>
                <h2 class="text-4xl md:text-5xl font-black tracking-tight mt-6">
                    <span class="text-white">Powerful Tools for</span>
                    <br>
                    <span class="bg-gradient-to-r from-orange-500 to-orange-400 bg-clip-text text-transparent">Business Intelligence</span>
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Feature 1: Clarity Profit -->
                <div @click="openModal = true; activeFeature = { 
                        title: 'Clarity Profit', 
                        desc: 'Hitung HPP real, bukan perkiraan. Ketahui margin sebenarnya dan profit per produk dengan akurat. Berhenti rugi dalam hitungan.',
                        url: '{{ route('hpp.bahan') }}',
                        icon: 'PROFIT',
                        theme: 'orange'
                    }" 
                    class="feature-card bg-white/5 border border-white/10 p-8 rounded-3xl cursor-pointer group hover:border-orange-500/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-orange rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="text-orange-400 font-black text-4xl mb-4 opacity-30 group-hover:opacity-100 transition-all">01</div>
                    <h4 class="text-xl font-black mb-3 tracking-tight text-white">Clarity <span class="text-gradient-orange">Profit</span></h4>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">Hitung HPP real dengan margin sebenarnya per unit produk.</p>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-orange-400 uppercase tracking-wider group-hover:gap-2 transition-all">
                        Buka Informasi
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>

                <!-- Feature 2: Clarity Decision -->
                <div @click="openModal = true; activeFeature = { 
                        title: 'Clarity Decision', 
                        desc: 'Jelas mana yang perlu dilanjutkan atau dihentikan. PO atau ready stock, growth atau efisiensi. Buat keputusan bisnis dengan data real.',
                        url: '{{ route('business.index') }}',
                        icon: 'DECISION',
                        theme: 'orange'
                    }"
                    class="feature-card bg-white/5 border border-white/10 p-8 rounded-3xl cursor-pointer group hover:border-orange-500/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-orange rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="text-orange-400 font-black text-4xl mb-4 opacity-30 group-hover:opacity-100 transition-all">02</div>
                    <h4 class="text-xl font-black mb-3 tracking-tight text-white">Clarity <span class="text-gradient-orange">Decision</span></h4>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">Framework keputusan bisnis berbasis data real untuk strategi cepat.</p>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-orange-400 uppercase tracking-wider group-hover:gap-2 transition-all">
                        Buka Informasi
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>

                <!-- Feature 3: Clarity Visual -->
                <div @click="openModal = true; activeFeature = { 
                        title: 'Clarity Visual', 
                        desc: 'Sederhanakan ide bisnis kompleks menjadi visual yang jelas. Lihat masalah lebih jernih dan komunikasikan strategy ke tim dengan mudah.',
                        url: '{{ route('download.template') }}',
                        icon: 'VISUAL',
                        theme: 'orange'
                    }"
                    class="feature-card bg-white/5 border border-white/10 p-8 rounded-3xl cursor-pointer group hover:border-orange-500/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-orange rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div class="text-orange-400 font-black text-4xl mb-4 opacity-30 group-hover:opacity-100 transition-all">03</div>
                    <h4 class="text-xl font-black mb-3 tracking-tight text-white">Clarity <span class="text-gradient-orange">Visual</span></h4>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">Template visual untuk mapping ide bisnis dan analisis masalah strategis.</p>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-orange-400 uppercase tracking-wider group-hover:gap-2 transition-all">
                        Unduh Resource
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>

                <!-- Feature 4: Clarity Control (Coming Soon) -->
                <div class="feature-card bg-white/5 border border-white/10 p-8 rounded-3xl cursor-default opacity-60 group hover:border-orange-500/50 transition-all relative">
                    <div class="absolute top-4 right-4 inline-flex items-center px-3 py-1.5 bg-orange-500/20 border border-orange-500/30 rounded-full">
                        <span class="text-[9px] font-bold text-orange-400 uppercase tracking-wider">Coming Soon</span>
                    </div>
                    <div class="w-14 h-14 bg-gradient-orange rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-orange-400 font-black text-4xl mb-4 opacity-30 group-hover:opacity-100 transition-all">04</div>
                    <h4 class="text-xl font-black mb-3 tracking-tight text-white">Clarity <span class="text-gradient-orange">Control</span></h4>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">Inventory control system. Tahu kapan restock, hindari dead stock, jaga cashflow tetap sehat.</p>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-orange-400 uppercase tracking-wider group-hover:gap-2 transition-all">
                        Segera Hadir
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>

                <!-- Feature 5: Clarity Studio (Coming Soon) -->
                <div class="feature-card bg-white/5 border border-white/10 p-8 rounded-3xl cursor-default opacity-60 group hover:border-orange-500/50 transition-all relative">
                    <div class="absolute top-4 right-4 inline-flex items-center px-3 py-1.5 bg-orange-500/20 border border-orange-500/30 rounded-full">
                        <span class="text-[9px] font-bold text-orange-400 uppercase tracking-wider">Coming Soon</span>
                    </div>
                    <div class="w-14 h-14 bg-gradient-orange rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2"></path>
                        </svg>
                    </div>
                    <div class="text-orange-400 font-black text-4xl mb-4 opacity-30 group-hover:opacity-100 transition-all">05</div>
                    <h4 class="text-xl font-black mb-3 tracking-tight text-white">Clarity <span class="text-gradient-orange">Studio</span></h4>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">Mockup design system. Visual produk profesional, tingkatkan perceived value, percepat konten.</p>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-orange-400 uppercase tracking-wider group-hover:gap-2 transition-all">
                        Segera Hadir
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>

            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-gradient-to-b from-navy-800 to-navy-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6">
                    <div class="text-4xl font-black text-orange-400 mb-2">500+</div>
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Business Analyzed</div>
                </div>
                <div class="p-6 border-l border-r border-orange-500/20">
                    <div class="text-4xl font-black text-orange-400 mb-2">98%</div>
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Accuracy Rate</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-black text-orange-400 mb-2">24/7</div>
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Support Available</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Explanation -->
    <div x-show="openModal" 
         class="fixed inset-0 z-[60] flex items-center justify-center p-6 modal-bg" 
         x-transition.opacity 
         x-cloak>
        <div class="bg-gradient-to-br from-gray-900 to-navy-900 border border-orange-500/30 w-full max-w-2xl rounded-3xl p-10 shadow-2xl relative overflow-hidden" @click.away="openModal = false">
            <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full blur-[100px] bg-orange-500/20"></div>
            <div class="absolute -left-20 -bottom-20 w-64 h-64 rounded-full blur-[100px] bg-orange-600/20"></div>
            
            <div class="mb-8 relative z-10">
                <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-[9px] font-bold text-orange-400 uppercase tracking-wider" x-text="'Engine Module: ' + activeFeature.icon"></span>
                <h3 class="text-3xl font-black tracking-tight mt-3 text-white" x-text="activeFeature.title"></h3>
            </div>
            <p class="text-gray-400 text-base leading-relaxed mb-10 relative z-10" x-text="activeFeature.desc"></p>
            <div class="flex flex-col sm:flex-row gap-4 relative z-10">
                <a :href="activeFeature.url" class="btn-primary flex-1 text-center py-4 rounded-xl text-sm font-black uppercase tracking-wider text-white shadow-lg transition-all">
                    Aktifkan Fitur Sekarang
                </a>
                <button @click="openModal = false" class="px-8 py-4 border border-orange-500/30 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-orange-500/10 transition-all text-white">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-navy-900 border-t border-orange-500/20 py-20 text-center">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-center gap-2 mb-6">
                <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="text-2xl font-black tracking-tight">
                    <span class="bg-gradient-to-r from-orange-500 to-orange-400 bg-clip-text text-transparent">Clarity</span>
                    <span class="text-white">Labs</span>
                </div>
            </div>
            <div class="text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-6">
                COMMAND CENTER • BUSINESS INTELLIGENCE PLATFORM
            </div>
            <div class="h-px w-20 bg-orange-500/30 mx-auto mb-8"></div>
            <p class="text-[10px] text-gray-500 font-semibold uppercase tracking-wider">
                Developed by Muhammad Ziyad • Institut Teknologi Nasional Bandung
            </p>
        </div>
    </footer>

</body>
</html>