<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-black tracking-tight">Buat Akun BizSight</h1>
        <p class="mt-2 text-sm text-white/70">Daftar untuk mulai menghitung HPP dan mengelola bahan dengan mudah.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-xs font-black text-white/80" />
            <x-text-input id="name" class="block mt-1 w-full rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-yellow-400 focus:ring-yellow-400" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-300" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-black text-white/80" />
            <x-text-input id="email" class="block mt-1 w-full rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-yellow-400 focus:ring-yellow-400" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-300" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-xs font-black text-white/80" />

            <x-text-input id="password" class="block mt-1 w-full rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-yellow-400 focus:ring-yellow-400"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-300" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-black text-white/80" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-yellow-400 focus:ring-yellow-400"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-300" />
        </div>

        <div class="flex items-center justify-between">
            <a class="text-xs font-black uppercase tracking-widest text-white/70 hover:text-white" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-yellow-400 text-black hover:bg-white hover:text-black">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
