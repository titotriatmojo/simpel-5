<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPkl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Tampilkan daftar laporan PKL siswa (Filter Otomatis)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // 1. Query dasar dengan relasi
        $query = LaporanPkl::with(['siswa.user']);

        // 2. LOGIC FILTER: Pakai property role langsung dari tabel users
        if ($user->role === 'guru') {
            $query->whereHas('siswa', function ($q) use ($user) {
                // Gunakan ID user atau ID guru (sesuaikan kolom di tabel siswa lo)
                // Kalau di tabel siswa kolomnya 'pembimbing_id' isinya ID User, ini sudah benar:
                $q->where('pembimbing_id', $user->id); 
            });
        }

        // 3. Logic Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%$search%")
                       ->orWhere('nim', 'like', "%$search%");
                })
                ->orWhere('status', 'like', "%$search%");
            });
        }

        $laporan = $query->latest()->paginate(8)->appends($request->only('search'));

        return view('admin.laporan.index', compact('laporan'));
    }

    /**
     * Proses verifikasi laporan PKL
     */
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $laporan = LaporanPkl::findOrFail($id);
        $user = Auth::user();
        
        // Proteksi Guru: Cek kolom role langsung
        if ($user->role === 'guru' && $laporan->siswa->pembimbing_id !== $user->id) {
            return back()->with('error', 'Anda tidak memiliki akses ke laporan ini.');
        }

        $laporan->status = $request->status;
        $laporan->save();

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Proteksi Admin: Cek kolom role langsung
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Hanya Admin yang boleh menghapus laporan.');
        }

        $laporan = LaporanPkl::findOrFail($id);
        
        if ($laporan->file && Storage::disk('public')->exists($laporan->file)) {
            Storage::disk('public')->delete($laporan->file);
        }

        $laporan->delete();
        return back()->with('success', 'Laporan berhasil dihapus secara permanen.');
    }
}