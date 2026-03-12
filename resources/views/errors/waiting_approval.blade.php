<x-guest-layout>
    <div class="text-center p-6">
        <h2 class="text-2xl font-bold text-gray-800">Akun Menunggu Persetujuan</h2>
        <p class="mt-4 text-gray-600">Terima kasih sudah mendaftar di BizShigth. Mohon tunggu admin menyetujui akun Anda sebelum bisa menggunakan Kalkulator Bisnis.</p>
        <div class="mt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-blue-500 underline">Logout</button>
            </form>
        </div>
    </div>
</x-guest-layout>