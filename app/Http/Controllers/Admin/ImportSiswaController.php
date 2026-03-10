<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportSiswaRequest;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportSiswaController extends Controller
{
    public function create()
    {
        return view('admin.siswa.import');
    }

    public function store(ImportSiswaRequest $request)
    {
        $import = new SiswaImport;
        Excel::import($import, $request->file('file'));

        if (!empty($import->errors)) {
            return redirect()->back()->withErrors(['import' => $import->errors])->withInput();
        }

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }
}