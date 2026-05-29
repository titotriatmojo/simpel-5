<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use App\Models\DataTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HasilSpkExport;
use App\Exports\DataTrainingExport;
use App\Imports\DataTrainingImport;

class SPKController extends Controller
{
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
            ->with(['siswa']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('siswa', function($sq) use ($search) {
                      $sq->where('nim', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->query('export') === 'excel') {
            $fileName = 'Hasil_Prediksi_KNN_' . now()->format('d-m-Y') . '.xlsx';
            return Excel::download(new HasilSpkExport($guruId), $fileName);
        }

        $siswas = $query->get();
        return view('guru.spk.index', compact('siswas'));
    }

    public function truncateTraining()
    {
        DataTraining::truncate(); 
        return redirect()->route('guru.spk.training.index')
            ->with('success', 'Dataset berhasil dikosongkan.');
    }

    /**
     * PREDICT KNN
     */
    public function predict($id)
    {
        $siswa = User::findOrFail($id);
        $dataset = DataTraining::all();

        if ($dataset->isEmpty()) {
            return back()->with('error', 'Dataset kosong.');
        }

        $x1 = (float) ($siswa->nilai_pkl ?? 0);
        $x2 = (float) (optional($siswa->nilaiPkl)->nilai ?? 0); // ini jadi sidang (guru)
        $x3 = ($x1 + $x2) / 2;

        if ($x1 <= 0 || $x2 <= 0 || $x3 <= 0) {
            return back()->with('error', 'Nilai PKL, Sidang, dan Total harus diisi.');
        }

        $distances = [];

        foreach ($dataset as $data) {
        $distance = sqrt(
            pow(($data->nilai_pkl - $x1), 2) +
            pow(($data->nilai_sidang - $x2), 2) +
            pow((($data->nilai_pkl + $data->nilai_sidang)/2 - $x3), 2)
        );

            $distances[] = [
                'jarak' => $distance,
                'label' => strtolower(trim($data->label))
            ];
        }

        usort($distances, fn($a, $b) => $a['jarak'] <=> $b['jarak']);

        $k = 3;
        $neighbors = array_slice($distances, 0, $k);

        $labels = array_column($neighbors, 'label');
        $counts = array_count_values($labels);
        arsort($counts);

        $hasilPrediksi = ucfirst(array_key_first($counts));

        $siswa->update(['hasil_prediksi' => $hasilPrediksi]);

        return redirect()->route('guru.spk.index')
            ->with('success', "Hasil Prediksi: $hasilPrediksi");
    }

    public function training()
    {
        $trainingData = DataTraining::latest()->get(); 
        return view('guru.spk.training', compact('trainingData'));
    }

    public function storeTraining(Request $request)
    {
        $data = $request->validate([
            'nama' => 'nullable|string',
            'nilai_pkl' => 'required|numeric|min:0|max:100',
            'nilai_sidang' => 'required|numeric|min:0|max:100',
            'nilai_total' => 'required|numeric|min:0|max:100',
            'label' => 'required|string',
        ]);

        $data['label'] = ucfirst(strtolower(trim($data['label'])));

        DataTraining::create($data);

        return back()->with('success', 'Data training ditambahkan.');
    }

    public function exportTraining()
    {
        return Excel::download(new DataTrainingExport, 'Dataset.xlsx');
    }

    public function importTraining(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new DataTrainingImport, $request->file('file'));
            return back()->with('success', 'Import berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroyTraining($id)
    {
        DataTraining::findOrFail($id)->delete();
        return back()->with('success', 'Data dihapus.');
    }

    public function input($id)
    {
        $siswa = User::findOrFail($id);
        return view('guru.spk.input', compact('siswa'));
    }

    public function storeInput(Request $request, $id)
    {
        $request->validate([
            'nilai_pkl' => 'required|numeric|min:0|max:100',
        ]);

        $siswa = User::findOrFail($id);

        // ambil nilai guru (sidang)
        $nilaiSidang = (float) (optional($siswa->nilaiPkl)->nilai ?? 0);

        // hitung total otomatis
        $nilaiTotal = ($request->nilai_pkl + $nilaiSidang) / 2;

        $siswa->update([
            'nilai_pkl'   => $request->nilai_pkl,
            'nilai_sidang'=> $nilaiSidang, 
            'nilai_total' => $nilaiTotal,  
        ]);

        return redirect()->route('guru.spk.index')
            ->with('success', 'Nilai berhasil disimpan (auto hitung total & sidang).');
    }


    //SPK TESTING
    // Halaman awal Uji Akurasi (Default nilai 0)
    public function testing()
    {
        return view('guru.spk.testing', [
            'akurasi' => 0,
            'precision' => 0,
            'recall' => 0,
            'specificity' => 0,
            'f1_score' => 0,
            'tp' => 0,
            'tn' => 0,
            'fp' => 0,
            'fn' => 0,
            'k_value' => 3,
            'totalDataUji' => 0
        ]);
    }

    /**
     * TESTING (CONFUSION MATRIX + METRIK EVALUASI)
     */
    public function prosesUji()
    {
        $k = 3;
        $fold = 5;

        // Ambil data 
        $dataset = DataTraining::orderBy('id', 'asc')->get()->toArray();

        if (count($dataset) < $fold) {
            return redirect()->back()->with('error', 'Jumlah dataset kurang untuk melakukan 5-Fold Cross Validation.');
        }

        // Pisahkan kelas
        $siap = array_values(array_filter($dataset, fn($d) => strtolower(trim($d['label'])) === 'siap'));
        $tidak = array_values(array_filter($dataset, fn($d) => strtolower(trim($d['label'])) === 'tidak siap'));

        // acak data
        mt_srand(42); 
        shuffle($siap);
        shuffle($tidak);
        $folds = array_fill(0, $fold, []);

        // distribusi rata per kelas ke tiap fold
        $distribute = function($classData) use (&$folds, $fold) {
            $i = 0;
            foreach ($classData as $item) {
                $folds[$i % $fold][] = $item;
                $i++;
            }
        };

        $distribute($siap);
        $distribute($tidak);

        $totalTp = $totalTn = $totalFp = $totalFn = 0;

        for ($i = 0; $i < $fold; $i++) {

            $testing = $folds[$i];

            $training = [];
            for ($j = 0; $j < $fold; $j++) {
                if ($j != $i) {
                    $training = array_merge($training, $folds[$j]);
                }
            }

            foreach ($testing as $test) {

                $distances = [];

                foreach ($training as $train) {
                    $distances[] = [
                        'distance' => sqrt(
                            pow($test['nilai_pkl'] - $train['nilai_pkl'], 2) +
                            pow($test['nilai_sidang'] - $train['nilai_sidang'], 2)
                        ),
                        'label' => strtolower(trim($train['label']))
                    ];
                }

                usort($distances, fn($a, $b) => $a['distance'] <=> $b['distance']);

                $neighbors = array_slice($distances, 0, $k);
                $labels = array_column($neighbors, 'label');

                $counts = array_count_values($labels);
                arsort($counts);

                $prediction = array_key_first($counts);
                $actual = strtolower(trim($test['label']));

                if ($actual === 'siap' && $prediction === 'siap') $totalTp++;
                elseif ($actual === 'tidak siap' && $prediction === 'tidak siap') $totalTn++;
                elseif ($actual === 'tidak siap' && $prediction === 'siap') $totalFp++;
                elseif ($actual === 'siap' && $prediction === 'tidak siap') $totalFn++;
            }
        }

        $totalData = $totalTp + $totalTn + $totalFp + $totalFn;

        // --- HITUNG METRIK EVALUASI ---
        
        // 1. Akurasi
        $akurasi = $totalData > 0 ? (($totalTp + $totalTn) / $totalData) * 100 : 0;

        // 2. Precision = TP / (TP + FP)
        $precision = ($totalTp + $totalFp) > 0 ? ($totalTp / ($totalTp + $totalFp)) * 100 : 0;

        // 3. Recall / Sensitivity = TP / (TP + FN)
        $recall = ($totalTp + $totalFn) > 0 ? ($totalTp / ($totalTp + $totalFn)) * 100 : 0;

        // 4. Specificity = TN / (TN + FP)
        $specificity = ($totalTn + $totalFp) > 0 ? ($totalTn / ($totalTn + $totalFp)) * 100 : 0;

        // 5. F1-Score = 2 * (Precision * Recall) / (Precision + Recall)
        $f1Score = ($precision + $recall) > 0 ? 2 * (($precision * $recall) / ($precision + $recall)) : 0;

        return view('guru.spk.testing', [
            'akurasi' => round($akurasi, 2),
            'precision' => round($precision, 2),
            'recall' => round($recall, 2),
            'specificity' => round($specificity, 2),
            'f1_score' => round($f1Score, 2),
            'tp' => $totalTp,
            'tn' => $totalTn,
            'fp' => $totalFp,
            'fn' => $totalFn,
            'k_value' => $k,
            'totalDataUji' => $totalData
        ]);
    }
}