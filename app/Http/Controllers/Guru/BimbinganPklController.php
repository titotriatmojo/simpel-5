<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bimbingan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BimbinganPklController extends Controller
{
   
    public function index()
    {
      
        $guru = Auth::user()->guru;
        
        $today = Carbon::today();

        $endDate = $today->copy()->addDays(7);
        $terverifikasi = Bimbingan::with('siswa.user')
            ->where('guru_id', $guru->id)
            ->whereIn('status', ['disetujui'])
            ->whereBetween('tanggal_bimbingan', [$today, $endDate])
            ->orderBy('tanggal_bimbingan', 'asc')
            ->get();

        $pending = Bimbingan::with('siswa.user')
            ->where('guru_id', $guru->id)
            ->where('status', 'pending')
            ->orderBy('tanggal_bimbingan', 'asc')
            ->get();

        return view('guru.bimbingan.index', compact('terverifikasi', 'pending'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'required|string|max:1000',
        ]);

        $bimbingan = Bimbingan::findOrFail($id);
        $bimbingan->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Permintaan bimbingan berhasil diperbarui.');
    }
}