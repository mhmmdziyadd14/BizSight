{{-- File: profile/edit.blade.php --}}
<x-app-layout>
    <style>
        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .profile-header {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            border-radius: 24px;
            padding: 48px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 32px;
            color: white;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(249, 115, 22, 0.2);
        }
        
        .profile-header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .profile-avatar-large {
            width: 100px;
            height: 100px;
            background: var(--cl-orange, #F97316);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: 800;
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.4);
            border: 4px solid rgba(255, 255, 255, 0.1);
            z-index: 10;
        }
        
        .profile-info h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 4px;
            letter-spacing: -0.02em;
        }
        
        .profile-info p {
            font-size: 16px;
            opacity: 0.7;
            font-weight: 500;
        }
        
        .profile-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 32px;
        }
        
        .profile-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .p-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            border-radius: 16px;
            text-decoration: none;
            color: #64748b;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
            border: 1px solid transparent;
        }
        
        .dark .p-nav-item { color: #94a3b8; }
        
        .p-nav-item:hover {
            background: white;
            color: #F97316;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        
        .dark .p-nav-item:hover { background: #1e293b; }
        
        .p-nav-item.active {
            background: white;
            color: #F97316;
            border-color: rgba(249, 115, 22, 0.3);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }
        
        .dark .p-nav-item.active { background: #1e293b; border-color: rgba(249, 115, 22, 0.5); }
        
        .profile-card {
            background: white;
            border-radius: 24px;
            padding: 32px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 32px;
        }
        
        .dark .profile-card {
            background: #0F172A;
            border-color: #334155;
        }
        
        .profile-card-title {
            font-size: 18px;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .dark .profile-card-title { color: white; }
        
        .p-dot { width: 12px; height: 4px; border-radius: 4px; background: #F97316; }

        /* Customizing partial contents */
        .profile-card h2 { display: none; }
        .profile-card p.mt-1 { margin-bottom: 24px; color: #64748b; font-size: 14px; }
        .dark .profile-card p.mt-1 { color: #94a3b8; }
        
        @media (max-width: 768px) {
            .profile-grid { grid-template-columns: 1fr; }
            .profile-header { padding: 32px; flex-direction: column; text-align: center; }
        }
    </style>

    <div class="profile-container">
        <!-- Modern Header -->
        <div class="profile-header">
            <div class="profile-avatar-large">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <h1>{{ $user->name }}</h1>
                <p>{{ $user->email }} • Member since {{ $user->created_at->format('M Y') }}</p>
            </div>
        </div>

        <div class="profile-grid">
            <!-- Sidebar Nav -->
            <div class="profile-nav">
                <a href="#info" class="p-nav-item active" onclick="scrollToSection('info', this)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Account Info
                </a>
                <a href="#password" class="p-nav-item" onclick="scrollToSection('password', this)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Security
                </a>
                <a href="#danger" class="p-nav-item" onclick="scrollToSection('danger', this)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Danger Zone
                </a>
            </div>

            <!-- Content Cards -->
            <div class="profile-content">
                <div id="info" class="profile-card">
                    <div class="profile-card-title"><div class="p-dot"></div> Update Profile</div>
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div id="password" class="profile-card">
                    <div class="profile-card-title"><div class="p-dot"></div> Change Password</div>
                    @include('profile.partials.update-password-form')
                </div>

                <div id="danger" class="profile-card" style="border-color: #fca5a5;">
                    <div class="profile-card-title" style="color: #ef4444;"><div class="p-dot" style="background: #ef4444;"></div> Delete Account</div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script>
        function scrollToSection(id, el) {
            document.querySelectorAll('.p-nav-item').forEach(n => n.classList.remove('active'));
            el.classList.add('active');
            // document.getElementById(id).scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    </script>
</x-app-layout>
