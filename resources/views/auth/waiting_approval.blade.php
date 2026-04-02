{{-- File: waiting_approval.blade.php --}}
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

        .floating-shape {
            position: absolute;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.05), rgba(234, 88, 12, 0.05));
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Menunggu Persetujuan</h2>
                <p class="text-orange-100 text-sm">Akun Anda sedang dalam proses verifikasi oleh administrator</p>
            </div>

            <!-- Waiting Approval Card -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white/20 relative">
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-semibold text-white mb-4">Akun Dalam Proses Verifikasi</h3>

                    <p class="text-orange-100 text-sm mb-6 leading-relaxed">
                        Terima kasih telah mendaftar! Akun Anda sedang ditinjau oleh administrator kami.
                        Anda akan menerima notifikasi melalui email setelah akun disetujui.
                    </p>

                    <div class="space-y-4">
                        <div class="bg-orange-500/20 rounded-lg p-4 border border-orange-500/30">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-orange-200 text-sm">Proses verifikasi biasanya memakan waktu 1-2 hari kerja</span>
                            </div>
                        </div>

                        <div class="bg-blue-500/20 rounded-lg p-4 border border-blue-500/30">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-blue-200 text-sm">Notifikasi akan dikirim ke email Anda</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 space-y-3">
                        <a href="{{ route('login') }}" class="w-full bg-gradient-orange text-white font-semibold py-3 px-6 rounded-xl hover:bg-orange-600 transition duration-200 inline-block text-center">
                            Kembali ke Login
                        </a>

                        <p class="text-orange-200 text-xs">
                            Sudah memiliki akun yang disetujui? <a href="{{ route('login') }}" class="text-orange-300 hover:text-orange-100 underline">Login di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>