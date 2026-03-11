<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiPkl extends Model
{
    protected $table = 'nilai_pkl';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'nilai',
    ];

    // Hubungkan ke Model Siswa (karena siswa_id = 1 di DB lo)
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Kalau guru_id di DB itu merujuk ke tabel gurus, arahkan ke Guru::class
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}