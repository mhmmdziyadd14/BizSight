{{-- File: navigation.blade.php --}}
<nav x-data="{ open: false }" class="glass-nav fixed top-0 left-0 right-0 z-50">
    <style>
        .glass-nav {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
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
                    <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-orange-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <svg class="w-5 h-5 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="bg-gradient-to-r from-orange-400 to-orange-500 bg-clip-text text-transparent text-2xl font-black italic group-hover:from-orange-300 group-hover:to-orange-400 transition-all duration-300">Biz</span>
                        <span class="text-white text-xl font-black group-hover:text-orange-100 transition-colors duration-300">Sight</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden lg:flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-300 hover:text-orange-400 transition-colors nav-link">
                    Dashboard
                </a>
                <a href="{{ route('hpp.index') }}" class="text-sm font-semibold text-gray-300 hover:text-orange-400 transition-colors nav-link">
                    HPP
                </a>
                <a href="{{ route('materials.index') }}" class="text-sm font-semibold text-gray-300 hover:text-orange-400 transition-colors nav-link">
                    Bahan
                </a>
                <a href="{{ route('business.index') }}" class="text-sm font-semibold text-gray-300 hover:text-orange-400 transition-colors nav-link">
                    Analisis
                </a>
                
                <!-- Search Bar -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Search..." class="bg-white/10 border border-orange-500/30 rounded-xl pl-10 pr-4 py-2 text-sm text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500/50 transition-all w-48">
                </div>
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
                                <div class="hidden md:block">
                                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                                </div>
                                <svg class="fill-current h-4 w-4 transition-transform group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-orange-500/20">
                                <p class="text-sm font-bold text-navy-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                            </div>
                            <x-dropdown-link href="{{ route('dashboard') }}" class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                {{ __('Dashboard') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('profile.edit') }}" class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-2 text-red-500 hover:text-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <a href="{{ route('hpp.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 hover:text-orange-400 hover:bg-orange-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    HPP
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
                    Analisis
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-300 hover:text-orange-400 hover:bg-orange-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile
                </a>
                
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
    .dropdown-menu {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(249, 115, 22, 0.2);
        overflow: hidden;
    }
    
    .dropdown-item {
        transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
        background: #FEF3C7;
        color: #F97316;
    }
</style>