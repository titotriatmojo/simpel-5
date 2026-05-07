<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTraining extends Model
{
    use HasFactory;

    protected $table = 'data_trainings';

    protected $fillable = [
        'nama',
        'nilai_pkl',
        'nilai_sidang',
        'nilai_total',
        'label',
    ];

    protected $casts = [
        'nilai_pkl'   => 'float',
        'nilai_sidang'   => 'float',
        'nilai_total' => 'float',
    ];
}