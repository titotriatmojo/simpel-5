<?php

namespace Database\Seeders;

use App\Models\DataTraining;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DataTrainingSeeder extends Seeder
{
    public function run(): void
    {
        // Set Faker ke Bahasa Indonesia
        $faker = Faker::create('id_ID');

        $datasets = [
            // [Akademik, Instansi, Pembimbing]
            // Kelompok SIAP (Nilai rata-rata > 75)
            [88, 90, 85], [82, 85, 80], [95, 92, 88], [78, 80, 82], [85, 85, 85],
            [90, 88, 90], [80, 78, 85], [86, 92, 84], [83, 80, 88], [92, 95, 90],
            
            // Kelompok TIDAK SIAP (Nilai rata-rata < 75)
            [70, 65, 60], [60, 70, 65], [55, 60, 50], [72, 68, 70], [65, 65, 65],
            [50, 55, 60], [45, 50, 55], [68, 72, 60], [58, 62, 65], [74, 70, 68],

            // Kelompok Campuran / Perbatasan (Test case buat KNN)
            [76, 75, 77], // Tipis di atas 75
            [74, 74, 73], // Tipis di bawah 75
        ];

        foreach ($datasets as $val) {
            // Logic penentuan label otomatis berdasarkan rata-rata
            $rataRata = array_sum($val) / 3;
            $label = ($rataRata >= 75) ? 'Siap' : 'Tidak Siap';

            DataTraining::create([
                'nama' => $faker->name(), // Nama Indonesia (Budi Santoso, Siti Aminah, dll)
                'nilai_akademik' => $val[0],
                'nilai_instansi' => $val[1],
                'nilai_pembimbing' => $val[2],
                'label' => $label,
            ]);
        }
    }
}