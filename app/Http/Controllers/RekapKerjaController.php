<?php

namespace App\Http\Controllers;

use App\Models\RekapKerja;
use App\Models\Karyawan;
use App\Models\LokasiSawit;
use App\Models\Hutang;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapKerjaController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $search = $request->input('search'); // Menerima input pencarian

        $karyawans = Karyawan::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('nama_lengkap', 'like', '%' . $search . '%');
            })
            ->paginate(10); // Menambahkan paginate

        return view('rekap_kerja.index', compact('karyawans', 'bulan', 'tahun'));
    }

    public function create($karyawan_id)
    {
        $karyawan = Karyawan::findOrFail($karyawan_id);
        $lokasiSawit = LokasiSawit::all();
        $karyawans = Karyawan::where('status', 'Aktif')->get(); // Hanya menampilkan karyawan yang aktif
        return view('rekap_kerja.create', compact('karyawan', 'lokasiSawit', 'karyawans'));
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'karyawan_id'      => 'required|exists:karyawans,id',
            'tanggal'          => 'required|date',
            'jenis_kerjaan'    => 'required|string|max:255',
            'banyak'           => 'required|string',
            'upah'             => 'required|numeric',
            'lokasi_sawit_id'  => 'required|exists:lokasi_sawit,id',
            'pembantu_id'      => 'nullable|exists:karyawans,id',  // Pembantu id bisa null
        ]);

        // Parse 'banyak' to numeric
        $banyakAngka = preg_replace('/[^0-9.,]/', '', $validated['banyak']);
        $banyakAngka = str_replace(',', '.', $banyakAngka);
        $banyakAngka = floatval($banyakAngka);

        // Calculate 'jumlah' (amount)
        $jumlah = $banyakAngka * $validated['upah'];

        // Save Rekap Kerja
        RekapKerja::create([
            'karyawan_id' => $validated['karyawan_id'],
            'tanggal' => $validated['tanggal'],
            'jenis_kerjaan' => $validated['jenis_kerjaan'],
            'banyak' => $validated['banyak'],
            'upah' => $validated['upah'],
            'jumlah' => $jumlah,
            'lokasi_sawit_id' => $validated['lokasi_sawit_id'],
            'pembantu_id' => $validated['pembantu_id'],  // Save the helper (if any)
        ]);

        return redirect()->route('rekap_kerja.index')->with('success', 'Rekap kerja berhasil ditambahkan!');
    }

    public function detail($id, Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $selectedBulan = $bulan;
        $selectedTahun = $tahun;

        // Find the employee
        $karyawan = Karyawan::findOrFail($id);

        // Retrieve the work data for the specified month and year
        $kerja = RekapKerja::where('karyawan_id', $id)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->with('lokasiSawit', 'pembantu')  // Include the 'pembantu' relationship
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tanggal' => $item->tanggal,
                    'jenis' => 'Kerja',
                    'jenis_kerjaan' => $item->jenis_kerjaan,
                    'lokasi' => optional($item->lokasiSawit)->nama_lokasi,
                    'banyak' => $item->banyak,
                    'upah' => $item->upah,
                    'jumlah' => $item->jumlah,
                    'pembantu' => optional($item->pembantu)->nama_lengkap, // Display the helper's name
                ];
            });

        // Retrieve the overtime data (lembur)
        $lembur = Kehadiran::where('karyawan_id', $id)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->where('jam_lembur', '>', 0)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => null,
                    'tanggal' => $item->tanggal,
                    'jenis' => 'Lembur',
                    'jenis_kerjaan' => 'Lembur',
                    'lokasi' => null,
                    'banyak' => number_format($item->jam_lembur, 2) . ' jam',
                    'upah' => $item->gaji_lembur,
                    'jumlah' => $item->total_gaji_lembur,
                ];
            });

        // Merge kerja and lembur data, then sort by date
        $rekapGabungan = $kerja->merge($lembur)->sortBy('tanggal')->values();

        // Calculate the totals for salary, overtime, and debt
        $totalGajiKerja = $kerja->sum('jumlah');
        $totalLembur = $lembur->sum('jumlah');
        $totalGaji = $totalGajiKerja + $totalLembur;

        // Calculate total debt and remaining salary
        $totalHutang = Hutang::where('karyawan_id', $id)->sum('jumlah');
        $sisaGaji = $totalGaji - $totalHutang;

        return view('rekap_kerja.detail', compact(
            'rekapGabungan', 'karyawan', 'bulan', 'tahun', 'selectedBulan', 'selectedTahun',
            'totalGajiKerja', 'totalLembur', 'totalGaji', 'totalHutang', 'sisaGaji'
        ));
    }

    public function storeHutang(Request $request)
    {
        if (!Auth::user()->hasRole('mandor')) {
            abort(403);
        }

        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'jumlah'      => 'required|numeric|min:1',
            'keterangan'  => 'nullable|string|max:255',
            'tanggal'     => 'required|date',
        ]);

        $jumlah = (int) preg_replace('/[^0-9]/', '', $validated['jumlah']);

        Hutang::create([
            'karyawan_id' => $validated['karyawan_id'],
            'jumlah'      => $jumlah,
            'keterangan'  => $validated['keterangan'] ?? null,
            'tanggal'     => $validated['tanggal'],
        ]);

        return back()->with('success', 'Hutang berhasil ditambahkan!');
    }

    public function kurangiHutang(Request $request, $karyawan_id)
    {
        if (!Auth::user()->hasRole('mandor')) {
            abort(403);
        }

        $validated = $request->validate([
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $jumlah = preg_replace('/[^0-9]/', '', $validated['jumlah']);

        Hutang::create([
            'karyawan_id' => $karyawan_id,
            'jumlah' => -$jumlah,
            'tanggal' => $validated['tanggal'],
            'keterangan' => $validated['keterangan'] ?? 'Pengurangan hutang',
        ]);

        return back()->with('success', 'Hutang berhasil dikurangi!');
    }

    public function formHutang($id)
    {
        if (!Auth::user()->hasRole('mandor')) {
            abort(403);
        }

        $karyawan = Karyawan::findOrFail($id);
        return view('rekap_kerja.form_hutang', compact('karyawan'));
    }

    public function prosesHutang(Request $request)
    {
        if (!Auth::user()->hasRole('mandor')) {
            abort(403);
        }

        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'jumlah'      => 'required|numeric|min:1',
            'tanggal'     => 'required|date',
            'keterangan'  => 'nullable|string|max:255',
            'tipe'        => 'required|in:tambah,kurangi',
        ]);

        $jumlah = (int) preg_replace('/[^0-9]/', '', $validated['jumlah']);

        if ($validated['tipe'] === 'kurangi') {
            $jumlah = -$jumlah;
        }

        Hutang::create([
            'karyawan_id' => $validated['karyawan_id'],
            'jumlah'      => $jumlah,
            'tanggal'     => $validated['tanggal'],
            'keterangan'  => $validated['keterangan'] ?? ($validated['tipe'] === 'kurangi' ? 'Pengurangan hutang' : 'Tambah hutang'),
        ]);

        return redirect()->route('rekap_kerja.detail', $validated['karyawan_id'])
                         ->with('success', 'Transaksi hutang berhasil disimpan.');
    }

    // Method to generate Rekap Kerja PDF
    public function generateRekapKerjaPDF(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $rekapKerja = RekapKerja::where('karyawan_id', $id)
            ->whereYear('tanggal', $request->input('tahun', date('Y')))
            ->whereMonth('tanggal', $request->input('bulan', date('m')))
            ->get();

        // Calculate total salary, overtime, and debt
        $totalGajiKerja = $rekapKerja->sum('jumlah');
        $totalLembur = Kehadiran::where('karyawan_id', $id)
            ->whereYear('tanggal', $request->input('tahun', date('Y')))
            ->whereMonth('tanggal', $request->input('bulan', date('m')))
            ->sum('total_gaji_lembur');
        $totalGaji = $totalGajiKerja + $totalLembur;

        // Calculate total debt
        $totalHutang = Hutang::where('karyawan_id', $id)->sum('jumlah');
        $sisaGaji = $totalGaji - $totalHutang;

        $data = [
            'nama_lengkap' => $karyawan->nama_lengkap,
            'bulan' => $request->input('bulan', date('m')),
            'tahun' => $request->input('tahun', date('Y')),
            'rekapKerja' => $rekapKerja,
            'totalGaji' => $totalGaji,
            'totalHutang' => $totalHutang,
            'sisaGaji' => $sisaGaji,
        ];

        $pdf = PDF::loadView('rekap_kerja.detail_rekap_kerja_pdf', $data);
        return $pdf->download('rekap_kerja_' . $karyawan->nama_lengkap . '.pdf');
    }
}
