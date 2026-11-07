<x-guest-layout>
    <div class="bg-white rounded-[28px] shadow-2xs border border-slate-200/60 overflow-hidden grid grid-cols-1 md:grid-cols-12">

        <!-- Sisi Kiri: Teks Formal Simpel (5 Cols) -->
        <div class="md:col-span-5 bg-slate-50 p-8 sm:p-10 border-b md:border-b-0 md:border-r border-slate-100 flex flex-col justify-between space-y-6">
            <div class="space-y-3">
                <h2 class="text-2xl font-bold text-[#1a1d1f] tracking-tight">
                    Masuk ke Sistem
                </h2>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Gunakan akun terdaftar Anda untuk mengakses portal akademik dan layanan pemantauan Karsapedia.
                </p>
            </div>

            <div class="pt-6 border-t border-slate-200/60 text-xs text-slate-400">
                Karsapedia
            </div>
        </div>

        <!-- Sisi Kanan: Formulir Masuk (7 Cols) -->
        <div class="md:col-span-7 bg-white p-8 sm:p-10 flex flex-col justify-center">
            <div class="space-y-5">

                <!-- Session Status Alert -->
                @if (session('status'))
                    <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email or Username -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                            Email atau Username
                        </label>
                        <input id="email"
                               type="text"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="nama@karsapedia.test atau username"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('email') border-rose-500 @enderror">
                        @error('email')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                                Kata Sandi
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-slate-500 hover:text-black transition">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>
                        <input id="password"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('password') border-rose-500 @enderror">
                        @error('password')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center pt-1">
                        <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="w-4 h-4 rounded-md border-slate-300 text-[#1a1d1f] focus:ring-slate-900 shadow-2xs">
                            <span class="text-xs text-slate-600 font-medium">Ingat saya</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-3 rounded-full bg-[#1a1d1f] hover:bg-black text-white text-xs font-bold shadow-sm transition">
                            Masuk
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
                @if (Route::has('register'))
                    <div class="pt-3 border-t border-slate-100 text-center">
                        <p class="text-xs text-slate-500">
                            Belum memiliki akun?
                            <a href="{{ route('register') }}" class="font-bold text-[#1a1d1f] hover:underline ml-1">
                                Daftar
                            </a>
                        </p>
                    </div>
                @endif

            </div>
        </div>

    </div>
</x-guest-layout>
