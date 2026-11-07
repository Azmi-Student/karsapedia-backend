<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-[#1a1d1f] tracking-tight">
                    Dashboard Pengguna
                </h2>
                <p class="text-xs text-slate-400 mt-1">
                    Selamat datang di portal akun Karsapedia Anda.
                </p>
            </div>

            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#1a1d1f] hover:bg-black text-white text-xs font-bold shadow-sm transition">
                    <span>Panel Monitoring Admin</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            @endif
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Welcome Banner Bento Card -->
        <div class="bg-white rounded-[28px] p-7 sm:p-10 shadow-2xs border border-slate-200/60 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-[#1a1d1f] text-white flex items-center justify-center font-extrabold text-xl uppercase shadow-xs flex-shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="space-y-1.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-xl font-bold text-[#1a1d1f] leading-none">{{ Auth::user()->name }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ Auth::user()->role === 'admin' ? 'bg-indigo-50 text-indigo-700' : (Auth::user()->role === 'guru' ? 'bg-amber-50 text-amber-700' : 'bg-sky-50 text-sky-700') }}">
                            {{ Auth::user()->role === 'admin' ? 'Administrator' : ucfirst(Auth::user()->role) }}
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">
                            Aktif
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 font-medium">{{ Auth::user()->email }}</p>
                    <p class="text-[11px] text-slate-400">Terdaftar pada {{ Auth::user()->created_at?->format('d F Y') ?? '-' }}</p>
                </div>
            </div>

            <div>
                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white border border-slate-200/90 text-xs font-bold text-slate-700 hover:text-black hover:bg-slate-50 shadow-2xs transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <span>Pengaturan Akun</span>
                </a>
            </div>
        </div>

        <!-- 3 Bento Feature / Quick Access Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Card 1: Informasi Akun -->
            <div class="bg-white rounded-[28px] p-7 shadow-2xs border border-slate-200/60 space-y-4">
                <div class="w-11 h-11 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#1a1d1f]">Informasi Kredensial</h3>
                    <p class="text-xs text-slate-400 mt-1">Data identitas dan hak akses akun Anda yang tersimpan di sistem.</p>
                </div>
                <div class="pt-3 border-t border-slate-100 space-y-2 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Asal Sekolah:</span>
                        <span class="font-bold text-[#1a1d1f] truncate max-w-[150px]">{{ Auth::user()->school?->name ?? 'Belum diatur' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Nomor Kontak:</span>
                        <span class="font-bold text-[#1a1d1f]">{{ Auth::user()->phone_number ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Status Akses:</span>
                        <span class="font-bold text-emerald-600">Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Akses Mobile Flutter -->
            <div class="bg-white rounded-[28px] p-7 shadow-2xs border border-slate-200/60 space-y-4">
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="5" y="2" width="14" height="20" rx="3"/>
                        <path d="M12 18h.01"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#1a1d1f]">Aplikasi Mobile</h3>
                    <p class="text-xs text-slate-400 mt-1">Akun ini dapat digunakan untuk login ke aplikasi Flutter Karsapedia.</p>
                </div>
                <div class="pt-3 border-t border-slate-100 text-xs text-slate-500 font-medium">
                    Sinkronisasi data otomatis via Karsapedia REST API.
                </div>
            </div>

            <!-- Card 3: Keamanan & Sesi -->
            <div class="bg-white rounded-[28px] p-7 shadow-2xs border border-slate-200/60 space-y-4">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#1a1d1f]">Keamanan Akun</h3>
                    <p class="text-xs text-slate-400 mt-1">Pastikan kredensial dan kata sandi akun Anda selalu terbarui.</p>
                </div>
                <div class="pt-3 border-t border-slate-100">
                    <a href="{{ route('profile.edit') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                        Kelola Kata Sandi &rarr;
                    </a>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
