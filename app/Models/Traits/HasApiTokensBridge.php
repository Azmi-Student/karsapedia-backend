<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

if (trait_exists(\Laravel\Sanctum\HasApiTokens::class)) {
    trait HasApiTokensBridge
    {
        use \Laravel\Sanctum\HasApiTokens;
    }
} else {
    trait HasApiTokensBridge
    {
        protected $currentAccessTokenInstance = null;

        /**
         * Create a new personal access token for the user.
         */
        public function createToken(string $name, array $abilities = ['*'], ?\DateTimeInterface $expiresAt = null)
        {
            $plainTextToken = Str::random(40);
            $hashedToken = hash('sha256', $plainTextToken);

            $tokenId = null;
            if (Schema::hasTable('personal_access_tokens')) {
                $tokenId = DB::table('personal_access_tokens')->insertGetId([
                    'tokenable_type' => static::class,
                    'tokenable_id' => $this->getKey(),
                    'name' => $name,
                    'token' => $hashedToken,
                    'abilities' => json_encode($abilities),
                    'expires_at' => $expiresAt,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $tokenObj = new class($tokenId, $name, $hashedToken) {
                public ?int $id;
                public string $name;
                public string $token;

                public function __construct(?int $id, string $name, string $token)
                {
                    $this->id = $id;
                    $this->name = $name;
                    $this->token = $token;
                }

                public function delete(): bool
                {
                    if ($this->id && Schema::hasTable('personal_access_tokens')) {
                        return DB::table('personal_access_tokens')->where('id', $this->id)->delete() > 0;
                    }
                    return true;
                }
            };

            return new class($tokenObj, $plainTextToken) {
                public $accessToken;
                public string $plainTextToken;

                public function __construct($accessToken, string $plainTextToken)
                {
                    $this->accessToken = $accessToken;
                    $this->plainTextToken = $plainTextToken;
                }
            };
        }

        /**
         * Get the access token currently associated with the authentication.
         */
        public function currentAccessToken()
        {
            if (!$this->currentAccessTokenInstance) {
                return new class {
                    public function delete(): bool { return true; }
                };
            }
            return $this->currentAccessTokenInstance;
        }

        /**
         * Set the current access token for the user.
         */
        public function withAccessToken($accessToken)
        {
            if (is_object($accessToken) && !method_exists($accessToken, 'delete')) {
                $tokenId = $accessToken->id ?? null;
                $this->currentAccessTokenInstance = new class($tokenId) {
                    public ?int $id;
                    public function __construct(?int $id) { $this->id = $id; }
                    public function delete(): bool
                    {
                        if ($this->id && Schema::hasTable('personal_access_tokens')) {
                            return DB::table('personal_access_tokens')->where('id', $this->id)->delete() > 0;
                        }
                        return true;
                    }
                };
            } else {
                $this->currentAccessTokenInstance = $accessToken;
            }

            return $this;
        }
    }
}
