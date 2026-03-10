<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Bimbingan;
use App\Models\Guru;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil data guru. 
        // Kalau profil "hilang" karena database crash/corrupt, kita buatkan 
        // otomatis pakai data dari User biar sistem gak nge-hang (Force Close).
        $guru = $user->guru;

        if (!$guru) {
            $guru = Guru::create([
                'user_id'       => $user->id,
                'nama'          => $user->name,
                'nip'           => 'PENDING-' . $user->id, // Fallback biar tetep bisa masuk
                'program_studi' => 'Belum Diatur',
            ]);
        }

        // 2. LOGIK DASHBOARD 
        // Kita hitung data bimbingan. Pakai query yang lebih efisien.
        $totalSiswa = Bimbingan::where('guru_id', $guru->id)
            ->distinct('siswa_id')
            ->count('siswa_id');

        $bimbinganStatus = Bimbingan::where('guru_id', $guru->id)
            ->selectRaw("count(case when status = 'disetujui' then 1 end) as disetujui")
            ->selectRaw("count(case when status = 'pending' then 1 end) as pending")
            ->first();

        return view('guru.dashboard', [
            'guru'               => $guru,
            'totalSiswa'         => $totalSiswa,
            'bimbinganDisetujui' => $bimbinganStatus->disetujui ?? 0,
            'bimbinganPending'   => $bimbinganStatus->pending ?? 0,
        ]);
    }
}