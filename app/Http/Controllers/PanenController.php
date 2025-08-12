<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\LokasiSawit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PanenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
{
    $query = Panen::with('lokasiSawit');
    $filterInfo = null;

    if ($request->filled('bulan') && $request->filled('tahun')) {
        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;

        // Menambahkan kondisi filter bulan dan tahun
        $query->whereMonth('tanggal', $bulan)
              ->whereYear('tanggal', $tahun);

        // Menyusun informasi filter
        $filterInfo = 'Bulan ' . Carbon::create()->month($bulan)->translatedFormat('F') . ' ' . $tahun;

        // Cek jika tanggal juga ada di request
        if ($request->filled('tanggal')) {
            $tanggal = (int) $request->tanggal;
            $query->whereDay('tanggal', $tanggal);
            $filterInfo = 'Tanggal ' . $tanggal . ' ' . $filterInfo;
        }

    } else {
        // Default: tampilkan data bulan ini
        $today = Carbon::today();
        $query->whereMonth('tanggal', $today->month)
              ->whereYear('tanggal', $today->year);

        $filterInfo = 'Bulan ini (' . $today->translatedFormat('F Y') . ')';
    }

    $panen = $query->orderBy('tanggal', 'desc')->paginate(10);
    $message = $panen->isEmpty() ? "Data tidak ditemukan untuk: $filterInfo" : null;

    // Total berat dan nilai panen
    $totalBerat = $panen->sum('berat');
    $totalNilai = $panen->sum('total_nilai');

    // Pass the selected month to the view
    $selectedBulan = $request->bulan; // For the month filter
    $selectedTahun = $request->tahun; // For the year filter

    // Mengirimkan data ke view
    return view('panen.index', compact('panen', 'filterInfo', 'message', 'totalBerat', 'totalNilai', 'selectedBulan', 'selectedTahun'));
}



    public function create()
    {
        $this->authorizeMandor();

        $lokasiSawit = LokasiSawit::all();
        return view('panen.create', compact('lokasiSawit'));
    }

    public function store(Request $request)
    {
        $this->authorizeMandor();

        $validated = $request->validate([
            'lokasi_sawit_id' => 'required|exists:lokasi_sawit,id',
            'tanggal'         => 'required|date',
            'berat'           => 'required|numeric',
            'harga_tbs'       => 'required|string',
            'termin'          => 'nullable|string',
        ]);

        $hargaTbs = floatval(str_replace(',', '.', str_replace('.', '', $validated['harga_tbs'])));
        $totalNilai = $validated['berat'] * $hargaTbs;

        Panen::create([
            'lokasi_sawit_id' => $validated['lokasi_sawit_id'],
            'tanggal'         => Carbon::parse($validated['tanggal']),
            'berat'           => $validated['berat'],
            'harga_tbs'       => $hargaTbs,
            'total_nilai'     => $totalNilai,
            'termin'          => $validated['termin'] ?? null,
        ]);

        return redirect()->route('panen.index')->with('success', 'Panen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorizeMandor();

        $panen = Panen::findOrFail($id);
        $lokasiSawit = LokasiSawit::all();
        return view('panen.edit', compact('panen', 'lokasiSawit'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeMandor();

        $validated = $request->validate([
            'lokasi_sawit_id' => 'required|exists:lokasi_sawit,id',
            'tanggal'         => 'required|date',
            'berat'           => 'required|numeric',
            'harga_tbs'       => 'required|string',
            'termin'          => 'nullable|string',
        ]);

        $hargaTbs = floatval(str_replace(',', '.', str_replace('.', '', $validated['harga_tbs'])));
        $totalNilai = $validated['berat'] * $hargaTbs;

        $panen = Panen::findOrFail($id);
        $panen->update([
            'lokasi_sawit_id' => $validated['lokasi_sawit_id'],
            'tanggal'         => Carbon::parse($validated['tanggal']),
            'berat'           => $validated['berat'],
            'harga_tbs'       => $hargaTbs,
            'total_nilai'     => $totalNilai,
            'termin'          => $validated['termin'] ?? null,
        ]);

        return redirect()->route('panen.index')->with('success', 'Panen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeMandor();

        $panen = Panen::findOrFail($id);
        $panen->delete();

        return redirect()->route('panen.index')->with('success', 'Panen berhasil dihapus.');
    }

    /**
     * Helper untuk memastikan hanya mandor yang bisa akses method tertentu.
     */
    private function authorizeMandor()
    {
        if (!auth()->user()->hasRole('mandor')) {
            abort(403, 'Anda tidak diizinkan melakukan aksi ini.');
        }
    }
}
