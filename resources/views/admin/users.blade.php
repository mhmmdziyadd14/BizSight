{{-- File: admin/users.blade.php --}}
<x-app-layout>
    <style>
        :root {
            --ora: #F97316;
            --ora-dk: #EA580C;
            --navy: #0F172A;
        }
        
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .bg-gradient-orange { background: linear-gradient(135deg, var(--ora) 0%, var(--ora-dk) 100%); }
        .text-gradient-orange { background: linear-gradient(135deg, var(--ora) 0%, #F59E0B 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
        
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1); }
        
        .status-approved { background: #10B98110; color: #059669; border: 1px solid #10B98130; }
        .status-pending { background: #F59E0B10; color: #F59E0B; border: 1px solid #F9731630; }
        
        .dark .status-approved { background: rgba(16, 185, 129, 0.1); color: #34d399; border-color: rgba(16, 185, 129, 0.2); }
        .dark .status-pending { background: rgba(245, 158, 11, 0.1); color: #fbbf24; border-color: rgba(245, 158, 11, 0.2); }

        .badge-feature { font-size: 9px; font-weight: 800; padding: 4px 10px; border-radius: 30px; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-vcp { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .badge-pcc { background: #fdf2f8; color: #db2777; border: 1px solid #fbcfe8; }
        .badge-de { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        
        .dark .badge-vcp { background: rgba(37, 99, 235, 0.1); color: #60a5fa; border-color: rgba(37, 99, 235, 0.2); }
        .dark .badge-pcc { background: rgba(219, 39, 119, 0.1); color: #f472b6; border-color: rgba(219, 39, 119, 0.2); }
        .dark .badge-de { background: rgba(22, 163, 74, 0.1); color: #4ade80; border-color: rgba(22, 163, 74, 0.2); }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    </style>

    <div class="py-10 bg-gray-50 dark:bg-navy-950 min-h-screen transition-colors duration-500" x-data="{ editModal: false, selectedUser: {id: null, name: '', email: ''} }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between border-b pb-6 border-gray-200 dark:border-white/5 fade-in-up">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-navy dark:bg-orange-500 rounded-2xl flex items-center justify-center shadow-lg transition-colors">
                        <svg class="w-7 h-7 text-orange-500 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-navy dark:text-white transition-colors"><span class="text-orange-500">User</span> Database</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Kelola akses, edit informasi, dan pantau pembelian pengguna.</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Admin -->
                <div class="w-full lg:w-64 shrink-0">
                    @include('layouts.admin-sidebar')
                </div>

                <div class="flex-1">
                    <!-- Table -->
                    <div class="bg-white dark:bg-navy-900 rounded-[32px] shadow-xl border border-gray-100 dark:border-white/5 overflow-hidden fade-in-up transition-colors">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 dark:divide-white/5">
                                <thead class="bg-gray-50/50 dark:bg-navy-950/50 transition-colors">
                                    <tr>
                                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">User Profile</th>
                                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Purchased Tools</th>
                                        <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-white/5 bg-white dark:bg-navy-900 transition-colors">
                                    @foreach($users as $user)
                                    <tr class="hover:bg-orange-50/30 dark:hover:bg-white/5 transition-colors">
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 bg-navy dark:bg-navy-800 rounded-xl flex items-center justify-center text-orange-500 font-black shadow-sm transition-colors">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="text-base font-bold text-navy dark:text-white transition-colors">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-400 dark:text-gray-500 font-medium">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="flex flex-wrap gap-2">
                                                @php
                                                    $userFeatures = $user->accesses->pluck('feature_code')->map(fn($f) => strtolower($f))->toArray();
                                                @endphp
                                                @if(empty($userFeatures))
                                                    <span class="text-[10px] text-gray-300 dark:text-gray-600 italic font-bold">No Purchases</span>
                                                @else
                                                    @if(in_array('vcp', $userFeatures)) <span class="badge-feature badge-vcp">Visual Pack</span> @endif
                                                    @if(in_array('pcc', $userFeatures)) <span class="badge-feature badge-pcc">Profit Calc</span> @endif
                                                    @if(in_array('de', $userFeatures)) <span class="badge-feature badge-de">Decision Eng</span> @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-right space-x-2">
                                            <button @click="selectedUser = {id: {{ $user->id }}, name: '{{ $user->name }}', email: '{{ $user->email }}'}; editModal = true" 
                                                    class="bg-navy dark:bg-navy-800 text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl hover:bg-black transition-all">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-navy/80 backdrop-blur-sm" @click="editModal = false"></div>
            <div class="bg-white dark:bg-navy-900 w-full max-w-md rounded-[32px] p-10 relative shadow-2xl scale-in transition-colors" @click.away="editModal = false">
                <h2 class="text-2xl font-black text-navy dark:text-white mb-2">Edit User Details</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-8 font-medium">Perbarui informasi email atau nama pengguna.</p>
                
                <form :action="'/admin/users/' + selectedUser.id" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2 ml-1">Full Name</label>
                        <input type="text" name="name" x-model="selectedUser.name" class="w-full bg-gray-50 dark:bg-navy-950 border-gray-100 dark:border-white/5 rounded-2xl px-5 py-4 text-sm font-bold text-navy dark:text-white focus:bg-white focus:border-orange-500 focus:ring-0 transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                        <input type="email" name="email" x-model="selectedUser.email" class="w-full bg-gray-50 dark:bg-navy-950 border-gray-100 dark:border-white/5 rounded-2xl px-5 py-4 text-sm font-bold text-navy dark:text-white focus:bg-white focus:border-orange-500 focus:ring-0 transition-all">
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="button" @click="editModal = false" class="flex-1 bg-gray-100 dark:bg-navy-800 text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest py-4 rounded-2xl">Cancel</button>
                        <button type="submit" class="flex-1 bg-orange-500 text-white text-[10px] font-black uppercase tracking-widest py-4 rounded-2xl shadow-lg shadow-orange-500/20">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>