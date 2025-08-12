@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')

<!-- Judul Halaman -->
<div class="container" style="max-width: 650px;">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white font-weight-bold text-center">
            Form Edit Panen
        </div>

        <div class="card-body">
            <form action="{{ route('panen.update', $panen->id) }}" method="POST">
                @csrf
                @method('PUT')
                {{-- Lokasi Sawit --}}
                <div class="mb-3">
                    <label for="lokasi_sawit_id" class="form-label fw-semibold">Lokasi Sawit</label>
                    <select name="lokasi_sawit_id" id="lokasi_sawit_id" class="form-select @error('lokasi_sawit_id') is-invalid @enderror" required>
                        <option value="">Pilih Lokasi</option>
                        @foreach ($lokasiSawit as $lokasi)
                            <option value="{{ $lokasi->id }}" {{ old('lokasi_sawit_id', $panen->lokasi_sawit_id) == $lokasi->id ? 'selected' : '' }}>
                                {{ $lokasi->nama_lokasi }}
                            </option>
                        @endforeach
                    </select>
                    @error('lokasi_sawit_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Panen --}}
                <div class="mb-3">
                    <label for="tanggal" class="form-label fw-semibold">Tanggal Panen</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                        value="{{ old('tanggal', $panen->tanggal->format('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Berat --}}
                <div class="mb-3">
                    <label for="berat" class="form-label fw-semibold">Berat (kg)</label>
                    <input type="number" step="0.01" name="berat" id="berat" class="form-control @error('berat') is-invalid @enderror"
                        value="{{ old('berat', $panen->berat) }}" required>
                    @error('berat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Harga TBS --}}
                <div class="mb-3">
                    <label for="harga_tbs" class="form-label fw-semibold">Harga TBS (IDR)</label>
                    <input type="text" name="harga_tbs" id="harga_tbs" class="form-control @error('harga_tbs') is-invalid @enderror"
                        value="{{ old('harga_tbs', number_format($panen->harga_tbs, 0, ',', '.')) }}" required>
                    @error('harga_tbs')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Termin --}}
                <div class="mb-3">
                    <label for="termin" class="form-label fw-semibold">Termin</label>
                    <select name="termin" id="termin" class="form-select @error('termin') is-invalid @enderror" required>
                        <option value="">Pilih Termin</option>
                        @for ($i = 1; $i <= 3; $i++)
                            <option value="Termin {{ $i }}" {{ old('termin', $panen->termin) == "Termin $i" ? 'selected' : '' }}>
                                Termin {{ $i }}
                            </option>
                        @endfor
                    </select>
                    @error('termin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('panen.index') }}" class="btn btn-secondary text-white fw-semibold d-flex align-items-center gap-2">
                        <i class="fas fa-arrow-left"></i> <span>Kembali</span>
                    </a>
                    <button type="submit" class="btn btn-success fw-semibold d-flex align-items-center gap-2">
                        <i class="fas fa-save"></i> <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
