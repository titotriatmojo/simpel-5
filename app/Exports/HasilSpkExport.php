<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HasilSpkExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $guruId;

    public function __construct($guruId)
    {
        $this->guruId = $guruId;
    }

    public function collection()
    {
        return User::where('role', 'siswa')
            ->whereHas('siswa.pendaftaranPkl', function($q) {
                $q->where('guru_id', $this->guruId)
                  ->where('status', 'diterima');
            })
            ->with(['siswa', 'nilaiPkl'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NISN',
            'Nilai PKL',
            'Nilai Sidang',
            'Nilai Total',
            'Hasil Prediksi KNN',
            'Tanggal Analisis'
        ];
    }

    public function map($user): array
    {
        static $no = 1;

        return [
            $no++,
            $user->name,
            $user->siswa->nim ?? '-',
            $user->nilai_pkl ?? '0',
            $user->nilai_sidang ?? '0',
            optional($user->nilaiPkl)->nilai ?? '0',
            $user->hasil_prediksi ?? 'Belum Dianalisis',
            $user->updated_at->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}