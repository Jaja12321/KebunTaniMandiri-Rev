<?php

// app/Http/Controllers/LaporanKeuanganController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panen;
use App\Models\RekapKerja;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // Import DomPDF

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $selectedBulan = $request->input('bulan', date('m'));
        $selectedTahun = $request->input('tahun', date('Y'));

        // Ambil data pendapatan dan pengeluaran
        $pendapatan = $this->getPendapatanData($selectedBulan, $selectedTahun);
        $pengeluaran = $this->getPengeluaranData($selectedBulan, $selectedTahun);

        // Hitung total pendapatan dan pengeluaran
        $totalPendapatan = $pendapatan->sum('jumlah');
        $totalPengeluaran = $pengeluaran->sum('jumlah');
        $selisih = $totalPendapatan - $totalPengeluaran;

        return view('laporan.keuangan', compact(
            'selectedBulan',
            'selectedTahun',
            'pendapatan',
            'pengeluaran',
            'totalPendapatan',
            'totalPengeluaran',
            'selisih'
        ));
    }

    // Mengambil data Pendapatan
    private function getPendapatanData($bulan, $tahun)
    {
        $panen = Panen::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get(['total_nilai as jumlah', 'tanggal', 'termin as keterangan'])
            ->map(function ($item) {
                return (object) [
                    'jenis' => 'Pendapatan',
                    'kategori' => 'Panen',
                    'jumlah' => $item->jumlah,
                    'tanggal' => $item->tanggal,
                    'keterangan' => 'Termin ' . $item->keterangan
                ];
            });

        return $panen;
    }

    // Mengambil data Pengeluaran
    private function getPengeluaranData($bulan, $tahun)
    {
        $rekapKerja = RekapKerja::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get(['jenis_kerjaan as name', 'jumlah', 'tanggal', 'keterangan'])
            ->map(function ($item) {
                return (object) [
                    'jenis' => 'Pengeluaran',
                    'kategori' => 'Rekap Kerja',
                    'jumlah' => $item->jumlah,
                    'tanggal' => $item->tanggal,
                    'keterangan' => $item->keterangan
                ];
            });

        $kehadiran = Kehadiran::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'jenis' => 'Pengeluaran',
                    'kategori' => 'Gaji Lembur',
                    'jumlah' => $item->total_gaji_lembur,
                    'tanggal' => $item->tanggal,
                    'keterangan' => $item->status
                ];
            });

        return $rekapKerja->concat($kehadiran);
    }

    // Menampilkan PDF laporan keuangan
    // LaporanKeuanganController.php

public function cetakPdf(Request $request)
{
    $selectedBulan = $request->input('bulan', date('m'));
    $selectedTahun = $request->input('tahun', date('Y'));

    $pendapatan = $this->getPendapatanData($selectedBulan, $selectedTahun);
    $pengeluaran = $this->getPengeluaranData($selectedBulan, $selectedTahun);

    $totalPendapatan = $pendapatan->sum('jumlah');
    $totalPengeluaran = $pengeluaran->sum('jumlah');
    $selisih = $totalPendapatan - $totalPengeluaran;

    // Prepare data for PDF
    $data = [
        'selectedBulan' => $selectedBulan,
        'selectedTahun' => $selectedTahun,
        'pendapatan' => $pendapatan,
        'pengeluaran' => $pengeluaran,
        'totalPendapatan' => $totalPendapatan,
        'totalPengeluaran' => $totalPengeluaran,
        'selisih' => $selisih,
        'tanggal' => Carbon::now()->format('d-m-Y') // Pass the current date as 'tanggal'
    ];

    // Generate PDF
    $pdf = PDF::loadView('laporan.keuangan_pdf', $data);
    return $pdf->stream('laporan-keuangan.pdf');
}

}
