{{-- File: auth/login.blade.php --}}
<x-guest-layout>
    <div class="mb-10">
        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-500 mb-2">Welcome Back</p>
        <h1 class="text-3xl font-black text-navy dark:text-white leading-tight">Masuk ke Akun</h1>
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Field -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Email Address</label>
            <x-text-input type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                class="w-full bg-gray-50 border-gray-200 text-navy placeholder-gray-400 focus:bg-white dark:bg-white/5 dark:border-white/10 dark:text-white"
                placeholder="email@anda.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password Field -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Password</label>
            <x-text-input type="password" name="password" required autocomplete="current-password" 
                class="w-full bg-gray-50 border-gray-200 text-navy placeholder-gray-400 focus:bg-white dark:bg-white/5 dark:border-white/10 dark:text-white"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer group">
                <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-orange-500 focus:ring-orange-500/50">
                <span class="text-xs font-bold text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 transition-colors">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs font-bold text-orange-600 dark:text-orange-500 hover:text-orange-700 dark:hover:text-orange-400 transition-colors">Lupa password?</a>
            @endif
        </div>

        <!-- Submit Button -->
        <x-primary-button class="w-full justify-center py-4 text-sm tracking-widest">
            Log In
        </x-primary-button>

        <!-- Register Link -->
        <div class="text-center pt-4">
            <p class="text-xs text-gray-500 font-bold">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-orange-500 hover:text-orange-400 ml-1">Daftar Gratis</a>
            </p>
        </div>
    </form>
</x-guest-layout>