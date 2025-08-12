@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')
<div class="container" style="max-width: 650px;">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white font-weight-bold text-center">
            <i class="fas fa-seedling"></i> Form Tambah Lahan Sawit
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('lokasi_sawit.store') }}">
                @csrf

                <!-- Nama Lokasi -->
                <div class="form-group">
                    <label for="nama_lokasi"><i class="fas fa-map-marker-alt text-primary"></i> Nama Lokasi Lahan Sawit</label>
                    <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" placeholder="Contoh: FAUZI, BUJANG, GINTING, dll." required>
                    <small class="form-text text-muted">Masukkan nama blok atau area lahan sawit</small>
                </div>

                <!-- Luas Lahan -->
                <div class="form-group mt-3">
                    <label for="luas_lahan"><i class="fas fa-ruler-combined text-success"></i> Luas Lahan Sawit (hektar)</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="luas_lahan" id="luas_lahan" class="form-control" placeholder="0.00" required>
                        <div class="input-group-append">
                            <span class="input-group-text">Ha</span>
                        </div>
                    </div>
                    <small class="form-text text-muted">Masukkan luas dalam satuan hektar (Ha)</small>
                </div>

                <!-- Jenis Tanaman -->
                <div class="form-group mt-3">
                    <label for="jenis_tanaman"><i class="fas fa-seedling text-success"></i> Jenis Tanaman</label>
                    <select name="jenis_tanaman" id="jenis_tanaman" class="form-control" required>
                        <option value="">Pilih Jenis Tanaman</option>
                        <option value="Kelapa Sawit" selected>🌴 Kelapa Sawit</option>
                        <option value="Sawit Hibrida">🌿 Sawit Hibrida</option>
                        <option value="Sawit Unggul">🌱 Sawit Unggul</option>
                    </select>
                </div>

                <!-- Kondisi Tanaman -->
                <div class="form-group mt-3">
                    <label for="kondisi_tanaman"><i class="fas fa-chart-line text-warning"></i> Kondisi Lahan Sawit</label>
                    <select name="kondisi_tanaman" id="kondisi_tanaman" class="form-control" required>
                        <option value="">Pilih Kondisi</option>
                        <option value="Produktif" selected>✅ Produktif</option>
                        <option value="Belum Produktif">⏳ Belum Produktif</option>
                        <option value="Dalam Perawatan">🔧 Dalam Perawatan</option>
                        <option value="Perlu Replanting">🔄 Perlu Replanting</option>
                    </select>
                </div>

                <!-- Latitude -->
                <div class="form-group mt-3">
                    <label for="latitude"><i class="fas fa-globe text-info"></i> Latitude (Garis Lintang)</label>
                    <input type="number" step="any" name="latitude" id="latitude" class="form-control" placeholder="-1.547778" required>
                    <small class="form-text text-muted">Koordinat lintang (negatif untuk selatan, contoh: -1.547778)</small>
                </div>

                <!-- Longitude -->
                <div class="form-group mt-3">
                    <label for="longitude"><i class="fas fa-globe text-info"></i> Longitude (Garis Bujur)</label>
                    <input type="number" step="any" name="longitude" id="longitude" class="form-control" placeholder="103.092778" required>
                    <small class="form-text text-muted">Koordinat bujur (positif untuk timur, contoh: 103.092778)</small>
                </div>

                <!-- Submit Button -->
                <div class="form-group mt-4 text-right">
                    <a href="{{ route('lokasi_sawit.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Lahan Sawit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
