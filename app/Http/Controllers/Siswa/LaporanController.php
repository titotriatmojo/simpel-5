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
            // Hapus file lama jika ada
            if ($laporan->file && Storage::disk('public')->exists($laporan->file)) {
                Storage::disk('public')->delete($laporan->file);
            }
            
            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension());

            if (!in_array($ext, ['pdf', 'doc', 'docx'])) {
                return back()->withErrors(['file' => 'Format harus PDF/DOC/DOCX']);
            }

            $laporan->file = $file->store('laporan_pkl', 'public');
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
    public function download()
    {
        $siswa = Auth::user()->siswa;
        $laporan = LaporanPkl::where('siswa_id', $siswa->id)->first();

        // Validasi keberadaan file
        if (!$laporan || !$laporan->file || !Storage::disk('public')->exists($laporan->file)) {
            return back()->with('error', 'File tidak ditemukan di server.');
        }

        $extension = pathinfo($laporan->file, PATHINFO_EXTENSION);
        $namaFile = "Laporan_PKL_" . str_replace(' ', '_', $siswa->nama) . "." . $extension;

        // Pakai response()->download() supaya editor (Intelephense) nggak merah
        return response()->download(storage_path('app/public/' . $laporan->file), $namaFile);
    }
}