<x-admin-layout>
    <div class="space-y-6">

        <!-- Header Page -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1a1d1f] tracking-tight">
                    Log Aktivitas
                </h2>
                <p class="text-xs text-slate-400 mt-1">
                    Riwayat lengkap pencatatan interaksi, perubahan role, dan aktivitas pengguna di Karsapedia.
                </p>
            </div>

            <!-- Back to Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-white border border-slate-200/80 text-xs font-bold text-slate-700 hover:text-slate-900 shadow-2xs hover:bg-slate-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

        <!-- Bento Card Table Log Aktivitas -->
        <div class="bg-white rounded-[28px] p-7 sm:p-8 shadow-2xs border border-slate-100 space-y-6">

            <!-- Filter & Search Toolbar -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <!-- Action Filter Pills -->
                <div class="flex flex-wrap items-center gap-1.5 bg-slate-100/70 p-1.5 rounded-2xl">
                    <a href="{{ route('admin.activity-logs.index', request()->only('search')) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request('action') ? 'bg-white text-[#1a1d1f] shadow-2xs' : 'text-slate-500 hover:text-slate-900' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.activity-logs.index', array_merge(request()->only('search'), ['action' => 'UPDATE_ROLE'])) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('action') === 'UPDATE_ROLE' ? 'bg-white text-indigo-700 shadow-2xs' : 'text-slate-500 hover:text-slate-900' }}">
                        Ubah Role
                    </a>
                    <a href="{{ route('admin.activity-logs.index', array_merge(request()->only('search'), ['action' => 'UPDATE_STATUS'])) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('action') === 'UPDATE_STATUS' ? 'bg-white text-emerald-700 shadow-2xs' : 'text-slate-500 hover:text-slate-900' }}">
                        Ubah Status
                    </a>
                </div>

                <!-- Search Input -->
                <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="flex items-center gap-2">
                    @if(request('action'))
                        <input type="hidden" name="action" value="{{ request('action') }}">
                    @endif
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari deskripsi / pengguna..."
                               class="text-xs rounded-full border-slate-200 pl-8 pr-4 py-2 w-56 sm:w-64 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs">
                        <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button type="submit" class="px-3.5 py-2 bg-[#1a1d1f] text-white text-xs font-bold rounded-full shadow-2xs transition">
                        Cari
                    </button>
                    @if(request('search') || request('action'))
                        <a href="{{ route('admin.activity-logs.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-full transition hover:bg-slate-200">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table Logs -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase text-[11px] font-bold border-b border-slate-100">
                            <th class="py-3.5 px-4">Pengguna</th>
                            <th class="py-3.5 px-4">Aksi</th>
                            <th class="py-3.5 px-4">Rincian Aktivitas</th>
                            <th class="py-3.5 px-4">IP Address</th>
                            <th class="py-3.5 px-4">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/80 text-sm">
                        @forelse($logs as $log)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- User -->
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 text-xs uppercase flex-shrink-0">
                                            {{ substr($log->user?->name ?? 'S', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-[#1a1d1f] text-xs leading-tight">{{ $log->user?->name ?? 'Sistem' }}</p>
                                            <p class="text-[11px] text-slate-400 font-medium">{{ $log->user?->email ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Action Badge -->
                                <td class="py-4 px-4">
                                    @if($log->action === 'UPDATE_ROLE')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-700">
                                            Ubah Role
                                        </span>
                                    @elseif($log->action === 'UPDATE_STATUS')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700">
                                            Ubah Status
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700">
                                            {{ $log->action }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Description -->
                                <td class="py-4 px-4 text-xs text-slate-700 font-medium">
                                    {{ $log->description }}
                                </td>

                                <!-- IP Address -->
                                <td class="py-4 px-4 text-xs text-slate-400 font-mono">
                                    {{ $log->ip_address ?? '127.0.0.1' }}
                                </td>

                                <!-- Timestamp -->
                                <td class="py-4 px-4 text-xs text-slate-400 whitespace-nowrap">
                                    <span class="font-semibold text-slate-600 block">{{ $log->created_at?->format('d M Y, H:i') }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $log->created_at?->diffForHumans() }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400 text-xs">
                                    Belum ada log aktivitas yang tercatat. Lakukan perubahan role atau status akun untuk melihat pencatatan log.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($logs, 'hasPages') && $logs->hasPages())
                <div class="pt-4 border-t border-slate-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>

    </div>
</x-admin-layout>

