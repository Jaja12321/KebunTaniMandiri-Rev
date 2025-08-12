@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')
<div class="container" style="max-width: 650px;">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white font-weight-bold text-center">
            Form Tambah Panen
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('panen.store') }}">
                @csrf

                <!-- Lokasi Sawit -->
                <div class="form-group">
                    <label for="lokasi_sawit_id">Lokasi Sawit</label>
                    <select name="lokasi_sawit_id" id="lokasi_sawit_id" class="form-control" required>
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach($lokasiSawit as $lokasi)
                            <option value="{{ $lokasi->id }}" {{ old('lokasi_sawit_id') == $lokasi->id ? 'selected' : '' }}>
                                {{ $lokasi->nama_lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Panen -->
                <div class="form-group mt-3">
                    <label for="tanggal">Tanggal Panen</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                </div>

                <!-- Berat -->
                <div class="form-group mt-3">
                    <label for="berat">Berat (kg)</label>
                    <input type="number" step="0.01" name="berat" id="berat" class="form-control" value="{{ old('berat') }}" required>
                </div>

                <!-- Harga TBS -->
                <div class="form-group mt-3">
                    <label for="harga_tbs">Harga TBS (IDR)</label>
                    <input type="text" name="harga_tbs" id="harga_tbs" class="form-control" value="{{ old('harga_tbs') }}" required>
                </div>

                <!-- Termin -->
                <div class="form-group mt-3">
                    <label for="termin">Termin</label>
                    <select name="termin" id="termin" class="form-control" required>
                        <option value="Termin 1" {{ old('termin') == 'Termin 1' ? 'selected' : '' }}>Termin 1</option>
                        <option value="Termin 2" {{ old('termin') == 'Termin 2' ? 'selected' : '' }}>Termin 2</option>
                        <option value="Termin 3" {{ old('termin') == 'Termin 3' ? 'selected' : '' }}>Termin 3</option>
                    </select>
                </div>

                <!-- Tombol di Bawah (Kanan) -->
                <div class="d-flex justify-content-end align-items-center gap-2 mt-4">
                    <a href="{{ route('panen.index') }}" class="btn btn-md btn-secondary text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                        <i class="fas fa-arrow-left"></i> <span>Kembali</span>
                    </a>

                    <button type="submit" class="btn btn-md btn-success fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                        <i class="fas fa-save"></i> <span>Simpan Panen</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
