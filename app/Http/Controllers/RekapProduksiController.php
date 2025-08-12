<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panen;
use App\Models\LokasiSawit;
use Carbon\Carbon;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapProduksiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input filter bulan & tahun, default ke bulan & tahun sekarang
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Ambil semua lokasi sawit, urut berdasarkan nama lokasi
        $lokasiSawits = LokasiSawit::orderBy('nama_lokasi')->get();

        // Query produksi per lokasi & termin sesuai bulan & tahun
        $produksiData = Panen::select(
            'lokasi_sawit_id',
            'termin',
            DB::raw('SUM(berat) as total_berat')
        )
        ->whereYear('tanggal', $tahun)
        ->whereMonth('tanggal', $bulan)
        ->groupBy('lokasi_sawit_id', 'termin')
        ->get()
        ->groupBy('lokasi_sawit_id');

        // Total berat per termin untuk bulan & tahun terpilih
        $totalTermin = Panen::select('termin', DB::raw('SUM(berat) as total_berat'))
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->groupBy('termin')
            ->pluck('total_berat', 'termin')
            ->toArray();

        // Total produksi keseluruhan
        $totalProduksi = Panen::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->sum('berat');

        // Kirim data ke view
        return view('rekap.index', compact('lokasiSawits', 'produksiData', 'totalTermin', 'totalProduksi', 'bulan', 'tahun'));
    }
    public function cetakPDF(Request $request)
{
    $bulan = $request->bulan ?? date('m');
    $tahun = $request->tahun ?? date('Y');

    $lokasiSawits = LokasiSawit::all();

    $produksiData = Panen::whereYear('tanggal', $tahun)
        ->whereMonth('tanggal', $bulan)
        ->select('lokasi_sawit_id', 'termin', DB::raw('SUM(berat) as total_berat'))
        ->groupBy('lokasi_sawit_id', 'termin')
        ->get()
        ->groupBy('lokasi_sawit_id');

    $totalTermin = [
        'Termin 1' => Panen::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->where('termin', 'Termin 1')->sum('berat'),
        'Termin 2' => Panen::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->where('termin', 'Termin 2')->sum('berat'),
        'Termin 3' => Panen::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->where('termin', 'Termin 3')->sum('berat'),
    ];
    $totalProduksi = array_sum($totalTermin);

    $pdf = PDF::loadView('rekap.pdf', compact('lokasiSawits', 'produksiData', 'totalTermin', 'totalProduksi', 'bulan', 'tahun'));
    return $pdf->stream('rekap_panen_'.$bulan.'_'.$tahun.'.pdf');
}
}
