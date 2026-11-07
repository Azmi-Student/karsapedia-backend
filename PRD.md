# Product Requirements Document (PRD)
## Karsapedia Backend — Authentication, RBAC & Core Infrastructure

* **Project**: Karsapedia Backend
* **Repository**: `karsapedia-backend`
* **Target Consumer**: Web Administration Dashboard & Flutter Mobile App (`karsapedia`)
* **Tech Stack**: Laravel 12.x / PHP 8.3+, PostgreSQL, Laravel Breeze, Laravel Sanctum, Alpine.js, Tailwind CSS
* **Design Framework**: Bento Elevated Minimalist (`DESIGN_GUIDELINES.md`)
* **Status**: In Active Development / Core Foundation Implemented

---

## 1. Ringkasan & Tujuan Proyek (Overview & Objectives)

**Karsapedia Backend** adalah platform backend utama berbasis framework Laravel 12 yang berfungsi sebagai penyedia layanan REST API untuk aplikasi mobile Flutter (**`karsapedia`**) sekaligus portal web manajemen bagi pengelola dan tenaga pendidik.

Fokus inti sistem mencakup:
1. **Autentikasi Ganda (Hybrid Auth)**:
   - **Web Session-based**: Menggunakan **Laravel Breeze** dengan proteksi CSRF dan session cookie aman untuk portal web.
   - **Token-based API**: Menggunakan **Laravel Sanctum** untuk menerbitkan Bearer Token bagi aplikasi mobile Flutter.
2. **Role-Based Access Control (RBAC)**:
   - Pengelolaan hak akses dengan 3 role hierarkis: **Admin**, **Guru**, dan **Siswa**.
3. **Master Data & Integrasi Asal Sekolah**:
   - Skema basis data terdedikasi untuk data sekolah dengan integrasi *live search* ke **Pusat Data Pendidikan API** (`https://api-pendidikan.vercel.app`) dan mekanisme *on-demand caching*.
4. **Audit Trail & Activity Logging**:
   - Pencatatan jejak aktivitas kritis pengguna (login, pembaruan data, manipulasi akun) ke dalam basis data.
5. **Standar Desain Anti-AI Slop**:
   - Penerapan antarmuka Bento Elevated Minimalist, bahasa formal Indonesia, tipografi tegas (*maximum weight 700*), dan *zero emoji* di seluruh tampilan.

---

## 2. Definisi Role & Hak Akses (User Roles & Permissions)

> [!NOTE]
> Struktur role terdiri dari 3 role tetap (*fixed*): `admin`, `guru`, dan `siswa`.

| Role | Deskripsi | Platform Akses Utama | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| **Admin** | Administrator sistem dengan kewenangan penuh atas data pengguna dan konfigurasi aplikasi. | Web Dashboard | - Manajemen Akun Pengguna (CRUD Siswa, Guru, Admin)<br>- Pengaturan status keaktifan akun (`active`, `inactive`, `pending`)<br>- Monitoring log aktivitas sistem (`activity_logs`)<br>- Pengelolaan master data sekolah |
| **Guru** | Tenaga pendidik yang membimbing siswa dan mengelola referensi ajar. | Web Dashboard & Mobile App | - Pengelolaan materi dan referensi kurikulum<br>- Review dan kurasi karya siswa binaan<br>- Pemberian penilaian dan apresiasi portofolio |
| **Siswa** | Pelajar atau pembelajar mandiri yang mempublikasikan karya dan mengeksplorasi materi. | Mobile App (Flutter) | - Eksplorasi ensiklopedia karya dan materi edukasi<br>- Unggah dan kelola portofolio karya mandiri<br>- Interaksi dengan materi tugas/bimbingan dari guru |

---

## 3. Arsitektur Sistem & Autentikasi

