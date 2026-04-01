<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bimbingan;
use App\Models\LaporanPkl;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nama',
        'nim',
        'program_studi',
        'kelas',
        'semester',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laporanPkl()
    {
        return $this->hasOne(LaporanPkl::class, 'siswa_id'); // sesuaikan foreign key-nya
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class);
    }

public function pendaftaranPkl()
{
    // Sesuaikan nama model pendaftaranmu
    return $this->hasOne(PendaftaranPkl::class, 'siswa_id'); 
}
    

    public function nilaiPkl()
    {
        return $this->hasOne(NilaiPkl::class);
    }
}