{{-- File: login.blade.php --}}
<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
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
        
        .card-glow {
            animation: fadeInUp 0.5s ease-out;
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
        
        .input-focus-ring {
            transition: all 0.2s ease;
        }
        
        .input-focus-ring:focus {
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
            border-color: #F97316;
            outline: none;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }
        
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .floating-shape {
            position: absolute;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.05), rgba(234, 88, 12, 0.05));
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        
        .success-message {
            animation: slideIn 0.4s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .relative {
            position: relative;
            z-index: 1;
        }
        
        .logo-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
        
        /* Custom checkbox styling */
        input[type="checkbox"] {
            accent-color: #F97316;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        
        /* Input styling for dark theme */
        .input-dark {
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(249, 115, 22, 0.3);
            color: #F1F5F9;
        }
        
        .input-dark:focus {
            border-color: #F97316;
            background: rgba(15, 23, 42, 0.7);
        }
        
        .input-dark::placeholder {
            color: rgba(241, 245, 249, 0.5);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-orange-500 via-orange-600 to-navy-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Decorative floating shapes -->
        <div class="floating-shape w-64 h-64 -top-32 -left-32 opacity-20"></div>
        <div class="floating-shape w-96 h-96 -bottom-48 -right-48 opacity-20"></div>
        <div class="floating-shape w-48 h-48 top-1/2 right-10 opacity-10"></div>
        <div class="floating-shape w-80 h-80 bottom-20 left-20 opacity-10"></div>
        
        <!-- Animated particles effect -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-2 h-2 bg-orange-300 rounded-full opacity-30 animate-pulse"></div>
            <div class="absolute bottom-32 right-20 w-3 h-3 bg-orange-400 rounded-full opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/4 w-1.5 h-1.5 bg-white rounded-full opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        
        <div class="max-w-md w-full space-y-8 card-glow relative z-10">
            <!-- Logo/Brand Section -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center shadow-2xl logo-icon">
                        <div class="bg-gradient-orange rounded-xl w-14 h-14 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-white">
                    <span class="bg-gradient-to-r from-orange-200 to-yellow-200 bg-clip-text text-transparent">Masuk ke</span>
                    <span class="text-white">ClarityLabs</span>
                </h1>
                <p class="mt-2 text-sm text-orange-100 font-medium">
                    Kelola HPP &amp; analisis usaha Anda dengan mudah.
                </p>
            </div>

            <!-- Session Status -->
            @if(session('status'))
                <div class="bg-green-500/20 backdrop-blur-sm border-l-4 border-green-500 rounded-lg p-4 success-message">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-sm text-green-200 font-medium">
                            {{ session('status') }}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Email Field -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <x-input-label for="email" :value="__('Email Address')" class="text-xs font-black text-orange-200 uppercase tracking-wider" />
                        <div class="text-[10px] text-orange-300 font-semibold">
                            Required *
                        </div>
                    </div>
                    
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <x-text-input id="email" 
                            class="block w-full pl-10 pr-3 py-3 rounded-xl input-dark backdrop-blur-sm focus:border-orange-400 focus:ring focus:ring-orange-500/30 transition-all duration-200 input-focus-ring"
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            placeholder="you@example.com"
                            required 
                            autofocus 
                            autocomplete="username" />
                    </div>

                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-300 font-medium" />
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <x-input-label for="password" :value="__('Password')" class="text-xs font-black text-orange-200 uppercase tracking-wider" />
                        <div class="text-[10px] text-orange-300 font-semibold">
                            Required *
                        </div>
                    </div>
                    
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6-4h12a2 2 0 002-2v-4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2zm10 5v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2h12z"></path>
                            </svg>
                        </div>
                        <x-text-input id="password" 
                            class="block w-full pl-10 pr-3 py-3 rounded-xl input-dark backdrop-blur-sm focus:border-orange-400 focus:ring focus:ring-orange-500/30 transition-all duration-200 input-focus-ring"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required 
                            autocomplete="current-password" />
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-300 font-medium" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer group">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-orange-400/30 bg-white/10 text-orange-500 focus:ring-orange-500 focus:ring-offset-0 cursor-pointer">
                        <span class="text-sm text-orange-200 group-hover:text-white transition-colors">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-semibold text-orange-300 hover:text-white transition-colors" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button & Register Link -->
                <div class="space-y-4 pt-2">
                    <button type="submit" class="btn-login w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl text-sm font-black uppercase tracking-wider text-white bg-gradient-orange hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        {{ __('Log in') }}
                    </button>

                    <div class="text-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-widest text-orange-300 hover:text-white transition-colors">
                            {{ __('Create an account') }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </form>

            <!-- Footer Note -->
            <div class="text-center pt-4 border-t border-orange-500/30 mt-6">
                <p class="text-[9px] text-orange-300/50 font-medium uppercase tracking-wider">
                    AVS Store • Business Intelligence Platform
                </p>
            </div>
        </div>
    </div>

    <style>
        /* Custom input autofill override */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px rgba(15, 23, 42, 0.7) inset !important;
            -webkit-text-fill-color: #F1F5F9 !important;
            border-color: #F97316 !important;
            border-radius: 0.75rem;
        }
        
        /* Smooth transitions */
        .btn-login, .input-focus-ring {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Focus styles */
        input:focus {
            outline: none;
        }
        
        /* Improve checkbox styling */
        input[type="checkbox"]:checked {
            background-color: #F97316;
            border-color: #F97316;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(249, 115, 22, 0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: #F97316;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #EA580C;
        }
    </style>
</x-guest-layout>