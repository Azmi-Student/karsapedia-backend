<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'action', 'description', 'ip_address', 'user_agent'])]
class ActivityLog extends Model
{
    use HasFactory;

    /**
     * User yang berelasi dengan aktivitas
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper cepat untuk mencatat aktivitas
     */
    public static function record(string $action, string $description, User|int|null $user = null): self
    {
        $userId = $user instanceof User ? $user->id : ($user ?? auth()->id());

        return static::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
