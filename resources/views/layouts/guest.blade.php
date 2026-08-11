{{-- File: guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Clarity Labs</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
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
        
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        
        <style>
            :root {
                --ora: #F97316;
                --ora-dk: #EA580C;
                --navy: #0F172A;
            }

            * { font-family: 'Outfit', sans-serif; }
            .clarity-labs-brand, .logo-text { font-family: 'Plus Jakarta Sans', sans-serif !important; }
            
            body { margin: 0; padding: 0; overflow-x: hidden; }

            .auth-wrapper { display: flex; min-height: 100vh; }

            /* Left Side: Form Section */
            .auth-left { 
                flex: 1.2; 
                background: white; 
                display: flex; 
                flex-direction: column; 
                padding: 40px 80px;
                justify-content: center;
            }
            .dark .auth-left { background: var(--navy); color: white; }

            /* Right Side: Branding Section */
            .auth-right { 
                flex: 0.8; 
                background: linear-gradient(135deg, var(--navy) 0%, #1e293b 100%); 
                padding: 60px; 
                display: flex; 
                flex-direction: column; 
                justify-content: center;
                position: relative;
                overflow: hidden;
                color: white;
            }
            .auth-right::before {
                content: '';
                position: absolute;
                top: -10%; right: -10%;
                width: 300px; height: 300px;
                background: radial-gradient(circle, rgba(249, 115, 22, 0.15), transparent 70%);
                pointer-events: none;
            }

            .logo-link { display: flex; align-items: center; gap: 12px; margin-bottom: 48px; text-decoration: none; }
            
            .benefit-item { display: flex; gap: 16px; margin-bottom: 32px; }
            .benefit-icon { 
                width: 40px; height: 40px; border-radius: 12px; 
                background: rgba(249, 115, 22, 0.1); 
                border: 1px solid rgba(249, 115, 22, 0.2);
                display: flex; align-items: center; justify-content: center; color: var(--ora);
                flex-shrink: 0;
            }
            .benefit-title { font-size: 16px; font-weight: 800; margin-bottom: 4px; }
            .benefit-desc { font-size: 13px; color: #94a3b8; line-height: 1.5; }

            .testimonial {
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.05);
                padding: 24px; border-radius: 20px; margin-top: 40px;
                backdrop-filter: blur(10px);
            }

            @media (max-width: 1024px) {
                .auth-wrapper { flex-direction: column; }
                .auth-left { padding: 60px 40px; order: 2; }
                .auth-right { padding: 60px 40px; order: 1; }
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="auth-wrapper">
            <!-- Form Section -->
            <div class="auth-left">
                <div class="max-w-md w-full mx-auto">
                    <a href="{{ route('welcome') }}" class="logo-link group mb-12">
                        <img src="{{ asset('images/ClarityLabs_Light.svg') }}" alt="Logo" class="h-10 w-auto dark:hidden">
                        <img src="{{ asset('images/ClarityLabs_Dark.svg') }}" alt="Logo" class="h-10 w-auto hidden dark:block">
                        <span class="text-2xl font-black tracking-tight text-navy dark:text-white transition-colors clarity-labs-brand">
                            <span class="text-orange-500">Clarity</span>Lab
                        </span>
                    </a>
                    
                    {{ $slot }}
                </div>
            </div>

            <!-- Branding Section -->
            <div class="auth-right">
                <div class="max-w-md">
                    <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center text-white shadow-lg mb-8">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    
                    <h2 class="text-3xl font-black mb-4 leading-tight">Decisions backed by clarity, not assumptions.</h2>
                    <p class="text-gray-400 mb-12 font-medium">Dirancang dari pengalaman real di production &amp; product development — ClarityLab membantu lo melihat apa yang benar-benar terjadi di balik angka.</p>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div>
                            <h4 class="benefit-title">HPP yang Akurat</h4>
                            <p class="benefit-desc">Hitung semua komponen biaya dan tahu margin Anda yang sebenarnya.</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div>
                            <h4 class="benefit-title">Briefing yang Jelas</h4>
                            <p class="benefit-desc">Template dokumen yang bikin vendor dan tim Anda paham dari awal.</p>
                        </div>
                    </div>

                    <div x-data="{
                        activeSlide: 0,
                        slides: [
                            {
                                text: 'Jujur, sampai hari ini gue masih menyeimbangkan antara data dan intuisi saat mengambil keputusan bisnis. Gue lihat angka penjualan, performa produk, dan margin. Tapi feeling tetap punya peran karena data yang gue punya belum selalu bisa kasih jawaban yang jelas.<br><br>Yang paling sering bikin overthinking adalah menentukan apakah produk baru ini layak dilanjutkan atau nggak.<br><br>Beberapa kali gue juga pernah yakin sama keputusan sendiri, tapi hasil akhirnya ternyata jauh dari ekspektasi.<br><br>Makanya menurut gue, proses analisis yang lebih terstruktur itu penting. Bukan buat menghilangkan intuisi, tapi supaya setiap keputusan punya pijakan yang lebih jelas dan bisa dipertanggungjawabkan.',
                                name: 'Muhammad Fadhillah Irfan',
                                role: 'Owner Sajadah Aladin',
                                initial: 'MI'
                            },
                            {
                                text: 'Menurut gue, sistem itu penting banget supaya kerjaan nggak bottleneck di owner.<br><br>Tanpa standar yang jelas, tim bakal terus nanya dan akhirnya semua tetap balik ke kita.',
                                name: 'Lendra Radyan',
                                role: 'Owner Auffan',
                                initial: 'LR'
                            },
                            {
                                text: 'Briefing yang ngasal itu efeknya ke mana-mana. Bisa buang waktu, buang bahan, bahkan jadi produk gagal yang akhirnya numpuk jadi stok mati.',
                                name: 'Gegi',
                                role: 'Owner Studiogegi & Ggoods',
                                initial: 'G'
                            },
                            {
                                text: 'Menurut gue kombinasi dua hal ini penting — data bikin performa bisnis jadi kelihatan, dan di saat yang sama bikin mental lebih ringan buat fokus ke strategi.',
                                name: 'Gunantyo',
                                role: 'Owner Portee',
                                initial: 'G'
                            },
                            {
                                text: 'Menurut gue, R&D yang matang itu harus sejalan sama hitungan biaya yang akurat sejak awal. Detail kecil yang sering dianggap sepele justru punya pengaruh ke hasil akhir.',
                                name: 'Nanda Mareta',
                                role: 'Owner Muna Mona',
                                initial: 'NM'
                            },
                            {
                                text: 'Lebih dari sekadar HPP, menurut gue setiap business owner memang harus paham keuangan secara utuh. Tapi pondasinya tetap mulai dari HPP — karena dari situ kita baru bisa bangun ke atas.',
                                name: 'Artha Sanjaya',
                                role: 'Owner Tusk Bag',
                                initial: 'AS'
                            }
                        ],
                        next() {
                            this.activeSlide = this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1;
                        },
                        init() {
                            setInterval(() => this.next(), 5000);
                        }
                    }" class="testimonial relative overflow-hidden pb-8">
                        <div class="relative w-full min-h-[160px]">
                            <template x-for="(slide, index) in slides" :key="index">
                                <div x-show="activeSlide === index" 
                                     x-transition:enter="transition ease-out duration-500" 
                                     x-transition:enter-start="opacity-0 translate-x-4" 
                                     x-transition:enter-end="opacity-100 translate-x-0" 
                                     x-transition:leave="transition ease-in duration-300 absolute inset-0" 
                                     x-transition:leave-start="opacity-100 translate-x-0" 
                                     x-transition:leave-end="opacity-0 -translate-x-4">
                                    <p class="text-sm italic text-gray-300 leading-relaxed mb-4" x-html="'&quot;' + slide.text + '&quot;'"></p>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-orange-500/20 border border-orange-500/30 flex items-center justify-center text-orange-500 font-bold text-xs" x-text="slide.initial"></div>
                                        <div>
                                            <p class="text-xs font-bold text-white" x-text="slide.name"></p>
                                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider" x-text="slide.role"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="absolute bottom-4 left-6 flex gap-1.5 z-10">
                            <template x-for="(slide, index) in slides" :key="index">
                                <button @click="activeSlide = index" :class="{'w-4 bg-orange-500': activeSlide === index, 'w-1.5 bg-gray-600': activeSlide !== index}" class="h-1.5 rounded-full transition-all duration-300"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>