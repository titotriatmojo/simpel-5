<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Bimbingan;
use App\Models\Guru;
use App\Models\Siswa; 

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $guru = $user->guru;

        if (!$guru) {
            $guru = Guru::create([
                'user_id'       => $user->id,
                'nama'          => $user->name,
                'nip'           => 'PENDING-' . $user->id,
                'program_studi' => 'Belum Diatur',
            ]);
        }


        $siswa = Siswa::whereHas('bimbingan', function($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->paginate(10); 

        $bimbinganStatus = Bimbingan::where('guru_id', $guru->id)
            ->selectRaw("count(case when status = 'disetujui' then 1 end) as disetujui")
            ->selectRaw("count(case when status = 'pending' then 1 end) as pending")
            ->first();

        return view('guru.dashboard', [
            'guru'               => $guru,
            'siswa'              => $siswa, 
            'totalSiswa'         => $siswa->total(),
            'bimbinganDisetujui' => $bimbinganStatus->disetujui ?? 0,
            'bimbinganPending'   => $bimbinganStatus->pending ?? 0,
        ]);
    }
}