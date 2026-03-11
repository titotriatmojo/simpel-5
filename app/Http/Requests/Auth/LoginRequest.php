<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Rules kita ubah: 'email' tidak boleh dipaksa format email, 
     * karena isinya bisa jadi NIP atau NISN.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'], // Dihapus filter 'email'-nya
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Logika autentikasi CUSTOM: Cari berdasarkan Email, NIP, atau NISN.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginValue = $this->input('email');
        $password = $this->input('password');

        // Cari User dengan logika:
        // 1. Cek kolom email di tabel users
        // 2. ATAU Cek NIP di tabel guru (lewat relasi)
        // 3. ATAU Cek NISN di tabel siswa (lewat relasi)
        $user = User::where('email', $loginValue)
            ->orWhereHas('guru', function ($query) use ($loginValue) {
                $query->where('nip', $loginValue);
            })
            ->orWhereHas('siswa', function ($query) use ($loginValue) {
                $query->where('nim', $loginValue);
            })
            ->first();

        // Verifikasi User dan Password
        if (! $user || ! Hash::check($password, $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Login kan user tersebut
        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}