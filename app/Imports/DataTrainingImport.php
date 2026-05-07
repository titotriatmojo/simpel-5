<?php

namespace App\Imports;

use App\Models\DataTraining;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataTrainingImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $nilai_pkl = (float) ($row['nilai_pkl'] ?? 0);
        $nilai_sidang = (float) ($row['nilai_sidang'] ?? 0);

        $nilai_total = ($nilai_pkl + $nilai_sidang) / 2;

        $data = [
            'nama'         => $row['nama'],
            'nilai_pkl'    => $nilai_pkl,
            'nilai_sidang' => $nilai_sidang,
            'nilai_total'  => $nilai_total, 
            'label'        => ucfirst(strtolower(trim($row['label'])))
        ];

        return new DataTraining($data);
    }
}