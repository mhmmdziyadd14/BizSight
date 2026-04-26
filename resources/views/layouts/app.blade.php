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
            if (localStorage.theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

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
        </script>
        
        <style>
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
        @php $isEmbed = request()->get('embed') == '1'; @endphp
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
    </body>
</html>