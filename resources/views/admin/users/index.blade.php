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

        <!-- Header Page & Add Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1a1d1f] tracking-tight">
                    Manajemen Pengguna
                </h2>
                <p class="text-xs text-slate-400 mt-1">
                    Kelola data pengguna, perbarui hak akses role, serta atur status keaktifan akun.
                </p>
            </div>

            <!-- Tambah Pengguna Button -->
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#1a1d1f] hover:bg-black text-white text-xs font-bold shadow-sm transition self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Pengguna</span>
            </a>
        </div>

        <!-- 4 Quick Stat Bento Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-2xs">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pengguna</span>
                <h4 class="text-2xl font-extrabold text-[#1a1d1f] mt-1">{{ number_format($stats['total']) }}</h4>
                <p class="text-[11px] text-emerald-600 font-semibold mt-0.5">{{ $stats['active'] }} akun aktif</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-2xs">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Siswa</span>
                <h4 class="text-2xl font-extrabold text-sky-600 mt-1">{{ number_format($stats['siswa']) }}</h4>
                <p class="text-[11px] text-slate-400 mt-0.5">Role Siswa</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-2xs">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Guru</span>
                <h4 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ number_format($stats['guru']) }}</h4>
                <p class="text-[11px] text-slate-400 mt-0.5">Role Guru</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-2xs">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Administrator</span>
                <h4 class="text-2xl font-extrabold text-indigo-600 mt-1">{{ number_format($stats['admin']) }}</h4>
                <p class="text-[11px] text-slate-400 mt-0.5">Role Admin</p>
            </div>
        </div>

        <!-- Main Bento Table -->
        <div class="bg-white rounded-[28px] p-7 sm:p-8 shadow-2xs border border-slate-100 space-y-6">

            <!-- Filter & Search Toolbar -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <!-- Filter Role Pills (Formal, No Emojis) -->
                <div class="flex flex-wrap items-center gap-1.5 bg-slate-100/70 p-1.5 rounded-2xl">
                    <a href="{{ route('admin.users.index', request()->only('search', 'status')) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request('role') ? 'bg-white text-[#1a1d1f] shadow-2xs' : 'text-slate-500 hover:text-slate-900' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.users.index', array_merge(request()->only('search', 'status'), ['role' => 'siswa'])) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('role') === 'siswa' ? 'bg-white text-sky-600 shadow-2xs' : 'text-slate-500 hover:text-slate-900' }}">
                        Siswa
                    </a>
                    <a href="{{ route('admin.users.index', array_merge(request()->only('search', 'status'), ['role' => 'guru'])) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('role') === 'guru' ? 'bg-white text-emerald-600 shadow-2xs' : 'text-slate-500 hover:text-slate-900' }}">
                        Guru
                    </a>
                    <a href="{{ route('admin.users.index', array_merge(request()->only('search', 'status'), ['role' => 'admin'])) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('role') === 'admin' ? 'bg-white text-indigo-600 shadow-2xs' : 'text-slate-500 hover:text-slate-900' }}">
                        Administrator
                    </a>
                </div>

                <!-- Search Input -->
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
                    @if(request('role'))
                        <input type="hidden" name="role" value="{{ request('role') }}">
                    @endif
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari nama, username, email, sekolah..."
                               class="text-xs rounded-full border-slate-200 pl-8 pr-4 py-2 w-56 sm:w-64 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs">
                        <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button type="submit" class="px-3.5 py-2 bg-[#1a1d1f] text-white text-xs font-bold rounded-full shadow-2xs transition">
                        Cari
                    </button>
                    @if(request('search') || request('role') || request('status'))
                        <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-full transition hover:bg-slate-200">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table List Pengguna -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase text-[11px] font-bold border-b border-slate-100">
                            <th class="py-3.5 px-4">Pengguna</th>
                            <th class="py-3.5 px-4">Role</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4">Nomor HP</th>
                            <th class="py-3.5 px-4">Terdaftar</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/80 text-sm">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- User Info -->
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 text-xs uppercase flex-shrink-0">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <p class="font-bold text-[#1a1d1f] text-xs leading-tight">{{ $user->name }}</p>
                                                @if($user->username)
                                                    <span class="text-[10px] font-semibold text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded-md">
                                                        {{ '@' . $user->username }}
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-[11px] text-slate-400 font-medium">{{ $user->email }}</p>
                                            @if($user->school)
                                                <p class="text-[10px] text-slate-500 font-semibold mt-0.5 truncate max-w-[280px]" title="{{ $user->school->name }}">
                                                    {{ $user->school->name }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Role Badge -->
                                <td class="py-4 px-4">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-700">
                                            Admin
                                        </span>
                                    @elseif($user->role === 'guru')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700">
                                            Guru
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-sky-50 text-sky-700">
                                            Siswa
                                        </span>
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-4">
                                    @if($user->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#e6f9ed] text-[#12b76a]">
                                            Active
                                        </span>
                                    @elseif($user->status === 'inactive')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#f4f5f6] text-slate-400">
                                            Offline
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700">
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                <!-- Kontak -->
                                <td class="py-4 px-4 text-xs text-slate-500 font-medium">
                                    {{ $user->phone_number ?? '-' }}
                                </td>

                                <!-- Tanggal -->
                                <td class="py-4 px-4 text-xs text-slate-400 font-medium">
                                    {{ $user->created_at?->format('d M Y') ?? '-' }}
                                </td>

                                <!-- Aksi CRUD: Edit & Delete -->
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           title="Edit Pengguna"
                                           class="p-1.5 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition shadow-2xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <!-- Delete Button -->
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Hapus Pengguna"
                                                        class="p-1.5 rounded-xl text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition shadow-2xs"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-slate-300 italic px-2">Anda</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 text-xs">
                                    Tidak ada data pengguna yang sesuai dengan kriteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="pt-4 border-t border-slate-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>
</x-admin-layout>
