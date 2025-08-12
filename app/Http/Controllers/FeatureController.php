<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Constructor: hanya untuk user yang sudah login.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar fitur.
     */
    public function index()
    {
        $this->authorize('view features');

        $features = Feature::all();
        return view('features.index', compact('features'));
    }

    /**
     * Tampilkan form tambah fitur.
     */
    public function create()
    {
        $this->authorize('create features');

        return view('features.create');
    }

    /**
     * Simpan fitur baru.
     */
    public function store(Request $request)
    {
        $this->authorize('create features');

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Feature::create([
            'name' => $request->name
        ]);

        return redirect()->route('features.index')
            ->with('success', 'Fitur berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit fitur.
     */
    public function edit(Feature $feature)
    {
        $this->authorize('update features');

        return view('features.edit', compact('feature'));
    }

    /**
     * Update fitur.
     */
    public function update(Request $request, Feature $feature)
    {
        $this->authorize('update features');

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $feature->update([
            'name' => $request->name
        ]);

        return redirect()->route('features.index')
            ->with('success', 'Fitur berhasil diperbarui.');
    }

    /**
     * Hapus fitur.
     */
    public function destroy(Feature $feature)
    {
        $this->authorize('delete features');

        $feature->delete();

        return redirect()->route('features.index')
            ->with('success', 'Fitur berhasil dihapus.');
    }
}