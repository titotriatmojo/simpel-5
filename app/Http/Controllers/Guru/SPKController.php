<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DataTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SPKController extends Controller
{
    /**
     * Halaman Utama SPK: Daftar Siswa Bimbingan
     */
    public function index()
    {
        $siswas = User::where('role', 'siswa')
                      ->where('guru_id', Auth::id())
                      ->with('nilai') 
                      ->get();

        return view('guru.spk.index', compact('siswas'));
    }

    /**
     * Halaman Form Input Nilai Manual (Akademik & Instansi)
     */
    public function input($id) 
    {
        $siswa = User::findOrFail($id); 
        return view('guru.spk.input', compact('siswa'));
    }

    /**
     * Proses Simpan Nilai Manual
     */
    public function storeInput(Request $request, $id)
    {
        $request->validate([
            'nilai_akademik' => 'required|numeric|min:0|max:100',
            'nilai_instansi' => 'required|numeric|min:0|max:100',
        ]);

        $siswa = User::findOrFail($id);
        $siswa->update([
            'nilai_akademik' => $request->nilai_akademik,
            'nilai_instansi' => $request->nilai_instansi,
        ]);

        return redirect()->route('guru.spk.index')->with('success', 'Nilai berhasil disimpan!');
    }

    /**
     * Halaman Dataset Alumni (Data Training KNN)
     */
    public function training()
    {
        $trainingData = DataTraining::latest()->get(); 
        return view('guru.spk.training', compact('trainingData'));
    }

    /**
     * Simpan Data Training Baru
     */
    public function storeTraining(Request $request)
    {
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'nilai_akademik' => 'required|numeric|min:0|max:100',
            'nilai_instansi' => 'required|numeric|min:0|max:100',
            'nilai_pembimbing' => 'required|numeric|min:0|max:100',
            'label' => 'required|string',
        ]);

        DataTraining::create($request->all());

        return redirect()->route('guru.spk.training')->with('success', 'Data alumni berhasil ditambahkan!');
    }

    /**
     * Hapus Data Training
     */
    public function destroyTraining($id)
    {
        $data = DataTraining::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data training berhasil dihapus!');
    }

    /**
     * LOGIC INTI KNN: K-Nearest Neighbors
     */
    public function predict($id)
    {
        $siswa = User::with('nilai')->findOrFail($id);
        $dataset = DataTraining::all();

        // 1. Ambil Nilai Siswa (Data Uji)
        $x1 = $siswa->nilai_akademik ?? 0;
        $x2 = $siswa->nilai_instansi ?? 0;
        
        // Proteksi jika relasi nilai atau kolom nilai kosong
        $x3 = ($siswa->nilai) ? $siswa->nilai->nilai : 0; 

        // 2. Alert Gagal (Merah) jika dataset kosong
        if ($dataset->isEmpty()) {
            return back()->with('error', 'Prediksi gagal! Pastikan data training sudah terisi.');
        }

        $distances = [];

        // 3. Hitung Jarak Euclidean
        foreach ($dataset as $data) {
            $distance = sqrt(
                pow(($data->nilai_akademik - $x1), 2) +
                pow(($data->nilai_instansi - $x2), 2) +
                pow(($data->nilai_pembimbing - $x3), 2)
            );

            $distances[] = [
                'jarak' => $distance,
                'label' => $data->label
            ];
        }

        // 4. Urutkan Jarak Terdekat
        usort($distances, fn($a, $b) => $a['jarak'] <=> $b['jarak']);

        // 5. Ambil K terdekat (K=3)
        $k = 3;
        $neighbors = array_slice($distances, 0, $k);

        // 6. Voting Label Terbanyak
        $counts = array_count_values(array_column($neighbors, 'label'));
        arsort($counts);
        $hasilPrediksi = array_key_first($counts);

        // 7. Update Hasil ke Database
        $siswa->update([
            'hasil_prediksi' => $hasilPrediksi
        ]);

        // 8. Alert Sukses (Simpel)
        return redirect()->route('guru.spk.index')->with('success', 'Prediksi selesai!');
    }
}