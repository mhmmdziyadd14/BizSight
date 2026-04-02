{{-- File: user-approval-management.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .bg-gradient-orange {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
        }
        
        .text-gradient-orange {
            background: linear-gradient(135deg, #F97316 0%, #F59E0B 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .bg-gradient-navy {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            position: relative;
            overflow: hidden;
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
        
        .status-approved {
            background: linear-gradient(135deg, #10B98110 0%, #05966920 100%);
            color: #059669;
            border: 1px solid #10B98130;
        }
        
        .status-pending {
            background: linear-gradient(135deg, #F59E0B10 0%, #F9731620 100%);
            color: #F59E0B;
            border: 1px solid #F9731630;
        }
        
        .btn-approve {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.25);
        }
        
        .btn-approve:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.35);
        }
        
        .btn-approve:active {
            transform: translateY(0);
        }
        
        .table-row-hover {
            transition: all 0.2s ease;
        }
        
        .table-row-hover:hover {
            background: linear-gradient(90deg, #FEF3C7 0%, #FFF7ED 100%);
        }
        
        .badge-icon {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.875rem;
            border-radius: 2rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.03em;
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
        
        .empty-state {
            animation: fadeInUp 0.4s ease-out;
        }
    </style>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-navy-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between border-b pb-6 border-orange-200/50 fade-in-up">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-orange rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                <span class="text-gradient-orange">User</span>
                                <span class="text-navy-900">Approval Management</span>
                            </h1>
                            <p class="mt-1 text-sm text-navy-600 font-medium">
                                Kelola akses dan otorisasi pengguna AVS Store
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm px-5 py-2.5 rounded-2xl shadow-sm border border-orange-200">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                        </span>
                        <span class="text-[10px] font-black text-navy-700 uppercase tracking-widest">Access Management</span>
                    </div>
                </div>
            </div>

            <!-- Stats Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8 fade-in-up">
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Total Users</p>
                            <p class="text-2xl font-black text-navy-900 mt-1">{{ $users->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Approved</p>
                            <p class="text-2xl font-black text-green-600 mt-1">{{ $users->where('is_approved', true)->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Pending</p>
                            <p class="text-2xl font-black text-orange-500 mt-1">{{ $users->where('is_approved', false)->count() }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-2xl shadow-sm border border-orange-100 p-5 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-orange-500 uppercase tracking-wider">Approval Rate</p>
                            <p class="text-2xl font-black text-navy-900 mt-1">
                                {{ $users->count() > 0 ? round(($users->where('is_approved', true)->count() / $users->count()) * 100) : 0 }}%
                            </p>
                        </div>
                        <div class="w-10 h-10 bg-navy-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-navy-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Approval Table Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden fade-in-up">
                <div class="bg-gradient-navy px-6 py-5 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white text-base tracking-wide">Manajemen Persetujuan User</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[9px] font-bold text-orange-300 uppercase tracking-wider">{{ $users->where('is_approved', false)->count() }} Menunggu</span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    @if($users->isEmpty())
                        <div class="p-12 text-center empty-state">
                            <div class="w-16 h-16 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-black text-navy-800 mb-2">Belum Ada User Terdaftar</h3>
                            <p class="text-sm text-navy-500 max-w-md mx-auto">Belum ada user yang mendaftar. User akan muncul di sini setelah melakukan registrasi.</p>
                        </div>
                    @else
                        <table class="min-w-full divide-y divide-orange-100">
                            <thead class="bg-orange-50/70">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[11px] font-black text-navy-700 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Nama
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-[11px] font-black text-navy-700 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            Email
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-[11px] font-black text-navy-700 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Status
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-[11px] font-black text-navy-700 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                            Aksi
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-orange-50">
                                @foreach($users as $user)
                                <tr class="table-row-hover transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-gradient-orange rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-semibold text-navy-800">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm text-navy-600">{{ $user->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->is_approved)
                                            <span class="badge-icon status-approved">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Disetujui
                                            </span>
                                        @else
                                            <span class="badge-icon status-pending">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Tertunda
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(!$user->is_approved)
                                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-approve inline-flex items-center gap-2 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider shadow-md transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Approve
                                                </button>
                                            </form>
                                        @else
                                            <div class="inline-flex items-center gap-2 text-gray-400 italic text-xs">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span class="font-medium">Selesai</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <!-- Table Footer -->
                        <div class="bg-orange-50/30 px-6 py-3 border-t border-orange-100 flex justify-between items-center">
                            <div class="text-[10px] font-semibold text-navy-500">
                                Total {{ $users->count() }} user terdaftar
                            </div>
                            <div class="flex gap-3 text-[10px] font-bold">
                                <span class="flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span> 
                                    {{ $users->where('is_approved', true)->count() }} Disetujui
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-orange-500"></span> 
                                    {{ $users->where('is_approved', false)->count() }} Tertunda
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Info Card -->
            <div class="mt-6 bg-gradient-to-r from-orange-500/10 to-orange-400/5 rounded-2xl p-4 border border-orange-200/50 fade-in-up">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-orange-600 uppercase tracking-wider">Informasi Persetujuan</p>
                        <p class="text-xs text-navy-600 mt-1">
                            User yang telah disetujui akan mendapatkan akses penuh ke aplikasi ClarityLabs, termasuk kalkulator HPP, manajemen bahan baku, dan fitur analisis bisnis lainnya.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>