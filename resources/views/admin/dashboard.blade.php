<x-admin-layout>
    <div class="space-y-6">

        <!-- Flash Message Alerts -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl shadow-2xs flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <p class="text-xs font-semibold">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 text-sm font-bold px-2">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl shadow-2xs flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </span>
                    <p class="text-xs font-semibold">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 text-sm font-bold px-2">&times;</button>
            </div>
        @endif

        <!-- ================= 1. RINGKASAN 3 CARDS ================= -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Card 1: Siswa -->
            <a href="{{ route('admin.users.index', ['role' => 'siswa']) }}"
               class="bg-white rounded-[28px] p-7 shadow-2xs border border-slate-100 hover:border-sky-300 hover:shadow-sm transition-all duration-200 block group">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <span class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-[#1a1d1f] group-hover:text-white transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Siswa</p>
                    <h4 class="text-3xl sm:text-4xl font-bold text-[#1a1d1f] tracking-tight mt-1">
                        {{ number_format($stats['total_siswa']) }}
                    </h4>
                    <p class="text-xs text-slate-400 mt-1">Pengguna dengan hak akses siswa</p>
                </div>
            </a>

            <!-- Card 2: Guru -->
            <a href="{{ route('admin.users.index', ['role' => 'guru']) }}"
               class="bg-white rounded-[28px] p-7 shadow-2xs border border-slate-100 hover:border-emerald-300 hover:shadow-sm transition-all duration-200 block group">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <span class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-[#1a1d1f] group-hover:text-white transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Guru</p>
                    <h4 class="text-3xl sm:text-4xl font-bold text-[#1a1d1f] tracking-tight mt-1">
                        {{ number_format($stats['total_guru']) }}
                    </h4>
                    <p class="text-xs text-slate-400 mt-1">Pengguna dengan hak akses guru</p>
                </div>
            </a>

            <!-- Card 3: Admin -->
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
               class="bg-white rounded-[28px] p-7 shadow-2xs border border-slate-100 hover:border-indigo-300 hover:shadow-sm transition-all duration-200 block group">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-[#1a1d1f] group-hover:text-white transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
                <div class="mt-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Administrator</p>
                    <h4 class="text-3xl sm:text-4xl font-bold text-[#1a1d1f] tracking-tight mt-1">
                        {{ number_format($stats['total_admin']) }}
                    </h4>
                    <p class="text-xs text-slate-400 mt-1">Pengguna dengan hak akses admin</p>
                </div>
            </a>
        </div>

        <!-- ================= 2. GRAFIK (KIRI) & LOG AKTIVITAS (KANAN) ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- Kiri (8 Cols): GRAFIK AKTIVITAS PENGGUNA -->
            <div class="lg:col-span-8 bg-white rounded-[28px] p-7 sm:p-8 shadow-2xs border border-slate-100 space-y-6">
                <!-- Header Card Grafik -->
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-[#1a1d1f]">
                            Statistik Pendaftaran Pengguna
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Frekuensi akun baru yang terdaftar dalam 7 hari terakhir.</p>
                    </div>

                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-600 shadow-2xs">
                        <span>7 Hari Terakhir</span>
                    </div>
                </div>

                <!-- Konten Grafik Bar Modern (Full Width & Clean) -->
                <div class="pt-6">
                    <div class="flex items-end gap-3 sm:gap-6 h-48 w-full justify-between">
                        @foreach($chartData as $item)
                            <div class="flex flex-col items-center gap-2 h-full justify-end flex-1">
                                @if($item['is_today'])
                                    <!-- Bar Hari Ini (Gradasi Hijau) -->
                                    <div class="relative flex flex-col items-center justify-end h-full w-full max-w-[48px]">
                                        <div class="absolute -top-9 flex flex-col items-center">
                                            <span class="bg-[#1a1d1f] text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm whitespace-nowrap">
                                                Hari ini
                                            </span>
                                            <div class="w-1.5 h-1.5 bg-[#1a1d1f] rotate-45 -mt-0.5"></div>
                                        </div>
                                        <div style="height: {{ $item['height'] }}%;"
                                             class="w-full bg-gradient-to-t from-emerald-400 to-emerald-300 rounded-t-xl transition-all duration-500 shadow-xs"></div>
                                    </div>
                                @else
                                    <!-- Bar Biasa -->
                                    <div class="w-full max-w-[48px] h-full flex items-end justify-center">
                                        <div style="height: {{ $item['height'] }}%;"
                                             class="w-full bg-slate-100 hover:bg-slate-200 rounded-t-xl transition-all duration-300"
                                             title="{{ $item['date'] }}: {{ $item['count'] }} pendaftaran"></div>
                                    </div>
                                @endif
                                <span class="text-[11px] font-semibold {{ $item['is_today'] ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">
                                    {{ $item['day'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kanan (4 Cols): LOG AKTIVITAS TERBARU -->
            <div class="lg:col-span-4 bg-white rounded-[28px] p-7 shadow-2xs border border-slate-100 space-y-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-[#1a1d1f]">
                            Log Aktivitas
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Catatan riwayat sistem</p>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                </div>

                <!-- Feed Log Aktivitas -->
                <div class="space-y-4">
                    @forelse($recentLogs as $log)
                        <div class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-slate-50 transition">
                            <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 text-xs uppercase flex-shrink-0">
                                {{ substr($log->user?->name ?? 'S', 0, 1) }}
                            </div>
                            <div class="space-y-0.5 overflow-hidden flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-xs font-bold text-[#1a1d1f] truncate">{{ $log->user?->name ?? 'Sistem' }}</p>
                                    <span class="text-[10px] text-slate-400 whitespace-nowrap">{{ $log->created_at?->diffForHumans(null, true) }}</span>
                                </div>
                                <p class="text-[11px] text-slate-500 leading-snug line-clamp-2">
                                    {{ $log->description }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <!-- Fallback jika belum ada log aksi -->
                        @foreach($latestUsers as $user)
                            <div class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-slate-50 transition">
                                <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 text-xs uppercase flex-shrink-0">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="space-y-0.5 overflow-hidden flex-1">
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs font-bold text-[#1a1d1f] truncate">{{ $user->name }}</p>
                                        <span class="text-[10px] text-slate-400">{{ $user->created_at?->diffForHumans(null, true) }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 leading-snug">
                                        Akun baru terdaftar dengan role <span class="font-bold text-slate-700 capitalize">{{ $user->role }}</span>.
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endforelse
                </div>

                <!-- Tombol ke Halaman Detail Log Aktivitas -->
                <a href="{{ route('admin.activity-logs.index') }}"
                   class="w-full py-3 rounded-2xl border border-slate-200 hover:border-slate-900 bg-white hover:bg-slate-50 text-xs font-bold text-[#1a1d1f] transition shadow-2xs block text-center mt-2">
                    Lihat Riwayat Lengkap
                </a>
            </div>

        </div>

    </div>
</x-admin-layout>
