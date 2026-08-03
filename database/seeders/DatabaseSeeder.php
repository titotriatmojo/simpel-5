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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. BUAT 1 GURU
        $userGuru = User::create([
            'name' => 'Eman Suherman',
            'email' => 'eman@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        Guru::create([
            'user_id'       => $userGuru->id,
            'nama'          => $userGuru->name,
            'nip'           => '198109052025211040',
            'program_studi' => 'Desain Komunikasi Visual',
        ]);

        // 3. BUAT 1 SISWA
        $userSiswa = User::create([
            'name' => 'Abdul Azis',
            'email' => 'abdul.azis@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'user_id'       => $userSiswa->id,
            'nama'          => $userSiswa->name,
            'nim'           => '20240533',
            'program_studi' => 'Desain Komunikasi Visual',
            'kelas'         => '11 DKV 1',
            'semester'      => '3',
        ]);

        }
    }
