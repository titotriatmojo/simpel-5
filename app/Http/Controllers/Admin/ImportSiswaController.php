<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportSiswaRequest;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ImportSiswaController extends Controller
{
    /**
     * Ganti 'create' jadi 'index' agar sinkron sama web.php
     */
    public function index()
    {
        return view('admin.siswa.import');
    }

    public function store(ImportSiswaRequest $request)
    {
        try {
            $import = new SiswaImport;
            Excel::import($import, $request->file('file'));

            // Cek jika ada error di baris Excel tertentu
            if (isset($import->errors) && !empty($import->errors)) {
                return redirect()->back()
                    ->withErrors(['import' => $import->errors])
                    ->withInput();
            }

            return redirect()->route('admin.siswa.index')
                ->with('success', 'Data siswa berhasil diimport secara massal.');

        } catch (\Exception $e) {
            // Log error jika ada masalah sistem (format file salah, dsb)
            Log::error('Import Siswa Error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal mengimport data. Pastikan format file sesuai template.')
                ->withInput();
        }
    }
}