```
+-----------------------------------------------------------------------------------+
|                              Karsapedia Architecture                              |
+-----------------------------------------------------------------------------------+
             |                                                       |
     (Web Browser)                                            (Flutter Mobile)
      Admin / Guru                                              Siswa / Guru
             |                                                       |
       Session Cookie                                           Bearer Token
    (Laravel Breeze Web)                                   (Laravel Sanctum API)
             |                                                       |
             +---------------------------+---------------------------+
                                         |
                            [ HTTP Router & Middleware ]
                                         |
             +---------------------------+---------------------------+
             |                           |                           |
       Role: Admin                  Role: Guru                  Role: Siswa
             |                           |                           |
   [ Web Admin Console ]       [ Educator Portal ]       [ Flutter API Consumer ]
             |                           |                           |
             +---------------------------+---------------------------+
                                         |
                       [ PostgreSQL Database & Models ]
                     (users, schools, activity_logs, ...)
                                         |
                 [ External: Pusat Data Pendidikan API ]
```

### 3.1 Web Authentication (Session-based)
- Menggunakan session cookie terenkripsi dengan proteksi CSRF.
- Dilengkapi halaman autentikasi responsif dengan layout 2-kolom Bento:
  - Masuk Akun (`/login`)
  - Pendaftaran Akun (`/register`)
  - Lupa Kata Sandi (`/forgot-password`)
  - Reset Kata Sandi (`/reset-password`)
- Middleware proteksi: `auth` dan `role:admin`.

### 3.2 Mobile API Authentication (Token-based)
- Menggunakan **Laravel Sanctum** (`personal_access_tokens`).
- Flutter mengirim kredensial login dan menerima access token unik.
- Token disimpan pada secure storage perangkat (`flutter_secure_storage`) dan disertakan pada header `Authorization: Bearer <token>`.

---

## 4. Desain Skema Basis Data (Database Schema - PostgreSQL)

### 4.1 Tabel `schools`
Tabel master data untuk menyimpan data sekolah hasil sinkronisasi atau input mandiri:

| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | `BIGINT (PK)` | Primary Key, Auto Increment |
| `name` | `VARCHAR(255)` | Unik. Format standar: `"Nama Sekolah, Kab/Kota, Provinsi"` |
| `npsn` | `VARCHAR(50)` | Nullable, Indexed. Nomor Pokok Sekolah Nasional |
| `created_at` | `TIMESTAMP` | Waktu data dibuat |
| `updated_at` | `TIMESTAMP` | Waktu data diperbarui |

### 4.2 Tabel `users`
Tabel pengguna utama yang menampung seluruh kredensial dan relasi role:

| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | `BIGINT (PK)` | Primary Key, Auto Increment |
| `name` | `VARCHAR(255)` | Nama lengkap pengguna |
| `username` | `VARCHAR(50)` | Nullable, Unique. Username unik pengguna |
| `email` | `VARCHAR(255)` | Email unik untuk autentikasi |
| `email_verified_at` | `TIMESTAMP` | Nullable, waktu verifikasi email |
| `password` | `VARCHAR(255)` | Hash kata sandi (Bcrypt) |
| `role` | `ENUM('admin', 'guru', 'siswa')` | Role hak akses (Default: `siswa`) |
| `school_id` | `BIGINT (FK)` | Nullable, Foreign Key $\rightarrow$ `schools.id` (`onDelete: set null`) |
| `phone_number` | `VARCHAR(20)` | Nullable, nomor kontak pengguna |
| `avatar` | `VARCHAR(255)` | Nullable, URL atau berkas foto profil |
| `status` | `ENUM('active', 'inactive', 'pending')` | Status akun (Default: `active`) |
| `remember_token` | `VARCHAR(100)` | Token sesi ingat saya |
| `created_at` | `TIMESTAMP` | Waktu akun dibuat |
| `updated_at` | `TIMESTAMP` | Waktu akun diperbarui |

### 4.3 Tabel `activity_logs`
Tabel audit trail pencatatan aktivitas pengguna dan administrator:

| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | `BIGINT (PK)` | Primary Key, Auto Increment |
| `user_id` | `BIGINT (FK)` | Foreign Key $\rightarrow$ `users.id` (`onDelete: cascade`) |
| `action` | `VARCHAR(50)` | Kode aksi (misal: `LOGIN`, `UPDATE_USER`, `DELETE_USER`) |
| `description` | `TEXT` | Rincian deskripsi tindakan yang dilakukan |
| `ip_address` | `VARCHAR(45)` | Nullable, alamat IP pelaku |
| `user_agent` | `TEXT` | Nullable, informasi browser / client |
| `created_at` | `TIMESTAMP` | Waktu log dicatat |
| `updated_at` | `TIMESTAMP` | Waktu log diperbarui |

---

## 5. Integrasi Eksternal: Pusat Data Pendidikan API

Sistem terintegrasi langsung dengan API data referensi pendidikan Indonesia (`https://api-pendidikan.vercel.app`):

### 5.1 Spesifikasi Endpoint Eksternal
* **Target URL**: `https://api-pendidikan.vercel.app/api/sekolah`
* **Metode**: `GET`
* **Query Parameter**:
  - `q` : Kata kunci pencarian nama sekolah atau wilayah (contoh: `telesandi`, `lohbener`, `surabaya`).
  - `limit` : Jumlah data maksimal per permintaan (default sistem: `15`).
* **Format Response**:
  ```json
  {
    "status": true,
    "data": [
      {
        "nama": "SMKS TELEKOMUNIKASI TELESANDI",
        "npsn": "20253675",
        "bentuk_pendidikan": "SMK",
        "status_sekolah": "SWASTA",
        "kabupaten": "Kab. Bekasi",
        "provinsi": "Prov. Jawa Barat"
      }
    ]
  }
  ```

### 5.2 Standarisasi Penamaan (*Data Normalization*)
Hasil pencarian distandarisasi ke dalam format gabungan:
$$\textbf{Format:} \quad \text{"\{nama sekolah\}, \{kab/kota\}, \{provinsi\}"}$$
*Contoh:* `"SMKS TELEKOMUNIKASI TELESANDI, Kab. Bekasi, Prov. Jawa Barat"`

### 5.3 Mekanisme *On-Demand Caching*
1. Pengguna mengetik nama sekolah pada komponen autocomplete (jeda *debounce* 300ms).
2. Sistem mencari ke database lokal PostgreSQL secara *case-insensitive* (`ILIKE`).
3. Sistem secara simultan memanggil Pusat Data Pendidikan API melalui proxy backend `/api/schools?search=...`.
4. Ketika formulir disimpan (registrasi/admin/profil), method `School::findOrCreateByName($name, $npsn)` secara otomatis menyimpan data sekolah tersebut ke tabel `schools` lokal jika belum pernah terdaftar sebelumnya.

---

## 6. Spesifikasi REST API Backend

### 6.1 Format Standar Respon JSON

**Respon Sukses:**
```json
{
  "success": true,
  "message": "Operasi berhasil dilakukan",
  "data": { ... }
}
```

**Respon Gagal / Validasi:**
```json
{
  "success": false,
  "message": "Data yang dikirim tidak valid",
  "errors": {
    "email": ["Email sudah digunakan."]
  }
}
```

### 6.2 Endpoint Publik & Layanan Internal

| Metode | Endpoint | Middleware | Deskripsi |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/schools` | `web / api` | Pencarian sekolah (hybrid lokal + API Pendidikan) dengan query `?search=...` |
| `GET` | `/api/user` | `auth:sanctum` | Mendapatkan data user saat ini beserta relasi `school` |

### 6.3 Endpoint Mobile Client (`/api/v1/auth`)

| Metode | Endpoint | Middleware | Deskripsi |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/v1/auth/register` | `guest` | Registrasi siswa baru (dengan input `name`, `username`, `email`, `school_name`) |
| `POST` | `/api/v1/auth/login` | `guest` | Login pengguna mobile (email atau username) & penerbitan Bearer Token Sanctum |
| `POST` | `/api/v1/auth/logout` | `auth:sanctum` | Pencabutan token sesi saat ini (*revoke token*) |
| `GET` | `/api/v1/auth/me` | `auth:sanctum` | Data profil akun, role, dan relasi sekolah |
| `PUT` | `/api/v1/auth/profile` | `auth:sanctum` | Pembaruan profil nama, telepon, dan asal sekolah |
| `POST` | `/api/v1/auth/forgot-password` | `guest` | Pengiriman instruksi pemulihan kata sandi |
| `POST` | `/api/v1/auth/reset-password` | `guest` | Reset kata sandi dengan token |

