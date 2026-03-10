<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

// Middleware untuk membatasi akses berdasarkan role user
class RoleMiddleware
{
    /**
     * Handle request dan cek role user.
     * Jika user login dan rolenya sesuai, lanjutkan request.
     * Jika tidak, tampilkan error 403 (Akses ditolak).
     */
public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek login & role (pake trim buat jaga-jaga spasi di database)
        if (Auth::check() && trim(Auth::user()->role) === $role) {
            return $next($request);
        }

        // Kalau gagal, kasih tau rolenya apa biar ketahuan salahnya dimana
        if (Auth::check()) {
            abort(403, 'Role User: ' . Auth::user()->role . ' | Role Dibutuhkan: ' . $role);
        }

        return redirect('/login');
    }
}