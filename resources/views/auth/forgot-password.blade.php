<x-guest-layout>
    <div class="bg-white rounded-[28px] shadow-2xs border border-slate-200/60 overflow-hidden grid grid-cols-1 md:grid-cols-12">

        <!-- Sisi Kiri: Teks Formal Simpel (5 Cols) -->
        <div class="md:col-span-5 bg-slate-50 p-8 sm:p-10 border-b md:border-b-0 md:border-r border-slate-100 flex flex-col justify-between space-y-6">
            <div class="space-y-3">
                <h2 class="text-2xl font-bold text-[#1a1d1f] tracking-tight">
                    Reset Kata Sandi
                </h2>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Masukkan email Anda untuk menerima tautan penyetelan ulang kata sandi akun.
                </p>
            </div>

            <div class="pt-6 border-t border-slate-200/60 text-xs text-slate-400">
                Karsapedia
            </div>
        </div>

        <!-- Sisi Kanan: Formulir Pemulihan (7 Cols) -->
        <div class="md:col-span-7 bg-white p-8 sm:p-10 flex flex-col justify-center">
            <div class="space-y-5">

                <!-- Session Status -->
                @if (session('status'))
                    <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

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
                               autofocus
                               placeholder="nama@karsapedia.test"
                               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error('email') border-rose-500 @enderror">
                        @error('email')
                            <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-3 rounded-full bg-[#1a1d1f] hover:bg-black text-white text-xs font-bold shadow-sm transition">
                            Kirim Tautan Reset
                        </button>
                    </div>
                </form>

                <!-- Back to Login -->
                <div class="pt-3 border-t border-slate-100 text-center">
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-600 hover:text-black transition">
                        Kembali ke halaman masuk
                    </a>
                </div>

            </div>
        </div>

    </div>
</x-guest-layout>
