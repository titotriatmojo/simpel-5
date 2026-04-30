<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTraining extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model.
     * Secara default Laravel akan menganggap namanya 'data_trainings'.
     */
    protected $table = 'data_trainings';

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'nama',
        'nilai_pkl',
        'nilai_sidang',
        'nilai_total',
        'label',
    ];

    /**
     * Konversi tipe data otomatis (Casting).
     * Memastikan nilai yang ditarik dari DB bertipe numerik untuk kebutuhan KNN.
     */
    protected $casts = [
        'nilai_pkl'   => 'float',
        'nilai_sidang'   => 'float',
        'nilai_total' => 'float',
    ];
}