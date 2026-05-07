<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'user_id', 
        'nama', 
        'nip', 
        'program_studi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pendaftaranPkl()
    {
        return $this->hasMany(PendaftaranPkl::class, 'guru_id');
    }


    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'guru_id');
    }

    public function nilaiPkl()
    {
        return $this->hasMany(NilaiPkl::class, 'guru_id');
    }
}