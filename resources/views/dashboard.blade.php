{{-- File: dashboard.blade.php --}}
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
        
        .dashboard-container {
            background: linear-gradient(135deg, #FEF3C7 0%, #FFFFFF 50%, #F1F5F9 100%);
            min-height: 100vh;
        }
        
        .welcome-card {
            background: white;
            border-radius: 32px;
            border: 1px solid rgba(249, 115, 22, 0.2);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .welcome-card:hover {
            border-color: #F97316;
            box-shadow: 0 20px 35px -12px rgba(249, 115, 22, 0.2);
            transform: translateY(-2px);
        }
        
        .card-header {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            padding: 28px 32px;
            border-bottom: 4px solid #F97316;
        }
        
        .card-header h1 {
            font-size: 28px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }
        
        .card-header p {
            font-size: 14px;
            color: #94A3B8;
            margin-top: 8px;
        }
        
        .card-content {
            padding: 32px;
        }
        
        .greeting-text {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #F97316, #F59E0B);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 32px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #FEF3C7 0%, #FFEDD5 100%);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(249, 115, 22, 0.2);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -12px rgba(249, 115, 22, 0.25);
            border-color: #F97316;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        
        .stat-icon svg {
            width: 24px;
            height: 24px;
            color: #F97316;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 800;
            color: #0F172A;
            line-height: 1.2;
        }
        
        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: #F97316;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 8px;
        }
        
        .quick-actions {
            margin-top: 32px;
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 60px;
            font-size: 13px;
            font-weight: 700;
            color: #1E293B;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        
        .action-btn:hover {
            border-color: #F97316;
            color: #F97316;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.15);
        }
        
        .action-btn-primary {
            background: linear-gradient(135deg, #F97316, #EA580C);
            border: none;
            color: white;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }
        
        .action-btn-primary:hover {
            background: linear-gradient(135deg, #EA580C, #F97316);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.35);
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
        
        .welcome-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #FEF3C7, #FFEDD5);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .welcome-icon svg {
            width: 32px;
            height: 32px;
            color: #F97316;
        }
    </style>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-orange rounded-xl flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
            <h2 class="font-extrabold text-xl text-navy-800 leading-tight tracking-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="dashboard-container py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="welcome-card fade-in-up">
                <div class="card-header">
                    <div class="flex items-center gap-3">
                        <div class="welcome-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <h1>Welcome to <span class="text-gradient-orange">BizSight</span></h1>
                            <p>Your Business Intelligence Dashboard</p>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                        <div>
                            <p class="text-2xl font-bold text-navy-800">
                                {{ __("You're logged in!") }}
                            </p>
                            <p class="text-sm text-navy-500 mt-1">
                                Manage your HPP calculations, materials inventory, and business analysis from here.
                            </p>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="stat-value">HPP</div>
                            <div class="stat-label">Cost Calculator</div>
                            <p class="text-xs text-navy-500 mt-2">Calculate product costs accurately</p>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div class="stat-value">Materials</div>
                            <div class="stat-label">Inventory</div>
                            <p class="text-xs text-navy-500 mt-2">Track raw materials stock</p>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="stat-value">Analysis</div>
                            <div class="stat-label">Business Viability</div>
                            <p class="text-xs text-navy-500 mt-2">Evaluate your business health</p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <a href="{{ route('hpp.create') }}" class="action-btn action-btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New HPP Calculation
                        </a>
                        <a href="{{ route('materials.index') }}" class="action-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Manage Materials
                        </a>
                        <a href="{{ route('hpp.index') }}" class="action-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            View HPP Reports
                        </a>
                        <a href="{{ route('business.index') }}" class="action-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Business Analyzer
                        </a>
                    </div>

                    <!-- Welcome Message -->
                    <div class="mt-8 pt-6 border-t border-orange-100">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-xs font-bold text-orange-600 uppercase tracking-wider">Getting Started</p>
                                <p class="text-xs text-navy-500 mt-1">
                                    New to BizSight? Start by adding your materials inventory, then create your first HPP calculation. 
                                    Use the Business Analyzer to evaluate product viability and make data-driven decisions.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>