<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class SiswaBimbinganController extends Controller
{
    public function index()
    {
        $guruId = Auth::user()->guru->id;

        $siswa = Siswa::with('user')
            ->whereHas('bimbingan', function($query) use ($guruId) {
                $query->where('guru_id', $guruId);
            })
            ->paginate(10);

        return view('guru.siswa.index', compact('siswa'));
    }
}