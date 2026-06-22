{{-- File: welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ClarityLab | Fashion Brand Intelligence</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        // Theme initialization
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Cross-tab theme synchronization
        window.addEventListener('storage', function(e) {
            if (e.key === 'theme') {
                if (e.newValue === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        });
        
        // Local time formatter
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.local-time').forEach(function(el) {
                const utcDate = el.getAttribute('data-utc');
                const format = el.getAttribute('data-format') || 'd M Y';
                if (utcDate) {
                    const date = new Date(utcDate);
                    const options = {};
                    
                    if (format.includes('d') || format.includes('M') || format.includes('Y')) {
                        options.day = '2-digit';
                        options.month = 'short';
                        options.year = 'numeric';
                    }
                    
                    if (format.includes('H:i') || format.includes('h:i')) {
                        options.hour = '2-digit';
                        options.minute = '2-digit';
                    }
                    
                    // Default to date if empty
                    if (Object.keys(options).length === 0) {
                        options.day = '2-digit';
                        options.month = 'short';
                        options.year = 'numeric';
                    }
                    
                    el.textContent = date.toLocaleString('id-ID', options).replace(/,/g, '');
                }
            });
        });
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
<body x-data="{ checkoutModal: false, selectedProduct: null, selectedPrice: 0, notifyModal: false, notifyProduct: '' }">

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
                        <a href="https://clarity-labs.myscalev.com/c/checkout?variant_ids=497388&qty=1" class="btn-primary py-2 px-6">Beli</a>
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
                        <a href="https://clarity-labs.myscalev.com/c/checkout?variant_ids=497385&qty=1" class="btn-primary py-2 px-6">Beli</a>
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
                        <a href="https://clarity-labs.myscalev.com/c/checkout?variant_ids=497390&qty=1" class="btn-primary py-2 px-6">Beli</a>
                    </div>
                </div>
            </div>

            <!-- Segera Hadir Section -->
            <div class="mt-16 pt-16 border-t border-gray-100 dark:border-gray-800">
                <div class="mb-12">
                    <h3 class="text-2xl font-extrabold dark:text-white mb-4">Segera Hadir</h3>
                    <p class="text-gray-500 dark:text-gray-400">Tools baru yang sedang dalam tahap pengembangan untuk melengkapi ekosistem ClarityLab.</p>
                </div>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Card 1: ClarityLabs Control -->
                    <div class="pcard relative">
                        <div class="absolute top-6 right-6 text-xs font-bold text-gray-400">Coming soon</div>
                        <div class="w-12 h-12 bg-gray-50 dark:bg-gray-800 rounded-xl flex items-center justify-center text-gray-500 mb-6 border border-gray-200 dark:border-gray-700">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="3" x2="9" y2="21"></line></svg>
                        </div>
                        <h3 class="text-xl font-extrabold mb-4 dark:text-white">ClarityLabs Control</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-8 leading-relaxed">Inventory control system — tau kapan restock, hindari dead stock, jaga cashflow tetap sehat.</p>
                        
                        <div class="mb-8">
                            <div class="flex justify-between text-xs font-bold mb-2">
                                <span class="text-gray-500 dark:text-gray-400">Dalam pengembangan</span>
                                <span class="text-orange-500">65%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-orange-500 h-full rounded-full" style="width: 65%"></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-6">
                            <p class="text-sm font-bold text-gray-500 dark:text-gray-400">Harga menyusul</p>
                            <button @click="notifyModal = true; notifyProduct = 'ClarityLabs Control'" class="text-sm font-bold text-gray-900 dark:text-white hover:text-orange-500 transition-colors">Notify me</button>
                        </div>
                    </div>

                    <!-- Card 2: Mockup Design System -->
                    <div class="pcard relative">
                        <div class="absolute top-6 right-6 text-xs font-bold text-gray-400">Coming soon</div>
                        <div class="w-12 h-12 bg-gray-50 dark:bg-gray-800 rounded-xl flex items-center justify-center text-gray-500 mb-6 border border-gray-200 dark:border-gray-700">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <h3 class="text-xl font-extrabold mb-4 dark:text-white">Mockup Design System</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-8 leading-relaxed">Visual produk fashion yang profesional tanpa sesi foto mahal. Tingkatkan perceived value, percepat konten.</p>
                        
                        <div class="mb-8">
                            <div class="flex justify-between text-xs font-bold mb-2">
                                <span class="text-gray-500 dark:text-gray-400">Dalam pengembangan</span>
                                <span class="text-orange-400">40%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-orange-400 h-full rounded-full" style="width: 40%"></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-6">
                            <p class="text-sm font-bold text-gray-500 dark:text-gray-400">Harga menyusul</p>
                            <button @click="notifyModal = true; notifyProduct = 'Mockup Design System'" class="text-sm font-bold text-gray-900 dark:text-white hover:text-orange-500 transition-colors">Notify me</button>
                        </div>
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
                    <a href="https://clarity-labs.myscalev.com/c/checkout?variant_ids=497399&qty=1" class="btn-secondary w-full text-center block">Beli Essentials</a>
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
                    <a href="https://clarity-labs.myscalev.com/c/checkout?variant_ids=497401&qty=1" class="btn-primary w-full text-center justify-center block">Beli Clarity Full</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials (Clarity Gap) -->
    <section id="testimonials" class="py-24 px-6 bg-orange-50/30 dark:bg-navy-950/50 transition-colors border-t border-orange-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto">
            <div class="mb-16 max-w-2xl">
                <p class="section-eyebrow">Clarity Gap</p>
                <h2 class="section-title dark:text-white">From Real Operators</h2>
                <p class="hero-sub">Unfiltered insights from business owners — tentang apa yang sebenarnya terjadi di balik angka, sistem, dan keputusan sehari-hari.</p>
            </div>
            
            <div class="columns-1 md:columns-2 lg:columns-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="pcard break-inside-avoid mb-8">
                    <div class="mb-6 text-orange-500 opacity-40">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                        “Menurut gue, sistem itu penting banget supaya kerjaan nggak bottleneck di owner.<br><br>Tanpa standar yang jelas, tim bakal terus nanya dan akhirnya semua tetap balik ke kita. Di titik tertentu, kita sadar kalau bisnis ini nggak bisa jalan sendiri kalau semuanya masih bergantung ke owner.”
                    </p>
                    <div class="pt-6 border-t border-gray-100 dark:border-gray-800 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-orange flex items-center justify-center text-white font-bold text-sm">LR</div>
                        <div>
                            <p class="font-extrabold text-gray-900 dark:text-white text-sm">Lendra Radyan</p>
                            <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mt-0.5">Owner Auffan</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 (Long) -->
                <div class="pcard break-inside-avoid mb-8">
                    <div class="mb-6 text-orange-500 opacity-40">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                        “Briefing yang ngasal itu efeknya ke mana-mana. Bisa buang waktu, buang bahan, bahkan jadi produk gagal yang akhirnya numpuk jadi stok mati.<br><br>Vendor itu eksekutor — kalau kita nggak kasih panduan yang jelas, mereka pasti jalan pakai asumsi. Dan di situ biasanya mulai muncul revisi bolak-balik yang nggak ada habisnya.<br><br>Ujungnya, semua jadi lambat. Kita nggak bisa scale kalau setiap detail harus dijelasin terus-terusan.”
                    </p>
                    <div class="pt-6 border-t border-gray-100 dark:border-gray-800 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-orange flex items-center justify-center text-white font-bold text-sm">G</div>
                        <div>
                            <p class="font-extrabold text-gray-900 dark:text-white text-sm">Gegi</p>
                            <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mt-0.5">Owner Studiogegi & Ggoods</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="pcard break-inside-avoid mb-8">
                    <div class="mb-6 text-orange-500 opacity-40">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                        “Menurut gue kombinasi dua hal ini penting — data bikin performa bisnis jadi kelihatan, dan di saat yang sama bikin mental lebih ringan buat fokus ke strategi.<br><br>Kalau semuanya masih berceceran, kita bukan cuma susah ambil keputusan, tapi juga capek duluan mikirin hal-hal kecil.”
                    </p>
                    <div class="pt-6 border-t border-gray-100 dark:border-gray-800 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-orange flex items-center justify-center text-white font-bold text-sm">G</div>
                        <div>
                            <p class="font-extrabold text-gray-900 dark:text-white text-sm">Gunantyo</p>
                            <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mt-0.5">Owner Portee</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 4 -->
                <div class="pcard break-inside-avoid mb-8">
                    <div class="mb-6 text-orange-500 opacity-40">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                        “Menurut gue, R&D yang matang itu harus sejalan sama hitungan biaya yang akurat sejak awal.<br><br>Detail kecil yang sering dianggap sepele justru punya pengaruh ke hasil akhir. Kalau dari awal nggak dihitung dengan benar, efeknya bakal kerasa ke kualitas dan profit di belakang.”
                    </p>
                    <div class="pt-6 border-t border-gray-100 dark:border-gray-800 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-orange flex items-center justify-center text-white font-bold text-sm">NM</div>
                        <div>
                            <p class="font-extrabold text-gray-900 dark:text-white text-sm">Nanda Mareta</p>
                            <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mt-0.5">Owner Muna Mona</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 5 (Long) -->
                <div class="pcard break-inside-avoid mb-8">
                    <div class="mb-6 text-orange-500 opacity-40">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                        “Lebih dari sekadar HPP, menurut gue setiap business owner memang harus paham keuangan secara utuh. Tapi pondasinya tetap mulai dari HPP — karena dari situ kita baru bisa bangun ke HPP penjualan, laporan keuangan, sampai ke arah financial forecasting.<br><br>Tanpa dasar itu, semua keputusan di atasnya jadi nggak punya pijakan yang jelas.<br><br>Dan yang gue lihat, masalahnya bukan karena owner nggak mau ngerti — tapi karena nggak ada tools yang bantu nge-breakdown angka itu jadi sesuatu yang benar-benar keliatan dan bisa dipakai buat ambil keputusan.”
                    </p>
                    <div class="pt-6 border-t border-gray-100 dark:border-gray-800 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-orange flex items-center justify-center text-white font-bold text-sm">AS</div>
                        <div>
                            <p class="font-extrabold text-gray-900 dark:text-white text-sm">Artha Sanjaya</p>
                            <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mt-0.5">Owner Tusk Bag</p>
                        </div>
                    </div>
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
                        <li><a href="https://wa.me/6285797245448" target="_blank" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-orange-500">Support (+62 857-9724-5448)</a></li>
                        <li><a href="https://Instagram.com/claritylabs.id" target="_blank" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-orange-500">Instagram (@claritylabs.id)</a></li>
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

    <!-- Checkout Modal Removed (Using Scalev Links) -->

    <!-- Notify Modal -->
    <div x-show="notifyModal" class="fixed inset-0 z-[100] flex items-center justify-center px-4" x-cloak>
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="notifyModal = false"></div>
        <div class="bg-white dark:bg-navy-900 w-full max-w-md rounded-3xl p-8 relative shadow-2xl">
            <h2 class="text-2xl font-black mb-2 dark:text-white">Dapatkan Notifikasi</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-8">Kami akan kabarin lo pas <span class="font-black text-orange-500" x-text="notifyProduct"></span> udah rilis.</p>
            
            <form action="{{ route('notify.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_name" :value="notifyProduct">
                
                <div class="space-y-4 mb-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-2">Nama</label>
                        <input type="text" name="name" required class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 outline-none dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-2">No Telepon (WhatsApp)</label>
                        <input type="tel" name="phone" required class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 outline-none dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-2">Username Social Media (Opsional)</label>
                        <input type="text" name="social_media" placeholder="Contoh: @username" class="w-full bg-gray-50 dark:bg-navy-950 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 outline-none dark:text-white">
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <button type="button" @click="notifyModal = false" class="btn-secondary flex-1">Batal</button>
                    <button type="submit" class="btn-primary flex-1 justify-center">Kabari Saya</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Flash Message -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-4 right-4 z-[110] bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-4 transition-all duration-500" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <span class="font-medium">{{ session('success') }}</span>
        <button @click="show = false" class="text-white hover:text-green-200 focus:outline-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    @endif

</body>
</html>
