<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\NilaiPkl;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    /**
     * Tampilkan daftar siswa bimbingan dan nilainya
     */
    public function index()
    {
        $guru = Auth::user()->guru;

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Profil Guru tidak ditemukan.');
        }

        $guruId = $guru->id;

        // Ambil siswa yang memiliki pendaftaran_pkl dengan guru_id ini
        $siswa = Siswa::whereHas('pendaftaranPkl', function ($query) use ($guruId) {
                $query->where('guru_id', $guruId);
            })
            ->with(['nilaiPkl' => function ($q) use ($guruId) {
                // Pastikan nilai yang diambil hanya yang diinput guru ini
                $q->where('guru_id', $guruId);
            }])
            ->get();

        return view('guru.nilai.index', compact('siswa'));
    }

    /**
     * Simpan nilai baru atau Update nilai (UpdateOrCreate)
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'nilai'    => 'required|numeric|min:0|max:100',
        ]);

        $guruId = Auth::user()->guru->id;

        // Logic sakti: Cari berdasarkan siswa_id & guru_id. 
        // Kalau ketemu di-UPDATE nilainya, kalau tidak ada di-INSERT baru.
        NilaiPkl::updateOrCreate(
            ['siswa_id' => $request->siswa_id, 'guru_id' => $guruId],
            ['nilai'    => $request->nilai]
        );

        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }

    /**
     * Update nilai via Route PUT (untuk fitur Edit)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $guruId = Auth::user()->guru->id;

        // Cari data nilai spesifik milik guru yang sedang login
        $nilai = NilaiPkl::where('id', $id)
                        ->where('guru_id', $guruId)
                        ->firstOrFail();

        $nilai->update(['nilai' => $request->nilai]);

        return redirect()->back()->with('success', 'Nilai berhasil diperbarui!');
    }

    /**
     * HAPUS NILAI (Fungsi Baru)
     */
    public function destroy($id)
    {
        $guruId = Auth::user()->guru->id;

        // Pastikan guru hanya bisa menghapus nilai yang dia input sendiri
        $nilai = NilaiPkl::where('id', $id)
                        ->where('guru_id', $guruId)
                        ->firstOrFail();

        $nilai->delete();

        return redirect()->back()->with('success', 'Nilai siswa berhasil dihapus.');
    }
}