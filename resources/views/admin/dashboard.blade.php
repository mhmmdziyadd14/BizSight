{{-- File: admin-dashboard.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .bg-gradient-orange {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
        }
        
        .bg-gradient-navy {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        }
        
        .text-gradient-orange {
            background: linear-gradient(135deg, #F97316 0%, #F59E0B 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .stat-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #F97316, #F59E0B);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }
        
        .badge-authorized {
            background: linear-gradient(135deg, #05966910 0%, #10B98120 100%);
            color: #059669;
            border: 1px solid #10B98130;
        }
        
        .badge-denied {
            background: linear-gradient(135deg, #DC262610 0%, #EF444420 100%);
            color: #DC2626;
            border: 1px solid #EF444430;
        }
        
        .table-row-hover {
            transition: all 0.2s ease;
        }
        
        .table-row-hover:hover {
            background: rgba(249, 115, 22, 0.05);
        }
        
        .btn-grant {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }
        
        .btn-grant:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
        }
        
        .btn-grant:active {
            transform: translateY(0);
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 40px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.05em;
        }
        
        .status-healthy {
            background: linear-gradient(135deg, #10B98110 0%, #05966920 100%);
            color: #10B981;
            border: 1px solid #10B98130;
        }
        
        .status-fragile {
            background: linear-gradient(135deg, #F59E0B10 0%, #F9731620 100%);
            color: #F59E0B;
            border: 1px solid #F9731630;
        }
        
        .status-critical {
            background: linear-gradient(135deg, #EF444410 0%, #DC262620 100%);
            color: #EF4444;
            border: 1px solid #EF444430;
        }
    </style>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-navy-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between border-b pb-6 border-orange-200/50 fade-in-up">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="bg-gradient-to-r from-orange-500 to-orange-400 bg-clip-text text-transparent\">Clarity</span>
                                <span class="text-navy-800\">Labs Admin Center</span>
                            </h1>
                            <p class="mt-2 text-sm text-navy-600 font-medium">
                                Otorisasi akses pengguna dan monitoring performa bisnis global secara real-time.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <span class="inline-flex items-center gap-2 bg-green-500/10 text-green-600 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest border border-green-500/30">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        System Online
                    </span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-6 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-orange-50 rounded-full opacity-50 group-hover:scale-150 transition-all duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 bg-orange-100 rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Analyzed Products</div>
                        </div>
                        <div class="text-4xl font-black text-navy-800">{{ $allCalculations->count() }}</div>
                        <div class="mt-2 text-xs font-semibold text-navy-500 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Total Business Viability Checks
                        </div>
                    </div>
                </div> 
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-6 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-orange-50 rounded-full opacity-50 group-hover:scale-150 transition-all duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 bg-orange-100 rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Pending Approval</div>
                        </div>
                        <div class="text-4xl font-black text-orange-500">{{ $users->where('is_approved', false)->count() }}</div>
                        <div class="mt-2 text-xs font-semibold text-navy-500 italic">Waiting for your authorization...</div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-6 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-orange-50 rounded-full opacity-50 group-hover:scale-150 transition-all duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 bg-orange-100 rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total Registered</div>
                        </div>
                        <div class="text-4xl font-black text-navy-800">{{ $users->count() }}</div>
                        <div class="mt-2 text-xs font-semibold text-navy-500 uppercase tracking-wider">Global ClarityLabs Users</div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                
                <!-- User Authorization Table -->
                <div class="bg-gradient-navy rounded-3xl shadow-xl border border-orange-500/30 overflow-hidden fade-in-up">
                    <div class="px-6 py-5 flex justify-between items-center border-b border-orange-500/30">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-white tracking-wide">USER AUTHORIZATION</h3>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-2 bg-gradient-orange text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg hover:shadow-xl transition-all hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Manage Users
                            </a>
                            <span class="text-[9px] font-bold text-orange-300 uppercase tracking-wider">Access Management</span>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-white/5 border-b border-orange-500/20">
                                    <th class="px-6 py-4 text-[10px] font-black text-orange-300 uppercase tracking-wider">Full Name</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-orange-300 uppercase tracking-wider">Security Credentials</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-orange-300 uppercase tracking-wider text-center">Authorization</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-orange-300 uppercase tracking-wider text-right">Command</th>
                                 </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-500/20">
                                @forelse($users as $user)
                                <tr class="table-row-hover transition-colors">
                                    <td class="px-6 py-4 font-bold text-white">{{ $user->name }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-300">{{ $user->email }}</div>
                                        <div class="text-[9px] font-bold text-orange-400/70 uppercase tracking-wider mt-1">{{ $user->role }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($user->is_approved)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 badge-authorized rounded-full text-[9px] font-black uppercase tracking-wider">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                Authorized
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 badge-denied rounded-full text-[9px] font-black uppercase tracking-wider">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                                Access Denied
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if(!$user->is_approved)
                                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-grant inline-flex items-center gap-2 text-white px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-wider shadow-md transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Grant Access
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-8 h-8 bg-green-500/10 rounded-full flex items-center justify-center ml-auto">
                                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <svg class="w-12 h-12 text-orange-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            <p class="text-gray-500 font-semibold italic text-sm">Database empty. No users found.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Global Product Monitoring Table -->
                <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden fade-in-up">
                    <div class="bg-gradient-navy px-6 py-5 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-white tracking-wide">GLOBAL PRODUCT MONITORING</h3>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.product') }}" class="inline-flex items-center gap-2 bg-gradient-orange text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg hover:shadow-xl transition-all hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Manage Products
                            </a>
                            <div class="flex items-center gap-2">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                <span class="text-[9px] font-bold text-orange-300 uppercase tracking-wider">Real-time Feed</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-orange-50/70 border-b border-orange-100">
                                    <th class="px-6 py-4 text-[10px] font-black text-navy-600 uppercase tracking-wider">Product Instance</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-navy-600 uppercase tracking-wider">Ownership</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-navy-600 uppercase tracking-wider">Performance</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-navy-600 uppercase tracking-wider text-right">System Result</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-50">
                                @forelse($allCalculations as $calc)
                                <tr class="table-row-hover transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-navy-800 text-lg">{{ $calc->product_name }}</div>
                                        <div class="text-[9px] font-black text-orange-500 uppercase mt-1">ID: #BZS-{{ $calc->id }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm font-bold text-navy-700">{{ $calc->user->name }}</div>
                                        <div class="text-xs text-navy-500">{{ $calc->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div>
                                                <div class="text-[8px] font-black text-orange-500 uppercase mb-1 tracking-wider">Net Margin</div>
                                                <div class="text-base font-black text-navy-800">{{ number_format($calc->net_margin_percent, 1) }}%</div>
                                            </div>
                                            <div class="h-8 w-px bg-orange-200"></div>
                                            <div>
                                                <div class="text-[8px] font-black text-orange-500 uppercase mb-1 tracking-wider">BEP Target</div>
                                                <div class="text-base font-black text-orange-600">{{ $calc->bep_unit }} <span class="text-[9px] font-bold text-navy-400">PCS</span></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        @php
                                            $statusClass = '';
                                            if (strtoupper($calc->status_label) === 'HEALTHY') {
                                                $statusClass = 'status-healthy';
                                            } elseif (strtoupper($calc->status_label) === 'FRAGILE') {
                                                $statusClass = 'status-fragile';
                                            } else {
                                                $statusClass = 'status-critical';
                                            }
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ strtoupper($calc->status_label) === 'HEALTHY' ? 'bg-green-500' : (strtoupper($calc->status_label) === 'FRAGILE' ? 'bg-orange-500' : 'bg-red-500') }}"></span>
                                            {{ $calc->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <svg class="w-12 h-12 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <p class="text-navy-400 font-semibold italic text-sm">No product data available in the cloud.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="bg-gradient-navy border-t border-orange-500/30 py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center gap-2 mb-4">
                <div class="w-8 h-8 bg-gradient-orange rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="text-2xl font-black tracking-tight">
                    <span class="text-gradient-orange\">Clarity</span>
                    <span class=\"text-white\">Labs Admin</span>
                </div>
            </div>
            <p class="text-[9px] text-orange-400/60 font-black uppercase tracking-wider mb-4">Core Analytics Engine v2.0</p>
            <div class="h-px w-20 bg-gradient-orange/50 mx-auto mb-6"></div>
            <p class="text-[10px] text-navy-300 font-semibold uppercase tracking-wider">
                Developed by Muhammad Ziyad • Institut Teknologi Nasional Bandung
            </p>
        </div>
    </footer>
</x-app-layout>