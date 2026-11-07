<!-- Sidebar Admin Karsapedia - Clean Minimalist -->
<aside class="flex flex-col w-64 md:w-72 bg-[#f4f5f6] text-slate-700 min-h-screen p-5 justify-between">
    <div class="space-y-6">
        <!-- Logo Brand -->
        <div class="flex items-center gap-3 px-2">
            <div class="w-10 h-10 rounded-full bg-[#1a1d1f] flex items-center justify-center text-white shadow-sm flex-shrink-0">
                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 3v18M3 12h18"/>
                </svg>
            </div>
            <div>
                <h1 class="font-extrabold text-base text-[#1a1d1f] leading-none tracking-tight">Karsapedia</h1>
                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Admin Panel</span>
            </div>
        </div>

        <!-- Navigation Menu (Hanya Menu Fungsional) -->
        <nav class="space-y-1.5 pt-2">
            <!-- Dashboard Monitoring -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-bold transition-all duration-200 {{ request()->routeIs('admin.dashboard') && !request('role') ? 'bg-white text-[#1a1d1f] shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-white/60' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="2"/>
                    <rect x="14" y="3" width="7" height="7" rx="2"/>
                    <rect x="14" y="14" width="7" height="7" rx="2"/>
                    <rect x="3" y="14" width="7" height="7" rx="2"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Manajemen Pengguna -->
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-white text-[#1a1d1f] shadow-sm font-bold' : 'text-slate-500 hover:text-slate-900 hover:bg-white/60' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>Manajemen Pengguna</span>
            </a>

            <!-- Log Aktivitas -->
            <a href="{{ route('admin.activity-logs.index') }}"
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-white text-[#1a1d1f] shadow-sm font-bold' : 'text-slate-500 hover:text-slate-900 hover:bg-white/60' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Log Aktivitas</span>
            </a>

            <!-- Profil Saya -->
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-white text-[#1a1d1f] shadow-sm font-bold' : 'text-slate-500 hover:text-slate-900 hover:bg-white/60' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                <span>Pengaturan Profil</span>
            </a>
        </nav>
    </div>

    <!-- User Profile & Logout Widget -->
    <div class="pt-4 border-t border-slate-200/80">
        <div class="p-2.5 rounded-2xl bg-white border border-slate-200/60 shadow-2xs flex items-center justify-between gap-2.5">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 min-w-0 flex-1 group" title="Buka Pengaturan Profil">
                <div class="w-9 h-9 rounded-full bg-[#1a1d1f] text-white font-extrabold flex items-center justify-center text-xs uppercase flex-shrink-0 group-hover:scale-105 transition-transform">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-[#1a1d1f] truncate leading-tight group-hover:text-slate-600 transition-colors" title="{{ Auth::user()->name }}">
                        {{ Auth::user()->name }}
                    </p>
                    <span class="text-[10px] text-slate-400 font-medium block mt-0.5">
                        {{ Auth::user()->role === 'admin' ? 'Administrator' : ucfirst(Auth::user()->role) }}
                    </span>
                </div>
            </a>

            <!-- Form Logout -->
            <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                @csrf
                <button type="submit" title="Keluar / Logout" class="w-8 h-8 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
