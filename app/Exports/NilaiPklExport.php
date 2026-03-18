<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiPklExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $guruId;

    public function __construct($guruId)
    {
        $this->guruId = $guruId;
    }

    /**
     * Ambil data siswa yang dibimbing oleh guru ini
     */
    public function collection()
    {
        return Siswa::whereHas('pendaftaranPkl', function ($q) {
                $q->where('guru_id', $this->guruId);
            })
            ->with(['nilaiPkl' => function ($q) {
                $q->where('guru_id', $this->guruId);
            }, 'pendaftaranPkl.perusahaan'])
            ->get();
    }

    /**
     * Header Tabel Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NISN',
            'Instansi PKL',
            'Nilai Akhir',
            'Status Penilaian',
            'Tanggal Update'
        ];
    }

    /**
     * Mapping data ke kolom Excel
     */
    public function map($siswa): array
    {
        static $no = 1;
        
        $nilai = $siswa->nilaiPkl ? $siswa->nilaiPkl->nilai : '0';
        $status = $siswa->nilaiPkl ? 'SUDAH DINILAI' : 'BELUM DINILAI';
        $tgl = $siswa->nilaiPkl ? $siswa->nilaiPkl->updated_at->format('d/m/Y H:i') : '-';

        return [
            $no++,
            $siswa->nama,
            $siswa->nim,
            $siswa->pendaftaranPkl->perusahaan->nama ?? '-',
            $nilai,
            $status,
            $tgl
        ];
    }

    /**
     * Styling Header biar cakep (Opsional)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Baris 1 jadi Bold
        ];
    }
}