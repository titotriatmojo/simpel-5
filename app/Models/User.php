<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\NilaiPkl;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'guru_id',
        'nilai_pkl', 
        'nilai_sidang', 
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
            \App\Models\NilaiPkl::class, 
            \App\Models\Siswa::class,    
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