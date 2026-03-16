<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Bimbingan;
use App\Models\Guru;
use App\Models\Siswa; // Pastikan Model Siswa di-import

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil data guru (dengan fallback create otomatis)
        $guru = $user->guru;

        if (!$guru) {
            $guru = Guru::create([
                'user_id'       => $user->id,
                'nama'          => $user->name,
                'nip'           => 'PENDING-' . $user->id,
                'program_studi' => 'Belum Diatur',
            ]);
        }

        // 2. Ambil DATA SISWA (Inilah yang bikin error tadi karena sebelumnya tidak ada)
        // Kita ambil data siswa yang bimbingannya terhubung dengan guru ini
        $siswa = Siswa::whereHas('bimbingan', function($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->paginate(10); // Pakai paginate sesuai kebutuhan tampilan table

        // 3. Hitung ringkasan data
        $bimbinganStatus = Bimbingan::where('guru_id', $guru->id)
            ->selectRaw("count(case when status = 'disetujui' then 1 end) as disetujui")
            ->selectRaw("count(case when status = 'pending' then 1 end) as pending")
            ->first();

        // 4. Kirim ke view
        return view('guru.dashboard', [
            'guru'               => $guru,
            'siswa'              => $siswa, // Variabel ini WAJIB ada buat table
            'totalSiswa'         => $siswa->total(), // Ambil total langsung dari objek pagination
            'bimbinganDisetujui' => $bimbinganStatus->disetujui ?? 0,
            'bimbinganPending'   => $bimbinganStatus->pending ?? 0,
        ]);
    }
}