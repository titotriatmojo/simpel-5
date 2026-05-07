<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPkl;
use App\Models\User;
use Illuminate\Http\Request;

class PendaftaranPklController extends Controller 
{
    public function index(Request $request)
    {
        
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

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $pendaftaran = PendaftaranPkl::findOrFail($id);

        
        $pendaftaran->update([
            'status' => $request->status
        ]);

        
        if ($request->status === 'diterima') {
            $userSiswa = User::find($pendaftaran->user_id ?? $pendaftaran->siswa_id);
            if ($userSiswa) {
                $userSiswa->update([
                    'guru_id' => $pendaftaran->guru_id
                ]);
            }
        }

        return redirect()->back()->with('success', "Pendaftaran siswa berhasil di-{$request->status}.");
    }

    public function destroy($id)
    {
        $pendaftaran = PendaftaranPkl::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->back()->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}