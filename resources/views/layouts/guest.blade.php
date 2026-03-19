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
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-[#0F172A] text-white">
        <div class="min-h-screen flex flex-col">
            <header class="py-6 px-6">
                <div class="max-w-7xl mx-auto flex items-center justify-between">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                        <span class="bg-yellow-400 text-black px-3 py-1 rounded-lg text-2xl font-black italic">Biz</span>
                        <span class="text-white text-xl font-black">Sight</span>
                    </a>

                    <a href="{{ route('welcome') }}" class="text-xs font-black uppercase tracking-widest text-white/70 hover:text-white transition">
                        ‹ Kembali ke Beranda
                    </a>
                </div>
            </header>

            <main class="flex-1 flex items-center justify-center px-4 pb-12">
                <div class="w-full max-w-md bg-white/10 backdrop-blur rounded-3xl shadow-xl border border-white/10 p-10">
                    {{ $slot }}
                </div>
            </main>

            <footer class="py-8 text-center text-xs text-white/40">
                &copy; {{ date('Y') }} BizSight • All rights reserved.
            </footer>
        </div>
    </body>
</html>
