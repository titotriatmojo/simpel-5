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

    // INI YANG HARUS DIUBAH
public function siswa(): BelongsTo
{
    // Harus merujuk ke User, karena siswa_id berisi ID dari tabel users
    return $this->belongsTo(User::class, 'siswa_id');
}

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}