<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    /**
     * Menampilkan daftar perusahaan dengan filter dan pencarian.
     */
    public function index(Request $request)
    {
        // PERBAIKAN: Gunakan 'pengusul' sesuai nama relasi di Model Perusahaan
        // Gunakan withCount('pendaftaran') untuk melihat berapa siswa yang sudah di sana
        $query = Perusahaan::with('pengusul')->withCount('pendaftaran');

        // Logic Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('alamat', 'like', "%$search%")
                    ->orWhere('bidang_usaha', 'like', "%$search%")
                    ->orWhere('no_hp', 'like', "%$search%");
            });
        }

        /**
         * Urutan Cerdas: 
         * 1. Status 'pending' muncul paling atas (biar admin cepat notice)
         * 2. Sisanya diurutkan berdasarkan yang terbaru
         */
        $perusahaan = $query->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
                            ->latest()
                            ->paginate(10)
                            ->appends($request->only('search'));

        return view('admin.perusahaan.index', compact('perusahaan'));
    }

    public function create()
    {
        return view('admin.perusahaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'alamat'       => 'required|string',
            'no_hp'        => 'required|string|max:20',
            'kuota'        => 'required|integer|min:1',
        ]);

        // Perusahaan yang diinput Admin langsung otomatis 'approved'
        $validated['status'] = 'approved';

        Perusahaan::create($validated);

        return redirect()->route('admin.perusahaan.index')
            ->with('success', 'Perusahaan baru berhasil ditambahkan.');
    }

    public function show(Perusahaan $perusahaan)
    {
        // Eager load pendaftaran.siswa untuk melihat siapa saja yang PKL di sana
        $perusahaan->load(['pengusul', 'pendaftaran.siswa']);
        return view('admin.perusahaan.show', compact('perusahaan'));
    }

    public function edit(Perusahaan $perusahaan)
    {
        return view('admin.perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request, Perusahaan $perusahaan)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'alamat'       => 'required|string',
            'no_hp'        => 'required|string|max:20',
            'kuota'        => 'required|integer|min:1',
            'status'       => 'required|in:pending,approved,rejected',
        ]);

        $perusahaan->update($validated);

        return redirect()->route('admin.perusahaan.index')
            ->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    public function destroy(Perusahaan $perusahaan)
    {
        // Proteksi: Jangan hapus perusahaan jika sudah ada siswa yang terdaftar PKL
        if ($perusahaan->pendaftaran()->exists()) {
            return redirect()->back()->with('error', 'Gagal menghapus! Perusahaan ini masih memiliki siswa yang terdaftar PKL.');
        }

        $perusahaan->delete();

        return redirect()->route('admin.perusahaan.index')
            ->with('success', 'Perusahaan berhasil dihapus.');
    }

    // --- FITUR APPROVAL ---

    public function approve($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update(['status' => 'approved']);

        return redirect()->route('admin.perusahaan.index')
            ->with('success', "Usulan perusahaan '{$perusahaan->nama}' telah disetujui.");
    }

    public function reject($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update(['status' => 'rejected']);

        return redirect()->route('admin.perusahaan.index')
            ->with('success', "Usulan perusahaan '{$perusahaan->nama}' telah ditolak.");
    }
}