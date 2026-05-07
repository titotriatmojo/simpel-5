<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perusahaan::with('pengusul')->withCount('pendaftaran');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('alamat', 'like', "%$search%")
                    ->orWhere('bidang_usaha', 'like', "%$search%")
                    ->orWhere('no_hp', 'like', "%$search%");
            });
        }

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
            'email'               => 'nullable|email',
            'pembimbing_lapangan' => 'nullable|string|max:255',
        ]);

        try {
            $validated['status'] = 'approved'; 
            
            if (empty($validated['pembimbing_lapangan'])) {
                $validated['pembimbing_lapangan'] = 'Bagian HRD/Admin';
            }

            Perusahaan::create($validated);

            return redirect()->route('admin.perusahaan.index')
                ->with('success', "Perusahaan '{$request->nama}' berhasil ditambahkan dan otomatis aktif.");

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal simpan data: ' . $e->getMessage());
        }
    }

    public function show(Perusahaan $perusahaan)
    {
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
                    'nama'                => 'required|string|max:255',
                    'bidang_usaha'        => 'required|string|max:255',
                    'alamat'              => 'required|string',
                    'no_hp'               => 'required|string|max:20',
                    'kuota'               => 'required|integer|min:1',
                    'pembimbing_lapangan' => 'required|string|max:255',
                    'email'               => 'nullable|email',
                    'koordinat_lokasi'    => 'nullable|string',
                ]);

                
                $validated['status'] = 'approved';

                
                $perusahaan->update($validated);

                return redirect()->route('admin.perusahaan.index')
                    ->with('success', "Data '{$perusahaan->nama}' berhasil diperbarui dan otomatis aktif.");
            }

    public function destroy(Perusahaan $perusahaan)
    {
        if ($perusahaan->pendaftaran()->exists()) {
            return redirect()->back()->with('error', 'Gagal menghapus! Perusahaan ini masih memiliki siswa yang terdaftar PKL.');
        }

        $perusahaan->delete();

        return redirect()->route('admin.perusahaan.index')
            ->with('success', 'Perusahaan berhasil dihapus.');
    }


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