<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminGuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with('user');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('nip', 'like', "%$search%")
                    ->orWhere('program_studi', 'like', "%$search%");
            });
        }
        
        $guru = $query->latest()->paginate(8)->appends($request->only('search'));
        return view('admin.guru.index', compact('guru'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:guru,nip',
            'email' => 'required|email|unique:users,email',
            'program_studi' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                
                'password' => Hash::make(trim($request->nip)), 
                'role' => 'guru',
            ]);

          
            Guru::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'nip' => trim($request->nip),
                'program_studi' => $request->program_studi,
            ]);

            DB::commit();
            return redirect()->route('admin.guru.index')->with('success', 'Guru dan Akun berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambah data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:guru,nip,' . $guru->id,
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'program_studi' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            
            $guru->update([
                'nama' => $request->nama,
                'nip' => trim($request->nip),
                'program_studi' => $request->program_studi,
            ]);

            
            if ($guru->user_id) {
                $guru->user->update([
                    'name' => $request->nama,
                    'email' => $request->email,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        DB::beginTransaction();

        try {
            
            if ($guru->user_id) {
                User::destroy($guru->user_id);
            }
            
            $guru->delete();

            DB::commit();
            return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }
    }
}