<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    // Tampilkan daftar karyawan dengan pagination
    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');
        
        // If there is a search term, filter the Karyawan model by name
        $karyawans = Karyawan::when($search, function ($query, $search) {
            return $query->where('nama_lengkap', 'like', '%' . $search . '%');
        })
        ->paginate(10);

        // Return the view with the filtered karyawans
        return view('karyawan.index', compact('karyawans'));
    }

    // Tampilkan form tambah karyawan
    public function create()
    {
        // hanya mandor
        $this->authorize('create karyawan');
        return view('karyawan.create');
    }

    // Simpan karyawan baru
    public function store(Request $request)
    {
        // hanya mandor
        $this->authorize('create karyawan');

        // Validasi input dari form
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'jabatan'        => 'required|string|max:255',
            'status'         => 'required|string|in:Harian,Borongan,Tetap', // Validasi status karyawan
            'nomor_telepon'  => 'required|string|max:15',
            'alamat'         => 'required|string|max:255',
        ]);

        // Jika jabatan adalah "Lainnya", simpan jabatan yang dimasukkan pengguna
        if ($request->jabatan == 'Lainnya') {
            $validated['jabatan'] = $request->jabatan_lain;
        }

        // Simpan data karyawan
        Karyawan::create($validated);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    // Tampilkan form edit karyawan
    public function edit($id)
    {
        // hanya mandor
        $this->authorize('update karyawan');

        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.edit', compact('karyawan'));
    }

    // Update data karyawan
    public function update(Request $request, $id)
    {
        // hanya mandor
        $this->authorize('update karyawan');

        // Validasi input dari form
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'jabatan'        => 'required|string|max:255',
            'status'         => 'required|string|in:Harian,Borongan,Tetap', // Validasi status karyawan
            'nomor_telepon'  => 'required|string|max:15',
            'alamat'         => 'required|string|max:255',
        ]);

        // Jika jabatan adalah "Lainnya", simpan jabatan yang dimasukkan pengguna
        if ($request->jabatan == 'Lainnya') {
            $validated['jabatan'] = $request->jabatan_lain;
        }

        // Temukan data karyawan yang akan diperbarui
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    // Hapus karyawan
    public function destroy($id)
    {
        // hanya mandor
        $this->authorize('delete karyawan');

        // Temukan data karyawan yang akan dihapus
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus!');
    }
}
