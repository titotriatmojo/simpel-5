<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index()
    {
        /**
         * Menggunakan withCount('siswas') agar Laravel otomatis membuat kolom 'siswas_count'.
         * Filter 'approved' memastikan Guru hanya melihat instansi yang sudah valid.
         */
        $instansi = Perusahaan::where('status', 'approved')
            ->withCount('siswas') 
            ->orderBy('nama', 'asc')
            ->get();

        return view('guru.instansi.index', compact('instansi'));
    }
}