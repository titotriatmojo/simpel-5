<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportGuruRequest;
use App\Imports\GuruImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportGuruController extends Controller
{
    public function index() 
    {
        return view('admin.guru.import');
    }

    public function store(ImportGuruRequest $request)
    {
        $import = new GuruImport;
        Excel::import($import, $request->file('file'));

        if (!empty($import->errors)) {
            return redirect()->back()->withErrors(['import' => $import->errors])->withInput();
        }

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }
}