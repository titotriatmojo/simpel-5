<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use App\Models\PendaftaranPkl;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $pendaftaran = PendaftaranPkl::where('siswa_id', $siswa->id)->first();
        
        $guru = Guru::all(); 
        $perusahaan = Perusahaan::all(); 

        return view('siswa.pendaftaran.index', compact('pendaftaran', 'perusahaan', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perusahaan_id' => 'required|exists:perusahaan,id',
            'guru_id'       => 'required|exists:guru,id', 
            'bidang_pkl'    => 'required|string|max:100',
            'periode'       => 'required|string|max:100',
        ]);

        $siswaId = Auth::user()->siswa->id;

        if (PendaftaranPkl::where('siswa_id', $siswaId)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah memiliki pendaftaran yang aktif.');
        }

        PendaftaranPkl::create([
            'siswa_id'      => $siswaId,
            'perusahaan_id' => $request->perusahaan_id,
            'guru_id'       => $request->guru_id,
            'bidang_pkl'    => $request->bidang_pkl,
            'periode'       => $request->periode,
            'status'        => 'menunggu',
        ]);

        return redirect()->route('siswa.pendaftaran')->with('success', 'Pendaftaran PKL berhasil diajukan!');
    }

    /**
     * UPDATE: Fungsi untuk mengubah pembimbing/perusahaan/bidang
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = PendaftaranPkl::findOrFail($id);

        // Keamanan 1: Pastikan ini milik siswa yang login
        if ($pendaftaran->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        // Keamanan 2: Cuma boleh edit kalau status masih 'menunggu'
        if ($pendaftaran->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Data tidak bisa diubah karena sudah diproses admin.');
        }

        $request->validate([
            'perusahaan_id' => 'required|exists:perusahaan,id',
            'guru_id'       => 'required|exists:guru,id',
            'bidang_pkl'    => 'required|string|max:100',
            'periode'       => 'required|string|max:100',
        ]);

        $pendaftaran->update([
            'perusahaan_id' => $request->perusahaan_id,
            'guru_id'       => $request->guru_id,
            'bidang_pkl'    => $request->bidang_pkl,
            'periode'       => $request->periode,
        ]);

        return redirect()->route('siswa.pendaftaran')->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendaftaran = PendaftaranPkl::findOrFail($id);
        
        if ($pendaftaran->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        // Opsional: Larang hapus kalau sudah disetujui
        if ($pendaftaran->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Pendaftaran yang sudah disetujui tidak bisa dihapus.');
        }

        $pendaftaran->delete();
        return redirect()->route('siswa.pendaftaran')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}