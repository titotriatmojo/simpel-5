<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use App\Models\DataTraining;
use App\Models\NilaiPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SPKController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); 
        $guruProfile = Guru::where('user_id', $userId)->first();

        if (!$guruProfile) {
            return view('guru.spk.index', ['siswas' => collect([])])
                   ->with('error', 'Profil Guru tidak ditemukan.');
        }

        // Ambil siswa bimbingan dengan Eager Loading
        $siswas = User::where('role', 'siswa')
            ->whereHas('siswa.pendaftaranPkl', function($q) use ($guruProfile) {
                $q->where('guru_id', $guruProfile->id)
                  ->where('status', 'diterima');
            })
            ->with(['siswa', 'nilaiPkl']) // Pastikan relasi nilaiPkl ada di Model User
            ->get();

        return view('guru.spk.index', compact('siswas'));
    }

    public function predict($id)
    {
        // 1. Ambil Data Siswa & Nilai PKL (82.00)
        $siswa = User::with('nilaiPkl')->findOrFail($id);
        $dataset = DataTraining::all();

        if ($dataset->isEmpty()) {
            return back()->with('error', 'Prediksi gagal! Dataset alumni kosong.');
        }

        // 2. Ambil Nilai Uji (Gunakan default 0 jika null agar tidak error matematika)
        $x1 = (float) ($siswa->nilai_akademik ?? 0);
        $x2 = (float) ($siswa->nilai_instansi ?? 0);
        $x3 = (float) ($siswa->nilaiPkl->nilai ?? 0); 

        // Proteksi: Jika nilai masih 0, jangan izinkan prediksi
        if ($x1 == 0 || $x2 == 0 || $x3 == 0) {
            return back()->with('error', 'Gagal! Pastikan semua nilai (Akademik, Instansi, Pembimbing) sudah terisi.');
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

        // 4. Urutkan & Voting
        usort($distances, fn($a, $b) => $a['jarak'] <=> $b['jarak']);
        $k = 3;
        $neighbors = array_slice($distances, 0, $k);
        $labels = array_column($neighbors, 'label');
        $counts = array_count_values($labels);
        arsort($counts);
        $hasilPrediksi = array_key_first($counts);

        // 5. Simpan Hasil
        $siswa->update(['hasil_prediksi' => $hasilPrediksi]);

        return redirect()->route('guru.spk.index')->with('success', "Analisis Selesai! Hasil: $hasilPrediksi");
    }
    /**
     * Fungsi Pendukung (Training Data)
     */
    public function training() {
        $trainingData = DataTraining::latest()->get(); 
        return view('guru.spk.training', compact('trainingData'));
    }

    public function storeTraining(Request $request) {
        $data = $request->validate([
            'nama' => 'nullable|string',
            'nilai_akademik' => 'required|numeric',
            'nilai_instansi' => 'required|numeric',
            'nilai_pembimbing' => 'required|numeric',
            'label' => 'required|string',
        ]);
        DataTraining::create($data);
        return redirect()->back()->with('success', 'Data training ditambahkan.');
    }

    public function destroyTraining($id) {
        DataTraining::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data training dihapus.');
    }
    public function input($id)
{
    // Ambil data user beserta profil siswanya
    $siswa = User::with('siswa')->findOrFail($id);
    return view('guru.spk.input', compact('siswa'));
}

/**
 * Simpan Nilai ke Tabel Users
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

    return redirect()->route('guru.spk.index')->with('success', 'Nilai berhasil diperbarui!');
}
}