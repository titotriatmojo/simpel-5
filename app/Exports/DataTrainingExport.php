<?php

namespace App\Exports;

use App\Models\DataTraining;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataTrainingExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DataTraining::all(['nama', 'nilai_akademik', 'nilai_instansi', 'nilai_pembimbing', 'label']);
    }

    public function headings(): array
    {
        return ['Nama', 'Nilai Akademik', 'Nilai Instansi', 'Nilai Pembimbing', 'Label'];
    }
}