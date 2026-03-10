<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class AdminSiswaController extends Controller
{
    /**
     * Tampilkan daftar semua siswa.
     */
    public function index(Request $request)
    {
        $query = Siswa::with('user');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('nim', 'like', "%$search%")
                    ->orWhere('program_studi', 'like', "%$search%")
                    ->orWhere('kelas', 'like', "%$search%")
                    ->orWhere('semester', 'like', "%$search%")
                ;
            });
        }
        $siswa = $query->latest()->paginate(8)->appends($request->only('search'));

        return view('admin.siswa.index', compact('siswa'));
    }

    /**
     * Tampilkan form tambah siswa manual.
     */
    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Simpan data siswa baru (manual).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:siswa,nim',
            'program_studi' => 'required|string',
            'kelas' => 'required|string',
            'semester' => 'required|integer|min:1',
            'email' => 'required|email|unique:users,email',
        ]);

        // Buat akun user
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->nim),
            'role' => 'siswa',
        ]);

        // Buat entri siswa
        Siswa::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'nim' => $request->nim,
            'program_studi' => $request->program_studi,
            'kelas' => $request->kelas,
            'semester' => $request->semester,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit siswa.
     */
    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Perbarui data siswa.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:siswa,nim,' . $siswa->id,
            'program_studi' => 'required|string',
            'kelas' => 'required|string',
            'semester' => 'required|integer|min:1',
        ]);

        $siswa->update($request->only(['nama', 'nim', 'program_studi', 'kelas', 'semester']));

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus user terkait jika ada
        if ($siswa->user_id) {
            $user = User::find($siswa->user_id);
            if ($user) {
                $user->delete();
            }
        }

        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}