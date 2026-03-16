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

        $path = $file->store('format-laporan', 'public');

        FormatLaporan::create([
            'nama' => $request->nama,
            'file' => $path,
            'link_format' => $request->link_format,
        ]);

        return redirect()->route('admin.format.index')->with('success', 'Format laporan berhasil diupload.');
    }

    /**
     * Download laporan berdasarkan ID
     */
        public function downloadLaporan($id)
    {
        // 1. Ambil data laporan
        $laporan = LaporanPkl::with('siswa')->findOrFail($id);

        // 2. Cek apakah file ada di disk public
        if (!Storage::disk('public')->exists($laporan->file)) {
            return back()->with('error', 'Maaf, file fisik tidak ditemukan di server.');
        }

        // 3. Ambil path absolut (lokasi asli di folder XAMPP)
        $pathToFile = Storage::disk('public')->path($laporan->file);
        
        // 4. Ambil ekstensi asli dari database (misal: .docx)
        $extension = pathinfo($laporan->file, PATHINFO_EXTENSION);
        
        // 5. Susun nama file baru untuk user saat didownload
        $namaSiswa = str_replace(' ', '_', $laporan->siswa->nama);
        $namaDownload = "Laporan_PKL_{$namaSiswa}.{$extension}";

        // 6. Jalankan download standar Laravel
        return response()->download($pathToFile, $namaDownload);
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