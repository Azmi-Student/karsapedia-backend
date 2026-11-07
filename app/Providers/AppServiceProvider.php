<?php

namespace App\Providers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fallback guard 'sanctum' jika paket laravel/sanctum belum diunduh ke vendor
        if (!class_exists(\Laravel\Sanctum\Sanctum::class)) {
            Auth::viaRequest('sanctum', function (Request $request) {
                $token = $request->bearerToken();
                if (!$token) {
                    return null;
                }

                if (!Schema::hasTable('personal_access_tokens')) {
                    return null;
                }

                $hashedToken = hash('sha256', $token);
                $record = DB::table('personal_access_tokens')
                    ->where('token', $hashedToken)
                    ->first();

                if (!$record) {
                    return null;
                }

                if ($record->expires_at && Carbon::parse($record->expires_at)->isPast()) {
                    return null;
                }

                DB::table('personal_access_tokens')
                    ->where('id', $record->id)
                    ->update(['last_used_at' => now()]);

                $user = User::find($record->tokenable_id);
                if (!$user) {
                    return null;
                }

                return $user->withAccessToken($record);
            });
        }
    }
}
