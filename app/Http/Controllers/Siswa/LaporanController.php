<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPkl;
use App\Models\FormatLaporan;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        
        $laporan = LaporanPkl::where('siswa_id', $siswa->id)->latest()->first();
        $perusahaan = Perusahaan::all();

        return view('siswa.laporan.index', compact('laporan', 'perusahaan'));
    }


    public function format()
    {
        $format = FormatLaporan::latest()->get(); 
        
        return view('siswa.format.index', compact('format'));
    }


    public function upload(Request $request)
    {
        $request->validate([
            'link_drive' => 'required|url',
            'perusahaan_id' => 'required|exists:perusahaan,id',
        ], [
            'link_drive.required' => 'Link Google Drive wajib diisi!',
            'file.required' => 'File fisik laporan (PDF/DOCX) wajib diunggah!',
        ]);

        $siswa = Auth::user()->siswa;
        $laporan = LaporanPkl::firstOrNew(['siswa_id' => $siswa->id]);

        if ($request->hasFile('file')) {
            if ($laporan->file && Storage::disk('public')->exists($laporan->file)) {
                Storage::disk('public')->delete($laporan->file);
            }
            
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            $newFileName = time() . '_' . uniqid() . '.' . $ext;
            
            $laporan->file = $file->storeAs('laporan_pkl', $newFileName, 'public');
        }

        $laporan->perusahaan_id = $request->perusahaan_id;
        $laporan->link_drive = $request->link_drive;
        $laporan->status = 'pending';
        $laporan->save();

        return redirect()->route('siswa.laporan.index')->with('success', 'Laporan berhasil dikirim!');
    }


    public function download($id)
    {
        
        $laporan = LaporanPkl::findOrFail($id);

       
        if (!$laporan->file || !Storage::disk('public')->exists($laporan->file)) {
            return back()->with('error', 'File laporan tidak ditemukan di server.');
        }

        
        if (ob_get_level()) ob_end_clean();

        $pathToFile = Storage::disk('public')->path($laporan->file);
        $extension = strtolower(pathinfo($laporan->file, PATHINFO_EXTENSION));

        $namaPemilik = $laporan->siswa ? $laporan->siswa->nama : 'Siswa';
        $namaClean = preg_replace('/[^A-Za-z0-9]/', '_', $namaPemilik);
        $namaFile = "Laporan_PKL_" . trim($namaClean, '_') . "." . $extension;

        $mimeTypes = [
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

        return response()->download($pathToFile, $namaFile, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
        ]);
    }

    public function downloadFormat($id)
    {
        $format = FormatLaporan::findOrFail($id);

        if (!Storage::disk('public')->exists($format->file)) {
            return back()->with('error', 'File format tidak ditemukan.');
        }

        if (ob_get_level()) ob_end_clean();

        $pathToFile = Storage::disk('public')->path($format->file);
        $extension = strtolower(pathinfo($format->file, PATHINFO_EXTENSION));

        $titleClean = preg_replace('/[^A-Za-z0-9]/', '_', $format->nama);
        $namaDownload = $titleClean . "." . $extension;

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
}