<?php

namespace App\Http\Controllers;

use App\Models\Rawat;
use Illuminate\Http\Request;

class RawatController extends Controller
{
    // Menampilkan daftar Rawat dengan filter bulan dan tahun
    public function index(Request $request)
    {
        // Ambil data rawat dengan filter bulan dan tahun
        $rawats = Rawat::query()
                    ->when($request->bulan, function ($query) use ($request) {
                        // Memfilter data berdasarkan bulan
                        return $query->whereMonth('tanggal', $request->bulan);
                    })
                    ->when($request->tahun, function ($query) use ($request) {
                        // Memfilter data berdasarkan tahun
                        return $query->whereYear('tanggal', $request->tahun);
                    })
                    ->get();

        // Menghitung total banyak dan jumlah
        $totalBanyak = $rawats->sum('banyak');
        $totalJumlah = $rawats->sum('jumlah');

        // Mengirim data ke view
        return view('rawat.index', compact('rawats', 'totalBanyak', 'totalJumlah'));
    }

    // Menampilkan form tambah Rawat
    public function create()
    {
        return view('rawat.create');
    }

    // Menyimpan data Rawat baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'banyak' => 'required|numeric',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        // Menghitung jumlah berdasarkan banyak dan harga
        $jumlah = $request->banyak * $request->harga;

        // Menyimpan data rawat dengan jumlah yang sudah dihitung
        Rawat::create([
            'name' => $request->name,
            'banyak' => $request->banyak,
            'harga' => $request->harga,
            'jumlah' => $jumlah,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('rawat.index')->with('success', 'Data rawat berhasil ditambahkan.');
    }

    // Menampilkan form edit Rawat
    public function edit(Rawat $rawat)
    {
        return view('rawat.edit', compact('rawat'));
    }

    // Mengupdate data Rawat
    public function update(Request $request, Rawat $rawat)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'banyak' => 'required|numeric',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        // Menghitung jumlah berdasarkan banyak dan harga
        $jumlah = $request->banyak * $request->harga;

        // Update data rawat dengan jumlah yang sudah dihitung
        $rawat->update([
            'name' => $request->name,
            'banyak' => $request->banyak,
            'harga' => $request->harga,
            'jumlah' => $jumlah,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('rawat.index')->with('success', 'Data rawat berhasil diupdate.');
    }

    // Menghapus data Rawat
    public function destroy(Rawat $rawat)
    {
        // Menghapus data rawat
        $rawat->delete();

        return redirect()->route('rawat.index')->with('success', 'Data rawat berhasil dihapus.');
    }
}
