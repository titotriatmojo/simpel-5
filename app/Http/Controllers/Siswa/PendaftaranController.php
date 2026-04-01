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
                'periode'       => 'required|string|max:100', // Udah bener di validasi
            ]);

            // Ambil ID Siswa, bukan ID User!
            $siswaId = Auth::user()->siswa->id;

            if (PendaftaranPkl::where('siswa_id', $siswaId)->exists()) {
                return redirect()->back()->with('error', 'Anda sudah memiliki pendaftaran yang aktif.');
            }

            PendaftaranPkl::create([
                'siswa_id'      => $siswaId, // Pake variabel yang bener
                'guru_id'       => $request->guru_id,
                'perusahaan_id' => $request->perusahaan_id,
                'bidang_pkl'    => $request->bidang_pkl,
                'periode'       => $request->periode, // <--- INI TADI YANG KETINGGALAN!
                'status'        => 'pending',
            ]);

            return redirect()->route('siswa.pendaftaran.index')->with('success', 'Pendaftaran PKL berhasil diajukan!');
        }

    public function update(Request $request, $id)
    {
        $pendaftaran = PendaftaranPkl::findOrFail($id);

        if ($pendaftaran->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

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

        // FIXED: Arahkan ke pendaftaran.index
        return redirect()->route('siswa.pendaftaran.index')->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendaftaran = PendaftaranPkl::findOrFail($id);
        
        if ($pendaftaran->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        if ($pendaftaran->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Pendaftaran yang sudah disetujui tidak bisa dihapus.');
        }

        $pendaftaran->delete();
        
        // FIXED: Arahkan ke pendaftaran.index
        return redirect()->route('siswa.pendaftaran.index')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}