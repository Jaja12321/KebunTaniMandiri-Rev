<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiSawit extends Model
{
    use HasFactory;
    protected $table = 'lokasi_sawit';

    // Fillable fields for mass assignment
    protected $fillable = [
        'nama_lokasi',
        'luas_lahan',
        'jenis_tanaman',
        'kondisi_tanaman',
        'latitude',
        'longitude',
    ];

    // One-to-many relationship between LokasiSawit and Panen
    public function panen()
    {
        return $this->hasMany(Panen::class); // Satu lokasi bisa memiliki banyak panen
    }

    public function rekapKerja()
    {
        return $this->hasMany(RekapKerja::class, 'lokasi_sawit_id');
    }
}




