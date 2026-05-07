<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

// Middleware untuk membatasi akses berdasarkan role user
class RoleMiddleware
{

public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek login & role 
        if (Auth::check() && trim(Auth::user()->role) === $role) {
            return $next($request);
        }

        // Kalau gagal
        if (Auth::check()) {
            abort(403, 'Role User: ' . Auth::user()->role . ' | Role Dibutuhkan: ' . $role);
        }

        return redirect('/login');
    }
}