<?php

namespace App\Http\Controllers;

use App\Models\LokasiSawit;
use Illuminate\Http\Request;

class LokasiSawitController extends Controller
{
    // Menampilkan daftar lokasi sawit
    public function index()
    {
        // Ambil semua data lokasi sawit
        $lokasi_sawit = LokasiSawit::all();
        return view('lokasi_sawit.index', compact('lokasi_sawit'));
    }

    // Menampilkan form tambah lokasi sawit
    public function create()
    {
        return view('lokasi_sawit.create');
    }

    // Menyimpan data lokasi sawit
    public function store(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'jenis_tanaman' => 'required|string|max:255',
            'kondisi_tanaman' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Simpan data lokasi sawit ke database
        LokasiSawit::create($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('lokasi_sawit.index')->with('success', 'Lokasi sawit berhasil ditambahkan!');
    }

    // Menampilkan form edit lokasi sawit
    public function edit($id)
    {
        $lokasiSawit = LokasiSawit::findOrFail($id);
        return view('lokasi_sawit.edit', compact('lokasiSawit'));
    }

    // Memperbarui data lokasi sawit
    public function update(Request $request, $id)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'jenis_tanaman' => 'required|string|max:255',
            'kondisi_tanaman' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $lokasiSawit = LokasiSawit::findOrFail($id);
        $lokasiSawit->update($validatedData);

        return redirect()->route('lokasi_sawit.index')->with('success', 'Lokasi sawit berhasil diperbarui!');
    }

    // Menghapus data lokasi sawit
    public function destroy($id)
    {
        $lokasiSawit = LokasiSawit::findOrFail($id);
        $lokasiSawit->delete();

        return redirect()->route('lokasi_sawit.index')->with('success', 'Lokasi sawit berhasil dihapus!');
    }
}
