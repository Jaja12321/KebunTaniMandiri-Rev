<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapKerja extends Model
{
    use HasFactory;

    protected $table = 'rekap_kerja';

    protected $fillable = [
    'karyawan_id',
    'tanggal',
    'jenis_kerjaan',
    'banyak',  // string sekarang
    'upah',
    'jumlah',
    'keterangan',
    'lokasi_sawit_id',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function lokasiSawit()
    {
        return $this->belongsTo(LokasiSawit::class);
    }
}
