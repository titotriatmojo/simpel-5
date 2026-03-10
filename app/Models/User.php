<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'guru_id', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * FITUR SAKTI: Auto-Create Profile (Self-Healing Version)
     */
    protected static function booted()
    {
        static::created(function ($user) {
            // Gunakan updateOrCreate biar gak duplikat kalau user dibuat ulang
            if ($user->role === 'guru') {
                $user->guru()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama' => $user->name, 
                        'nip' => 'PENDING-' . $user->id,
                        'program_studi' => 'Belum Diatur' // Fix error default value
                    ]
                );
            } elseif ($user->role === 'siswa') {
                $user->siswa()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama' => $user->name, 
                        'nim' => 'PENDING-' . $user->id,
                        'program_studi' => 'Belum Diatur', // Fix error default value
                        'kelas' => '-',               // Fix jika kolom ini NOT NULL
                        'semester' => '1'              // Fix jika kolom ini NOT NULL
                    ]
                );
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Profil
    |--------------------------------------------------------------------------
    */

    public function siswa(): HasOne
    {
        return $this->hasOne(Siswa::class, 'user_id', 'id');
    }

    public function guru(): HasOne
    {
        return $this->hasOne(Guru::class, 'user_id', 'id');
    }

    // Alias agar kodingan lama tetap jalan
    public function guru_profile(): HasOne { return $this->guru(); }
    public function siswa_profile(): HasOne { return $this->siswa(); }

    /*
    |--------------------------------------------------------------------------
    | Role Checkers
    |--------------------------------------------------------------------------
    */
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isGuru(): bool { return $this->role === 'guru'; }
    public function isSiswa(): bool { return $this->role === 'siswa'; }
}