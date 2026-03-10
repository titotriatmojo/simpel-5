<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perusahaan extends Model
{
    use HasFactory;

    /**
     * Nama tabel eksplisit karena tidak menggunakan plural standar Laravel (perusahaans)
     */
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

    /**
     * RELASI UTAMA: Menghitung Siswa Aktif
     * Karena data penempatan ada di tabel pendaftaran_pkl,
     * kita gunakan ini untuk ->withCount('pendaftaran') di Controller.
     */
    public function pendaftaran(): HasMany
    {
        return $this->hasMany(PendaftaranPkl::class, 'perusahaan_id');
    }

    /**
     * Relasi ke Laporan PKL
     */
    public function laporanPkl(): HasMany
    {
        return $this->hasMany(LaporanPkl::class, 'perusahaan_id');
    }

    /**
     * Relasi ke Siswa (PENGUSUL/INPUTER)
     * Untuk mengetahui siapa siswa yang pertama kali mendaftarkan instansi ini.
     */
    public function pengusul(): BelongsTo
    {
        // Saya ganti nama fungsinya jadi 'pengusul' agar tidak tertukar dengan list siswa PKL
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Alias untuk memudahkan pemanggilan jika kamu tetap ingin pakai nama 'siswas'
     */
    public function siswas(): HasMany
    {
        return $this->pendaftaran();
    }
}