<x-admin-layout>
    <div class="space-y-8 max-w-5xl mx-auto">

        <!-- Header Halaman Profil -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1a1d1f] tracking-tight">
                    Pengaturan Profil
                </h2>
                <p class="text-xs text-slate-400 mt-1">
                    Kelola data pribadi, nomor kontak, dan keamanan kredensial akun Anda.
                </p>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-white border border-slate-200/80 text-xs font-bold text-slate-700 hover:text-slate-900 shadow-2xs hover:bg-slate-50 transition self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Notifikasi Status -->
        @if (session('status') === 'profile-updated')
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-between text-emerald-800 text-xs font-bold shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Informasi profil berhasil diperbarui.</span>
                </div>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-between text-emerald-800 text-xs font-bold shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Kata sandi akun berhasil diperbarui.</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-between text-rose-800 text-xs font-bold shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Bento Card 1: Ringkasan Akun -->
        <div class="bg-white rounded-[28px] p-6 sm:p-8 shadow-2xs border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-[#1a1d1f] text-white flex items-center justify-center font-bold text-xl uppercase shadow-xs flex-shrink-0">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="space-y-1">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <h3 class="text-lg font-bold text-[#1a1d1f] leading-none">{{ $user->name }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $user->role === 'admin' ? 'bg-indigo-50 text-indigo-700' : ($user->role === 'guru' ? 'bg-amber-50 text-amber-700' : 'bg-blue-50 text-blue-700') }}">
                            {{ $user->role === 'admin' ? 'Administrator' : ucfirst($user->role) }}
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $user->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $user->status === 'active' ? 'Aktif' : ucfirst($user->status) }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 font-medium">{{ $user->email }}</p>
                    @if($user->school)
                        <p class="text-xs font-semibold text-slate-600">Asal Sekolah: {{ $user->school->name }}</p>
                    @endif
                    <p class="text-[11px] text-slate-400">Terdaftar sejak {{ $user->created_at?->format('d F Y') ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Bento Card 2: Informasi Profil -->
        <div class="bg-white rounded-[28px] p-7 sm:p-10 shadow-2xs border border-slate-100">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Bento Card 3: Perbarui Kata Sandi -->
        <div class="bg-white rounded-[28px] p-7 sm:p-10 shadow-2xs border border-slate-100">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Bento Card 4: Hapus Akun -->
        <div class="bg-white rounded-[28px] p-7 sm:p-10 shadow-2xs border border-rose-100/80">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</x-admin-layout>
