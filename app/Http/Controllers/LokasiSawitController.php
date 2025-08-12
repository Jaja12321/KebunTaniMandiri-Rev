<?php

namespace App\Http\Controllers;

use App\Models\LokasiSawit2; // Make sure the correct model is imported
use Illuminate\Http\Request;

class LokasiSawitController extends Controller
{
    // Menampilkan daftar lokasi sawit2
    public function index()
{
    // Ambil semua data lokasi sawit2
    $lokasiSawit2 = LokasiSawit2::all();
    return view('lokasi_sawit.index', compact('lokasiSawit2'));  // Correct variable name here
}


    // Menampilkan form tambah lokasi sawit2
    public function create()
    {
        return view('lokasi_sawit.create');
    }

    // Menyimpan lokasi sawit2 baru ke dalam database
    public function store(Request $request)
{
    // Validate the input fields
    $request->validate([
        'nama_lokasi' => 'required|string|max:255',
        'area' => 'required|string|max:255',
        'area_size' => 'required|string',
        'area_type' => 'required|string',
        'coords' => 'required|json',  // Validate as JSON
        'color' => 'nullable|string',
        'stroke_color' => 'nullable|string',
        'stroke_width' => 'nullable|integer',
        'has_area' => 'required|boolean',
    ]);

    // Decode the coordinates into an array from the JSON format
    $coords = json_decode($request->coords, true);  // Ensure it's an array

    // Save the data to the database
    LokasiSawit2::create([
        'nama_lokasi' => $request->nama_lokasi,
        'area' => $request->area,
        'area_size' => $request->area_size,
        'area_type' => $request->area_type,
        'coords' => json_encode($coords),  // Save as JSON
        'color' => $request->color,
        'stroke_color' => $request->stroke_color,
        'stroke_width' => $request->stroke_width,
        'has_area' => $request->has_area,
    ]);

    return redirect()->route('lokasi_sawit.index')->with('success', 'Lokasi Sawit berhasil ditambahkan!');
}

    // Display form for editing the sawit location
    public function edit($id)
    {
        $lokasi = LokasiSawit2::findOrFail($id);
        return view('lokasi_sawit.edit', compact('lokasi'));
    }

    // Update the sawit location in the database
    public function update(Request $request, $id)
    {
        // Validasi input, coords wajib JSON string
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'area_size' => 'required|string',
            'area_type' => 'required|string',
            'coords' => 'required|json',
            'color' => 'nullable|string',
            'stroke_color' => 'nullable|string',
            'stroke_width' => 'nullable|integer',
            'has_area' => 'required|boolean',
        ]);

        // Update data
        $lokasi = LokasiSawit2::findOrFail($id);
        $lokasi->update([
            'nama_lokasi' => $request->nama_lokasi,
            'area' => $request->area,
            'area_size' => $request->area_size,
            'area_type' => $request->area_type,
            'coords' => json_decode($request->coords, true),
            'color' => $request->color,
            'stroke_color' => $request->stroke_color,
            'stroke_width' => $request->stroke_width,
            'has_area' => $request->has_area,
        ]);

        return redirect()->route('lokasi_sawit.index')->with('success', 'Lokasi Sawit berhasil diperbarui!');
    }

    // Delete the sawit location
    public function destroy($id)
    {
        $lokasi = LokasiSawit2::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('lokasi_sawit2.index')->with('success', 'Lokasi Sawit berhasil dihapus!');
    }
}
