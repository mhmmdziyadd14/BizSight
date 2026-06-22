{{-- File: auth/register.blade.php --}}
<x-guest-layout>
    <div class="mb-10">
        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-500 mb-2">Create Account</p>
        <h1 class="text-3xl font-black text-navy dark:text-white leading-tight">Daftar Akun Baru</h1>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name Field -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Full Name</label>
            <x-text-input type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                class="w-full bg-gray-50 border-gray-200 text-navy placeholder-gray-400 focus:bg-white dark:bg-white/5 dark:border-white/10 dark:text-white"
                placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Field -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Email Address</label>
            <x-text-input type="email" name="email" :value="old('email')" required autocomplete="username" 
                class="w-full bg-gray-50 border-gray-200 text-navy placeholder-gray-400 focus:bg-white dark:bg-white/5 dark:border-white/10 dark:text-white"
                placeholder="email@anda.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Field -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">No Telepon</label>
            <x-text-input type="text" name="phone" :value="old('phone')" required 
                class="w-full bg-gray-50 border-gray-200 text-navy placeholder-gray-400 focus:bg-white dark:bg-white/5 dark:border-white/10 dark:text-white"
                placeholder="+62 812-3456-7890" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password Field -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Password</label>
            <x-text-input type="password" name="password" required autocomplete="new-password" 
                class="w-full bg-gray-50 border-gray-200 text-navy placeholder-gray-400 focus:bg-white dark:bg-white/5 dark:border-white/10 dark:text-white"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Confirm Password</label>
            <x-text-input type="password" name="password_confirmation" required autocomplete="new-password" 
                class="w-full bg-gray-50 border-gray-200 text-navy placeholder-gray-400 focus:bg-white dark:bg-white/5 dark:border-white/10 dark:text-white"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <x-primary-button class="w-full justify-center py-4 text-sm tracking-widest">
            Create Account
        </x-primary-button>

        <!-- Login Link -->
        <div class="text-center pt-4">
            <p class="text-xs text-gray-500 font-bold">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-400 ml-1">Masuk Sekarang</a>
            </p>
        </div>
    </form>
</x-guest-layout>