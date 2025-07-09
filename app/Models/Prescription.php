<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'resep_dokter';

    protected $fillable = [
        'no_resep',
        'tanggal_resep',
        'nama_dokter',
        'rumah_sakit',
        'nama_pasien',
    ];
}
