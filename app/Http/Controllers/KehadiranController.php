<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    // Menampilkan data kehadiran dengan filter tanggal
    public function index(Request $request)
{
    $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

    // Ambil semua karyawan dengan paginasi, beserta kehadirannya pada tanggal yang dipilih
    $karyawans = Karyawan::with(['kehadiran' => function ($query) use ($tanggal) {
        $query->whereDate('tanggal', $tanggal); // Filter berdasarkan tanggal
    }])->orderBy('nama_lengkap')->paginate(10); // Paginasi ditambahkan

    return view('kehadiran.index', compact('karyawans', 'tanggal'));
}
    // Menampilkan form untuk menambah data kehadiran
   public function create(Request $request)
{
    // Get the employee data using the karyawan_id passed in the URL
    $karyawan = Karyawan::find($request->karyawan_id);

    // If no employee is found, you can handle it with an error or redirect
    if (!$karyawan) {
        return redirect()->route('kehadiran.index')->with('error', 'Karyawan tidak ditemukan');
    }

    // Pass the employee data to the view
    return view('kehadiran.create', compact('karyawan'));
}


    // Menyimpan data kehadiran yang baru
    public function store(Request $request)
    {
        $this->authorizeMandor();

        // Validasi data input
        $validated = $this->validateData($request);

        // Hitung jam kerja dan lembur
        [$jamKerja, $jamLembur, $totalGajiLembur] = $this->hitungJamDanLembur($validated);

        // Simpan data kehadiran
        Kehadiran::create(array_merge($validated, [
            'jam_kerja' => $jamKerja,
            'jam_lembur' => $jamLembur,
            'total_gaji_lembur' => $totalGajiLembur,
        ]));

        return redirect()->route('kehadiran.index')->with('success', 'Data kehadiran berhasil disimpan.');
    }

    public function history($karyawan_id)
{
    // Ambil karyawan dan semua data kehadirannya
    $karyawan = Karyawan::with('kehadiran')->findOrFail($karyawan_id);

    // Tampilkan halaman history kehadiran
    return view('kehadiran.history', compact('karyawan'));
}

    // Menampilkan form untuk mengedit data kehadiran
    public function edit($id)
    {
        $this->authorizeMandor();

        $kehadiran = Kehadiran::findOrFail($id);
        $karyawans = Karyawan::orderBy('nama_lengkap')->get();

        return view('kehadiran.edit', compact('kehadiran', 'karyawans'));
    }

    // Memperbarui data kehadiran
    public function update(Request $request, $id)
    {
        $this->authorizeMandor();

        $validated = $this->validateData($request);

        [$jamKerja, $jamLembur, $totalGajiLembur] = $this->hitungJamDanLembur($validated);

        // Update data kehadiran
        $kehadiran = Kehadiran::findOrFail($id);
        $kehadiran->update(array_merge($validated, [
            'jam_kerja' => $jamKerja,
            'jam_lembur' => $jamLembur,
            'total_gaji_lembur' => $totalGajiLembur,
        ]));

        return redirect()->route('kehadiran.index')->with('success', 'Data kehadiran berhasil diperbarui.');
    }

    // Menghapus data kehadiran
    public function destroy($id)
    {
        $this->authorizeMandor();

        $kehadiran = Kehadiran::findOrFail($id);
        $kehadiran->delete();

        return redirect()->route('kehadiran.index')->with('success', 'Data kehadiran berhasil dihapus.');
    }

    // Validasi input request untuk kehadiran
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

    // Menghitung jam kerja, jam lembur, dan total gaji lembur
    private function hitungJamDanLembur($data)
    {
        $waktuMasuk = Carbon::createFromFormat('H:i', $data['waktu_masuk']);
        $waktuKeluar = Carbon::createFromFormat('H:i', $data['waktu_keluar']);

        if ($waktuKeluar->lessThan($waktuMasuk)) {
            $waktuKeluar->addDay(); // jika shift malam
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

    // Mengecek apakah user memiliki role "mandor"
    private function authorizeMandor()
    {
        if (!auth()->user()->hasRole('mandor')) {
            abort(403, 'Anda tidak diizinkan untuk melakukan aksi ini.');
        }
    }

    
}
