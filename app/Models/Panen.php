<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    use HasFactory;

    protected $table = 'panens';

    protected $fillable = [
        'lokasi_sawit_id',
        'tanggal',
        'berat',
        'harga_tbs',
        'total_nilai',
        'termin',
        'is_active',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'berat' => 'float',
        'harga_tbs' => 'integer',
        'total_nilai' => 'float',
        'is_active' => 'boolean',
    ];

    public function lokasiSawit()
    {
        return $this->belongsTo(LokasiSawit::class, 'lokasi_sawit_id');
    }
}
