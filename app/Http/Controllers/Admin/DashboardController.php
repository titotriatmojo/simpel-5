<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Perusahaan;
use App\Models\LaporanPkl;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            return $this->errorResponse($user->id ?? 'Unknown', 'Admin');
        }

        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalPerusahaan = Perusahaan::count();
        
        $totalLaporan = LaporanPkl::count();
        $laporanPending = LaporanPkl::where('status', 'pending')->count();
        $laporanDiterima = LaporanPkl::where('status', 'diterima')->count();
        $laporanDitolak = LaporanPkl::where('status', 'ditolak')->count();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalPerusahaan',
            'totalLaporan',
            'laporanPending',
            'laporanDiterima',
            'laporanDitolak'
        ));
    }

    private function errorResponse($userId, $role)
    {
        $logoutUrl = route('logout');
        $csrf = csrf_token();

        return "
        <div style='min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f3f4f6; font-family: sans-serif;'>
            <div style='background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); text-align: center; max-width: 400px; border: 1px solid #e5e7eb;'>
                <div style='background: #fee2e2; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;'>
                    <svg style='width: 32px; height: 32px; color: #ef4444;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'/></svg>
                </div>
                <h2 style='font-size: 1.25rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;'>Akses Terbatas!</h2>
                <p style='color: #4b5563; font-size: 0.875rem; margin-bottom: 1.5rem;'>
                    User ID <b>{$userId}</b> tidak memiliki otoritas sebagai {$role} atau sesi Anda bermasalah.
                </p>
                <form method='POST' action='{$logoutUrl}'>
                    <input type='hidden' name='_token' value='{$csrf}'>
                    <button type='submit' style='width: 100%; background: #111827; color: white; padding: 0.75rem; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;'>
                        Keluar & Login Ulang
                    </button>
                </form>
            </div>
        </div>";
    }
}