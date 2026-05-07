<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\PendaftaranPkl;
use App\Exports\MonitoringSiswaExport; 
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{

    public function index(Request $request)
    {
        $guru = Auth::user()->guru;

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Profil Guru tidak ditemukan.');
        }

        if ($request->query('export') === 'excel') {
            return $this->exportExcel();
        }

        $siswa = Siswa::whereHas('pendaftaranPkl', function ($query) use ($guru) {
                $query->where('guru_id', $guru->id);
            })
            ->with(['user', 'pendaftaranPkl.perusahaan', 'laporanPkl']) 
            ->latest()
            ->get();

        $stats = [
            'total'    => $siswa->count(),
            'menunggu' => $siswa->where('pendaftaranPkl.status', 'menunggu')->count(),
            'diterima' => $siswa->where('pendaftaranPkl.status', 'diterima')->count(),
            'ditolak'  => $siswa->where('pendaftaranPkl.status', 'ditolak')->count(),
        ];

        return view('guru.monitoring.index', compact('siswa', 'stats'));
    }

    public function exportExcel()
    {
        try {
            $guru = Auth::user()->guru;

            if (!$guru) {
                return back()->with('error', 'Gagal export! Profil tidak ditemukan.');
            }

            $fileName = 'Laporan_Monitoring_PKL_' . now()->format('Y-m-d_His') . '.xlsx';
            
            return Excel::download(new MonitoringSiswaExport($guru->id), $fileName);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat export data.');
        }
    }

    public function downloadLaporan($id)
    {
        $laporan = \App\Models\LaporanPkl::with('siswa')->findOrFail($id);

        $filePath = storage_path('app/public/' . $laporan->file);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File fisik tidak ditemukan!');
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION); 
        $namaSiswa = str_replace(' ', '_', $laporan->siswa->nama); 
        $fileNameCustom = "Laporan_PKL_" . $namaSiswa . "." . $extension;

        return response()->download($filePath, $fileNameCustom);
    }
}