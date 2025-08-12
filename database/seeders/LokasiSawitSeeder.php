<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\LokasiSawit;

class LokasiSawitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data lokasi sawit berdasarkan peta dengan bentuk polygon yang akurat
        // Area dengan label "L=" diubah menjadi "LAHAN SAWIT MANIS MADU"
        $lokasiData = [
            [
                'nama_lokasi' => 'FAUZI',
                'luas_lahan' => 5.50,
                'jenis_tanaman' => 'LAHAN SAWIT MANIS MADU',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.541000,
                'longitude' => 103.096000,
            ],
            [
                'nama_lokasi' => 'BUJANG',
                'luas_lahan' => 12.99,
                'jenis_tanaman' => 'LAHAN SAWIT MANIS MADU',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.562000,
                'longitude' => 103.104000,
            ],
            [
                'nama_lokasi' => 'HUSNAK',
                'luas_lahan' => 2.60,
                'jenis_tanaman' => 'LAHAN SAWIT MANIS MADU',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.560000,
                'longitude' => 103.087000,
            ],
            [
                'nama_lokasi' => 'GINTING',
                'luas_lahan' => 40.09,
                'jenis_tanaman' => 'LAHAN SAWIT MANIS MADU',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.565000,
                'longitude' => 103.076000,
            ],
            [
                'nama_lokasi' => 'TONI',
                'luas_lahan' => 8.50,
                'jenis_tanaman' => 'Kelapa Sawit',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.538000,
                'longitude' => 103.083000,
            ],
            [
                'nama_lokasi' => 'SIANAK',
                'luas_lahan' => 6.75,
                'jenis_tanaman' => 'Kelapa Sawit',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.537000,
                'longitude' => 103.105000,
            ],
            [
                'nama_lokasi' => 'DAYAT',
                'luas_lahan' => 4.25,
                'jenis_tanaman' => 'Kelapa Sawit',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.551000,
                'longitude' => 103.103000,
            ],
            [
                'nama_lokasi' => 'NGADINO',
                'luas_lahan' => 5.80,
                'jenis_tanaman' => 'Kelapa Sawit',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.564000,
                'longitude' => 103.099000,
            ],
            [
                'nama_lokasi' => 'ADUN',
                'luas_lahan' => 3.40,
                'jenis_tanaman' => 'Kelapa Sawit',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.552000,
                'longitude' => 103.087000,
            ],
            [
                'nama_lokasi' => 'JON ALI',
                'luas_lahan' => 1.20,
                'jenis_tanaman' => 'Kelapa Sawit',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.547778, // Koordinat tepat yang diminta
                'longitude' => 103.092778, // Koordinat tepat yang diminta
            ],
            [
                'nama_lokasi' => 'MUSA',
                'luas_lahan' => 7.15,
                'jenis_tanaman' => 'Kelapa Sawit',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.575000,
                'longitude' => 103.088000,
            ],
            [
                'nama_lokasi' => 'SYAHRIL',
                'luas_lahan' => 4.90,
                'jenis_tanaman' => 'Kelapa Sawit',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.583000,
                'longitude' => 103.076000,
            ],
            [
                'nama_lokasi' => 'SADAT',
                'luas_lahan' => 6.30,
                'jenis_tanaman' => 'Kelapa Sawit',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.587000,
                'longitude' => 103.090000,
            ],
            [
                'nama_lokasi' => 'GINTING_EXTENSION',
                'luas_lahan' => 15.25,
                'jenis_tanaman' => 'Kelapa Sawit',
                'kondisi_tanaman' => 'Produktif',
                'latitude' => -1.578000,
                'longitude' => 103.070000,
            ],
        ];

        // Hapus data lama dengan aman (tanpa melanggar foreign key constraints)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        LokasiSawit::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insert data baru
        foreach ($lokasiData as $data) {
            LokasiSawit::create($data);
        }

        echo "✅ Data lokasi sawit berhasil di-seed berdasarkan peta Manis Madu!\n";
        echo "📊 Total lokasi: " . count($lokasiData) . " area\n";
        echo "🌿 Total luas: " . array_sum(array_column($lokasiData, 'luas_lahan')) . " hektar\n";
    }
}
