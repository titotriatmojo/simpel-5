<?php

namespace App\Imports;

use App\Models\DataTraining;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataTrainingImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataTraining([
            'nama'             => $row['nama'],
            'nilai_akademik'   => $row['nilai_akademik'],
            'nilai_instansi'   => $row['nilai_instansi'],
            'nilai_pembimbing' => $row['nilai_pembimbing'],
            'label'            => $row['label'], // Harus 'Siap' atau 'Tidak Siap'
        ]);
    }
}