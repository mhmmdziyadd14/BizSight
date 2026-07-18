{{-- File: admin/notifications.blade.php --}}
<x-app-layout>
    <style>
        :root {
            --ora: #F97316;
            --ora-dk: #EA580C;
            --navy: #0F172A;
        }
        
        * { font-family: 'Outfit', sans-serif; }
        
        .bg-gradient-orange { background: linear-gradient(135deg, var(--ora) 0%, var(--ora-dk) 100%); }
        .text-gradient-orange { background: linear-gradient(135deg, var(--ora) 0%, #F59E0B 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
        
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1); }
        
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    </style>

    <div class="py-10 bg-gray-50 dark:bg-navy-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between border-b pb-6 border-gray-200 dark:border-white/5 fade-in-up">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-navy dark:bg-orange-500 rounded-2xl flex items-center justify-center shadow-lg transition-colors">
                        <svg class="w-7 h-7 text-orange-500 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-navy dark:text-white transition-colors"><span class="text-orange-500">Waitlist</span> Database</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Daftar pengguna yang meminta notifikasi peluncuran produk baru.</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Admin -->
                <div class="w-full lg:w-64 shrink-0">
                    @include('layouts.admin-sidebar')
                </div>

                <div class="flex-1">
                    <!-- Table -->
                    <div class="bg-white dark:bg-navy-900 rounded-[32px] shadow-xl border border-gray-100 dark:border-white/5 overflow-hidden fade-in-up transition-colors">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 dark:divide-white/5">
                                <thead class="bg-gray-50/50 dark:bg-navy-950/50 transition-colors">
                                    <tr>
                                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Kontak Leads</th>
                                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Minat Produk</th>
                                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Waktu Registrasi</th>
                                        <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Tindakan Cepat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-white/5 bg-white dark:bg-navy-900 transition-colors">
                                    @forelse($notifications as $notif)
                                    <tr class="hover:bg-orange-50/30 dark:hover:bg-white/5 transition-colors">
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 bg-navy dark:bg-navy-800 rounded-xl flex items-center justify-center text-orange-500 font-black shadow-sm transition-colors">
                                                    {{ strtoupper(substr($notif->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="text-base font-bold text-navy dark:text-white transition-colors">{{ $notif->name }}</div>
                                                    <div class="text-xs text-gray-400 dark:text-gray-500 font-medium">
                                                        WA: {{ $notif->phone }} 
                                                        @if($notif->social_media)
                                                            <span class="mx-1">•</span> IG/TT: {{ $notif->social_media }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 border border-orange-100 dark:border-orange-500/20">
                                                {{ $notif->product_name }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="text-sm font-bold text-navy dark:text-white"><span class="local-time" data-utc="{{ $notif->created_at->toIso8601String() }}" data-format="d M Y">{{ $notif->created_at->format('d M Y') }}</span></div>
                                            <div class="text-[10px] text-gray-400 font-bold"><span class="local-time" data-utc="{{ $notif->created_at->toIso8601String() }}" data-format="H:i">{{ $notif->created_at->format('H:i') }}</span> WIB</div>
                                        </td>
                                        <td class="px-8 py-6 text-right space-x-2 flex justify-end gap-2">
                                            @php
                                                $phone = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $notif->phone));
                                                $waText = urlencode("Halo {$notif->name}, kami dari ClarityLab ingin mengabarkan bahwa produk {$notif->product_name} yang kamu tunggu-tunggu sekarang sudah siap!");
                                            @endphp
                                            <a href="https://wa.me/{{ $phone }}?text={{ $waText }}" target="_blank" class="bg-green-50 text-green-600 border border-green-200 dark:bg-green-900/30 dark:border-green-800 dark:text-green-400 text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl hover:bg-green-100 transition-all flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.125-.397-.179-.974-.439-1.983-1.342-1.008-.902-1.692-2.015-1.89-2.355-.198-.34-.022-.525.148-.696.155-.155.334-.393.5-.591.167-.197.222-.336.334-.56.111-.224.055-.419-.028-.574-.083-.155-.733-1.767-1.005-2.42-.266-.638-.535-.551-.733-.561-.186-.01-.399-.012-.612-.012-.213 0-.56.08-.853.398-.293.318-1.121 1.096-1.121 2.673 0 1.577 1.147 3.103 1.307 3.318.16.215 2.264 3.456 5.485 4.846.767.332 1.365.53 1.834.678.771.243 1.472.208 2.028.126.621-.092 1.913-.782 2.18-1.538.267-.757.267-1.405.187-1.538-.08-.133-.293-.213-.613-.373z"/></svg>
                                                WhatsApp
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-10 text-center">
                                            <div class="text-gray-400 dark:text-gray-500 font-bold">Belum ada data pendaftar Notify Me.</div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
