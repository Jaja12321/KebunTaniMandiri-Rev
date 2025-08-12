<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Rawat;
use App\Models\RekapKerja;
use App\Models\Panen;

class LaporanBulananController extends Controller
{
    // Menampilkan laporan di halaman web
    public function index(Request $request)
    {
        // Mengambil bulan dan tahun dari request atau menggunakan bulan dan tahun saat ini
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // Mengambil data pengeluaran operasional dari tabel rawats dan rekap_kerja
        $rawat = Rawat::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
        $rekapKerja = RekapKerja::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();

        // Mengambil data hasil panen dari tabel panens
        $panen = Panen::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();

        // Mengirim data bulan, tahun, dan hasil query ke view
        return view('laporan_bulanan.index', compact('bulan', 'tahun', 'rawat', 'rekapKerja', 'panen'));
    }

    // Menyediakan file PDF untuk laporan bulanan
    public function cetak(Request $request)
    {
        // Mengambil bulan dan tahun dari request atau menggunakan bulan dan tahun saat ini
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // Mengambil data pengeluaran operasional dari tabel rawats dan rekap_kerja
        $rawat = Rawat::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
        $rekapKerja = RekapKerja::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();

        // Mengambil data hasil panen dari tabel panens
        $panen = Panen::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();

        // Menggunakan DomPDF untuk menghasilkan file PDF
        $pdf = Pdf::loadView('laporan_bulanan.pdf', compact('bulan', 'tahun', 'rawat', 'rekapKerja', 'panen'));

        // Mengunduh file PDF
        return $pdf->download("Laporan-Bulanan-$bulan-$tahun.pdf");
    }
}
