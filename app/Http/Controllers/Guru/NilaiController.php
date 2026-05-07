<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\NilaiPkl;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiPklExport; 

class NilaiController extends Controller
{

    public function index(Request $request)
    {
        $guru = Auth::user()->guru;

        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Profil Guru tidak ditemukan.');
        }

        $guruId = $guru->id;

        $query = Siswa::whereHas('pendaftaranPkl', function ($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            })
            ->with(['nilaiPkl' => function ($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        if ($request->query('export') === 'excel') {
            $fileName = 'Rekap_Nilai_Siswa_' . now()->format('d-m-Y') . '.xlsx';
            return Excel::download(new NilaiPklExport($guruId), $fileName);
        }

        $siswa = $query->get();

        return view('guru.nilai.index', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'nilai'    => 'required|numeric|min:0|max:100',
        ]);

        $guruId = Auth::user()->guru->id;

        NilaiPkl::updateOrCreate(
            ['siswa_id' => $request->siswa_id, 'guru_id' => $guruId],
            ['nilai'    => $request->nilai]
        );

        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $guruId = Auth::user()->guru->id;

        $nilai = NilaiPkl::where('id', $id)
                        ->where('guru_id', $guruId)
                        ->firstOrFail();

        $nilai->update(['nilai' => $request->nilai]);

        return redirect()->back()->with('success', 'Nilai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $guruId = Auth::user()->guru->id;

        $nilai = NilaiPkl::where('id', $id)
                        ->where('guru_id', $guruId)
                        ->firstOrFail();

        $nilai->delete();

        return redirect()->back()->with('success', 'Nilai siswa berhasil dihapus.');
    }
}