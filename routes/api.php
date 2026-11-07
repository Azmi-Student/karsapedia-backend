<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Mobile Client API Endpoints (v1)
|--------------------------------------------------------------------------
*/
Route::prefix('v1/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::put('/password', [AuthController::class, 'updatePassword']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::get('/user', function (Request $request) {
    return $request->user()->loadMissing('school');
})->middleware('auth:sanctum');

Route::get('/schools', function (Request $request) {
    if (!Schema::hasTable('schools')) {
        return response()->json(['data' => []]);
    }

    $rawSearch = trim($request->input('search', ''));
    $normalizedSearch = strtolower($rawSearch);

    // 1. Jika query kosong atau kurang dari 3 karakter: kembalikan 10 sekolah default dari cache 24 jam
    if (mb_strlen($rawSearch) < 3) {
        $defaultSchools = Cache::remember('schools_default_list', 86400, function () {
            return School::orderBy('name')->limit(10)->get(['id', 'name', 'npsn'])->map(function ($s) {
                $parts = explode(', ', $s->name, 2);
                return [
                    'id' => $s->id,
                    'name' => $s->name,
                    'school_name' => $parts[0] ?? $s->name,
                    'location' => $parts[1] ?? null,
                    'npsn' => $s->npsn,
                ];
            });
        });

        return response()->json(['data' => $defaultSchools]);
    }

    // 2. Cache hasil pencarian 24 jam berdasarkan md5 dari query yang dinormalisasi
    $cacheKey = 'schools_search_' . md5($normalizedSearch);

    $results = Cache::remember($cacheKey, 86400, function () use ($rawSearch, $normalizedSearch) {
        // A. Ambil dari database lokal (sangat cepat ~1-2ms)
        $localSchools = School::whereRaw('LOWER(name) LIKE ?', ['%' . $normalizedSearch . '%'])
            ->orWhere('npsn', 'like', "%{$rawSearch}%")
            ->orderBy('name')
            ->limit(15)
            ->get(['id', 'name', 'npsn'])
            ->map(function ($s) {
                $parts = explode(', ', $s->name, 2);
                return [
                    'id' => $s->id,
                    'name' => $s->name,
                    'school_name' => $parts[0] ?? $s->name,
                    'location' => $parts[1] ?? null,
                    'npsn' => $s->npsn,
                ];
            });

        $collected = collect($localSchools);

        // B. Jika hasil lokal sudah mencukupi (>= 8 hasil), hemat beban dan tidak perlu memanggil API luar
        if ($collected->count() >= 8) {
            return $collected->take(15)->values()->toArray();
        }

        // C. Jika hasil lokal sedikit, panggil API Kemendikbud secara hemat dengan timeout singkat
        $baseUrl = rtrim(config('services.pendidikan.url', 'https://api-pendidikan.vercel.app'), '/');
        try {
            $response = Http::withoutVerifying()
                ->timeout(4)
                ->get("{$baseUrl}/api/sekolah", [
                    'q' => $rawSearch,
                    'limit' => 10,
                ]);

            if ($response->successful()) {
                $apiData = $response->json('data') ?? [];
                if (is_array($apiData)) {
                    foreach ($apiData as $item) {
                        $schoolOnly = trim($item['nama'] ?? $item['sekolah'] ?? $item['nama_sekolah'] ?? '');
                        if (empty($schoolOnly)) continue;

                        $kabupaten = trim($item['kabupaten'] ?? $item['kab_kota'] ?? $item['kota'] ?? '');
                        $provinsi = trim($item['provinsi'] ?? '');
                        $parts = array_filter([$schoolOnly, $kabupaten, $provinsi]);
                        $formattedFullName = implode(', ', $parts);
                        $locationParts = array_filter([$kabupaten, $provinsi]);
                        $locationStr = !empty($locationParts) ? implode(', ', $locationParts) : null;
                        $npsn = !empty($item['npsn']) ? trim((string)$item['npsn']) : null;

                        // Cek apakah sudah ada di hasil
                        $alreadyExists = $collected->contains(function ($existing) use ($formattedFullName, $schoolOnly) {
                            $exName = is_array($existing) ? $existing['name'] : $existing->name;
                            $exSchool = is_array($existing) ? $existing['school_name'] : $existing->school_name;
                            return strcasecmp($exName, $formattedFullName) === 0 || strcasecmp($exSchool, $schoolOnly) === 0;
                        });

                        if (!$alreadyExists) {
                            // Simpan otomatis ke database lokal agar pencarian berikutnya tidak perlu memanggil API luar lagi
                            $newLocal = School::findOrCreateByName($formattedFullName, $npsn);

                            $collected->push([
                                'id' => $newLocal?->id,
                                'name' => $formattedFullName,
                                'school_name' => $schoolOnly,
                                'location' => $locationStr,
                                'npsn' => $npsn,
                            ]);
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning('API Pendidikan Fetch Warning: ' . $e->getMessage());
        }

        return $collected->take(15)->values()->toArray();
    });

    return response()->json([
        'data' => $results,
    ]);
})->middleware('throttle:60,1');
