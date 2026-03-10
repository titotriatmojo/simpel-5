<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory;

    // Nama tabel di database (Manual biar gak nyari 'gurus')
    protected $table = 'guru';

    // Kolom yang boleh diisi
    protected $fillable = [
        'user_id', 
        'nama', 
        'nip', 
        'program_studi'
    ];

    /**
     * Relasi ke User (Satu Guru punya satu User Account)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Pendaftaran PKL (Satu Guru bisa membimbing banyak pendaftaran)
     */
    public function pendaftaranPkl()
    {
        return $this->hasMany(PendaftaranPkl::class, 'guru_id');
    }

    /**
     * Relasi ke Bimbingan
     */
    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'guru_id');
    }

    /**
     * Relasi ke Nilai PKL
     */
    public function nilaiPkl()
    {
        return $this->hasMany(NilaiPkl::class, 'guru_id');
    }
}