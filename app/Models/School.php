<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'npsn',
    ];

    /**
     * Relasi ke seluruh pengguna dari sekolah ini.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Helper untuk mencari atau membuat sekolah berdasarkan nama (otomatis trim & case-insensitive).
     */
    public static function findOrCreateByName(?string $name, ?string $npsn = null): ?self
    {
        $cleanName = trim($name ?? '');
        if (empty($cleanName)) {
            return null;
        }

        $cleanNpsn = $npsn ? trim($npsn) : null;

        $school = static::whereRaw('LOWER(name) = ?', [strtolower($cleanName)])->first();
        if ($school) {
            if ($cleanNpsn && empty($school->npsn)) {
                $school->update(['npsn' => $cleanNpsn]);
            }
            return $school;
        }

        return static::create([
            'name' => $cleanName,
            'npsn' => $cleanNpsn,
        ]);
    }
}

