<?php

namespace App\Imports;

use App\Models\DataTraining;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataTrainingImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1. Ambil nilai dan pastikan tipenya angka (float)
        $nilai_pkl = (float) ($row['nilai_pkl'] ?? 0);
        $nilai_sidang = (float) ($row['nilai_sidang'] ?? 0);

        // 2. Hitung total di sini (Bypass rumus Excel yang bermasalah)
        $nilai_total = ($nilai_pkl + $nilai_sidang) / 2;

        // 3. Simpan ke variabel dulu kalau mau di-Log
        $data = [
            'nama'         => $row['nama'],
            'nilai_pkl'    => $nilai_pkl,
            'nilai_sidang' => $nilai_sidang,
            'nilai_total'  => $nilai_total, // Pakai hasil hitungan Laravel
            'label'        => ucfirst(strtolower(trim($row['label'])))
        ];

        // 4. Log buat debugging (Opsional)
        // \Log::info('Importing Row:', $data);

        // 5. Baru return Model-nya
        return new DataTraining($data);
    }
}