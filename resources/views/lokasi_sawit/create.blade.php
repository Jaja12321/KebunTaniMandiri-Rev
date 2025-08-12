@extends('layouts.admin')

@section('page-title') {{-- Title for this page --}}

@section('main-content')
<h5 class="mb-4 d-flex align-items-center gap-2"
    style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.5rem; color: #212529;">
    <i class="fas fa-plus-circle text-success"></i> <span>Tambah Lokasi Sawit</span>
</h5>

<!-- Error Handling -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Form untuk tambah lokasi sawit -->
<form action="{{ route('lokasi_sawit.store') }}" method="POST">
    @csrf

    <!-- Nama Lokasi -->
    <div class="form-group">
        <label for="nama_lokasi">Nama Lokasi</label>
        <input type="text" name="nama_lokasi" class="form-control @error('nama_lokasi') is-invalid @enderror" value="{{ old('nama_lokasi') }}" required>
        @error('nama_lokasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Area -->
    <div class="form-group">
        <label for="area">Area</label>
        <input type="text" name="area" class="form-control @error('area') is-invalid @enderror" value="{{ old('area') }}" required>
        @error('area')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Luas Lahan -->
    <div class="form-group">
        <label for="area_size">Luas Lahan (Ha)</label>
        <input type="text" name="area_size" class="form-control @error('area_size') is-invalid @enderror" value="{{ old('area_size') }}" required>
        @error('area_size')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Jenis Tanaman -->
    <div class="form-group">
        <label for="area_type">Jenis Tanaman</label>
        <input type="text" name="area_type" class="form-control @error('area_type') is-invalid @enderror" value="{{ old('area_type') }}" required>
        @error('area_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Koordinat -->
    <div class="form-group">
        <label for="coords">Koordinat (Array)</label>
        <textarea name="coords" class="form-control @error('coords') is-invalid @enderror" rows="4" required>{{ old('coords') }}</textarea>
        @error('coords')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Warna -->
    <div class="form-group">
        <label for="color">Warna</label>
        <input type="text" name="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color') }}">
        @error('color')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Warna Stroke -->
    <div class="form-group">
        <label for="stroke_color">Warna Stroke</label>
        <input type="text" name="stroke_color" class="form-control @error('stroke_color') is-invalid @enderror" value="{{ old('stroke_color') }}">
        @error('stroke_color')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Ketebalan Stroke -->
    <div class="form-group">
        <label for="stroke_width">Ketebalan Stroke</label>
        <input type="number" name="stroke_width" class="form-control @error('stroke_width') is-invalid @enderror" value="{{ old('stroke_width') }}">
        @error('stroke_width')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Checkbox Has Area -->
    <div class="form-group">
        <label for="has_area">Data Luas Tersedia</label>
        <input type="checkbox" name="has_area" value="1" {{ old('has_area') ? 'checked' : '' }}>
    </div>

    <!-- Tombol Submit -->
    <div class="d-flex justify-content-end align-items-center gap-2 mt-4">
        <a href="{{ route('lokasi_sawit.index') }}" class="btn btn-md btn-secondary text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
            <i class="fas fa-arrow-left"></i> <span>Kembali</span>
        </a>

        <button type="submit" class="btn btn-md btn-success fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
            <i class="fas fa-save"></i> <span>Simpan Lokasi Sawit</span>
        </button>
    </div>
</form>
@endsection
