<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Top Header & Back Link -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1a1d1f] tracking-tight">
                    Tambah Pengguna Baru
                </h2>
                <p class="text-xs text-slate-400 mt-1">
                    Daftarkan akun baru ke sistem dengan role Siswa, Guru, atau Administrator.
                </p>
            </div>

            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-slate-200/80 text-xs font-bold text-slate-700 hover:text-slate-900 shadow-2xs hover:bg-slate-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Bento Form Container -->
        <div class="bg-white rounded-[28px] p-7 sm:p-10 shadow-2xs border border-slate-100">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6" autocomplete="off">
                @csrf
                <!-- Pencegah autofill otomatis dari browser -->
                <input type="text" style="display:none" aria-hidden="true">
                <input type="password" style="display:none" aria-hidden="true">

                <!-- Grid 2 Kolom Input -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <!-- Nama Lengkap -->
                    <div class="space-y-2">
                        <label for="name" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               placeholder="Contoh: Budi Santoso"
                               autocomplete="off"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('name') border-rose-500 @enderror">
                        @error('name')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="space-y-2">
                        <label for="username" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Username
                        </label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                               placeholder="Contoh: budisantoso (opsional)"
                               autocomplete="off"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('username') border-rose-500 @enderror">
                        @error('username')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Alamat Email <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               placeholder="nama@karsapedia.test"
                               autocomplete="off"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('email') border-rose-500 @enderror">
                        @error('email')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Password Awal <span class="text-rose-500">*</span>
                        </label>
                        <input type="password" name="password" id="password" required
                               placeholder="Minimal 8 karakter"
                               autocomplete="new-password"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('password') border-rose-500 @enderror">
                        @error('password')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor HP / WA -->
                    <div class="space-y-2">
                        <label for="phone_number" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Nomor Telepon / WhatsApp
                        </label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                               placeholder="081234567890"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('phone_number') border-rose-500 @enderror">
                        @error('phone_number')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Asal Sekolah (Live Autocomplete) -->
                    <x-school-autocomplete
                        name="school_name"
                        :value="old('school_name')"
                        label="Asal Sekolah"
                        placeholder="Contoh: SMKN 1 Surabaya"
                    />

                    <!-- Role Pengguna -->
                    <div class="space-y-2">
                        <label for="role" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Pilih Role <span class="text-rose-500">*</span>
                        </label>
                        <select name="role" id="role" required
                                class="w-full text-xs font-bold rounded-2xl border-slate-200 p-3.5 bg-white focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('role') border-rose-500 @enderror">
                            <option value="siswa" {{ old('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        @error('role')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Akun -->
                    <div class="space-y-2">
                        <label for="status" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Status Akun <span class="text-rose-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full text-xs font-bold rounded-2xl border-slate-200 p-3.5 bg-white focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('status') border-rose-500 @enderror">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                        @error('status')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Action Buttons -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.users.index') }}"
                       class="px-5 py-2.5 rounded-full text-xs font-bold text-slate-500 hover:text-slate-800 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-full bg-[#1a1d1f] hover:bg-black text-white text-xs font-bold shadow-sm transition">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>

