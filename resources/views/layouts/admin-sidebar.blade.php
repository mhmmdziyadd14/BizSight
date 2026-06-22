{{-- File: resources/views/layouts/admin-sidebar.blade.php --}}
<div class="bg-white dark:bg-navy-900 rounded-[28px] border border-gray-100 dark:border-white/5 p-6 shadow-sm space-y-2 transition-colors duration-500">
    <div class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest px-4 mb-4">Navigasi Admin</div>
    
    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all duration-300 {{ Route::is('admin.dashboard') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-gray-600 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-navy-800 hover:text-orange-500' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
        </svg>
        <span>Dashboard Admin</span>
    </a>

    <a href="{{ route('admin.users') }}" 
       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all duration-300 {{ Route::is('admin.users') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-gray-600 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-navy-800 hover:text-orange-500' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <span>User Database</span>
    </a>

    <a href="{{ route('admin.product') }}" 
       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all duration-300 {{ Route::is('admin.product') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-gray-600 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-navy-800 hover:text-orange-500' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        <span>Product Monitoring</span>
    </a>

    <a href="{{ route('admin.notifications') }}" 
       class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all duration-300 {{ Route::is('admin.notifications') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-gray-600 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-navy-800 hover:text-orange-500' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span>Waitlist Database</span>
    </a>
</div>
