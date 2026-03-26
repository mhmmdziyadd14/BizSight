{{-- File: guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BizSight') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            * {
                font-family: 'Inter', sans-serif;
            }
            
            body {
                background: linear-gradient(135deg, #F97316 0%, #EA580C 50%, #0F172A 100%);
                position: relative;
                overflow-x: hidden;
            }
            
            /* Animated gradient overlay */
            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: radial-gradient(circle at 20% 50%, rgba(249, 115, 22, 0.15), transparent 70%);
                pointer-events: none;
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
            
            .glass-card {
                background: rgba(15, 23, 42, 0.6);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(249, 115, 22, 0.3);
                transition: all 0.3s ease;
            }
            
            .glass-card:hover {
                border-color: rgba(249, 115, 22, 0.6);
                box-shadow: 0 8px 32px rgba(249, 115, 22, 0.1);
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-5px); }
            }
            
            .logo-icon {
                animation: float 3s ease-in-out infinite;
            }
            
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .main-content {
                animation: fadeInUp 0.5s ease-out;
            }
            
            /* Decorative elements */
            .bg-shape {
                position: absolute;
                background: radial-gradient(circle, rgba(249, 115, 22, 0.1), transparent);
                border-radius: 50%;
                pointer-events: none;
                z-index: 0;
            }
        </style>
    </head>
    <body class="antialiased text-white min-h-screen relative overflow-x-hidden">
        <!-- Decorative background shapes -->
        <div class="bg-shape w-[500px] h-[500px] -top-64 -left-64"></div>
        <div class="bg-shape w-[400px] h-[400px] -bottom-48 -right-48"></div>
        <div class="bg-shape w-[300px] h-[300px] top-1/3 right-10 opacity-30"></div>
        
        <div class="min-h-screen flex flex-col relative z-10">
            <header class="py-6 px-4 sm:px-6">
                <div class="max-w-7xl mx-auto flex items-center justify-between">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-2 group">
                        <div class="logo-icon w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="bg-gradient-to-r from-orange-400 to-orange-500 bg-clip-text text-transparent text-2xl font-black italic">Biz</span>
                            <span class="text-white text-xl font-black">Sight</span>
                        </div>
                    </a>

                    <a href="{{ route('welcome') }}" class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest text-orange-300 hover:text-white transition-all group">
                        <svg class="w-3 h-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        ‹ Kembali ke Beranda
                    </a>
                </div>
            </header>

            <main class="flex-1 flex items-center justify-center px-4 pb-12 main-content">
                <div class="w-full max-w-md glass-card rounded-3xl shadow-2xl p-8 sm:p-10">
                    {{ $slot }}
                </div>
            </main>

            <footer class="py-8 text-center">
                <p class="text-[10px] text-orange-300/50 font-medium uppercase tracking-wider">
                    &copy; {{ date('Y') }} BizSight • Business Intelligence Platform
                </p>
            </footer>
        </div>
        
        <style>
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }
            
            ::-webkit-scrollbar-track {
                background: rgba(249, 115, 22, 0.1);
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb {
                background: #F97316;
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: #EA580C;
            }
            
            /* Selection styling */
            ::selection {
                background: #F97316;
                color: white;
            }
            
            ::-moz-selection {
                background: #F97316;
                color: white;
            }
        </style>
    </body>
</html>