<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT ADMIN (Tetap 1)
        User::create([
            'name' => 'Admin 1',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. BUAT 3 GURU
        for ($i = 1; $i <= 3; $i++) {
            $userGuru = User::create([
                'name' => 'Guru ' . $i,
                'email' => 'guru' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]);

            Guru::create([
                'user_id'       => $userGuru->id,
                'nama'          => $userGuru->name,
                'nip'           => '1980010' . $i,
                'program_studi' => 'Teknik Informatika',
            ]);
        }

        // 3. BUAT 3 SISWA
        for ($j = 1; $j <= 3; $j++) {
            $userSiswa = User::create([
                'name' => 'siswa ' . $j,
                'email' => 'siswa' . $j . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);

            Siswa::create([
                'user_id'       => $userSiswa->id,
                'nama'          => $userSiswa->name,
                'nim'           => '202400' . $j,
                'program_studi' => 'Teknik Informatika',
                'kelas'         => '12 RPL ' . $j,
                'semester'      => '6',
            ]);
        }
    }
}