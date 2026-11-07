<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Registrasi pengguna baru (default role: siswa) untuk aplikasi mobile.
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'school_name' => ['nullable', 'string', 'max:255'],
            'school_npsn' => ['nullable', 'string', 'max:50'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi data registrasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // 1. Simpan/hubungkan data sekolah jika ada
        $schoolId = null;
        if (!empty($validated['school_name']) && Schema::hasTable('schools')) {
            $school = School::findOrCreateByName($validated['school_name'], $validated['school_npsn'] ?? null);
            $schoolId = $school?->id;
        }

        // Tentukan username (jika kosong, buat otomatis dari email)
        $username = $validated['username'] ?? null;
        if (empty($username)) {
            $baseUser = Str::slug(explode('@', $validated['email'])[0], '_');
            $candidate = $baseUser;
            $counter = 1;
            while (User::where('username', $candidate)->exists()) {
                $candidate = $baseUser . $counter;
                $counter++;
            }
            $username = $candidate;
        }

        // 2. Buat akun pengguna baru
        $userData = [
            'name' => $validated['name'],
            'username' => $username,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'siswa', // Default role registrasi mobile
            'phone_number' => $validated['phone_number'] ?? null,
            'status' => 'active',
        ];

        if (Schema::hasColumn('users', 'school_id')) {
            $userData['school_id'] = $schoolId;
        }

        $user = User::create($userData);

        // 3. Catat aktivitas registrasi
        if (Schema::hasTable('activity_logs')) {
            ActivityLog::record(
                'REGISTER_MOBILE',
                "Pendaftaran akun mobile baru: {$user->name} (@{$user->username} / {$user->email})",
                $user
            );
        }

        // 4. Terbitkan token Sanctum
        $deviceName = $validated['device_name'] ?? 'flutter_mobile';
        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi akun berhasil.',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $user->loadMissing('school'),
            ],
        ], 201);
    }

    /**
     * Login pengguna & issue token Sanctum untuk aplikasi mobile (mendukung email atau username).
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'login' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter login atau kata sandi tidak valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $identifier = trim($request->input('login') ?? $request->input('email') ?? $request->input('username') ?? '');
        if (empty($identifier)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau username wajib diisi.',
            ], 422);
        }

        // Cari user berdasarkan email ATAU username (case-insensitive)
        $user = User::where(function ($q) use ($identifier) {
            $q->whereRaw('LOWER(email) = ?', [strtolower($identifier)]);
            if (Schema::hasColumn('users', 'username')) {
                $q->orWhereRaw('LOWER(username) = ?', [strtolower($identifier)]);
            }
        })->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kombinasi email/username dan kata sandi tidak cocok.',
            ], 401);
        }

        // Cek status keaktifan akun
        if (isset($user->status) && $user->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda saat ini dinonaktifkan atau dalam status peninjauan.',
            ], 403);
        }

        // Catat aktivitas login
        if (Schema::hasTable('activity_logs')) {
            ActivityLog::record(
                'LOGIN_MOBILE',
                "Pengguna login melalui aplikasi mobile: {$user->email} (@{$user->username})",
                $user
            );
        }

        // Terbitkan token Sanctum
        $deviceName = $request->input('device_name', 'flutter_mobile');
        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $user->loadMissing('school'),
            ],
        ]);
    }

    /**
     * Mendapatkan profil lengkap pengguna saat ini.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Data profil pengguna berhasil dimuat.',
            'data' => [
                'user' => $request->user()->loadMissing('school'),
            ],
        ]);
    }

    /**
     * Perbarui data profil pengguna (nama, username, nomor HP, sekolah).
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:50', 'alpha_dash', 'unique:users,username,' . $user->id],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'school_name' => ['nullable', 'string', 'max:255'],
            'school_npsn' => ['nullable', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi pembaruan profil gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $user->name = $validated['name'];
        if (array_key_exists('username', $validated)) {
            $user->username = $validated['username'];
        }
        if (array_key_exists('phone_number', $validated)) {
            $user->phone_number = $validated['phone_number'];
        }

        if (Schema::hasColumn('users', 'school_id')) {
            if (!empty($validated['school_name']) && Schema::hasTable('schools')) {
                $school = School::findOrCreateByName($validated['school_name'], $validated['school_npsn'] ?? null);
                $user->school_id = $school?->id;
            } elseif (array_key_exists('school_name', $validated) && empty($validated['school_name'])) {
                $user->school_id = null;
            }
        }

        $user->save();

        if (Schema::hasTable('activity_logs')) {
            ActivityLog::record(
                'UPDATE_PROFILE_MOBILE',
                "Pengguna memperbarui profil melalui aplikasi mobile: {$user->name} (@{$user->username})",
                $user
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data' => [
                'user' => $user->fresh()->loadMissing('school'),
            ],
        ]);
    }

    /**
     * Perbarui kata sandi akun pengguna.
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi ubah kata sandi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi saat ini tidak cocok.',
            ], 422);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        if (Schema::hasTable('activity_logs')) {
            ActivityLog::record(
                'UPDATE_PASSWORD_MOBILE',
                "Pengguna memperbarui kata sandi melalui aplikasi mobile: {$user->email}",
                $user
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Kata sandi berhasil diperbarui.',
        ]);
    }

    /**
     * Logout & hapus token akses saat ini.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            // Hapus token akses yang sedang digunakan saat ini
            $user->currentAccessToken()->delete();

            if (Schema::hasTable('activity_logs')) {
                ActivityLog::record(
                    'LOGOUT_MOBILE',
                    "Pengguna logout dari aplikasi mobile: {$user->email}",
                    $user
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil. Sesi token telah dihapus.',
        ]);
    }
}

