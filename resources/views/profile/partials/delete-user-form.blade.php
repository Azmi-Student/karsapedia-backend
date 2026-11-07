<section class="space-y-6">
    <header>
        <h3 class="text-base sm:text-lg font-extrabold text-rose-700 tracking-tight">
            Hapus Akun
        </h3>
        <p class="text-xs text-slate-400 mt-1">
            Setelah akun Anda dihapus, seluruh data dan akses Anda di platform Karsapedia akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
        </p>
    </header>

    <div>
        <button type="button"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="px-5 py-2.5 rounded-full bg-rose-50 text-rose-700 hover:bg-rose-100 hover:text-rose-800 border border-rose-200/80 text-xs font-bold transition shadow-2xs">
            Hapus Akun Saya
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-7 sm:p-9 space-y-6">
            @csrf
            @method('delete')

            <div class="space-y-2">
                <h3 class="text-lg font-extrabold text-[#1a1d1f] tracking-tight">
                    Apakah Anda yakin ingin menghapus akun?
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Setelah akun dihapus, seluruh data dan akses Anda akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun.
                </p>
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
                    Kata Sandi Konfirmasi
                </label>
                <input id="password"
                       name="password"
                       type="password"
                       placeholder="Masukkan kata sandi akun Anda"
                       class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 shadow-2xs @if($errors->userDeletion->has('password')) border-rose-500 @endif">
                @if($errors->userDeletion->has('password'))
                    <p class="text-[11px] text-rose-500 font-semibold mt-1">
                        {{ $errors->userDeletion->first('password') }}
                    </p>
                @endif
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="px-5 py-2.5 rounded-full text-xs font-bold text-slate-600 hover:text-slate-900 transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-6 py-2.5 rounded-full bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-sm transition">
                    Hapus Akun Secara Permanen
                </button>
            </div>
        </form>
    </x-modal>
</section>
