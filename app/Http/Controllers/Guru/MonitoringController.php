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
    public function index(Request $request) // <-- Tambahkan Request $request di sini
{
    $guru = Auth::user()->guru;

    if (!$guru) {
        return redirect()->route('dashboard')->with('error', 'Akses ditolak! Profil Guru tidak ditemukan.');
    }

    // --- TAMBAHKAN LOGIKA INI AGAR TOMBOL EXPORT JALAN ---
    if ($request->query('export') === 'excel') {
        return $this->exportExcel(); // Memanggil fungsi exportExcel yang sudah lo buat di bawah
    }
    // ----------------------------------------------------

    $siswa = Siswa::whereHas('pendaftaranPkl', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })
        ->with(['user', 'pendaftaranPkl.perusahaan'])
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
}