<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil | ClarityLab</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
        }
        .dark body {
            background: #0f172a;
        }
    </style>
</head>
<body class="antialiased text-gray-900 dark:text-gray-100 flex items-center justify-center min-h-screen">
    
    <div class="bg-white dark:bg-slate-800 p-10 rounded-3xl shadow-xl max-w-md w-full text-center border border-gray-100 dark:border-slate-700">
        <!-- Success Icon -->
        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h1 class="text-2xl font-extrabold mb-4">Pembayaran Berhasil!</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
            Terima kasih atas pembelian Anda. Akses produk sedang diproses. <br><br>
            <span class="font-bold text-orange-500">Silakan cek email Anda</span> untuk informasi akses atau klik tautan reset password untuk masuk ke dashboard.
        </p>
        
        <a href="{{ route('login') }}" class="inline-flex justify-center items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-xl transition-all w-full mb-4">
            Masuk ke Dashboard
        </a>
        <a href="{{ route('welcome') }}" class="inline-flex justify-center items-center gap-2 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 font-bold py-3 px-8 rounded-xl transition-all w-full">
            Kembali ke Beranda
        </a>
    </div>

</body>
</html>
