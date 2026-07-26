{{-- File: app.blade.php --}}
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
        
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            /* SweetAlert2 Theme Customization to match ClarityLabs (Navy, Slate, Orange) */
            .swal2-custom-popup {
                font-family: 'Outfit', sans-serif !important;
                border-radius: 24px !important;
                padding: 2rem !important;
                border: 1px solid rgba(249, 115, 22, 0.15) !important;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3) !important;
                background-color: #ffffff !important;
                color: #0f172a !important;
                transition: background-color 0.3s, color 0.3s;
            }
            .dark .swal2-custom-popup {
                background-color: #0f172a !important;
                color: #ffffff !important;
                border-color: rgba(255, 255, 255, 0.08) !important;
            }
            .swal2-custom-title {
                font-size: 1.25rem !important;
                font-weight: 900 !important;
                color: #0f172a !important;
            }
            .dark .swal2-custom-title {
                color: #ffffff !important;
            }
            .swal2-custom-text {
                font-size: 0.875rem !important;
                font-weight: 600 !important;
                color: #475569 !important;
            }
            .dark .swal2-custom-text {
                color: #94a3b8 !important;
            }
            .swal2-custom-confirm-btn {
                font-size: 0.75rem !important;
                font-weight: 800 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.05em !important;
                padding: 0.75rem 1.75rem !important;
                border-radius: 12px !important;
                background-color: #f97316 !important;
                color: #ffffff !important;
                border: none !important;
                box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.2) !important;
                transition: all 0.2s !important;
            }
            .swal2-custom-confirm-btn:hover {
                background-color: #ea580c !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 10px 15px -3px rgba(249, 115, 22, 0.3) !important;
            }
            .swal2-custom-cancel-btn {
                font-size: 0.75rem !important;
                font-weight: 800 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.05em !important;
                padding: 0.75rem 1.75rem !important;
                border-radius: 12px !important;
                background-color: #f1f5f9 !important;
                color: #475569 !important;
                border: 1px solid #e2e8f0 !important;
                transition: all 0.2s !important;
            }
            .dark .swal2-custom-cancel-btn {
                background-color: #1e293b !important;
                color: #94a3b8 !important;
                border-color: rgba(255, 255, 255, 0.05) !important;
            }
            .swal2-custom-cancel-btn:hover {
                background-color: #e2e8f0 !important;
            }
            .dark .swal2-custom-cancel-btn:hover {
                background-color: #334155 !important;
            }
            /* Toast Styles */
            .swal2-custom-toast {
                font-family: 'Outfit', sans-serif !important;
                border-radius: 16px !important;
                padding: 0.75rem 1.25rem !important;
                border: 1px solid rgba(249, 115, 22, 0.15) !important;
                background-color: #ffffff !important;
                color: #0f172a !important;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            }
            .dark .swal2-custom-toast {
                background-color: #0f172a !important;
                color: #ffffff !important;
                border-color: rgba(255, 255, 255, 0.08) !important;
            }
        </style>
        
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
                font-family: 'Outfit', sans-serif;
            }
            .logo-text, .clarity-labs-brand {
                font-family: 'Plus Jakarta Sans', sans-serif !important;
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
                    const selects = Array.from(document.querySelectorAll('select[name="material_ids[]"]:not(.material-color-select), select.material-live, select[data-live="materials"]'));
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
        <script>
            // Custom SweetAlert2 Interception & Toast notifications
            (function() {
                // Toast helper configuration
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'swal2-custom-toast'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                // Display success / error session flash messages
                @if(session('success'))
                    Toast.fire({
                        icon: 'success',
                        title: "{{ session('success') }}"
                    });
                @endif

                @if(session('error'))
                    Toast.fire({
                        icon: 'error',
                        title: "{{ session('error') }}"
                    });
                @endif
                
                @if(session('status'))
                    Toast.fire({
                        icon: 'info',
                        title: "{{ session('status') }}"
                    });
                @endif

                // Listen for form submissions in the CAPTURE phase to intercept inline onsubmit before they execute
                document.addEventListener('submit', function(e) {
                    const form = e.target;
                    const onsubmitAttr = form.getAttribute('onsubmit');
                    
                    if (onsubmitAttr && onsubmitAttr.includes('confirm(')) {
                        // Prevent the browser's default action and inline confirm dialog
                        e.preventDefault();
                        e.stopImmediatePropagation();

                        // Try to extract the confirmation message
                        let message = 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
                        const match = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
                        if (match && match[1]) {
                            message = match[1];
                        }

                        Swal.fire({
                            title: 'Konfirmasi Tindakan',
                            text: message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#F97316',
                            cancelButtonColor: '#475569',
                            confirmButtonText: 'Ya, Lanjutkan',
                            cancelButtonText: 'Batal',
                            customClass: {
                                popup: 'swal2-custom-popup',
                                title: 'swal2-custom-title',
                                htmlContainer: 'swal2-custom-text',
                                confirmButton: 'swal2-custom-confirm-btn',
                                cancelButton: 'swal2-custom-cancel-btn'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Programmatically submit form, which bypasses the submit event/handler loop
                                form.submit();
                            }
                        });
                    }
                }, true); // Use capture phase to intercept before inline onsubmit runs
            })();
        </script>
    </body>
</html>