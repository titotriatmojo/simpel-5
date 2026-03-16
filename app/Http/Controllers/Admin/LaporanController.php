<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPkl;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Tampilkan daftar laporan PKL siswa.
     */
    public function index(Request $request)
    {
        $query = LaporanPkl::with(['siswa.user']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%$search%")
                        ->orWhere('nim', 'like', "%$search%")
                    ;
                })
                    ->orWhere('status', 'like', "%$search%")
                ;
            });
        }
        $laporan = $query->latest()->paginate(8)->appends($request->only('search'));

        return view('admin.laporan.index', compact('laporan'));
    }

    /**
     * Proses verifikasi laporan PKL.
     */
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $laporan = LaporanPkl::findOrFail($id);
        $laporan->status = $request->status;
        $laporan->save();

        return redirect()->route('admin.laporan.verifikasi')->with('success', 'Laporan berhasil diverifikasi.');
    }
    public function destroy($id)
{
    $laporan = LaporanPkl::findOrFail($id);
    
    // Hapus file fisik jika ada
    if ($laporan->file && Storage::disk('public')->exists($laporan->file)) {
        Storage::disk('public')->delete($laporan->file);
    }

    $laporan->delete();

    return back()->with('success', 'Laporan berhasil dihapus secara permanen.');
}
    
}