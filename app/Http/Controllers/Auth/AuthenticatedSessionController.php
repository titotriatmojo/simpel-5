<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = null;

        // 1. Cek apakah login pake EMAIL (Universal untuk Admin/Guru/Siswa)
        if (filter_var($request->login, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->login)->first();
        } 
        
        // 2. Cek apakah login pake NIM (Siswa) - Jika belum ketemu pake email
        if (!$user) {
            $siswa = Siswa::where('nim', $request->login)->first();
            if ($siswa) $user = $siswa->user;
        }

        // 3. Cek apakah login pake NIP (Guru) - Jika belum ketemu juga
        if (!$user) {
            $guru = Guru::where('nip', $request->login)->first();
            if ($guru) $user = $guru->user;
        }

        // VERIFIKASI AKHIR
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withInput()->withErrors([
                'login' => 'Kredensial tidak cocok dengan data kami.',
            ]);
        }

        // Validasi Tambahan: Pastikan profil ada (Auto-fix jika hilang)
        $this->ensureProfileExists($user);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/redirect');
    }

    /**
     * Mencegah error "Profil Hilang" saat runtime
     */
    private function ensureProfileExists($user)
    {
        if ($user->role === 'guru' && !$user->guru_profile) {
            $user->guru_profile()->create(['nama' => $user->name, 'nip' => '-']);
        }
        if ($user->role === 'siswa' && !$user->siswa_profile) {
            $user->siswa_profile()->create(['nama' => $user->name, 'nisn' => '-']);
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}