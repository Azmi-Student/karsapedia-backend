<x-guest-layout>
    <div class="bg-white rounded-[28px] shadow-2xs border border-slate-200/60 overflow-hidden grid grid-cols-1 md:grid-cols-12">

        <!-- Sisi Kiri: Teks Formal Simpel (5 Cols) -->
        <div class="md:col-span-5 bg-slate-50 p-8 sm:p-10 border-b md:border-b-0 md:border-r border-slate-100 flex flex-col justify-between space-y-6">
            <div class="space-y-3">
                <h2 class="text-2xl font-bold text-[#1a1d1f] tracking-tight">
                    Pendaftaran Akun
                </h2>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Daftarkan akun baru untuk mulai mengakses platform dan fasilitas pembelajaran Karsapedia.
                </p>
            </div>

            <div class="pt-6 border-t border-slate-200/60 text-xs text-slate-400">
                Karsapedia
            </div>
        </div>

        <!-- Sisi Kanan: Formulir Registrasi (7 Cols) -->
        <div class="md:col-span-7 bg-white p-8 sm:p-10 flex flex-col justify-center">
            <div class="space-y-5">

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-1.5">
                        <label for="name" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Nama Lengkap
                        </label>
                        <input id="name"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               autocomplete="name"
                               placeholder="Contoh: Budi Santoso"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('name') border-rose-500 @enderror">
                        @error('name')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Email
                        </label>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="username"
                               placeholder="nama@karsapedia.test"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('email') border-rose-500 @enderror">
                        @error('email')
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

                    <!-- Password -->
                    <div class="space-y-1.5">
                        <label for="password" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Kata Sandi
                        </label>
                        <input id="password"
                               type="password"
                               name="password"
                               required
                               autocomplete="new-password"
                               placeholder="Minimal 8 karakter"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('password') border-rose-500 @enderror">
                        @error('password')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Konfirmasi Kata Sandi
                        </label>
                        <input id="password_confirmation"
                               type="password"
                               name="password_confirmation"
                               required
                               autocomplete="new-password"
                               placeholder="Ulangi kata sandi"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('password_confirmation') border-rose-500 @enderror">
                        @error('password_confirmation')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-3 rounded-full bg-[#1a1d1f] hover:bg-black text-white text-xs font-bold shadow-sm transition">
                            Daftar
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="pt-3 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-500">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="font-bold text-[#1a1d1f] hover:underline ml-1">
                            Masuk
                        </a>
                    </p>
                </div>

            </div>
        </div>

    </div>
</x-guest-layout>
