# Panduan Desain & Aturan UI Karsapedia

Dokumen ini berisi standar desain antarmuka (UI/UX) dan aturan penulisan konten untuk seluruh ekosistem **Karsapedia Backend & Web Portal**. Setiap pengembang atau asisten AI yang memodifikasi atau membuat halaman baru **wajib mematuhi dokumen ini tanpa kecuali**.

---

## 1. Aturan Anti-AI Slop (Ketat)

Untuk menjaga kredibilitas, profesionalisme, dan estetika sistem, aturan berikut bersifat mutlak:

1. **Zero Emoji**:
   - Dilarang keras menggunakan emoji di bagian mana pun dalam antarmuka (tidak boleh ada 👨‍🏫, 🎓, ⚙️, 🚀, dsb.).
   - Seluruh indikator visual hanya boleh menggunakan **ikon SVG monokrom/minimalis** (Heroicons atau Lucide format SVG).

2. **Dilarang Menambahkan Badge atau Persentase Artifisial**:
   - Dilarang membuat badge dekoratif yang tidak fungsional (misal: badge `3 Akun`, `33%`, atau panah tren finansial `↑ 100% Berstatus Aktif`).
   - Angka metrik harus berdiri sendiri secara tegas dan bersih tanpa embel-embel dekorasi buatan.

3. **Dilarang Menambahkan Marketing Checklist Generik**:
   - Dilarang menyisipkan daftar fitur generik bergaya brosur promosi (seperti: *"Keamanan Data Terjamin"*, *"Akses Terintegrasi Multi-Role"*, *"Sinkronisasi Cepat"*).
   - Antarmuka harus fokus langsung pada tujuan fungsional (formulir, data tabel, grafik riil).

4. **Standar Bahasa Formal & Baku**:
   - Gunakan bahasa Indonesia baku standar perangkat lunak.
   - Contoh padanan kata:
     - `Log in` &rarr; **Masuk**
     - `Register` &rarr; **Daftar**
     - `Save changes` &rarr; **Simpan Perubahan**
     - `Current password` &rarr; **Kata Sandi Saat Ini**
     - `New password` &rarr; **Kata Sandi Baru**
     - `Dashboard Monitoring` &rarr; **Dashboard**
     - `User Management` &rarr; **Manajemen Pengguna**
     - `Activity Logs` &rarr; **Log Aktivitas**

---

## 2. Design System & Bahasa Visual (Bento Elevated Minimalist)

### A. Palet Warna
- **Kanvas Latar Belakang**: `#f4f5f6` (abu-abu terang elevated).
- **Latar Belakang Card**: `#ffffff` (putih murni).
- **Warna Teks Utama**: `#1a1d1f` (hitam pekat bernuansa arang).
- **Warna Teks Sekunder/Muted**: `#64748b` (slate-500) atau `#94a3b8` (slate-400).
- **Garis Batas (Border)**: `border-slate-200/60` atau `border-slate-100`.
- **Warna Aksen Utama**: `#1a1d1f` (tombol utama hitam solid dengan hover `hover:bg-black`).
- **Aksen Status**:
  - Aktif / Sukses: Emerald (`bg-emerald-50 text-emerald-700 border-emerald-100`)
  - Bahaya / Hapus: Rose (`bg-rose-50 text-rose-700 border-rose-100`)
  - Info / Role Siswa: Sky (`bg-sky-50 text-sky-700`)
  - Peran Guru: Emerald (`bg-emerald-50 text-emerald-700`)
  - Peran Admin: Indigo (`bg-indigo-50 text-indigo-700`)

### B. Tipografi
- **Font Utama**: **Plus Jakarta Sans** (dengan fallback **Figtree**).
- **Aturan Ketebalan Font (Font Weight Limit)**:
  - **Maksimal ketebalan adalah `font-bold` (weight 700)** untuk judul dan angka metrik.
  - **Dilarang keras memakai `font-black` (weight 900)** atau **`font-extrabold` (weight 800)** karena membuat teks tampak terlalu tebal dan mengganggu kenyamanan membaca.
  - Untuk label dan tombol: gunakan `font-bold` (700) atau `font-semibold` (600).
  - Untuk isi paragraf dan teks bantuan: gunakan `font-normal` (400) atau `font-medium` (500).

### C. Sudut Membulat (Border Radius)
- **Kontainer Bento Card**: `rounded-[28px]` atau `rounded-[32px]`.
- **Field Input Form**: `rounded-2xl`.
- **Tombol Aksi Utama & Pill Navigasi**: `rounded-full` atau `rounded-2xl`.
- **Ikon Container / Avatar**: `rounded-full` atau `rounded-2xl`.

### D. Shadow & Elevasi
- Gunakan shadow halus: `shadow-2xs` (0 1px rgba(0, 0, 0, 0.05)) atau `shadow-xs`.
- Hindari shadow tebal / gelap (`shadow-xl` / `shadow-2xl`) yang membuat tampilan tampak kotor.

---

## 3. Standar Komponen UI

### A. Bento Card Kontainer
```html
<div class="bg-white rounded-[28px] p-7 sm:p-10 shadow-2xs border border-slate-200/60">
    <!-- Konten di sini -->
</div>
```

### B. Field Input Formulir
```html
<div class="space-y-1.5">
    <label for="nama_field" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
        Label Input
    </label>
    <input type="text"
           id="nama_field"
           name="nama_field"
           class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs">
</div>
```

### C. Tombol Aksi Utama (Black Pill)
```html
<button type="submit"
        class="px-6 py-2.5 rounded-full bg-[#1a1d1f] hover:bg-black text-white text-xs font-bold shadow-sm transition">
    Simpan Perubahan
</button>
```

### D. Tombol Navigasi / Kembali
```html
<a href="{{ route('admin.dashboard') }}"
   class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-slate-200/80 text-xs font-bold text-slate-700 hover:text-black shadow-2xs hover:bg-slate-50 transition">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    <span>Kembali</span>
</a>
```

### E. Alert Notifikasi Bersih
```html
@if (session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-between text-emerald-800 text-xs font-bold shadow-2xs">
        <div class="flex items-center gap-2.5">
            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif
```

---

## 4. Checklist Saat Membuat Halaman Baru

- [ ] Apakah halaman menggunakan background `#f4f5f6`?
- [ ] Apakah semua kontainer menggunakan Bento style `rounded-[28px]` dengan border tipis `border-slate-200/60`?
- [ ] Apakah font menggunakan **Plus Jakarta Sans** tanpa `font-black` atau `font-extrabold`?
- [ ] Apakah tidak ada satu pun emoji dalam kode maupun teks?
- [ ] Apakah tidak ada persentase dekoratif atau panah tren buatan?
- [ ] Apakah seluruh istilah menggunakan bahasa Indonesia formal?
- [ ] Apakah ada tombol "Kembali" yang jelas jika halaman merupakan submenu/halaman anak?

