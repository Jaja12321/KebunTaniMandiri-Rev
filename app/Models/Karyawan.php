<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    // Define the table name if it's not the default 'karyawans'
    protected $table = 'karyawans';

    // If the primary key column is not 'id', define it like this
    // protected $primaryKey = 'your_primary_key_column';

    // If timestamps are not named 'created_at' and 'updated_at', define them like this
    // const CREATED_AT = 'your_created_at_column';
    // const UPDATED_AT = 'your_updated_at_column';

    // Fillable attributes to allow mass assignment
    protected $fillable = [
        'nama_lengkap', 
        'jabatan', 
        'status', 
        'nomor_telepon', 
        'alamat'
    ];

    // Define the relationship between Karyawan and Kehadiran (One to Many)
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class);
    }

    // Define the relationship between Karyawan and RekapKerja (One to Many)
    public function rekapKerja()
    {
        return $this->hasMany(RekapKerja::class, 'karyawan_id');
    }

    // Define the relationship between Karyawan and Hutang (One to Many)
    public function hutang()
    {
        return $this->hasMany(Hutang::class);
    }
}
