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
                    <select name="karyawan_id" id="karyawan_id" class="form-control" required>
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach($karyawans as $karyawan)
                            <option value="{{ $karyawan->id }}" {{ old('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                {{ $karyawan->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="form-group mt-3">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                </div>

                <!-- Status -->
                <div class="form-group mt-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Hadir" {{ old('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Izin" {{ old('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Sakit" {{ old('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                </div>

                <!-- Waktu Masuk -->
                <div class="form-group mt-3">
                    <label for="waktu_masuk">Waktu Masuk</label>
                    <input type="time" name="waktu_masuk" id="waktu_masuk" class="form-control" value="{{ old('waktu_masuk') }}" required>
                </div>

                <!-- Waktu Keluar -->
                <div class="form-group mt-3">
                    <label for="waktu_keluar">Waktu Keluar</label>
                    <input type="time" name="waktu_keluar" id="waktu_keluar" class="form-control" value="{{ old('waktu_keluar') }}" required>
                </div>

                <!-- Gaji Lembur -->
                <div class="form-group mt-3">
                    <label for="gaji_lembur">Gaji Lembur (Rp)</label>
                    <input type="text" name="gaji_lembur" id="gaji_lembur" class="form-control" value="{{ old('gaji_lembur') }}" required>
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
    gajiInput.addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^\d]/g, '');  // Hapus selain angka
        if (!value) {
            e.target.value = '';
            return;
        }
        e.target.value = parseInt(value, 10).toLocaleString('id-ID');  // Format dengan ribuan
    });
    document.querySelector('form').addEventListener('submit', function () {
        gajiInput.value = gajiInput.value.replace(/\./g, '');  // Hapus titik sebelum submit
    });
});
</script>

@endsection
