{{-- File: resources/views/layouts/footer.blade.php --}}
<footer class="mt-auto relative overflow-hidden bg-white dark:bg-navy-950 py-16 transition-all duration-500 border-t border-orange-500/10 dark:border-orange-500/20">
    <!-- Subtle Glow Orbs -->
    <div class="absolute top-0 left-1/4 w-64 h-64 bg-orange-500/5 dark:bg-orange-500/10 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-slate-200 dark:bg-navy-900/40 rounded-full blur-3xl opacity-30"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-12 mb-16">
            <!-- Branding -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/ClarityLabs_Light.svg') }}" alt="ClarityLabs" class="h-8 w-auto dark:hidden">
                            <img src="{{ asset('images/ClarityLabs_Dark.svg') }}" alt="ClarityLabs" class="h-8 w-auto hidden dark:block">
                            <div class="text-2xl font-black text-navy-900 dark:text-white tracking-tighter">
                                <span class="text-gradient-orange">Clarity</span>Labs
                            </div>
                        </div>
                        <div class="text-[9px] font-black text-orange-500/60 uppercase tracking-widest leading-none mt-1">Intelligence Platform</div>
                    </div>
                </div>
                <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed max-w-xs font-medium">
                    Analisis profitabilitas cerdas untuk membantu Anda mengambil keputusan bisnis yang lebih presisi.
                </p>
            </div>

            <!-- Platform Status -->
            <div class="flex flex-wrap gap-4">
                <div class="bg-gray-50 dark:bg-navy-900/50 border border-orange-500/10 dark:border-white/5 rounded-2xl px-5 py-3 transition-all">
                    <div class="text-[8px] font-black text-orange-500 uppercase tracking-widest mb-1">System Health</div>
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[10px] font-bold text-navy-900 dark:text-white uppercase tracking-wider">Operational</span>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-navy-900/50 border border-orange-500/10 dark:border-white/5 rounded-2xl px-5 py-3 transition-all">
                    <div class="text-[8px] font-black text-orange-500 uppercase tracking-widest mb-1">Last Update</div>
                    <div class="text-[10px] font-bold text-navy-900 dark:text-white uppercase tracking-wider">v2.4.0 • 2026</div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="h-px bg-gradient-to-r from-transparent via-orange-500/20 dark:via-orange-500/10 to-transparent mb-10"></div>

        <!-- Bottom Section -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col items-center md:items-start">
                <span class="text-[9px] text-slate-500 dark:text-slate-500 font-bold uppercase tracking-[0.2em] leading-none mb-1">Created by ClarityLabs</span>
                <span class="text-[9px] text-slate-400 dark:text-slate-600 font-medium uppercase tracking-widest leading-none">Business Intelligence Platform</span>
            </div>
            
            <div class="flex items-center gap-6 flex-wrap justify-center md:justify-end">
                <a href="https://wa.me/6285797245448" target="_blank" class="text-[10px] font-black text-slate-400 dark:text-slate-500 hover:text-orange-500 dark:hover:text-white uppercase tracking-widest transition-all">Support: +62 857-9724-5448</a>
                <a href="https://Instagram.com/claritylabs.id" target="_blank" class="text-[10px] font-black text-slate-400 dark:text-slate-500 hover:text-orange-500 dark:hover:text-white uppercase tracking-widest transition-all">Instagram: @claritylabs.id</a>
                <div class="w-1.5 h-1.5 rounded-full bg-orange-500/20"></div>
                <span class="text-[10px] font-black text-navy-900 dark:text-white uppercase tracking-widest">© 2026 ClarityLabs</span>
            </div>
        </div>
    </div>
</footer>
