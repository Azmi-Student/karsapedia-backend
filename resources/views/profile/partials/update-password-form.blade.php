<section>
    <header class="mb-6">
        <h3 class="text-base sm:text-lg font-extrabold text-[#1a1d1f] tracking-tight">
            Perbarui Kata Sandi
        </h3>
        <p class="text-xs text-slate-400 mt-1">
            Pastikan akun Anda menggunakan kata sandi yang aman dan tidak digunakan di platform lain.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <!-- Kata Sandi Saat Ini -->
            <div class="space-y-2">
                <label for="update_password_current_password" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                    Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                </label>
                <input type="password"
                       id="update_password_current_password"
                       name="current_password"
                       autocomplete="current-password"
                       placeholder="Masukkan kata sandi lama"
                       class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @if($errors->updatePassword->has('current_password')) border-rose-500 @endif">
                @if($errors->updatePassword->has('current_password'))
                    <p class="text-[11px] text-rose-500 font-semibold mt-1">
                        {{ $errors->updatePassword->first('current_password') }}
                    </p>
                @endif
            </div>

            <!-- Kata Sandi Baru -->
            <div class="space-y-2">
                <label for="update_password_password" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                    Kata Sandi Baru <span class="text-rose-500">*</span>
                </label>
                <input type="password"
                       id="update_password_password"
                       name="password"
                       autocomplete="new-password"
                       placeholder="Minimal 8 karakter"
                       class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @if($errors->updatePassword->has('password')) border-rose-500 @endif">
                @if($errors->updatePassword->has('password'))
                    <p class="text-[11px] text-rose-500 font-semibold mt-1">
                        {{ $errors->updatePassword->first('password') }}
                    </p>
                @endif
            </div>

            <!-- Konfirmasi Kata Sandi Baru -->
            <div class="space-y-2">
                <label for="update_password_password_confirmation" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                    Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                </label>
                <input type="password"
                       id="update_password_password_confirmation"
                       name="password_confirmation"
                       autocomplete="new-password"
                       placeholder="Ulangi kata sandi baru"
                       class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @if($errors->updatePassword->has('password_confirmation')) border-rose-500 @endif">
                @if($errors->updatePassword->has('password_confirmation'))
                    <p class="text-[11px] text-rose-500 font-semibold mt-1">
                        {{ $errors->updatePassword->first('password_confirmation') }}
                    </p>
                @endif
            </div>

        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
            <button type="submit"
                    class="px-6 py-2.5 rounded-full bg-[#1a1d1f] hover:bg-black text-white text-xs font-bold shadow-sm transition">
                Perbarui Kata Sandi
            </button>
        </div>
    </form>
</section>
