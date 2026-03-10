<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilan Dashboard dengan Proteksi Profil
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        // PROTEKSI: Tampilan Darurat jika Profil Siswa Tidak Ditemukan
        if (!$siswa) {
            return $this->errorResponse($user->id, 'Siswa');
        }

        return view('siswa.dashboard', compact('siswa'));
    }

    /**
     * Menampilkan daftar perusahaan yang sudah disetujui
     */
    public function perusahaan(Request $request)
    {
        $user = Auth::user();
        if (!$user->siswa) return $this->errorResponse($user->id, 'Siswa');

        $query = Perusahaan::where('status', 'approved')->withCount('pendaftaran');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('alamat', 'like', "%$search%")
                  ->orWhere('bidang_usaha', 'like', "%$search%");
            });
        }

        $perusahaan = $query->orderBy('nama', 'asc')
                            ->paginate(9)
                            ->appends($request->only('search'));
        
        return view('siswa.perusahaan.index', compact('perusahaan'));
    }

    public function showPerusahaan($id)
    {
        $user = Auth::user();
        if (!$user->siswa) return $this->errorResponse($user->id, 'Siswa');

        $perusahaan = Perusahaan::where('status', 'approved')
            ->withCount('pendaftaran')
            ->findOrFail($id);
        
        return view('siswa.perusahaan.show', compact('perusahaan'));
    }

    public function createPerusahaan()
    {
        $user = Auth::user();
        if (!$user->siswa) return $this->errorResponse($user->id, 'Siswa');

        return view('siswa.perusahaan.create'); 
    }

    public function storePerusahaan(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) return $this->errorResponse($user->id, 'Siswa');

        $validated = $request->validate([
            'nama'                => 'required|string|max:255',
            'bidang_usaha'        => 'required|string|max:255',
            'alamat'              => 'required|string',
            'no_hp'               => 'required|string|max:20',
            'pembimbing_lapangan' => 'required|string|max:255',
            'kuota'               => 'required|integer|min:1|max:50',
            'email'               => 'nullable|email|max:255',
            'koordinat_lokasi'    => 'nullable|string',
        ]);

        $validated['status']   = 'pending';
        $validated['siswa_id'] = $siswa->id; // Menggunakan ID yang sudah divalidasi

        Perusahaan::create($validated);

        return redirect()->route('siswa.perusahaan')
            ->with('success', 'Saran perusahaan berhasil dikirim! Mohon tunggu verifikasi admin.');
    }

    /**
     * Helper untuk menampilkan tampilan error & tombol logout
     */
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
                <h2 style='font-size: 1.25rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;'>Data {$role} Hilang!</h2>
                <p style='color: #4b5563; font-size: 0.875rem; margin-bottom: 1.5rem;'>
                    User ID <b>{$userId}</b> terdaftar sebagai {$role}, tapi detail profil Anda tidak ada di database.
                </p>
                <form method='POST' action='{$logoutUrl}'>
                    <input type='hidden' name='_token' value='{$csrf}'>
                    <button type='submit' style='width: 100%; background: #2563eb; color: white; padding: 0.75rem; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;'>
                        Keluar & Perbaiki Data
                    </button>
                </form>
            </div>
        </div>";
    }
}