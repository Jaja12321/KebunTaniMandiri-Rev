<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\LokasiSawit;
use App\Models\LokasiSawit2;
use App\Models\Panen;
use App\Models\RekapKerja;
use App\Models\Kehadiran;
use App\Models\Rawat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Data summary
        $jumlahKaryawan = Karyawan::count();
        
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // Panen bulan ini
        $panenBulanIni = Panen::whereYear('tanggal', $tahunIni)
                            ->whereMonth('tanggal', $bulanIni)
                            ->sum('berat');

        // Total Pendapatan
        $totalPendapatan = Panen::sum('total_nilai');

        // Total Pengeluaran (menggunakan rekapan)
        $totalRekapKerja = RekapKerja::sum('jumlah');
        $totalGajiLembur = Kehadiran::sum('total_gaji_lembur');
        $totalRawat = Rawat::sum('jumlah');

        $totalPengeluaran = $totalRekapKerja + $totalGajiLembur + $totalRawat;

        // Kehadiran hari ini
        $kehadiranHariIni = Kehadiran::whereDate('tanggal', Carbon::today())
                                ->where('status', 'Hadir')
                                ->count();

        // Data chart produksi per bulan
        $produksiPerBulan = Panen::selectRaw('MONTH(tanggal) as bulan, SUM(berat) as total_berat')
                            ->whereYear('tanggal', $tahunIni)
                            ->groupBy('bulan')
                            ->orderBy('bulan')
                            ->get();

        // Data chart pendapatan per bulan
        $pendapatanPerBulan = Panen::selectRaw('MONTH(tanggal) as bulan, SUM(total_nilai) as total_pendapatan')
                                ->whereYear('tanggal', $tahunIni)
                                ->groupBy('bulan')
                                ->orderBy('bulan')
                                ->get();

        // Data chart pengeluaran per bulan (dari RekapKerja)
        $pengeluaranRekapKerja = RekapKerja::selectRaw('MONTH(tanggal) as bulan, SUM(jumlah) as total_pengeluaran')
                                           ->groupBy('bulan')
                                           ->orderBy('bulan')
                                           ->get();

        // Inisialisasi array pengeluaran per bulan
        $pengeluaranPerBulan = array_fill(1, 12, 0);  // Menggunakan indeks 1 hingga 12 untuk bulan

        // Data pengeluaran dari RekapKerja
        foreach ($pengeluaranRekapKerja as $item) {
            if (is_numeric($item->bulan) && $item->bulan >= 1 && $item->bulan <= 12) {
                $pengeluaranPerBulan[$item->bulan] += $item->total_pengeluaran;
            }
        }

        // Siapkan array label (bulan) dan data untuk chart
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Menyusun data untuk produksi, pendapatan, dan pengeluaran
        $produksiData = array_fill(0, 12, 0);
        foreach ($produksiPerBulan as $p) {
            $produksiData[$p->bulan - 1] = (float) $p->total_berat;
        }

        $pendapatanData = array_fill(0, 12, 0);
        foreach ($pendapatanPerBulan as $p) {
            $pendapatanData[$p->bulan - 1] = (float) $p->total_pendapatan;
        }

        // Menggunakan indeks bulan yang benar untuk pengeluaran
        $pengeluaranData = array_fill(0, 12, 0);
        foreach ($pengeluaranPerBulan as $i => $value) {
            $pengeluaranData[$i - 1] = $value;
        }

    
        return view('home', compact(
            'jumlahKaryawan',
            'panenBulanIni',
            'totalPendapatan',
            'totalPengeluaran',
            'kehadiranHariIni',
            'labels',
            'produksiData',
            'pendapatanData',
            'pengeluaranData',
        ));
    }
}