---

## 7. Desain Sistem & Panduan UI/UX (Design Guidelines)

Mengacu ketat pada `DESIGN_GUIDELINES.md`:
* **Tema Visual**: Bento Elevated Minimalist.
* **Palet Warna**:
  - Background Canvas: `#f4f5f6`
  - Kontainer & Card: `#ffffff` dengan border halus `border-slate-200/60` dan bayangan lembut `shadow-2xs`
  - Teks Utama: `#1a1d1f`
  - Teks Sekunder: `#64748b` (Slate 500)
* **Tipografi**:
  - Font Family: Plus Jakarta Sans / Figtree
  - Batasan Font Weight: Maksimal `font-bold` (700). Mutlak dilarang menggunakan `font-black` (900) atau `font-extrabold` (800).
* **Anti-AI Slop**:
  - Mutlak bebas dari emoji di seluruh antarmuka dan salinan teks.
  - Bebas dari metrik palsu (tren persentase buatan seperti `+33%`, `↑ 100%`).
  - Bahasa formal, lugas, dan baku dalam Bahasa Indonesia.

---

## 8. Status Implementasi & Roadmap Proyek

* [x] **Fase 1: Fondasi Framework & Autentikasi Web**
  * [x] Instalasi Laravel 12 & Laravel Breeze
  * [x] Instalasi dan konfigurasi Laravel Sanctum API
  * [x] Redesain Landing Page (`welcome.blade.php`) Bento Minimalist
  * [x] Redesain Halaman Guest & Auth (`login`, `register`, `forgot-password`, `reset-password`)
* [x] **Fase 2: Skema Basis Data & Role-Based Access Control**
  * [x] Konfigurasi basis data PostgreSQL di Laragon
  * [x] Skema migrasi tabel `schools`, `users`, dan `activity_logs`
  * [x] Database Seeder untuk Admin, Guru, dan Siswa terkait sekolah default
  * [x] Middleware verifikasi role (`EnsureUserHasRole`)
* [x] **Fase 3: Integrasi Data Sekolah & Autocomplete Komponen**
  * [x] Endpoint proxy hybrid `/api/schools?search=...`
  * [x] Integrasi Pusat Data Pendidikan API (`https://api-pendidikan.vercel.app/api/sekolah?q=...`)
  * [x] Komponen Blade Autocomplete (`school-autocomplete.blade.php`) berbasis Alpine.js
  * [x] Format standar nama sekolah: `"nama sekolah, kab/kota, provinsi"`
  * [x] On-demand caching ke tabel lokal `schools`
* [x] **Fase 4: Panel Manajemen Web Admin**
  * [x] Layout Dashboard Admin Bento dengan sidebar navigasi
  * [x] CRUD Manajemen Pengguna (`admin.users.index`, `create`, `edit`)
  * [x] Fitur filter role, filter status keaktifan, dan pencarian pengguna *case-insensitive*
  * [x] Pencatatan aktivitas pengguna (`ActivityLog`) pada aksi mutasi akun
  * [x] Halaman Edit Profil Akun terintegrasi sekolah
* [ ] **Fase 5: Standarisasi Endpoint API Mobile (`/api/v1/auth/*`)**
  * [ ] Pembuatan `Api/V1/AuthController` khusus client mobile
  * [ ] Pembuatan `UserResource` dan `SchoolResource`
  * [ ] Testing otentikasi Sanctum (login, register, me, profile update)
* [ ] **Fase 6: Pengujian Integrasi Flutter (`karsapedia`)**
  * [ ] Pembuatan dokumentasi koleksi Postman / HTTP client
  * [ ] Pengujian aliran login dan token persistence pada emulator Android
