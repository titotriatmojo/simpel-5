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

        // 1. Cek jika login pake Email
        if (filter_var($request->login, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->login)->first();
        } 
        
        // 2. Cek jika login pake NIM/NISN Siswa
        if (!$user) {
            $siswa = Siswa::where('nim', $request->login)->first();
            if ($siswa) $user = $siswa->user;
        }

        // 3. Cek jika login pake NIP Guru
        if (!$user) {
            $guru = Guru::where('nip', $request->login)->first();
            if ($guru) $user = $guru->user;
        }

        // 4. Cek Password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withInput()->withErrors([
                'login' => 'Kredensial tidak cocok dengan data kami.',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/redirect');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}