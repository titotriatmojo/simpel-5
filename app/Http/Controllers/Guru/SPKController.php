<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use App\Models\DataTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\HasilSpkExport;
use App\Exports\DataTrainingExport; // Tambahkan ini
use App\Imports\DataTrainingImport; // Tambahkan ini


class SPKController extends Controller
{
    /**
     * Index: Daftar Siswa & Export Hasil Prediksi
     */
    public function index(Request $request)
    {
        $userId = Auth::id(); 
        $guruProfile = Guru::where('user_id', $userId)->first();

        if (!$guruProfile) {
            return view('guru.spk.index', ['siswas' => collect([])])
                   ->with('error', 'Profil Guru tidak ditemukan.');
        }

        $guruId = $guruProfile->id;

        $query = User::where('role', 'siswa')
            ->whereHas('siswa.pendaftaranPkl', function($q) use ($guruId) {
                $q->where('guru_id', $guruId)
                  ->where('status', 'diterima');
            })
            ->with(['siswa', 'nilaiPkl']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('siswa', function($sq) use ($search) {
                      $sq->where('nim', 'like', "%{$search}%");
                  });
            });
        }

        // Export Hasil Prediksi (Halaman Index)
        if ($request->query('export') === 'excel') {
            $fileName = 'Hasil_Prediksi_KNN_' . now()->format('d-m-Y') . '.xlsx';
            return Excel::download(new HasilSpkExport($guruId), $fileName);
        }

        $siswas = $query->get();
        return view('guru.spk.index', compact('siswas'));
    }

            //import hasil prediksi
        public function truncateTraining()
        {
            try {
                // Cara 1: Menggunakan Model (Lebih disarankan di Laravel)
                DataTraining::truncate(); 

                // Cara 2: Menggunakan DB facade (Jika cara 1 ada kendala foreign key)
                // DB::table('data_trainings')->truncate(); 
                
                return redirect()->route('guru.spk.training.index')
                                ->with('success', 'Seluruh dataset alumni berhasil dikosongkan!');
            } catch (\Exception $e) {
                return redirect()->back()
                                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
            }
        }

    /**
     * Prediksi KNN
     */
    public function predict($id)
    {
        $siswa = User::with('nilaiPkl')->findOrFail($id);
        $dataset = DataTraining::all();

        if ($dataset->isEmpty()) {
            return back()->with('error', 'Prediksi gagal! Dataset alumni kosong.');
        }

        $x1 = (float) ($siswa->nilai_akademik ?? 0);
        $x2 = (float) ($siswa->nilai_instansi ?? 0);
        $x3 = (float) ($siswa->nilaiPkl->nilai ?? 0); 

        if ($x1 <= 0 || $x2 <= 0 || $x3 <= 0) {
            return back()->with('error', 'Gagal! Pastikan Nilai Akademik, Instansi, dan Pembimbing sudah terisi.');
        }

        $distances = [];
        foreach ($dataset as $data) {
            $distance = sqrt(
                pow(($data->nilai_akademik - $x1), 2) +
                pow(($data->nilai_instansi - $x2), 2) +
                pow(($data->nilai_pembimbing - $x3), 2)
            );
            $distances[] = ['jarak' => $distance, 'label' => $data->label];
        }

        usort($distances, fn($a, $b) => $a['jarak'] <=> $b['jarak']);
        
        $k = 3;
        $neighbors = array_slice($distances, 0, $k);
        $labels = array_column($neighbors, 'label');
        $counts = array_count_values($labels);
        arsort($counts);
        $hasilPrediksi = array_key_first($counts);

        $siswa->update(['hasil_prediksi' => $hasilPrediksi]);

        return redirect()->route('guru.spk.index')->with('success', "Analisis Selesai! Hasil: $hasilPrediksi");
    }

    /**
     * Halaman Data Training
     */
    public function training() 
    {
        // Ambil data terbaru
        $trainingData = DataTraining::latest()->get(); 
        
        // Kirim ke view dengan nama 'trainingData'
        return view('guru.spk.training', compact('trainingData'));
    }
    /**
     * Store Data Training Manual
     */
    public function storeTraining(Request $request) {
        $data = $request->validate([
            'nama' => 'nullable|string',
            'nilai_akademik' => 'required|numeric|min:0|max:100',
            'nilai_instansi' => 'required|numeric|min:0|max:100',
            'nilai_pembimbing' => 'required|numeric|min:0|max:100',
            'label' => 'required|string',
        ]);
        DataTraining::create($data);
        return redirect()->back()->with('success', 'Data training berhasil ditambahkan.');
    }

    /**
     * Export Data Training
     */
    public function exportTraining()
    {
        return Excel::download(new DataTrainingExport, 'Dataset_Alumni_' . now()->format('d-m-Y') . '.xlsx');
    }

    /**
     * Import Data Training
     */
    public function importTraining(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new DataTrainingImport, $request->file('file'));
            return back()->with('success', 'Data training berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimport data. Pastikan format file benar.');
        }
    }

    public function destroyTraining($id) {
        DataTraining::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data training telah dihapus.');
    }

    /**
     * Input Nilai Akademik & Instansi Siswa
     */
    public function input($id) {
        $siswa = User::with('siswa')->findOrFail($id);
        return view('guru.spk.input', compact('siswa'));
    }

    public function storeInput(Request $request, $id) {
        $request->validate([
            'nilai_akademik' => 'required|numeric|min:0|max:100',
            'nilai_instansi' => 'required|numeric|min:0|max:100',
        ]);

        User::findOrFail($id)->update([
            'nilai_akademik' => $request->nilai_akademik,
            'nilai_instansi' => $request->nilai_instansi,
        ]);

        return redirect()->route('guru.spk.index')->with('success', 'Nilai berhasil disimpan!');
    }

    
    /* Testing & Confusion Matrix */
    public function testing()
    {
        // 1. Ambil semua data dari database
        $semuaData = DataTraining::all();
        
        // 2. Hitung total data untuk statistik di dashboard testing
        $totalData = $semuaData->count();
        
        // 3. Ambil data dengan label tertentu (contoh buat statistik awal)
        $sesuai = $semuaData->where('label', 'Sesuai')->count();
        $tidakSesuai = $semuaData->where('label', 'Tidak Sesuai')->count();

        // Kirim data ke view (Nilai TP, TN, dll masih 0 sebelum tombol "Uji" diklik)
        return view('guru.spk.testing', [
            'akurasi' => 0,
            'totalDataUji' => $totalData,
            'k_value' => 5, // default value
            'tp' => 0,
            'tn' => 0,
            'fp' => 0,
            'fn' => 0,
            'data_db' => $semuaData // Kalau mau nampilin tabel datanya juga
        ]);
    }

    /**
     * Memproses perhitungan K-NN untuk uji akurasi
     */
        public function prosesUji(Request $request)
        {
            // Pakai K=3 sesuai request, atau ambil dari input kalau user ganti
            $k = $request->k ?? 3;

            // Ambil semua data dari database
            $dataset = DataTraining::all()->toArray();
            
            if (count($dataset) < 1) {
                return redirect()->back()->with('error', 'Data training kosong!');
            }

            $tp = 0; $tn = 0; $fp = 0; $fn = 0;

            // Loop Utama: Anggap setiap data di DB adalah "Data Uji"
            foreach ($dataset as $test) {
                $distances = [];

                // Loop Pembanding: Bandingkan data uji dengan data lainnya di DB (Data Training)
                foreach ($dataset as $train) {
                    // JANGAN bandingkan data dengan dirinya sendiri
                    if ($test['id'] == $train['id']) {
                        continue;
                    }

                    // Hitung Euclidean Distance
                    $dist = sqrt(
                        pow((float)$test['nilai_akademik'] - (float)$train['nilai_akademik'], 2) +
                        pow((float)$test['nilai_instansi'] - (float)$train['nilai_instansi'], 2) +
                        pow((float)$test['nilai_pembimbing'] - (float)$train['nilai_pembimbing'], 2)
                    );

                    $distances[] = [
                        'distance' => $dist,
                        'label' => $train['label']
                    ];
                }

                // Urutkan jarak terdekat (terkecil ke terbesar)
                usort($distances, fn($a, $b) => $a['distance'] <=> $b['distance']);

                // Ambil 3 tetangga terdekat (K=3)
                $neighbors = array_slice($distances, 0, $k);
                $labels = array_column($neighbors, 'label');
                $counts = array_count_values($labels);
                
                // Voting: Ambil label yang paling banyak muncul
                arsort($counts);
                $prediction = array_key_first($counts);

                // --- Confusion Matrix Logic (Siap vs Tidak Siap) ---
                $actual = strtolower(trim($test['label']));
                $pred = strtolower(trim($prediction));

                if ($actual == 'siap' && $pred == 'siap') $tp++;
                elseif ($actual == 'tidak siap' && $pred == 'tidak siap') $tn++;
                elseif ($actual == 'tidak siap' && $pred == 'siap') $fp++;
                elseif ($actual == 'siap' && $pred == 'tidak siap') $fn++;
            }

            // Hitung Akurasi dari TOTAL dataset (23 data)
            $totalUji = count($dataset);
            $akurasi = ($totalUji > 0) ? (($tp + $tn) / $totalUji) * 100 : 0;

            return view('guru.spk.testing', [
                'akurasi' => round($akurasi, 2),
                'totalDataUji' => $totalUji,
                'k_value' => $k,
                'tp' => $tp,
                'tn' => $tn,
                'fp' => $fp,
                'fn' => $fn
            ])->with('success', 'Uji Akurasi Selesai dengan K=3!');
        }
}