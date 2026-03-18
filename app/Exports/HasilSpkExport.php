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

    /**
     * Terima ID Guru dari Controller
     */
    public function __construct($guruId)
    {
        $this->guruId = $guruId;
    }

    /**
     * Ambil data siswa bimbingan guru yang bersangkutan
     */
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

    /**
     * Header Tabel di Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NISN',
            'Nilai Akademik',
            'Nilai Instansi',
            'Nilai Pembimbing',
            'Hasil Prediksi KNN',
            'Tanggal Analisis'
        ];
    }

    /**
     * Mapping data agar rapi di Excel
     */
    public function map($user): array
    {
        static $no = 1;

        return [
            $no++,
            $user->name,
            $user->siswa->nim ?? '-',
            $user->nilai_akademik ?? '0',
            $user->nilai_instansi ?? '0',
            optional($user->nilaiPkl)->nilai ?? '0',
            $user->hasil_prediksi ?? 'Belum Dianalisis',
            $user->updated_at->format('d/m/Y H:i')
        ];
    }

    /**
     * Styling: Bikin Header jadi Bold
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}