<?php

namespace App\Exports;

use App\Models\DataTraining;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataTrainingExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DataTraining::all(['nama', 'nilai_pkl', 'nilai_sidang', 'nilai_total', 'label']);
    }

    public function headings(): array
    {
        return ['Nama', 'Nilai PKL', 'Nilai Sidang', 'Nilai Total', 'Label'];
    }
}