<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FormatLaporan;
use App\Models\LaporanPkl; 

class FormatLaporanController extends Controller
{
    public function index()
    {
        $format = FormatLaporan::latest()->get();
        return view('admin.format.index', compact('format'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'file' => 'required|file|max:102400', 
            'link_format' => 'nullable|url',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $allowedExtensions = ['pdf', 'doc', 'docx'];

        if (!in_array($extension, $allowedExtensions)) {
            return back()->withErrors(['file' => 'Format file harus: pdf, doc, atau docx.'])->withInput();
        }

        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $path = $file->storeAs('format-laporan', $fileName, 'public');

        FormatLaporan::create([
            'nama' => $request->nama,
            'file' => $path,
            'link_format' => $request->link_format,
        ]);

        return redirect()->route('admin.format.index')->with('success', 'Format laporan berhasil diupload.');
    }

    public function downloadFormat($id)
{
  
    $format = FormatLaporan::findOrFail($id);

    
    if (!Storage::disk('public')->exists($format->file)) {
        return back()->with('error', 'File template tidak ditemukan di server.');
    }

    
    if (ob_get_level()) {
        ob_end_clean();
    }

    $pathToFile = Storage::disk('public')->path($format->file);
    $extension = strtolower(pathinfo($format->file, PATHINFO_EXTENSION));


    $namaClean = preg_replace('/[^A-Za-z0-9]/', '_', $format->nama);
    
    $namaClean = trim(preg_replace('/_+/', '_', $namaClean), '_');
    
    
    $namaDownload = $namaClean . "." . $extension;

    
    $mimeTypes = [
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];
    $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

   
    return response()->download($pathToFile, $namaDownload, [
        'Content-Type'        => $contentType,
        'Content-Disposition' => 'attachment; filename="' . $namaDownload . '"',
    ]);
}
    public function downloadLaporan($id)
    {
        $laporan = LaporanPkl::with('siswa')->findOrFail($id);

        if (!Storage::disk('public')->exists($laporan->file)) {
            return back()->with('error', 'File fisik tidak ditemukan.');
        }

        $pathToFile = Storage::disk('public')->path($laporan->file);
        $extension = strtolower(pathinfo($laporan->file, PATHINFO_EXTENSION));

       
        $namaClean = preg_replace('/[^A-Za-z0-9]/', '_', $laporan->siswa->nama);
        
        
        $namaDownload = "Laporan_PKL_" . $namaClean . "." . $extension;

        
        $mimeTypes = [
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

        
        return response()->download($pathToFile, $namaDownload, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $namaDownload . '"',
        ]);
    }

    public function destroy($id)
    {
        $format = FormatLaporan::findOrFail($id);

        if (Storage::disk('public')->exists($format->file)) {
            Storage::disk('public')->delete($format->file);
        }

        $format->delete();

        return redirect()->route('admin.format.index')->with('success', 'Format laporan berhasil dihapus.');
    }
}