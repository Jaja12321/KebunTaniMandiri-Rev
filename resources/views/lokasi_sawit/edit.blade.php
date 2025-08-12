@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')
<div class="container" style="max-width: 650px;">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white font-weight-bold text-center">
            <i class="fas fa-edit"></i> Form Edit Lahan Sawit
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('lokasi_sawit.update', $lokasi->id) }}">
                @csrf
                @method('PUT')

                <!-- Nama Lokasi -->
                <div class="form-group">
                    <label for="nama_lokasi"><i class="fas fa-map-marker-alt text-primary"></i> Nama Lokasi Lahan Sawit</label>
                    <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}" required>
                    <small class="form-text text-muted">Nama blok atau area lahan sawit</small>
                </div>

                <!-- Luas Lahan -->
                <div class="form-group mt-3">
                    <label for="area_size"><i class="fas fa-ruler-combined text-success"></i> Luas Lahan Sawit (hektar)</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="area_size" id="area_size" class="form-control" value="{{ old('area_size', $lokasi->area_size) }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text">Ha</span>
                        </div>
                    </div>
                    <small class="form-text text-success">
                        <strong>L = {{ $lokasi->area_size }} Ha</strong> (luas saat ini)
                    </small>
                </div>

                <!-- Jenis Tanaman -->
                <div class="form-group mt-3">
                    <label for="jenis_tanaman"><i class="fas fa-seedling text-success"></i> Jenis Tanaman</label>
                    <select name="jenis_tanaman" id="jenis_tanaman" class="form-control" required>
                        <option value="Kelapa Sawit" {{ old('jenis_tanaman', $lokasi->jenis_tanaman) == 'Kelapa Sawit' ? 'selected' : '' }}>🌴 Kelapa Sawit</option>
                        <option value="Sawit Hibrida" {{ old('jenis_tanaman', $lokasi->jenis_tanaman) == 'Sawit Hibrida' ? 'selected' : '' }}>🌿 Sawit Hibrida</option>
                        <option value="Sawit Unggul" {{ old('jenis_tanaman', $lokasi->jenis_tanaman) == 'Sawit Unggul' ? 'selected' : '' }}>🌱 Sawit Unggul</option>
                        <option value="Sawit" {{ old('jenis_tanaman', $lokasi->jenis_tanaman) == 'Sawit' ? 'selected' : '' }}>🌾 Sawit</option>
                    </select>
                </div>

                <!-- Kondisi Tanaman -->
                <div class="form-group mt-3">
                    <label for="kondisi_tanaman"><i class="fas fa-chart-line text-warning"></i> Kondisi Lahan Sawit</label>
                    <select name="kondisi_tanaman" id="kondisi_tanaman" class="form-control" required>
                        <option value="Produktif" {{ old('kondisi_tanaman', $lokasi->kondisi_tanaman) == 'Produktif' ? 'selected' : '' }}>✅ Produktif</option>
                        <option value="Belum Produktif" {{ old('kondisi_tanaman', $lokasi->kondisi_tanaman) == 'Belum Produktif' ? 'selected' : '' }}>⏳ Belum Produktif</option>
                        <option value="Dalam Perawatan" {{ old('kondisi_tanaman', $lokasi->kondisi_tanaman) == 'Dalam Perawatan' ? 'selected' : '' }}>🔧 Dalam Perawatan</option>
                        <option value="Perlu Replanting" {{ old('kondisi_tanaman', $lokasi->kondisi_tanaman) == 'Perlu Replanting' ? 'selected' : '' }}>🔄 Perlu Replanting</option>
                    </select>
                </div>


                <!-- Koordinat Polygon -->
                <div class="form-group mt-3">
                    <label for="coords"><i class="fas fa-draw-polygon text-info"></i> Koordinat Polygon (format JSON)</label>
                    <textarea name="coords" id="coords" class="form-control" rows="4" required>{{ old('coords', json_encode($lokasi->coords)) }}</textarea>
                    <small class="form-text text-muted">
                        Contoh: [[-1.545,103.07],[-1.542,103.075],[-1.544,103.08]]
                    </small>
                </div>

                <!-- Submit Button -->
                <div class="form-group mt-4 text-right">
                    <a href="{{ route('lokasi_sawit.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
