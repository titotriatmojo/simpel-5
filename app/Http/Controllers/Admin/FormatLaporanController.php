<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FormatLaporan;
use App\Models\LaporanPkl; // Memastikan model LaporanPkl terbaca

class FormatLaporanController extends Controller
{
    /**
     * Tampilkan daftar format laporan.
     */
    public function index()
    {
        $format = FormatLaporan::latest()->get();
        return view('admin.format.index', compact('format'));
    }

    /**
     * Upload file format laporan.
     */
    /**
     * Upload file format laporan (Admin).
     */
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

        // --- FIX DI SINI: Pakai storeAs biar gak jadi .bin ---
        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $path = $file->storeAs('format-laporan', $fileName, 'public');

        FormatLaporan::create([
            'nama' => $request->nama,
            'file' => $path,
            'link_format' => $request->link_format,
        ]);

        return redirect()->route('admin.format.index')->with('success', 'Format laporan berhasil diupload.');
    }

    /**
     * Download laporan (Admin POV - Mendownload file kiriman Siswa)
     */
    /**
     * Download Format (Admin/Siswa POV - Mendownload Template)
     */
    public function downloadFormat($id)
{
    // 1. Cari data template (pake findOrFail biar kalau ID gak ada langsung 404)
    $format = FormatLaporan::findOrFail($id);

    // 2. Cek keberadaan file di storage
    if (!Storage::disk('public')->exists($format->file)) {
        return back()->with('error', 'File template tidak ditemukan di server.');
    }

    // 3. JURUS ANTI NGACAK: Bersihkan sisa output buffer
    if (ob_get_level()) {
        ob_end_clean();
    }

    $pathToFile = Storage::disk('public')->path($format->file);
    $extension = strtolower(pathinfo($format->file, PATHINFO_EXTENSION));

    // 4. PENAMAAN SESUAI TITLE:
    // Ganti karakter non-alfanumerik jadi underscore
    $namaClean = preg_replace('/[^A-Za-z0-9]/', '_', $format->nama);
    // Hapus underscore ganda atau yang ada di ujung-ujung
    $namaClean = trim(preg_replace('/_+/', '_', $namaClean), '_');
    
    // Gabungkan Title + Ekstensi
    $namaDownload = $namaClean . "." . $extension;

    // 5. Mapping MIME Type (Penting buat browser mobile & Chrome)
    $mimeTypes = [
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];
    $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

    // 6. Eksekusi Download
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

        // 1. Bersihkan nama siswa dari karakter aneh (hanya huruf, angka, dan underscore)
        $namaClean = preg_replace('/[^A-Za-z0-9]/', '_', $laporan->siswa->nama);
        
        // 2. Susun nama download (Pastikan tidak ada spasi sama sekali)
        $namaDownload = "Laporan_PKL_" . $namaClean . "." . $extension;

        // 3. Mapping Mime Type (Biar gak jadi .bin)
        $mimeTypes = [
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

        // 4. Return dengan Header yang sangat spesifik
        return response()->download($pathToFile, $namaDownload, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $namaDownload . '"',
        ]);
    }

    /**
     * Hapus format laporan.
     */
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