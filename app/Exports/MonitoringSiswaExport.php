<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MonitoringSiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $guruId;

    public function __construct($guruId)
    {
        $this->guruId = $guruId;
    }

    public function collection()
    {
        return Siswa::whereHas('pendaftaranPkl', function ($q) {
                $q->where('guru_id', $this->guruId);
            })
            // Tambahkan 'laporanPkl' di sini biar datanya narik ke excel
            ->with(['pendaftaranPkl.perusahaan', 'laporanPkl']) 
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NISN/NIM',
            'Kelas',
            'Jurusan',
            'Instansi Tujuan',
            'Status Pendaftaran',
            'Link File Laporan', // Kolom Baru
            'Link Google Drive', // Kolom Baru
        ];
    }

    public function map($siswa): array
    {
        static $no = 1;
        
        // Bikin URL Full buat download file (pake url asset)
        $fileUrl = ($siswa->laporanPkl && $siswa->laporanPkl->file) 
            ? url('storage/' . $siswa->laporanPkl->file) 
            : 'Belum Upload';

        return [
            $no++,
            $siswa->nama,
            $siswa->nim,
            $siswa->kelas,
            $siswa->program_studi,
            $siswa->pendaftaranPkl->perusahaan->nama ?? 'Belum Ada',
            strtoupper($siswa->pendaftaranPkl->status ?? 'BELUM'),
            $fileUrl,
            $siswa->laporanPkl->link_drive ?? 'Tidak Ada Link',
        ];
    }
}