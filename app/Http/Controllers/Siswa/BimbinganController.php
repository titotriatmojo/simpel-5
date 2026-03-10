<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $bimbingan = Bimbingan::where('siswa_id', $siswa->id)->with('guru')->latest()->get();
        return view('siswa.bimbingan.index', compact('bimbingan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'tanggal_bimbingan' => 'required|date',
            'catatan' => 'required|string'
        ]);

        Bimbingan::create([
            'siswa_id' => Auth::user()->siswa->id,
            'guru_id' => $request->guru_id,
            'tanggal_bimbingan' => $request->tanggal_bimbingan,
            'catatan' => $request->catatan,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Pengajuan bimbingan berhasil!');
    }
}