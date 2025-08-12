@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')
<div class="container" style="max-width: 650px;">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white font-weight-bold text-center">
            Form Edit Karyawan
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('karyawan.update', $karyawan->id) }}">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}" required>
                    @error('nama_lengkap')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jabatan -->
                <div class="form-group mt-3">
                    <label for="jabatan">Jabatan</label>
                    <select class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required onchange="toggleOtherJabatan(this)">
                        <option value="Petani Aktif" {{ old('jabatan', $karyawan->jabatan) == 'Petani Aktif' ? 'selected' : '' }}>Petani Aktif</option>
                        <option value="Pemupuk" {{ old('jabatan', $karyawan->jabatan) == 'Pemupuk' ? 'selected' : '' }}>Pemupuk</option>
                        <option value="Mandor" {{ old('jabatan', $karyawan->jabatan) == 'Mandor' ? 'selected' : '' }}>Mandor</option>
                        <option value="Pekerja Panen" {{ old('jabatan', $karyawan->jabatan) == 'Pekerja Panen' ? 'selected' : '' }}>Pekerja Panen</option>
                        <option value="Operator Alat Berat" {{ old('jabatan', $karyawan->jabatan) == 'Operator Alat Berat' ? 'selected' : '' }}>Operator Alat Berat</option>
                        <option value="Lainnya" {{ old('jabatan', $karyawan->jabatan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jabatan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Input untuk jabatan Lainnya -->
                <div class="form-group mt-3" id="jabatan-lainnya" style="{{ old('jabatan', $karyawan->jabatan) == 'Lainnya' ? 'display:block;' : 'display:none;' }}">
                    <label for="jabatan_lain">Jabatan Lainnya</label>
                    <input type="text" class="form-control @error('jabatan_lain') is-invalid @enderror" id="jabatan_lain" name="jabatan_lain" value="{{ old('jabatan_lain', $karyawan->jabatan_lain) }}" placeholder="Masukkan jabatan lainnya">
                    @error('jabatan_lain')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group mt-3">
                    <label for="status">Status Karyawan</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="Harian" {{ old('status', $karyawan->status) == 'Harian' ? 'selected' : '' }}>Harian</option>
                        <option value="Borongan" {{ old('status', $karyawan->status) == 'Borongan' ? 'selected' : '' }}>Borongan</option>
                        <option value="Tetap" {{ old('status', $karyawan->status) == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div class="form-group mt-3">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control @error('nomor_telepon') is-invalid @enderror" value="{{ old('nomor_telepon', $karyawan->nomor_telepon) }}" required>
                    @error('nomor_telepon')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="form-group mt-3">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $karyawan->alamat) }}</textarea>
                    @error('alamat')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol di Bawah (Kanan) -->
                <div class="d-flex justify-content-end align-items-center gap-2 mt-4">
                    <a href="{{ route('karyawan.index') }}" class="btn btn-md btn-secondary border text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                        <i class="fas fa-arrow-left"></i> <span>Kembali</span>
                    </a>

                    <button type="submit" class="btn btn-md btn-success fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                        <i class="fas fa-save"></i> <span>Update Karyawan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleOtherJabatan(select) {
        var inputField = document.getElementById('jabatan-lainnya');
        if (select.value == "Lainnya") {
            inputField.style.display = 'block';
        } else {
            inputField.style.display = 'none';
        }
    }

    // If "Lainnya" is selected when the form loads, display the input field
    window.onload = function() {
        var selectedJabatan = document.getElementById('jabatan').value;
        if (selectedJabatan == "Lainnya") {
            document.getElementById('jabatan-lainnya').style.display = 'block';
        }
    }
</script>
@endsection
