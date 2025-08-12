<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id(); // Kolom ID sebagai primary key
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade'); // Relasi ke tabel karyawan
            $table->date('tanggal'); // Tanggal kehadiran
            $table->string('status', 50); // Status kehadiran (misalnya: hadir, izin, sakit)
            $table->time('waktu_masuk'); // Waktu masuk
            $table->time('waktu_keluar'); // Waktu keluar
            $table->decimal('jam_kerja', 5, 2); // Jumlah jam kerja
            $table->decimal('jam_lembur', 5, 2); // Jumlah jam lembur
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};
