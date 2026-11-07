<section>
    <header class="mb-6">
        <h3 class="text-base sm:text-lg font-extrabold text-[#1a1d1f] tracking-tight">
            Informasi Profil
        </h3>
        <p class="text-xs text-slate-400 mt-1">
            Perbarui data identitas nama lengkap, alamat email resmi, dan nomor kontak akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            <!-- Nama Lengkap -->
            <div class="space-y-2">
                <label for="name" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       required
                       autofocus
                       autocomplete="name"
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
                <input type="text"
                       id="username"
                       name="username"
                       value="{{ old('username', $user->username) }}"
                       placeholder="Contoh: budisantoso (tanpa spasi)"
                       class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('username') border-rose-500 @enderror">
                @error('username')
                    <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat Email -->
            <div class="space-y-2">
                <label for="email" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                    Alamat Email <span class="text-rose-500">*</span>
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       required
                       autocomplete="username"
                       class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 text-xs text-amber-700 bg-amber-50 p-3 rounded-xl border border-amber-200">
                        <p>Alamat email Anda belum terverifikasi.</p>
                        <button form="send-verification" class="mt-1 font-bold underline hover:text-amber-900">
                            Kirim ulang email verifikasi
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-[11px] font-bold text-emerald-700">
                                Tautan verifikasi baru telah dikirimkan ke alamat email Anda.
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Nomor Telepon / WA -->
            <div class="space-y-2">
                <label for="phone_number" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                    Nomor Telepon / WhatsApp
                </label>
                <input type="text"
                       id="phone_number"
                       name="phone_number"
                       value="{{ old('phone_number', $user->phone_number) }}"
                       placeholder="Contoh: 081234567890"
                       autocomplete="tel"
                       class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('phone_number') border-rose-500 @enderror">
                @error('phone_number')
                    <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Asal Sekolah (Live Autocomplete) -->
            <x-school-autocomplete
                class="sm:col-span-2"
                name="school_name"
                :value="old('school_name', $user->school?->name)"
                label="Asal Sekolah"
                placeholder="Contoh: SMKN 1 Surabaya"
            />

        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
            <button type="submit"
                    class="px-6 py-2.5 rounded-full bg-[#1a1d1f] hover:bg-black text-white text-xs font-bold shadow-sm transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</section>
