<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - ClarityLabs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Midtrans Snap Script -->
    @if(config('midtrans.is_production'))
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
</head>
<body class="bg-gradient-to-b from-navy-900 to-navy-800 min-h-screen text-white font-sans antialiased flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white/5 border border-white/10 p-8 rounded-3xl relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 p-4 opacity-10">
            <svg class="w-24 h-24 text-orange-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
        </div>
        
        <h2 class="text-2xl font-black mb-6 relative z-10">Ringkasan Pesanan</h2>
        
        <div class="space-y-4 mb-8 relative z-10">
            <div class="flex justify-between items-center border-b border-white/10 pb-4">
                <span class="text-gray-400">Produk</span>
                <span class="font-bold text-orange-400">{{ $product->name }}</span>
            </div>
            <div class="flex justify-between items-center border-b border-white/10 pb-4">
                <span class="text-gray-400">Tipe</span>
                <span class="font-bold uppercase text-[10px] bg-orange-500/20 text-orange-400 px-2 py-1 rounded">{{ $product->type == 'bundle' ? 'Bundle' : 'Single Tool' }}</span>
            </div>
            <div class="flex justify-between items-center pt-2">
                <span class="text-gray-300">Total Pembayaran</span>
                <span class="text-3xl font-black text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="space-y-3 relative z-10">
            <button id="pay-button" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-orange-500/30">
                Bayar Sekarang
            </button>
            <a href="{{ route('welcome') }}" class="block text-center w-full bg-white/5 hover:bg-white/10 text-gray-300 font-bold py-3 rounded-xl transition-all">
                Batal
            </a>
        </div>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    alert("Pembayaran berhasil! Silakan nikmati akses ke fitur Anda.");
                    window.location.href = "{{ route('dashboard') }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!");
                    window.location.href = "{{ route('dashboard') }}";
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        });
    </script>
</body>
</html>
