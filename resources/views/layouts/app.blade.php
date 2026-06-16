{{-- File: app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ClarityLabs') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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

            // Listen for theme changes from parent window (for iframes)
            window.addEventListener('message', function(event) {
                if (event.data && event.data.type === 'THEME_CHANGE') {
                    if (event.data.theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            });

            if (window !== window.top) {
                document.documentElement.classList.add('is-iframe');
            }
        </script>
        
        <style>
            html.is-iframe nav,
            html.is-iframe footer,
            html.is-iframe header.header-glow,
            html.is-iframe .nav-container,
            html.is-iframe #hppTabNav,
            html.is-iframe .mb-8.flex.flex-col.md\:flex-row.md\:items-end,
            html.is-iframe .mb-10.flex.flex-col.md\:flex-row.md\:items-end {
                display: none !important;
            }
            html.is-iframe .pt-20 {
                padding-top: 0 !important;
            }
            html.is-iframe .py-10 {
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important;
            }
            html.is-iframe .min-h-screen {
                min-height: auto !important;
            }
            * {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            
            body {
                background: linear-gradient(135deg, #fff7f3 0%, #ffffff 50%, #fff3ed 100%);
                transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease, background-image 0.5s ease;
            }
            
            .dark body {
                background: linear-gradient(135deg, #0F172A 0%, #020617 100%);
                color: #f8fafc;
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
            
            .glass-nav {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(12px);
                border-bottom: 2px solid rgba(249, 115, 22, 0.2);
            }
            
            .dark .glass-nav {
                background: rgba(15, 23, 42, 0.95);
                border-bottom: 1px solid rgba(249, 115, 22, 0.2);
            }
            
            .header-glow {
                background: linear-gradient(135deg, #ffffff 0%, #fff7f3 100%);
                border-bottom: 3px solid #F97316;
            }
            
            .dark .header-glow {
                background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
                border-bottom: 3px solid #F97316;
            }
            
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .main-content {
                animation: fadeIn 0.4s ease-out;
            }
        </style>
    </head>
    <body class="font-sans antialiased min-h-screen">
        @php $isEmbed = request()->get('embed') == '1' || request()->get('from') == 'hpp'; @endphp
        <div class="{{ $isEmbed ? '' : 'min-h-screen pt-20' }}">
            @if(!$isEmbed)
                @include('layouts.navigation')
            @endif

            <!-- Page Heading -->
            @if(!$isEmbed)
                @isset($header)
                    <header class="header-glow shadow-lg">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
            @endif

            <!-- Page Content -->
            <main class="{{ $isEmbed ? '' : 'main-content' }}">
                @if($isEmbed)
                    {{-- In embed mode: hide hpp_nav and top header section inside the content --}}
                    <style>
                        .nav-container, nav.mb-8, [id="hppTabNav"],
                        .mb-8.flex.flex-col.md\:flex-row.md\:items-end,
                        .mb-10.flex.flex-col.md\:flex-row.md\:items-end { display: none !important; }
                        .py-10 { padding-top: 0.5rem !important; }
                    </style>
                @endif
                {{ $slot }}
            </main>

            @if(!$isEmbed)
                @include('layouts.footer')
            @endif
        </div>
        
        <style>
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            
            ::-webkit-scrollbar-track {
                background: #FEF3C7;
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Intercept all DELETE forms for smooth AJAX removal
                const forms = document.querySelectorAll('form');
                forms.forEach(form => {
                    const methodInput = form.querySelector('input[name="_method"][value="DELETE"]');
                    if (methodInput) {
                        form.addEventListener('submit', async function(e) {
                            // If the inline onsubmit (e.g. confirm) cancelled the event, do nothing
                            if (e.defaultPrevented) return;
                            
                            e.preventDefault();
                            
                            const btn = form.querySelector('button[type="submit"]');
                            const originalContent = btn ? btn.innerHTML : '';
                            if (btn) {
                                btn.disabled = true;
                                btn.innerHTML = '<svg class="animate-spin h-4 w-4 text-current inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
                            }

                            try {
                                const response = await fetch(form.action, {
                                    method: 'POST',
                                    body: new FormData(form),
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                });
                                
                                // Assume success if ok or redirected
                                if (response.ok || response.redirected || response.status === 200 || response.status === 302) {
                                    // Smoothly remove the row or card
                                    const tr = form.closest('tr');
                                    if (tr) {
                                        tr.style.transition = 'all 0.4s ease';
                                        tr.style.opacity = '0';
                                        tr.style.transform = 'translateX(20px)';
                                        setTimeout(() => tr.remove(), 400);
                                    } else {
                                        const card = form.closest('.bg-white, .bg-navy-900, .card');
                                        if (card && card !== document.body) {
                                            card.style.transition = 'all 0.4s ease';
                                            card.style.opacity = '0';
                                            card.style.transform = 'scale(0.95)';
                                            setTimeout(() => card.remove(), 400);
                                        } else {
                                            window.location.reload();
                                        }
                                    }
                                } else {
                                    alert('Terjadi kesalahan saat menghapus data.');
                                    if (btn) {
                                        btn.disabled = false;
                                        btn.innerHTML = originalContent;
                                    }
                                }
                            } catch (error) {
                                alert('Terjadi kesalahan jaringan.');
                                if (btn) {
                                    btn.disabled = false;
                                    btn.innerHTML = originalContent;
                                }
                            }
                        });
                    }
                });

                // Local time formatter
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
        <script>
            // Realtime polling (simple fallback) to keep HPP and Material selects up-to-date.
            (function() {
                const intervalMs = 3000; // polling interval (ms)

                async function fetchLists() {
                    try {
                        const [hppRes, matRes] = await Promise.all([
                            fetch('/api/hpp/list', { headers: { 'X-Requested-With': 'XMLHttpRequest' } }),
                            fetch('/api/materials/list', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        ]);

                        if (hppRes.ok) {
                            const h = await hppRes.json();
                            if (h && h.success) updateHppSelects(h.data);
                        }
                        if (matRes.ok) {
                            const m = await matRes.json();
                            if (m && m.success) updateMaterialSelects(m.data);
                        }
                    } catch (e) {
                        console.debug('Realtime poll error', e);
                    }
                }

                function updateHppSelects(items) {
                    const ids = ['vp-product', 'hppSelect', 'existingIdSelect'];
                    ids.forEach(id => {
                        const el = document.getElementById(id);
                        if (!el) return;
                        const cur = el.value;
                        // Clear
                        while (el.firstChild) el.removeChild(el.firstChild);
                        // Default option
                        const defaultOpt = document.createElement('option');
                        defaultOpt.value = '';
                        defaultOpt.textContent = id === 'hppSelect' ? 'HPP Manual' : '-- Pilih --';
                        el.appendChild(defaultOpt);

                        items.forEach(item => {
                            const opt = document.createElement('option');
                            if (id === 'hppSelect') {
                                opt.value = item.total_hpp_per_unit;
                                opt.textContent = item.hpp_id + ' • ' + item.name + ' • Rp' + Number(item.total_hpp_per_unit).toLocaleString('id-ID');
                            } else if (id === 'existingIdSelect') {
                                opt.value = item.hpp_id;
                                opt.textContent = item.hpp_id + ' • ' + item.name;
                            } else {
                                opt.value = item.id;
                                opt.textContent = item.hpp_id + ' • ' + item.name;
                            }
                            el.appendChild(opt);
                        });

                        try { el.value = cur; } catch (e) {}
                    });
                }

                function updateMaterialSelects(items) {
                    // Update selects that store material ids
                    const selects = Array.from(document.querySelectorAll('select[name="material_ids[]"], select.material-live, select[data-live="materials"]'));
                    selects.forEach(el => {
                        const cur = el.value;
                        while (el.firstChild) el.removeChild(el.firstChild);
                        const defaultOpt = document.createElement('option'); defaultOpt.value = ''; defaultOpt.textContent = '-- Pilih Bahan --'; el.appendChild(defaultOpt);
                        items.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.name + ' • Rp' + Number(item.price).toLocaleString('id-ID') + ' / ' + (item.unit || 'unit');
                            el.appendChild(opt);
                        });
                        try { el.value = cur; } catch (e) {}
                    });
                }

                // Start polling shortly after load
                setTimeout(() => { fetchLists(); setInterval(fetchLists, intervalMs); }, 1500);
            })();
        </script>
    </body>
</html>