<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranPkl extends Model
{
    protected $table = 'pendaftaran_pkl';

    protected $fillable = [
        'siswa_id',
        'perusahaan_id',
        'guru_id', 
        'bidang_pkl',
        'periode',
        'status',
    ];

    public function guru() {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
}