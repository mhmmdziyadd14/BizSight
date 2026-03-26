{{-- File: verify-email.blade.php --}}
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
        
        .btn-resend {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }
        
        .btn-resend:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
        }
        
        .btn-resend:active {
            transform: translateY(0);
        }
        
        .btn-logout {
            transition: all 0.2s ease;
        }
        
        .btn-logout:hover {
            color: #F97316;
            transform: translateX(2px);
        }
        
        .floating-shape {
            position: absolute;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.05), rgba(234, 88, 12, 0.05));
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
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
        
        .envelope-icon {
            animation: wiggle 3s ease-in-out infinite;
        }
        
        @keyframes wiggle {
            0%, 100% {
                transform: rotate(0deg);
            }
            10% {
                transform: rotate(5deg);
            }
            20% {
                transform: rotate(-5deg);
            }
            30% {
                transform: rotate(3deg);
            }
            40% {
                transform: rotate(-3deg);
            }
            50% {
                transform: rotate(0deg);
            }
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
            <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-orange-200 rounded-full opacity-40 animate-pulse" style="animation-delay: 0.5s;"></div>
        </div>
        
        <div class="max-w-md w-full space-y-8 card-glow relative z-10">
            <!-- Logo/Brand Section -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center shadow-2xl logo-icon">
                        <div class="bg-gradient-orange rounded-xl w-14 h-14 flex items-center justify-center envelope-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-white">
                    <span class="bg-gradient-to-r from-orange-200 to-yellow-200 bg-clip-text text-transparent">Verify</span>
                    <span class="text-white">Email</span>
                </h1>
                <p class="mt-2 text-sm text-orange-100 font-medium">
                    Konfirmasi alamat email Anda
                </p>
            </div>

            <!-- Info Message Card -->
            <div class="bg-orange-500/20 backdrop-blur-sm border border-orange-400/30 rounded-xl p-6">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-300 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-sm text-orange-200 font-medium leading-relaxed">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="bg-green-500/20 backdrop-blur-sm border-l-4 border-green-500 rounded-xl p-4 success-message">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-sm text-green-200 font-medium">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="space-y-4 pt-4">
                <!-- Resend Verification Email Form -->
                <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                    @csrf
                    <button type="submit" class="btn-resend w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl text-sm font-black uppercase tracking-wider text-white bg-gradient-orange hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="btn-logout w-full flex justify-center items-center gap-2 py-3 px-4 border border-orange-400/50 rounded-xl text-sm font-bold uppercase tracking-wider text-orange-300 hover:text-white hover:border-orange-400 hover:bg-orange-500/20 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>

            <!-- Help Text -->
            <div class="text-center pt-2">
                <p class="text-[10px] text-orange-300/70 font-medium">
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tidak menerima email? Periksa folder spam Anda
                    </span>
                </p>
            </div>

            <!-- Footer Note -->
            <div class="text-center pt-4 border-t border-orange-500/30 mt-6">
                <p class="text-[9px] text-orange-300/50 font-medium uppercase tracking-wider">
                    AVS Store • Email Verification Required
                </p>
            </div>
        </div>
    </div>

    <style>
        /* Smooth transitions */
        .btn-resend, .btn-logout {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Focus styles */
        button:focus {
            outline: none;
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