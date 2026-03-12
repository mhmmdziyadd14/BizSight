<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>

    <div class="py-10 bg-[#F3F4F6] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between border-b pb-6 border-gray-200">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center">
                        <span class="bg-gray-900 text-yellow-400 px-3 py-1 rounded-lg mr-3 text-xl italic shadow-lg">Biz</span>
                        ADMIN COMMAND CENTER
                    </h1>
                    <p class="mt-2 text-sm text-gray-500 font-medium">
                        Otorisasi akses pengguna dan monitoring performa bisnis global secara real-time.
                    </p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center border border-green-200">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        System Online
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-all duration-700"></div>
                    <div class="relative z-10">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Analyzed Products</div>
                        <div class="text-4xl font-black text-gray-900">{{ $allCalculations->count() }}</div>
                        <div class="mt-2 text-xs font-bold text-blue-500 flex items-center">
                            Total Business Viability Checks
                        </div>
                    </div>
                </div> 
                
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-yellow-50 rounded-full opacity-50 group-hover:scale-150 transition-all duration-700"></div>
                    <div class="relative z-10">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Pending Approval</div>
                        <div class="text-4xl font-black text-yellow-600">{{ $users->where('is_approved', false)->count() }}</div>
                        <div class="mt-2 text-xs font-bold text-yellow-500 italic">Waiting for your authorization...</div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-gray-50 rounded-full opacity-50 group-hover:scale-150 transition-all duration-700"></div>
                    <div class="relative z-10">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Total Registered</div>
                        <div class="text-4xl font-black text-gray-900">{{ $users->count() }}</div>
                        <div class="mt-2 text-xs font-bold text-gray-500 uppercase tracking-widest">Global BizSight Users</div>
                    </div>
                </div>
            </div>

            <div class="space-y-12">
                
                <div class="bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-800 overflow-hidden">
                    <div class="px-8 py-6 flex justify-between items-center border-b border-gray-800">
                        <h3 class="font-bold text-white flex items-center tracking-wide">
                            <span class="bg-yellow-400 text-black w-8 h-8 rounded-xl flex items-center justify-center mr-4 text-xs italic">U</span>
                            USER AUTHORIZATION
                        </h3>
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.3em]">Access Management</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-black/30">
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-500 uppercase tracking-widest">Full Name</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-500 uppercase tracking-widest">Security Credentials</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-500 uppercase tracking-widest text-center">Authorization</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-500 uppercase tracking-widest text-right">Command</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse($users as $user)
                                <tr class="hover:bg-white/[0.02] transition-colors group">
                                    <td class="px-8 py-5 font-bold text-white">{{ $user->name }}</td>
                                    <td class="px-8 py-5">
                                        <div class="text-sm font-bold text-gray-300">{{ $user->email }}</div>
                                        <div class="text-[10px] font-black text-yellow-500/50 uppercase tracking-widest mt-1">{{ $user->role }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        @if($user->is_approved)
                                            <span class="px-4 py-1.5 bg-green-500/10 text-green-500 rounded-full text-[10px] font-black uppercase tracking-widest border border-green-500/20">Authorized</span>
                                        @else
                                            <span class="px-4 py-1.5 bg-red-500/10 text-red-500 rounded-full text-[10px] font-black uppercase tracking-widest border border-red-500/20">Access Denied</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        @if(!$user->is_approved)
                                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="bg-yellow-400 text-black px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-white transition-all shadow-lg shadow-yellow-400/10 active:scale-95">
                                                    Grant Access
                                                </button>
                                            </form>
                                        @else
                                            <svg class="w-5 h-5 text-gray-700 ml-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center text-gray-600 font-bold italic uppercase tracking-widest text-sm">Database empty. No users found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden mt-3">
                    <div class="bg-white px-8 py-6 flex justify-between items-center border-b border-gray-50">
                        <h3 class="font-bold text-gray-900 flex items-center tracking-wide uppercase text-sm">
                            <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-xl flex items-center justify-center mr-4 text-xs font-black">P</span>
                            Global Product Monitoring
                        </h3>
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Real-time Feed</div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Product Instance</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Ownership</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Performance</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 text-right">System Result</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($allCalculations as $calc)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-8 py-6">
                                        <div class="font-bold text-gray-900 text-lg">{{ $calc->product_name }}</div>
                                        <div class="text-[10px] font-black text-gray-400 uppercase mt-1">ID: #BZS-{{ $calc->id }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-sm font-bold text-gray-800">{{ $calc->user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $calc->user->email }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center">
                                            <div class="mr-4">
                                                <div class="text-[9px] font-black text-gray-400 uppercase mb-1">Net Margin</div>
                                                <div class="text-base font-black text-gray-900">{{ number_format($calc->net_margin_percent, 1) }}%</div>
                                            </div>
                                            <div class="h-8 w-px bg-gray-100 mx-2"></div>
                                            <div>
                                                <div class="text-[9px] font-black text-gray-400 uppercase mb-1">BEP Target</div>
                                                <div class="text-base font-black text-blue-600">{{ $calc->bep_unit }} <span class="text-[10px] font-bold text-gray-300">PCS</span></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <span class="px-4 py-2 bg-gray-900 text-yellow-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.1em] border-2 border-gray-900 shadow-xl shadow-gray-100">
                                            {{ $calc->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center text-gray-400 font-bold italic text-sm">No product data available in the cloud.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="bg-gray-900 border-t border-gray-800 py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="text-2xl font-black text-white mb-3 italic tracking-tighter">
                <span class="text-yellow-400">Biz</span>Sight Command
            </div>
            <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.4em] mb-4">Core Analytics Engine v1.0.4</p>
            <div class="h-px w-20 bg-yellow-400/30 mx-auto mb-6"></div>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest italic">
                Developed by Muhammad Ziyad • Institut Teknologi Nasional Bandung
            </p>
        </div>
    </footer>
</x-app-layout>
