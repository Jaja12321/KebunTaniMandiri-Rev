<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiSawit2 extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai dengan nama tabel di database
    protected $table = 'lokasi_sawit2';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_lokasi',
        'area',
        'area_size',
        'area_type',
        'coords',
        'color',
        'stroke_color',
        'stroke_width',
        'has_area'
    ];

    // Cast koordinat sebagai array
    protected $casts = [
        'coords' => 'array',
    ];

    // Jika menggunakan timestamps otomatis
    public $timestamps = true;
}





