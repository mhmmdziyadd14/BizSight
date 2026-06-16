<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Visual <span class="text-orange-500">Packs</span></h1>
                    <p class="text-slate-500 mt-1">Kelola data Technical Sheet & Visual Clarity Pack Anda.</p>
                </div>
                <a href="{{ route('clarity.visual') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 text-white rounded-xl text-sm font-black uppercase tracking-wider hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/30">
                    + BUAT VISUAL PACK BARU
                </a>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-medium">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="py-4 px-6 font-bold text-xs text-slate-400 uppercase tracking-wider">TANGGAL</th>
                            <th class="py-4 px-6 font-bold text-xs text-slate-400 uppercase tracking-wider">NAMA PACK</th>
                            <th class="py-4 px-6 font-bold text-xs text-slate-400 uppercase tracking-wider">PRODUK TERKAIT</th>
                            <th class="py-4 px-6 font-bold text-xs text-slate-400 uppercase tracking-wider text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visuals as $visual)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-700"><span class="local-time" data-utc="{{ $visual->created_at->toIso8601String() }}">{{ $visual->created_at->format('d M Y') }}</span></span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $visual->name }}</div>
                            </td>
                            <td class="py-4 px-6">
                                @if($visual->hppCalculation)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $visual->hppCalculation->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400 text-sm italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('clarity.visual', $visual->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-orange-100 text-orange-600 hover:bg-orange-500 hover:text-white transition-colors" title="Edit & Cetak PDF">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('visual.destroy', $visual->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus Visual Pack ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-500">
                                Belum ada data Visual Pack. <br>
                                <a href="{{ route('clarity.visual') }}" class="text-orange-500 font-bold hover:underline mt-2 inline-block">Buat sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
