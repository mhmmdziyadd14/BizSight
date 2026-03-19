<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-black tracking-tight">Masuk ke BizSight</h1>
        <p class="mt-2 text-sm text-white/70">Kelola HPP &amp; analisis usaha Anda dengan mudah.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-black text-white/80" />
            <x-text-input id="email" class="block mt-1 w-full rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-yellow-400 focus:ring-yellow-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-300" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-xs font-black text-white/80" />

            <x-text-input id="password" class="block mt-1 w-full rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-yellow-400 focus:ring-yellow-400"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-300" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-3">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-white/30 text-yellow-400 shadow-sm focus:ring-yellow-400" name="remember">
                <span class="ms-2 text-sm text-white/70">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="ml-auto text-sm font-black text-white/70 hover:text-white transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-between">
            <x-primary-button class="bg-yellow-400 text-black hover:bg-white hover:text-black">
                {{ __('Log in') }}
            </x-primary-button>

            <a href="{{ route('register') }}" class="text-xs font-black uppercase tracking-widest text-white/70 hover:text-white">
                {{ __('Create an account') }}
            </a>
        </div>
    </form>
</x-guest-layout>
