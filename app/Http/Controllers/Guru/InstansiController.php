<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class InstansiController extends Controller
{

    public function index(Request $request) 
    {
        $query = Perusahaan::where('status', 'approved')
            ->withCount('siswas') 
            ->orderBy('nama', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $instansi = $query->get();

        return view('guru.instansi.index', compact('instansi'));
    }
}