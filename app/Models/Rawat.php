<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rawat extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'rawats';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'name', 'banyak', 'harga', 'jumlah', 'keterangan', 'tanggal'
    ];

    // Menonaktifkan timestamp jika tidak digunakan
    public $timestamps = true;

    // Mengatur format tanggal
    protected $dates = ['created_at', 'updated_at', 'tanggal'];
}
