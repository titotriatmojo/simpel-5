<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    /**
     * Menampilkan daftar instansi dengan fitur pencarian.
     */
    public function index(Request $request) // Tambahkan parameter Request $request
    {
        // 1. Mulai Query dengan filter status approved
        $query = Perusahaan::where('status', 'approved')
            ->withCount('siswas') // Menghitung otomatis relasi siswas
            ->orderBy('nama', 'asc');

        // 2. Logika Search (Jika ada input 'search' dari view)
        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 3. Ambil data (Gunakan get() atau paginate(10) jika data sudah sangat banyak)
        $instansi = $query->get();

        return view('guru.instansi.index', compact('instansi'));
    }
}