{{-- File: navigation.blade.php --}}
<nav x-data="{ open: false }" class="glass-nav fixed top-0 left-0 right-0 z-50">
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(249, 115, 22, 0.1);
        }
        .dark .glass-nav {
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid rgba(249, 115, 22, 0.2);
        }
        
        .nav-link {
            transition: all 0.2s ease;
        }
        
        .nav-link:hover {
            color: #F97316;
            transform: translateY(-1px);
        }
        
        .user-avatar {
            background: linear-gradient(135deg, #F97316, #F59E0B);
            transition: all 0.2s ease;
        }
        
        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.3);
        }
        
        .dropdown-trigger {
            background: rgba(249, 115, 22, 0.1);
            border: 1px solid rgba(249, 115, 22, 0.3);
            transition: all 0.2s ease;
        }
        
        .dropdown-trigger:hover {
            background: rgba(249, 115, 22, 0.2);
            border-color: rgba(249, 115, 22, 0.5);
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .mobile-menu {
            animation: slideDown 0.2s ease-out;
        }
        
        .menu-icon {
            transition: all 0.2s ease;
        }
        
        .menu-icon:hover {
            background: rgba(249, 115, 22, 0.2);
        }
    </style>
    
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex items-center gap-4">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 group">
                    <!-- Tampil di Light Mode (Logo Dark) -->
                    <img src="{{ asset('images/ClarityLabs_Light.svg') }}" alt="ClarityLabs" class="h-10 w-auto block dark:hidden group-hover:scale-105 transition-transform duration-300">
                    <!-- Tampil di Dark Mode (Logo Light) -->
                    <img src="{{ asset('images/ClarityLabs_Dark.svg') }}" alt="ClarityLabs" class="h-10 w-auto hidden dark:block group-hover:scale-105 transition-transform duration-300">
                    <span class="text-xl font-extrabold tracking-tight text-navy-900 dark:text-white transition-colors duration-300">
                        <span class="text-gradient-orange">Clarity</span> Labs
                    </span>
                </a>
            </div>

            @php
                $user = auth()->user();
                $isAdmin = $user && $user->isAdmin();
                $accesses = $isAdmin ? [] : ($user ? \App\Models\UserAccess::where('user_id', $user->id)
                    ->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
                    ->pluck('feature_code')
                    ->map(fn($val) => strtolower($val))
                    ->toArray() : []);
                $hasVCP = $isAdmin || in_array('vcp', $accesses);
                $hasPCC = $isAdmin || in_array('pcc', $accesses);
                $hasDE = $isAdmin || in_array('de', $accesses);
            @endphp

            <!-- Desktop Navigation Links -->
            <div class="hidden lg:flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors nav-link">
                    Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors nav-link">
                    Our Products
                </a>
                @if($hasPCC)
                <a href="{{ route('hpp.index') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors nav-link">
                    Clarity Profit
                </a>
                @endif
                @if($hasDE)
                <a href="{{ route('business.index') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors nav-link">
                    Clarity Decision
                </a>
                @endif
                @if($hasVCP)
                <a href="{{ route('clarity.visual') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors nav-link">
                    Clarity Visual
                </a>
                @endif
                @if($isAdmin)
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors nav-link">
                    Admin Panel
                </a>
                <a href="{{ route('admin.notifications') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400 transition-colors nav-link">
                    Waitlist
                </a>
                @endif
            </div>

            <!-- User Menu -->
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="dropdown-trigger inline-flex items-center gap-2 px-4 py-2 text-sm leading-4 font-medium rounded-xl text-white focus:outline-none transition-all group">
                                <div class="user-avatar w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-md">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="hidden md:block text-gray-800 dark:text-white">
                                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                                </div>
                                <svg class="fill-current h-4 w-4 transition-transform group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-4 border-b border-orange-500/10 bg-orange-50/30 dark:bg-navy-950/50 transition-colors">
                                <p class="text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-widest mb-1">User Account</p>
                                <p class="text-sm font-bold text-navy-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate mt-0.5">{{ Auth::user()->email }}</p>
                            </div>
                            <x-dropdown-link href="{{ route('dashboard') }}" class="flex items-center gap-2 dark:text-gray-300 dark:hover:bg-navy-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                {{ __('Dashboard') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('profile.edit') }}" class="flex items-center gap-2 dark:text-gray-300 dark:hover:bg-navy-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Theme Toggle -->
                            <button onclick="toggleTheme()" class="w-full text-left flex items-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-navy-800 transition-all group">
                                <div class="w-6 h-6 rounded-lg bg-orange-100 dark:bg-navy-950 flex items-center justify-center text-orange-500 transition-colors">
                                    <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                                    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <span class="block dark:hidden">Dark Mode</span>
                                <span class="hidden dark:block">Light Mode</span>
                            </button>
                            
                            <script>
                                function toggleTheme() {
                                    const html = document.documentElement;
                                    const isDark = html.classList.contains('dark');
                                    const newTheme = isDark ? 'light' : 'dark';
                                    
                                    if (isDark) {
                                        html.classList.remove('dark');
                                        localStorage.theme = 'light';
                                    } else {
                                        html.classList.add('dark');
                                        localStorage.theme = 'dark';
                                    }
                                    
                                    // 1. Dispatch event for local components
                                    window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: newTheme } }));

                                    // 2. Broadcast to all iframes (for HPP suite SPA feel)
                                    document.querySelectorAll('iframe').forEach(iframe => {
                                        try {
                                            iframe.contentWindow.postMessage({ type: 'THEME_CHANGE', theme: newTheme }, '*');
                                        } catch (e) {
                                            console.warn('Could not post message to iframe', e);
                                        }
                                    });
                                }
                            </script>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" class="p-2">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center justify-center gap-2 bg-gradient-to-r from-navy-900 to-navy-800 dark:from-navy-950 dark:to-navy-900 text-white hover:from-orange-600 hover:to-orange-500 rounded-xl py-3 px-4 shadow-lg transition-all font-black text-[10px] uppercase tracking-[0.2em] group">
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <button @click="open = ! open" class="menu-icon inline-flex items-center justify-center p-2 rounded-xl text-white hover:bg-orange-500/20 focus:outline-none transition-all duration-200 relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500/20 to-orange-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-xl"></div>
                        <svg class="h-6 w-6 relative z-10 transition-transform duration-200" :class="{'rotate-90 scale-110': open}" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex transition-all duration-200" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden transition-all duration-200" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden mobile-menu">
        <div class="px-4 py-4 border-t border-orange-500/20 bg-navy-900/95 backdrop-blur">
            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-orange-500/20">
                <div class="user-avatar w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-white">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-orange-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 hover:text-orange-400 hover:bg-orange-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    {{ __('Dashboard') }}
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 hover:text-orange-400 hover:bg-orange-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Our Products
                </a>
                <a href="{{ route('hpp.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 hover:text-orange-400 hover:bg-orange-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Clarity Profit
                </a>
                <a href="{{ route('materials.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 hover:text-orange-400 hover:bg-orange-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Bahan
                </a>
                <a href="{{ route('business.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 hover:text-orange-400 hover:bg-orange-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Clarity Decision
                </a>
                <a href="{{ route('clarity.visual') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 hover:text-orange-400 hover:bg-orange-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Clarity Visual
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 hover:text-orange-400 hover:bg-orange-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile
                </a>
                
                @if($isAdmin)
                <div class="pt-2 mt-2 border-t border-orange-500/20">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-orange-400 hover:text-orange-300 hover:bg-orange-500/10 transition-all font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Admin Panel
                    </a>
                    <a href="{{ route('admin.notifications') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-orange-400 hover:text-orange-300 hover:bg-orange-500/10 transition-all font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        Waitlist Database
                    </a>
                </div>
                @endif
                
                <div class="pt-4 mt-4 border-t border-orange-500/20">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 rounded-xl text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    .bg-gradient-orange {
        background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
    }
    
    /* Dropdown styling overrides */
    .dark [x-show="open"] > div {
        background-color: #0f172a !important; /* Navy 900 */
        border: 1px solid rgba(249, 115, 22, 0.2);
    }
    
    .dropdown-item {
        transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
        background: #FEF3C7;
        color: #F97316;
    }
</style>