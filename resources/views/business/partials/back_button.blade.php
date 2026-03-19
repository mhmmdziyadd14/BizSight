<div class="mb-6">
    <button type="button"
            onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ route('welcome') }}'"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest text-black bg-yellow-400 hover:bg-yellow-500 transition">
        Back
    </button>
</div>
