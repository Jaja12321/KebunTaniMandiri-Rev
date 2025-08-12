@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')
<div class="container" style="max-width: 650px;">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white font-weight-bold text-center">
            Form Tambah Kehadiran
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('kehadiran.store') }}">
                @csrf

                <!-- Nama Karyawan -->
                <div class="form-group">
                    <label for="karyawan_id">Nama Karyawan</label>
                    <input type="text" class="form-control" value="{{ $karyawan->nama_lengkap }}" readonly>
                    <input type="hidden" name="karyawan_id" value="{{ request()->karyawan_id }}">
                    @error('karyawan_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div class="form-group mt-3">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', now()->toDateString()) }}" required>
                    @error('tanggal')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group mt-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Hadir" {{ old('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Izin" {{ old('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Sakit" {{ old('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Waktu Masuk -->
                <div class="form-group mt-3">
                    <label for="waktu_masuk">Waktu Masuk</label>
                    <input type="time" name="waktu_masuk" id="waktu_masuk" class="form-control" value="{{ old('waktu_masuk') }}" required>
                    @error('waktu_masuk')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Waktu Keluar -->
                <div class="form-group mt-3">
                    <label for="waktu_keluar">Waktu Keluar</label>
                    <input type="time" name="waktu_keluar" id="waktu_keluar" class="form-control" value="{{ old('waktu_keluar') }}" required>
                    @error('waktu_keluar')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gaji Lembur -->
                <div class="form-group mt-3">
                    <label for="gaji_lembur">Gaji Lembur (Rp)</label>
                    <input type="text" name="gaji_lembur" id="gaji_lembur" class="form-control" value="{{ old('gaji_lembur') }}" required>
                    @error('gaji_lembur')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol di Bawah (Kanan) -->
                <div class="d-flex justify-content-end align-items-center gap-2 mt-4">
                    <a href="{{ route('kehadiran.index') }}" class="btn btn-md btn-secondary border text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                        <i class="fas fa-arrow-left"></i> <span>Kembali</span>
                    </a>

                    <button type="submit" class="btn btn-md btn-success fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                        <i class="fas fa-save"></i> <span>Simpan Kehadiran</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const gajiInput = document.getElementById('gaji_lembur');
    
    // Format currency in Rupiah
    gajiInput.addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^\d]/g, '');  // Remove non-numeric characters
        if (!value) {
            e.target.value = '';
            return;
        }
        e.target.value = parseInt(value, 10).toLocaleString('id-ID');  // Format with thousands separator
    });

    // Before form submission, clean the value by removing dots
    document.querySelector('form').addEventListener('submit', function () {
        gajiInput.value = gajiInput.value.replace(/\./g, '');  // Remove dots before submitting
    });
});
</script>

@endsection
