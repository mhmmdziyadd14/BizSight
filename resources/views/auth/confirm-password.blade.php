{{-- File: password-confirm.blade.php --}}
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
        
        .btn-confirm {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }
        
        .btn-confirm:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
        }
        
        .btn-confirm:active {
            transform: translateY(0);
        }
        
        .floating-shape {
            position: absolute;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.05), rgba(234, 88, 12, 0.05));
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        
        .security-icon {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }
        
        .relative {
            position: relative;
            z-index: 1;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-orange-500 via-orange-600 to-navy-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Decorative floating shapes -->
        <div class="floating-shape w-64 h-64 -top-32 -left-32 opacity-30"></div>
        <div class="floating-shape w-96 h-96 -bottom-48 -right-48 opacity-20"></div>
        <div class="floating-shape w-48 h-48 top-1/2 right-10 opacity-10"></div>
        
        <div class="max-w-md w-full space-y-8 card-glow relative">
            <!-- Logo/Brand Section -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-xl security-icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6-4h12a2 2 0 002-2v-4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2zm10 5v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2h12z"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-3xl font-extrabold tracking-tight">
                    <span class="text-gradient-orange">Secure</span>
                    <span class="text-white">Access</span>
                </h2>
                <p class="mt-2 text-sm text-orange-200 font-medium">
                    Konfirmasi keamanan akun Anda
                </p>
            </div>

            <!-- Security Message Card -->
            <div class="bg-orange-500/20 backdrop-blur-sm border border-orange-400/30 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-300 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-sm text-orange-200 font-medium leading-relaxed">
                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </div>
                </div>
            </div>

            <!-- Confirmation Form -->
            <form method="POST" action="{{ route('password.confirm') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Password Field -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-bold text-orange-200 uppercase tracking-wider text-[11px]" />
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
                            class="block w-full pl-10 pr-3 py-3 border border-orange-500/30 rounded-xl bg-white/10 backdrop-blur-sm text-white placeholder-white/50 focus:border-orange-400 focus:ring focus:ring-orange-500/30 focus:ring-opacity-50 transition-all duration-200 input-focus-ring"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            required autocomplete="current-password" />
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300 text-xs font-semibold" />
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="btn-confirm w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl text-sm font-black uppercase tracking-wider text-white bg-gradient-orange hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Confirm Access') }}
                    </button>
                </div>

                <!-- Additional Security Note -->
                <div class="text-center pt-2">
                    <p class="text-[10px] text-orange-300/70 font-medium uppercase tracking-wider">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Session akan tetap aman
                        </span>
                    </p>
                </div>
            </form>

            <!-- Footer Note -->
            <div class="text-center pt-4 border-t border-orange-500/30 mt-6">
                <p class="text-[9px] text-orange-300/50 font-medium">
                    AVS Store • Protected Area
                </p>
            </div>
        </div>
    </div>

    <style>
        /* Custom input styling override */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px rgba(15, 23, 42, 0.5) inset !important;
            -webkit-text-fill-color: #F1F5F9 !important;
            border-color: #F97316 !important;
            border-radius: 0.75rem;
        }
        
        /* Smooth transitions */
        .btn-confirm, .input-focus-ring {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
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