{{-- File: back-button-pill.blade.php --}}
<div class="mb-6">
    <button type="button"
            onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ route('welcome') }}'"
            class="group inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-300 bg-gradient-to-r from-orange-400 to-orange-500 text-white shadow-md hover:shadow-orange-500/25 hover:shadow-lg hover:scale-105 active:scale-95">
        <svg class="w-4 h-4 transition-transform duration-300 group-hover:-translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back</span>
    </button>
</div>