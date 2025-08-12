<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KehadiranController extends Controller
{
  public function index(Request $request)
{
    $query = Kehadiran::with('karyawan')->orderBy('tanggal', 'desc');

    $tanggal = $request->input('tanggal');

    // Jika tanggal ada, filter penuh berdasarkan format Y-m-d
    if ($tanggal) {
        $query->whereDate('tanggal', $tanggal);
    }

    $kehadiran = $query->paginate(10);

    return view('kehadiran.index', compact('kehadiran', 'tanggal'));
}


    public function create()
    {
        $this->authorizeMandor();

        $karyawans = Karyawan::orderBy('nama_lengkap')->get();

        return view('kehadiran.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $this->authorizeMandor();

        $validated = $this->validateData($request);

        [$jamKerja, $jamLembur, $totalGajiLembur] = $this->hitungJamDanLembur($validated);

        Kehadiran::create(array_merge($validated, [
            'jam_kerja' => $jamKerja,
            'jam_lembur' => $jamLembur,
            'total_gaji_lembur' => $totalGajiLembur,
        ]));

        return redirect()->route('kehadiran.index')->with('success', 'Data kehadiran berhasil disimpan.');
    }

    public function edit($id)
    {
        $this->authorizeMandor();

        $kehadiran = Kehadiran::findOrFail($id);
        $karyawans = Karyawan::orderBy('nama_lengkap')->get();

        return view('kehadiran.edit', compact('kehadiran', 'karyawans'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeMandor();

        $validated = $this->validateData($request);

        [$jamKerja, $jamLembur, $totalGajiLembur] = $this->hitungJamDanLembur($validated);

        $kehadiran = Kehadiran::findOrFail($id);
        $kehadiran->update(array_merge($validated, [
            'jam_kerja' => $jamKerja,
            'jam_lembur' => $jamLembur,
            'total_gaji_lembur' => $totalGajiLembur,
        ]));

        return redirect()->route('kehadiran.index')->with('success', 'Data kehadiran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeMandor();

        $kehadiran = Kehadiran::findOrFail($id);
        $kehadiran->delete();

        return redirect()->route('kehadiran.index')->with('success', 'Data kehadiran berhasil dihapus.');
    }

    /**
     * Validasi input request.
     */
    private function validateData(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'status' => 'required|string|in:Hadir,Izin,Sakit',
            'waktu_masuk' => 'required|date_format:H:i',
            'waktu_keluar' => 'required|date_format:H:i',
            'gaji_lembur' => ['required', 'string'],
        ], [
            'waktu_masuk.date_format' => 'Format waktu masuk salah (H:i).',
            'waktu_keluar.date_format' => 'Format waktu keluar salah (H:i).',
        ]);

        // Bersihkan format ribuan dari gaji_lembur
        $validated['gaji_lembur'] = preg_replace('/[^\d]/', '', $validated['gaji_lembur']);

        if (!is_numeric($validated['gaji_lembur']) || intval($validated['gaji_lembur']) <= 0) {
            abort(422, 'Gaji lembur harus berupa angka lebih besar dari 0.');
        }

        return $validated;
    }

    /**
     * Hitung jam kerja, jam lembur, total gaji lembur.
     */
    private function hitungJamDanLembur($data)
    {
        $waktuMasuk = Carbon::createFromFormat('H:i', $data['waktu_masuk']);
        $waktuKeluar = Carbon::createFromFormat('H:i', $data['waktu_keluar']);

        if ($waktuKeluar->lessThan($waktuMasuk)) {
            $waktuKeluar->addDay(); // kalau shift malam
        }

        $jamKerja = $waktuMasuk->diffInMinutes($waktuKeluar) / 60;
        $jamLembur = max(0, $jamKerja - 8);
        $totalGajiLembur = $jamLembur * intval($data['gaji_lembur']);

        return [
            round($jamKerja, 2),
            round($jamLembur, 2),
            intval($totalGajiLembur)
        ];
    }

    /**
     * Mengecek apakah user punya role mandor.
     */
    private function authorizeMandor()
    {
        if (!auth()->user()->hasRole('mandor')) {
            abort(403, 'Anda tidak diizinkan untuk melakukan aksi ini.');
        }
    }
}
