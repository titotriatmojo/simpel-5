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
    /**
     * Halaman Utama Laporan Siswa
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;
        
        // Mengambil laporan terbaru milik siswa
        $laporan = LaporanPkl::where('siswa_id', $siswa->id)->latest()->first();
        $perusahaan = Perusahaan::all();

        return view('siswa.laporan.index', compact('laporan', 'perusahaan'));
    }

    /**
     * Halaman Download Format Laporan (POV Siswa)
     */
    public function format()
    {
        // Mengambil semua template format laporan dari admin
        $format = FormatLaporan::latest()->get(); 
        
        return view('siswa.format.index', compact('format'));
    }

    /**
     * Proses Upload/Update Laporan
     */
    public function upload(Request $request)
    {
        $request->validate([
            'link_drive' => 'required|url',
            'perusahaan_id' => 'required|exists:perusahaan,id',
            'file' => 'nullable|file|max:102400' 
        ]);

        $siswa = Auth::user()->siswa;
        
        // Cari laporan yang sudah ada atau buat instance baru
        $laporan = LaporanPkl::firstOrNew(['siswa_id' => $siswa->id]);

        // Jika ada file baru yang diunggah
        if ($request->hasFile('file')) {
            if ($laporan->file && Storage::disk('public')->exists($laporan->file)) {
                Storage::disk('public')->delete($laporan->file);
            }
            
            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension());

            if (!in_array($ext, ['pdf', 'doc', 'docx'])) {
                return back()->withErrors(['file' => 'Format harus PDF/DOC/DOCX']);
            }

            // PAKAI STOREAS BIAR GAK JADI .BIN
            $newFileName = time() . '_' . uniqid() . '.' . $ext;
            $laporan->file = $file->storeAs('laporan_pkl', $newFileName, 'public');
        }

        $laporan->perusahaan_id = $request->perusahaan_id;
        $laporan->link_drive = $request->link_drive;
        $laporan->status = 'pending'; // Reset status ke pending saat update
        $laporan->save();

        return redirect()->route('siswa.laporan.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Fungsi Download Laporan yang Sudah Diunggah
     */
    /**
     * Fungsi Download Laporan yang Sudah Diunggah (MILIK SISWA)
     */
    public function download($id)
    {
        // 1. Cari laporan berdasarkan ID (Bisa diakses Admin maupun Siswa)
        $laporan = LaporanPkl::findOrFail($id);

        // 2. Cek apakah file fisiknya ada di storage
        if (!$laporan->file || !Storage::disk('public')->exists($laporan->file)) {
            return back()->with('error', 'File laporan tidak ditemukan di server.');
        }

        // 3. JURUS ANTI .BIN (PENTING!)
        if (ob_get_level()) ob_end_clean();

        $pathToFile = Storage::disk('public')->path($laporan->file);
        $extension = strtolower(pathinfo($laporan->file, PATHINFO_EXTENSION));

        // 4. PENAMAAN FILE (Ambil dari relasi siswa agar nama file rapi)
        // Pastikan model LaporanPkl punya relasi 'siswa'
        $namaPemilik = $laporan->siswa ? $laporan->siswa->nama : 'Siswa';
        $namaClean = preg_replace('/[^A-Za-z0-9]/', '_', $namaPemilik);
        $namaFile = "Laporan_PKL_" . trim($namaClean, '_') . "." . $extension;

        // 5. MAPPING MIME TYPE
        $mimeTypes = [
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

        // 6. RETURN DOWNLOAD
        return response()->download($pathToFile, $namaFile, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
        ]);
    }

    /**
     * Fungsi Download Format (Template dari Admin)
     */
    /**
     * Fungsi Download Format (Template dari Admin)
     */
    public function downloadFormat($id)
    {
        $format = FormatLaporan::findOrFail($id);

        if (!Storage::disk('public')->exists($format->file)) {
            return back()->with('error', 'File format tidak ditemukan.');
        }

        // --- JURUS ANTI NAMA NGACAK & ANTI .BIN ---
        // Bersihkan buffer biar nggak ada karakter sisa yang ngerusak header
        if (ob_get_level()) ob_end_clean();

        $pathToFile = Storage::disk('public')->path($format->file);
        $extension = strtolower(pathinfo($format->file, PATHINFO_EXTENSION));

        // Ambil Title dari database, ganti spasi jadi underscore biar browser gak bingung
        $titleClean = preg_replace('/[^A-Za-z0-9]/', '_', $format->nama);
        $namaDownload = $titleClean . "." . $extension;

        // Mapping MIME Type manual biar lebih 'galak' ke browser
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