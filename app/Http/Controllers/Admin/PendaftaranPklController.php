<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPkl;
use Illuminate\Http\Request;

class PendaftaranPklController extends Controller
{
    /**
     * Menampilkan daftar pendaftaran dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $query = PendaftaranPkl::with(['siswa.user', 'perusahaan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($sq) use ($search) {
                    $sq->where('nama', 'like', "%$search%")
                       ->orWhere('nim', 'like', "%$search%")
                       ->orWhere('program_studi', 'like', "%$search%")
                       ->orWhere('kelas', 'like', "%$search%");
                })
                ->orWhereHas('perusahaan', function ($pq) use ($search) {
                    $pq->where('nama', 'like', "%$search%");
                })
                ->orWhere('bidang_pkl', 'like', "%$search%")
                ->orWhere('status', 'like', "%$search%");
            });
        }

        $pendaftaran = $query->latest()->paginate(8)->appends($request->only('search'));

        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }

    /**
     * Verifikasi status pendaftaran (Terima/Tolak).
     */
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $pendaftaran = PendaftaranPkl::findOrFail($id);
        $pendaftaran->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', "Pendaftaran siswa berhasil di-{$request->status}.");
    }

    /**
     * Menghapus data pendaftaran (Fitur Trash).
     */
    public function destroy($id)
    {
        $pendaftaran = PendaftaranPkl::findOrFail($id);
        
        // Simpan nama siswa buat pesan sukses (opsional biar keren)
        $namaSiswa = $pendaftaran->siswa->nama;
        
        $pendaftaran->delete();

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', "Data pendaftaran dari $namaSiswa berhasil dihapus.");
    }
}