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

    <div class="py-10 bg-gray-50 dark:bg-navy-950 min-h-screen transition-colors duration-500" x-data="{ editModal: false, selectedUser: {id: null, name: '', email: '', phone: '', created_at: '', products_html: '', accesses: []} }">
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
                                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Trial & Expiry</th>
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
                                                    $productsHtml = '';
                                                    if (in_array('vcp', $userFeatures)) {
                                                        $productsHtml .= "<span class='badge-feature badge-vcp'>Visual Pack</span>";
                                                    }
                                                    if (in_array('pcc', $userFeatures)) {
                                                        $productsHtml .= "<span class='badge-feature badge-pcc'>Profit Calc</span>";
                                                    }
                                                    if (in_array('de', $userFeatures)) {
                                                        $productsHtml .= "<span class='badge-feature badge-de'>Decision Eng</span>";
                                                    }
                                                @endphp
                                                @if(empty($userFeatures))
                                                    <span class="text-[10px] text-gray-300 dark:text-gray-600 italic font-bold">No Purchases</span>
                                                @else
                                                    {!! $productsHtml !!}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="space-y-1.5">
                                                @php
                                                    $trials = $user->accesses->where('is_trial', true);
                                                @endphp
                                                @if($trials->isEmpty())
                                                    <span class="text-xs text-gray-400 font-bold">-</span>
                                                @else
                                                    @foreach($trials as $trial)
                                                        @php
                                                            $isExpired = $trial->expires_at && now()->greaterThan($trial->expires_at);
                                                        @endphp
                                                        <div class="flex items-center gap-1.5 text-xs">
                                                            <span class="font-black uppercase tracking-wider text-[10px] {{ $isExpired ? 'text-gray-400' : 'text-orange-500' }}">
                                                                {{ strtoupper($trial->feature_code) }}:
                                                            </span>
                                                            @if($isExpired)
                                                                <span class="text-red-500 font-bold">Expired</span>
                                                            @else
                                                                <span class="text-navy dark:text-white font-bold">
                                                                    {{ $trial->expires_at ? $trial->expires_at->format('d M Y') : 'Active' }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </td>
                                        @php
                                            $featureMap = [];
                                            $coreFeatures = ['pcc', 'vcp', 'de'];
                                            foreach ($coreFeatures as $fc) {
                                                $access = $user->accesses->where('feature_code', $fc)->first();
                                                if ($access) {
                                                    $featureMap[$fc] = [
                                                        'id' => $access->id,
                                                        'feature_code' => strtoupper($fc),
                                                        'is_trial' => (bool)$access->is_trial,
                                                        'expires_at' => $access->expires_at ? $access->expires_at->format('Y-m-d') : '',
                                                        'is_lifetime' => !$access->is_trial,
                                                    ];
                                                } else {
                                                    $featureMap[$fc] = [
                                                        'id' => null,
                                                        'feature_code' => strtoupper($fc),
                                                        'is_trial' => false,
                                                        'expires_at' => '',
                                                        'is_lifetime' => false,
                                                    ];
                                                }
                                            }
                                            $accessesJson = json_encode($featureMap);
                                        @endphp
                                        <td class="px-8 py-6 text-right">
                                            <button @click="selectedUser = {
                                                        id: {{ $user->id }}, 
                                                        name: {{ json_encode($user->name) }}, 
                                                        email: {{ json_encode($user->email) }}, 
                                                        phone: {{ json_encode($user->phone ?? '') }},
                                                        created_at: {{ json_encode($user->created_at->format('d M Y H:i')) }},
                                                        products_html: {{ json_encode($productsHtml) }},
                                                        accesses: {{ $accessesJson }}
                                                    }; editModal = true" 
                                                    class="bg-navy-900 dark:bg-navy-800 text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl hover:bg-black transition-all">
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
            <div class="bg-white dark:bg-navy-900 w-full max-w-3xl rounded-[32px] p-8 md:p-10 relative shadow-2xl scale-in transition-colors max-h-[95vh] overflow-y-auto" @click.away="editModal = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-black text-navy dark:text-white mb-1">Edit User Details</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Perbarui informasi email, nama, atau telepon pengguna.</p>
                    </div>
                    <button type="button" @click="editModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column: Inputs -->
                    <div>
                        <form :action="'/admin/users/' + selectedUser.id" method="POST" id="edit-user-form" class="space-y-5">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 ml-1">Full Name</label>
                                <input type="text" name="name" x-model="selectedUser.name" class="w-full bg-gray-50 dark:bg-navy-950 border-gray-100 dark:border-white/5 rounded-2xl px-5 py-3.5 text-sm font-bold text-navy dark:text-white focus:bg-white focus:border-orange-500 focus:ring-0 transition-all">
                            </div>
         
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 ml-1">Email Address</label>
                                <input type="email" name="email" x-model="selectedUser.email" class="w-full bg-gray-50 dark:bg-navy-950 border-gray-100 dark:border-white/5 rounded-2xl px-5 py-3.5 text-sm font-bold text-navy dark:text-white focus:bg-white focus:border-orange-500 focus:ring-0 transition-all">
                            </div>
        
                            <div>
                                                                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 ml-1">No Telepon</label>
                                                                <input type="text" name="phone" x-model="selectedUser.phone" class="w-full bg-gray-50 dark:bg-navy-950 border-gray-100 dark:border-white/5 rounded-2xl px-5 py-3.5 text-sm font-bold text-navy dark:text-white focus:bg-white focus:border-orange-500 focus:ring-0 transition-all">
                                                            </div>

                                                            <div class="border-t border-gray-100 dark:border-white/5 pt-4 mt-4" x-show="selectedUser.accesses">
                                                                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3 ml-1">Manage Trial Status & Expiry</label>
                                                                <div class="space-y-4">
                                                                    
                                                                    <!-- PCC Feature Row -->
                                                                    <div class="bg-gray-50 dark:bg-navy-950 p-4 rounded-2xl border border-gray-100 dark:border-white/5">
                                                                        <div class="flex items-center justify-between">
                                                                            <span class="text-xs font-black text-navy dark:text-white">PROFIT CLARITY CALCULATOR (PCC)</span>
                                                                            
                                                                            <!-- If it is lifetime -->
                                                                            <template x-if="selectedUser.accesses && selectedUser.accesses.pcc && selectedUser.accesses.pcc.is_lifetime">
                                                                                <span class="text-[10px] font-black text-green-500 bg-green-500/10 px-2.5 py-1 rounded-lg uppercase tracking-wider">Purchased (Lifetime)</span>
                                                                            </template>
                                                                            
                                                                            <!-- If it is trial / none -->
                                                                            <template x-if="selectedUser.accesses && selectedUser.accesses.pcc && !selectedUser.accesses.pcc.is_lifetime">
                                                                                <label class="flex items-center gap-2 cursor-pointer">
                                                                                    <input type="checkbox" name="features[pcc][is_trial]" x-model="selectedUser.accesses.pcc.is_trial" class="rounded border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-orange-500 focus:ring-orange-500/50">
                                                                                    <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-wider">Trial Access</span>
                                                                                </label>
                                                                            </template>
                                                                        </div>
                                                                        
                                                                        <!-- Expiry input for PCC -->
                                                                        <template x-if="selectedUser.accesses && selectedUser.accesses.pcc && !selectedUser.accesses.pcc.is_lifetime">
                                                                            <div x-show="selectedUser.accesses.pcc.is_trial" class="mt-3">
                                                                                <label class="block text-[9px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 ml-1">Batas Akhir Trial</label>
                                                                                <input type="date" name="features[pcc][expires_at]" x-model="selectedUser.accesses.pcc.expires_at" class="w-full bg-white dark:bg-navy-900 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2 text-xs font-semibold text-navy dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                                                            </div>
                                                                        </template>
                                                                    </div>

                                                                    <!-- VCP Feature Row -->
                                                                    <div class="bg-gray-50 dark:bg-navy-950 p-4 rounded-2xl border border-gray-100 dark:border-white/5">
                                                                        <div class="flex items-center justify-between">
                                                                            <span class="text-xs font-black text-navy dark:text-white">VISUAL CLARITY PACK (VCP)</span>
                                                                            
                                                                            <!-- If it is lifetime -->
                                                                            <template x-if="selectedUser.accesses && selectedUser.accesses.vcp && selectedUser.accesses.vcp.is_lifetime">
                                                                                <span class="text-[10px] font-black text-green-500 bg-green-500/10 px-2.5 py-1 rounded-lg uppercase tracking-wider">Purchased (Lifetime)</span>
                                                                            </template>
                                                                            
                                                                            <!-- If it is trial / none -->
                                                                            <template x-if="selectedUser.accesses && selectedUser.accesses.vcp && !selectedUser.accesses.vcp.is_lifetime">
                                                                                <label class="flex items-center gap-2 cursor-pointer">
                                                                                    <input type="checkbox" name="features[vcp][is_trial]" x-model="selectedUser.accesses.vcp.is_trial" class="rounded border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-orange-500 focus:ring-orange-500/50">
                                                                                    <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-wider">Trial Access</span>
                                                                                </label>
                                                                            </template>
                                                                        </div>
                                                                        
                                                                        <!-- Expiry input for VCP -->
                                                                        <template x-if="selectedUser.accesses && selectedUser.accesses.vcp && !selectedUser.accesses.vcp.is_lifetime">
                                                                            <div x-show="selectedUser.accesses.vcp.is_trial" class="mt-3">
                                                                                <label class="block text-[9px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 ml-1">Batas Akhir Trial</label>
                                                                                <input type="date" name="features[vcp][expires_at]" x-model="selectedUser.accesses.vcp.expires_at" class="w-full bg-white dark:bg-navy-900 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2 text-xs font-semibold text-navy dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                                                            </div>
                                                                        </template>
                                                                    </div>

                                                                    <!-- DE Feature Row -->
                                                                    <div class="bg-gray-50 dark:bg-navy-950 p-4 rounded-2xl border border-gray-100 dark:border-white/5">
                                                                        <div class="flex items-center justify-between">
                                                                            <span class="text-xs font-black text-navy dark:text-white">DECISION ENGINE (DE)</span>
                                                                            
                                                                            <!-- If it is lifetime -->
                                                                            <template x-if="selectedUser.accesses && selectedUser.accesses.de && selectedUser.accesses.de.is_lifetime">
                                                                                <span class="text-[10px] font-black text-green-500 bg-green-500/10 px-2.5 py-1 rounded-lg uppercase tracking-wider">Purchased (Lifetime)</span>
                                                                            </template>
                                                                            
                                                                            <!-- If it is trial / none -->
                                                                            <template x-if="selectedUser.accesses && selectedUser.accesses.de && !selectedUser.accesses.de.is_lifetime">
                                                                                <label class="flex items-center gap-2 cursor-pointer">
                                                                                    <input type="checkbox" name="features[de][is_trial]" x-model="selectedUser.accesses.de.is_trial" class="rounded border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-orange-500 focus:ring-orange-500/50">
                                                                                    <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-wider">Trial Access</span>
                                                                                </label>
                                                                            </template>
                                                                        </div>
                                                                        
                                                                        <!-- Expiry input for DE -->
                                                                        <template x-if="selectedUser.accesses && selectedUser.accesses.de && !selectedUser.accesses.de.is_lifetime">
                                                                            <div x-show="selectedUser.accesses.de.is_trial" class="mt-3">
                                                                                <label class="block text-[9px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1 ml-1">Batas Akhir Trial</label>
                                                                                <input type="date" name="features[de][expires_at]" x-model="selectedUser.accesses.de.expires_at" class="w-full bg-white dark:bg-navy-900 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2 text-xs font-semibold text-navy dark:text-white focus:border-orange-500 focus:ring-0 transition-all">
                                                                            </div>
                                                                        </template>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </form>
                    </div>

                    <!-- Right Column: Details & Actions -->
                    <div class="flex flex-col justify-between">
                        <!-- Details Section -->
                        <div class="space-y-5">
                            <div>
                                <span class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 ml-1">Tanggal Terdaftar</span>
                                <div class="bg-gray-50 dark:bg-navy-950 rounded-2xl px-5 py-3.5 text-sm font-bold text-navy dark:text-white" x-text="selectedUser.created_at"></div>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 ml-1">Produk Yang Dibeli</span>
                                <div class="bg-gray-50 dark:bg-navy-950 rounded-2xl px-5 py-3.5 flex flex-wrap gap-2 text-navy dark:text-white" x-html="selectedUser.products_html || '<span class=\'text-gray-400 italic font-bold text-xs\'>No Purchases</span>'"></div>
                            </div>
                        </div>

                        <!-- Actions Container -->
                        <div class="flex flex-col gap-3 pt-6 border-t border-gray-100 dark:border-white/5 mt-6">
                            <div class="flex gap-3">
                                <button type="button" @click="editModal = false" class="flex-1 bg-gray-100 dark:bg-navy-800 text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest py-3.5 rounded-2xl">Cancel</button>
                                <button type="submit" form="edit-user-form" class="flex-1 bg-orange-500 text-white text-[10px] font-black uppercase tracking-widest py-3.5 rounded-2xl shadow-lg shadow-orange-500/20">Save Changes</button>
                            </div>

                            <form :action="'/admin/users/' + selectedUser.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.')" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white text-[10px] font-black uppercase tracking-widest py-3.5 rounded-2xl transition-all">
                                    Hapus Akun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>