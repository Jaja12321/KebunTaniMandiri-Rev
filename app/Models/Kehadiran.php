<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kehadiran extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'kehadirans';

    // Specify the fillable columns (Mass Assignment)
    protected $fillable = [
        'karyawan_id', 
        'tanggal', 
        'status', 
        'waktu_masuk', 
        'waktu_keluar', 
        'jam_kerja', 
        'jam_lembur',
        'gaji_lembur', 
        'total_gaji_lembur', // Column to store overtime pay
    ];

    // Relationship with the Karyawan model
    // In App\Models\Kehadiran.php
public function karyawan()
{
    return $this->belongsTo(Karyawan::class, 'karyawan_id'); // Make sure 'karyawan_id' matches the foreign key
}

    // Scope to filter data by today's date
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', Carbon::today()->toDateString()); // Filters by today's date
    }

    // Calculate overtime hours and overtime pay
    public function hitungJamLembur()
    {
        // Ensure that both 'waktu_masuk' and 'waktu_keluar' exist and are properly formatted
        if (!$this->waktu_masuk || !$this->waktu_keluar) {
            // You can log this or handle differently depending on your application logic
            return response()->json(['error' => 'Waktu masuk dan waktu keluar harus diisi.'], 400);
        }

        try {
            // Create Carbon instances for 'waktu_masuk' and 'waktu_keluar'
            $waktu_masuk = Carbon::createFromFormat('H:i', $this->waktu_masuk);
            $waktu_keluar = Carbon::createFromFormat('H:i', $this->waktu_keluar);

            // If 'waktu_keluar' is before 'waktu_masuk', assume the checkout is the next day
            if ($waktu_keluar < $waktu_masuk) {
                $waktu_keluar->addDay();
            }

            // Calculate total work hours (including fractional hours)
            $jam_kerja = $waktu_masuk->diffInHours($waktu_keluar) + ($waktu_masuk->diffInMinutes($waktu_keluar) % 60) / 60;
            $this->jam_kerja = $jam_kerja;

            // Calculate overtime hours if total work hours are more than 8
            $jam_lembur = 0;
            if ($jam_kerja > 8) {
                $jam_lembur = $jam_kerja - 8; // Overtime hours
            }

            // Calculate overtime pay (for example, Rp 50,000 per overtime hour)
            $overtimeRate = 50000; // Overtime rate per hour
            $gaji_lembur = $jam_lembur * $overtimeRate;

            // Save overtime hours and overtime pay
            $this->jam_lembur = $jam_lembur;
            $this->gaji_lembur = $gaji_lembur;

            // Save changes to the database
            $this->save();
        } catch (\Exception $e) {
            // Log error or handle it gracefully
            \Log::error('Error calculating overtime: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to calculate overtime.'], 500);
        }
    }
}
