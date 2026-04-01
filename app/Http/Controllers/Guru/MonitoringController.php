<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\PendaftaranPkl;
use App\Exports\MonitoringSiswaExport; // Import class export nanti
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    /**
     * Menampilkan halaman monitoring utama
     */
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Profil Guru tidak ditemukan.');
        }

        if ($request->query('export') === 'excel') {
            return $this->exportExcel();
        }

        // --- REVISI QUERY DI SINI ---
        $siswa = Siswa::whereHas('pendaftaranPkl', function ($query) use ($guru) {
                $query->where('guru_id', $guru->id);
            })
            // Tambahkan 'laporanPkl' di dalam with agar datanya narik ke Blade
            ->with(['user', 'pendaftaranPkl.perusahaan', 'laporanPkl']) 
            ->latest()
            ->get();

        // Stats juga perlu dipastikan path-nya bener
        $stats = [
            'total'    => $siswa->count(),
            'menunggu' => $siswa->where('pendaftaranPkl.status', 'menunggu')->count(),
            'diterima' => $siswa->where('pendaftaranPkl.status', 'diterima')->count(),
            'ditolak'  => $siswa->where('pendaftaranPkl.status', 'ditolak')->count(),
        ];

        return view('guru.monitoring.index', compact('siswa', 'stats'));
    }

    /**
     * Fungsi Export Excel
     */
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
        // Ambil data laporan beserta data siswanya (biar dapet namanya)
        $laporan = \App\Models\LaporanPkl::with('siswa')->findOrFail($id);

        $filePath = storage_path('app/public/' . $laporan->file);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File fisik tidak ditemukan!');
        }

        // --- REVISI DI SINI ---
        // Kita susun nama file yang rapi
        $extension = pathinfo($filePath, PATHINFO_EXTENSION); // Ambil ekstensi asli (.pdf/.docx)
        $namaSiswa = str_replace(' ', '_', $laporan->siswa->nama); // Spasi ganti underscore
        $fileNameCustom = "Laporan_PKL_" . $namaSiswa . "." . $extension;

        // Masukin $fileNameCustom sebagai parameter kedua
        return response()->download($filePath, $fileNameCustom);
    }
}