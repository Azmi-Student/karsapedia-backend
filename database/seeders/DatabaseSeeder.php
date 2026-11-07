<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $sampleSchool = null;
        if (\Illuminate\Support\Facades\Schema::hasTable('schools')) {
            $sampleSchool = \App\Models\School::findOrCreateByName('SMK Negeri 1 Surabaya');
        }

        // 1. Akun Admin Default
        User::firstOrCreate(
            ['email' => 'admin@karsapedia.com'],
            [
                'name' => 'Administrator Karsapedia',
                'username' => 'admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'phone_number' => '081234567890',
                'status' => 'active',
            ]
        );

        // 2. Akun Guru Default
        User::firstOrCreate(
            ['email' => 'guru@karsapedia.com'],
            [
                'name' => 'Guru Karsapedia',
                'username' => 'guru',
                'password' => bcrypt('password'),
                'role' => 'guru',
                'school_id' => $sampleSchool?->id,
                'phone_number' => '081234567891',
                'status' => 'active',
            ]
        );

        // 3. Akun Siswa Default
        User::firstOrCreate(
            ['email' => 'siswa@karsapedia.com'],
            [
                'name' => 'Siswa Karsapedia',
                'username' => 'siswa',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'school_id' => $sampleSchool?->id,
                'phone_number' => '081234567892',
                'status' => 'active',
            ]
        );
    }
}
