<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    /**
     * Mass Assignment
     */
    protected $fillable = [
        'nama', 
        'alamat', 
        'no_hp', 
        'email',
        'pembimbing_lapangan',
        'bidang_usaha',
        'koordinat_lokasi',
        'kuota',
        'status',
        'siswa_id' 
    ];

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(PendaftaranPkl::class, 'perusahaan_id');
    }

    public function laporanPkl(): HasMany
    {
        return $this->hasMany(LaporanPkl::class, 'perusahaan_id');
    }

    public function pengusul(): BelongsTo
    {
        // Saya ganti nama fungsinya jadi 'pengusul' agar tidak tertukar dengan list siswa PKL
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function siswas(): HasMany
    {
        return $this->pendaftaran();
    }
}