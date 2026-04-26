{{-- File: welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ClarityLab | Fashion Brand Intelligence</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style>
        :root {
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --ora: #F97316;
            --ora-dk: #EA580C;
        }
        
        * { font-family: var(--font-sans); }
        
        body { 
            background: linear-gradient(160deg, #fff7f3 0%, #ffffff 40%, #fff3ed 70%, #fef9f7 100%);
            overflow-x: hidden;
            color: #1e293b;
        }
        
        .dark body { background: #0F172A; color: #f8fafc; }
        
        .glass-nav { 
            background: rgba(255, 255, 255, 0.92); 
            backdrop-filter: blur(16px); 
            border-bottom: 1px solid rgba(249, 115, 22, 0.1);
        }
        
        .dark .glass-nav { background: rgba(15, 23, 42, 0.95); border-bottom-color: rgba(249, 115, 22, 0.2); }
        
        .text-gradient-orange {
            background: linear-gradient(135deg, #F97316 0%, #F59E0B 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-title { font-size: 4rem; font-weight: 800; line-height: 1.1; letter-spacing: -0.04em; }
        .hero-sub { font-size: 1.25rem; color: #475569; max-width: 600px; line-height: 1.6; }
        .dark .hero-sub { color: #94a3b8; }

        .pcard {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 32px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .dark .pcard { background: #1e293b; border-color: #334155; }
        .pcard:hover { transform: translateY(-8px); border-color: var(--ora); box-shadow: 0 20px 25px -12px rgba(249, 115, 22, 0.15); }

        .btn-primary { background: var(--ora); color: white; padding: 12px 28px; border-radius: 14px; font-weight: 700; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary:hover { background: var(--ora-dk); transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(249, 115, 22, 0.3); }

        .btn-secondary { background: #f1f5f9; color: #1e293b; padding: 12px 28px; border-radius: 14px; font-weight: 700; transition: all 0.2s; }
        .dark .btn-secondary { background: #334155; color: #f8fafc; }

        .badge-premium { background: var(--ora); color: white; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; }
        
        .section-eyebrow { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--ora); margin-bottom: 12px; }
        .section-title { font-size: 2.5rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 16px; }
        
        @media (max-width: 768px) { .hero-title { font-size: 2.5rem; } }
    </style>
</head>
<body x-data="{ checkoutModal: false, selectedProduct: null, selectedPrice: 0 }">

    <!-- Navigation -->
    <nav class="glass-nav fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('welcome') }}" class="flex items-center gap-2 group">
                <!-- Tampil di Light Mode (Logo Dark) -->
                <img src="{{ asset('images/ClarityLabs_Light.svg') }}" alt="ClarityLabs" class="h-10 w-auto block dark:hidden group-hover:scale-105 transition-transform duration-300">
                <!-- Tampil di Dark Mode (Logo Light) -->
                <img src="{{ asset('images/ClarityLabs_Dark.svg') }}" alt="ClarityLabs" class="h-10 w-auto hidden dark:block group-hover:scale-105 transition-transform duration-300">
                <span class="text-xl font-black tracking-tight dark:text-white transition-colors">ClarityLab</span>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="#products" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-orange-500 transition-colors">Products</a>
                <a href="#pricing" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-orange-500 transition-colors">Pricing</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary py-2 px-6">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-900 dark:text-white">Log in</a>
                    <a href="{{ route('register') }}" class="btn-primary py-2 px-6">Get started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="pt-40 pb-24 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-columns-2 gap-16 items-center">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-100 dark:bg-orange-500/10 border border-orange-200 dark:border-orange-500/20 mb-8">
                    <div class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></div>
                    <span class="text-[11px] font-extrabold text-orange-600 dark:text-orange-400 uppercase tracking-widest">Tools untuk fashion brand owner</span>
                </div>
                <h1 class="hero-title mb-8 dark:text-white">
                    Jalanin bisnis fashion<br>dengan <span class="text-gradient-orange">clarity</span>, bukan<br>tebak-tebakan.
                </h1>
                <p class="hero-sub mb-10">
                    ClarityLab menyediakan tools digital untuk bantu lo hitung HPP, susun brief yang jelas, dan ambil keputusan bisnis berdasarkan data — bukan feeling.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#products" class="btn-primary text-lg px-10">Lihat semua tools →</a>
                </div>
                <div class="mt-16 flex gap-12">
                    <div>
                        <p class="text-3xl font-black text-gray-900 dark:text-white">5</p>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Tools Ekosistem</p>
                    </div>
                    <div class="w-px h-12 bg-gray-200 dark:bg-gray-800"></div>
                    <div>
                        <p class="text-3xl font-black text-gray-900 dark:text-white">3</p>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Tersedia Sekarang</p>
                    </div>
                    <div class="w-px h-12 bg-gray-200 dark:bg-gray-800"></div>
                    <div>
                        <p class="text-3xl font-black text-gray-900 dark:text-white">2</p>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Segera Hadir</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products -->
    <section id="products" class="py-24 px-6 bg-white dark:bg-navy-900 transition-colors">
        <div class="max-w-7xl mx-auto">
            <p class="section-eyebrow">Products</p>
            <h2 class="section-title dark:text-white">Satu ekosistem, lima tools.</h2>
            <p class="hero-sub mb-16">Dari ngitung HPP, bikin brief, evaluasi produk, kontrol inventory, sampai visual profesional — semua ada di satu tempat.</p>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- VCP -->
                <div class="pcard">
                    <div class="w-12 h-12 bg-orange-50 dark:bg-orange-500/10 rounded-xl flex items-center justify-center text-orange-500 mb-6">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <span class="badge-premium mb-4 inline-block">Brief & Visual</span>
                    <h3 class="text-xl font-extrabold mb-4 dark:text-white">Visual Clarity Pack</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-8 leading-relaxed">Template briefing dan dokumen kerja yang bikin tim, vendor, dan klien lo ngerti dari awal — tanpa perlu diulang.</p>
                    <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-6">
                        <p class="text-2xl font-black dark:text-white">Rp 149k</p>
                        <button @click="checkoutModal = true; selectedProduct = { id: 1, name: 'Visual Clarity Pack' }; selectedPrice = 149000" class="btn-primary py-2 px-6">Beli</button>
                    </div>
                </div>

                <!-- PCC -->
                <div class="pcard border-orange-500/50 shadow-xl shadow-orange-500/10">
                    <div class="w-12 h-12 bg-orange-50 dark:bg-orange-500/10 rounded-xl flex items-center justify-center text-orange-500 mb-6">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="badge-premium bg-orange-600">Terlaris</span>
                    </div>
                    <h3 class="text-xl font-extrabold mb-4 dark:text-white">Profit Clarity Calculator</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-8 leading-relaxed">Hitung HPP produk fashion lo dengan benar — bahan, CMT, packaging, reject rate, sampai margin yang realistis.</p>
                    <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-6">
                        <p class="text-2xl font-black dark:text-white">Rp 149k</p>
                        <button @click="checkoutModal = true; selectedProduct = { id: 2, name: 'Profit Clarity Calculator' }; selectedPrice = 149000" class="btn-primary py-2 px-6">Beli</button>
                    </div>
                </div>

                <!-- DE -->
                <div class="pcard">
                    <div class="w-12 h-12 bg-orange-50 dark:bg-orange-500/10 rounded-xl flex items-center justify-center text-orange-500 mb-6">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <span class="badge-premium mb-4 inline-block">Decision</span>
                    <h3 class="text-xl font-extrabold mb-4 dark:text-white">Decision Engine</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-8 leading-relaxed">Evaluasi apakah produk layak dijual — berdasarkan angka, bukan feeling. Sebelum produksi, lo udah tau jawabannya.</p>
                    <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-6">
                        <p class="text-2xl font-black dark:text-white">Rp 249k</p>
                        <button @click="checkoutModal = true; selectedProduct = { id: 3, name: 'Decision Engine' }; selectedPrice = 249000" class="btn-primary py-2 px-6">Beli</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bundle -->
    <section id="pricing" class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <p class="section-eyebrow">Bundles</p>
                <h2 class="section-title dark:text-white">Pilih paket yang paling sesuai.</h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <!-- Tier 1 -->
                <div class="pcard">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Tier 1</p>
                    <h3 class="text-2xl font-black mb-4 dark:text-white">Clarity Essentials</h3>
                    <p class="text-sm text-gray-500 mb-8 leading-relaxed">Dua tools inti untuk keputusan produk yang lebih tajam — hitung HPP dulu, lalu evaluasi apakah produknya layak dijual.</p>
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center gap-3 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></svg>
                            Profit Clarity Calculator
                        </div>
                        <div class="flex items-center gap-3 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></svg>
                            Decision Engine
                        </div>
                        <div class="flex items-center gap-3 text-sm font-bold text-gray-400 line-through">
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></svg>
                            Visual Clarity Pack
                        </div>
                    </div>
                    <div class="flex items-baseline gap-3 mb-6">
                        <span class="text-3xl font-black dark:text-white">Rp 279k</span>
                        <span class="text-sm text-gray-400 line-through">Rp 398k</span>
                    </div>
                    <p class="text-orange-600 font-bold text-sm mb-8">Hemat Rp 119k dari harga satuan</p>
                    <button class="btn-secondary w-full">Beli Essentials</button>
                </div>

                <!-- Tier 2 -->
                <div class="pcard border-orange-500 border-2 relative overflow-hidden">
                    <div class="absolute top-6 right-6 badge-premium">Rekomendasi</div>
                    <p class="text-xs font-black text-orange-500 uppercase tracking-widest mb-2">Tier 2</p>
                    <h3 class="text-2xl font-black mb-4 dark:text-white">Clarity Full</h3>
                    <p class="text-sm text-gray-500 mb-8 leading-relaxed">Ekosistem lengkap — brief yang jelas, HPP yang akurat, dan keputusan produk yang terukur. Plus akses prioritas ke tools berikutnya.</p>
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center gap-3 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></svg>
                            Visual Clarity Pack
                        </div>
                        <div class="flex items-center gap-3 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></svg>
                            Profit Clarity Calculator
                        </div>
                        <div class="flex items-center gap-3 text-sm font-bold text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></svg>
                            Decision Engine
                        </div>
                        <div class="flex items-center gap-3 text-sm font-bold text-orange-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></svg>
                            Akses prioritas tools baru
                        </div>
                    </div>
                    <div class="flex items-baseline gap-3 mb-6">
                        <span class="text-3xl font-black dark:text-white">Rp 389k</span>
                        <span class="text-sm text-gray-400 line-through">Rp 547k</span>
                    </div>
                    <p class="text-orange-600 font-bold text-sm mb-8">Hemat Rp 158k — bayar 2, dapet 3</p>
                    <button class="btn-primary w-full">Beli Clarity Full</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-24 px-6 bg-gray-50 dark:bg-navy-950 transition-colors">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-2">
                    <div class="flex items-center gap-2 mb-6">
                        <!-- Tampil di Light Mode (Logo Dark) -->
                        <img src="{{ asset('images/ClarityLabs_Light.svg') }}" alt="ClarityLabs" class="h-8 w-auto block dark:hidden">
                        <!-- Tampil di Dark Mode (Logo Light) -->
                        <img src="{{ asset('images/ClarityLabs_Dark.svg') }}" alt="ClarityLabs" class="h-8 w-auto hidden dark:block">
                        <span class="text-lg font-black dark:text-white tracking-tight">ClarityLab</span>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 max-w-sm leading-relaxed">Tools digital untuk fashion brand owner yang mau jalanin bisnis dengan data, bukan feeling. Berhenti nebak-tebak, mulai dengan clarity.</p>
                </div>
                <div>
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Products</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-orange-500">Visual Clarity Pack</a></li>
                        <li><a href="#" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-orange-500">Profit Clarity Calculator</a></li>
                        <li><a href="#" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-orange-500">Decision Engine</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Company</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-orange-500">About</a></li>
                        <li><a href="#" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-orange-500">Support</a></li>
                        <li><a href="#" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-orange-500">Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-gray-200 dark:border-gray-800 flex justify-between items-center flex-wrap gap-4">
                <p class="text-sm text-gray-400">© 2024 ClarityLab.id. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-xs font-bold text-gray-400 hover:text-gray-600 uppercase tracking-widest">Privacy</a>
                    <a href="#" class="text-xs font-bold text-gray-400 hover:text-gray-600 uppercase tracking-widest">Terms</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Checkout Modal -->
    <div x-show="checkoutModal" class="fixed inset-0 z-[100] flex items-center justify-center px-4" x-cloak>
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="checkoutModal = false"></div>
        <div class="bg-white dark:bg-navy-900 w-full max-w-md rounded-3xl p-8 relative shadow-2xl">
            <h2 class="text-2xl font-black mb-2 dark:text-white">Satu langkah lagi.</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-8">Lo akan membeli <span class="font-black text-orange-500" x-text="selectedProduct?.name"></span>.</p>
            
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" :value="selectedProduct?.id">
                <input type="hidden" name="total_price" :value="selectedPrice">
                
                <div class="bg-gray-50 dark:bg-navy-950 p-6 rounded-2xl mb-8">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Bayar</span>
                        <span class="text-2xl font-black text-orange-500" x-text="'Rp ' + (selectedPrice/1000) + 'k'"></span>
                    </div>
                    <p class="text-[10px] text-gray-400">Pembayaran aman via Midtrans. Akses instan setelah bayar.</p>
                </div>
                
                <div class="flex gap-4">
                    <button type="button" @click="checkoutModal = false" class="btn-secondary flex-1">Batal</button>
                    <button type="submit" class="btn-primary flex-1 justify-center">Lanjutkan ke Pembayaran</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
