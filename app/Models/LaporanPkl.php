<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPkl extends Model
{
    protected $table = 'laporan_pkl';

    protected $fillable = ['siswa_id', 'perusahaan_id', 'file', 'status','link_drive'];

    public function siswa() 
    {
    return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
}