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
            'nama'          => $row['nama'],
            'nilai_pkl'     => $row['nilai_pkl'],
            'nilai_sidang'  => $row['nilai_sidang'],
            'nilai_total'   => $row['nilai_total'],
            'label'         => ucfirst(strtolower(trim($row['label'])))
        ]);
        \Log::info($data);

    return $data;
    }
}