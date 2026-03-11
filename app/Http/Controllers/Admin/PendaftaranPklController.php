<?php

namespace App\Http\Controllers\Admin; // 1. Namespace harus ADMIN

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPkl;
use App\Models\User;
use Illuminate\Http\Request;

class PendaftaranPklController extends Controller // 2. Nama class harus sesuai NAMA FILE
{
    /**
     * Menampilkan SEMUA pendaftaran PKL untuk Admin
     */
    public function index(Request $request)
    {
        // Admin bisa melihat semua, bukan cuma milik guru tertentu
        $query = PendaftaranPkl::with(['siswa', 'perusahaan', 'guru']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('nim', 'like', "%$search%");
            });
        }

        $pendaftaran = $query->latest()->paginate(10);

        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }

    /**
     * Verifikasi Pendaftaran oleh Admin
     */
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $pendaftaran = PendaftaranPkl::findOrFail($id);

        // Update status pendaftaran
        $pendaftaran->update([
            'status' => $request->status
        ]);

        // LOGIC SAKTI: Sinkronkan guru_id ke tabel User (untuk akses Dashboard & SPK)
        if ($request->status === 'diterima') {
            // Kita cari User berdasarkan siswa_id yang ada di tabel pendaftaran
            $userSiswa = User::find($pendaftaran->user_id ?? $pendaftaran->siswa_id);
            if ($userSiswa) {
                $userSiswa->update([
                    'guru_id' => $pendaftaran->guru_id
                ]);
            }
        }

        return redirect()->back()->with('success', "Pendaftaran siswa berhasil di-{$request->status}.");
    }

    /**
     * Hapus data pendaftaran jika diperlukan
     */
    public function destroy($id)
    {
        $pendaftaran = PendaftaranPkl::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->back()->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}