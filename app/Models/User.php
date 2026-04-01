<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// WAJIB IMPORT MODEL-MODEL RELASINYA DI SINI
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\NilaiPkl;

class User extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'guru_id',
        'nilai_akademik', 
        'nilai_instansi', 
        'hasil_prediksi', 
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

    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->role === 'guru') {
                $user->guru()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama' => $user->name, 
                        'nip' => 'PENDING-' . $user->id,
                        'program_studi' => 'Belum Diatur'
                    ]
                );
            } elseif ($user->role === 'siswa') {
                $user->siswa()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama' => $user->name, 
                        'nim' => 'PENDING-' . $user->id,
                        'program_studi' => 'Belum Diatur',
                        'kelas' => '-',
                        'semester' => '1'
                    ]
                );
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Utama
    |--------------------------------------------------------------------------
    */

    public function siswa(): HasOne
    {
        return $this->hasOne(Siswa::class, 'user_id', 'id');
    }

    public function nilaiPkl(): HasOneThrough
    {
        return $this->hasOneThrough(
            \App\Models\NilaiPkl::class, // Pakai backslash di depan
            \App\Models\Siswa::class,    // Pakai backslash di depan
            'user_id',
            'siswa_id',
            'id',
            'id'
        );
    }
    
    public function guru(): HasOne
    {
        return $this->hasOne(Guru::class, 'user_id', 'id');
    }


    /*
    |--------------------------------------------------------------------------
    | Alias & Helper
    |--------------------------------------------------------------------------
    */
    public function guru_profile(): HasOne { return $this->guru(); }
    public function siswa_profile(): HasOne { return $this->siswa(); }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isGuru(): bool { return $this->role === 'guru'; }
    public function isSiswa(): bool { return $this->role === 'siswa'; }
}