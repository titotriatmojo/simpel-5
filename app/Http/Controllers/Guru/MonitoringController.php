<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\PendaftaranPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function index()
    {
        // 1. Ambil data Guru yang sedang login beserta relasi siswanya
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Profil Guru tidak ditemukan.');
        }

        $guruId = $guru->id;

        /**
         * 2. Ambil data siswa bimbingan.
         * Kita gunakan with() untuk menghindari N+1 query problem.
         * Kita filter siswa yang pendaftarannya dibimbing oleh guru ini.
         */
        $siswa = Siswa::whereHas('pendaftaranPkl', function ($query) use ($guruId) {
                $query->where('guru_id', $guruId);
            })
            ->with([
                'user', 
                'pendaftaranPkl.perusahaan' // Ambil data perusahaan sekaligus
            ])
            ->latest()
            ->get();

        /**
         * 3. Hitung statistik bimbingan dengan cara yang lebih bersih.
         * Menggunakan collection agar lebih fleksibel di View.
         */
        $pendaftaran = PendaftaranPkl::where('guru_id', $guruId)->get();
        
        $stats = [
            'total'    => $pendaftaran->count(),
            'menunggu' => $pendaftaran->where('status', 'menunggu')->count(),
            'diterima' => $pendaftaran->where('status', 'diterima')->count(),
            'ditolak'  => $pendaftaran->where('status', 'ditolak')->count(),
        ];

        return view('guru.monitoring.index', compact('siswa', 'stats'));
    }
}