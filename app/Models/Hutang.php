<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    use HasFactory;

    
    protected $table = 'hutang'; // atau 'hutang' jika tabel Anda tanpa 's'

    protected $fillable = [
        'karyawan_id',
        'jumlah',
        'keterangan',
        'tanggal',
    ];

    // Relasi ke Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
