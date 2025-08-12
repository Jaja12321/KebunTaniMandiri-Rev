@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')

@php
    use Carbon\Carbon;
    $selectedTanggal = request('tanggal', now()->toDateString());
@endphp

<!-- Judul -->
<h5 class="mb-4 d-flex align-items-center gap-2"
    style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.5rem; color: #212529;">
    <i class="fas fa-calendar-check text-info"></i> <span>Data Kehadiran Karyawan</span>
</h5>

<!-- Filter Form -->
<div class="mb-3">
    <form method="GET" action="{{ route('kehadiran.index') }}" class="d-flex align-items-center gap-1 flex-wrap">
        <!-- Input Tanggal -->
        <div class="input-group input-group-sm" style="max-width: 220px;">
            <span class="input-group-text bg-white">
                <i class="fas fa-calendar-alt text-primary"></i>
            </span>
            <input type="date" name="tanggal" class="form-control"
                   value="{{ $selectedTanggal }}">
        </div>

        <!-- Tombol Cari -->
        <button type="submit" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
            <i class="fas fa-search"></i> <span>Cari</span>
        </button>
    </form>
</div>

<!-- Success Alert -->
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Tabel Kehadiran -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            @if($karyawans->count() > 0)
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark text-white small">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Kehadiran</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Jam Kerja</th>
                        <th>Lembur</th>
                        <th>History Kehadiran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawans as $index => $karyawan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-start">{{ $karyawan->nama_lengkap }}</td>
                        <td>{{ $selectedTanggal }}</td>
                        <td>
                            @if ($karyawan->kehadiran->isNotEmpty())
                                <span class="badge bg-{{ $karyawan->kehadiran->first()->status == 'Hadir' ? 'success' : ($karyawan->kehadiran->first()->status == 'Izin' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($karyawan->kehadiran->first()->status) }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Belum Hadir</span>
                            @endif
                        </td>
                        <td>
                            @if ($karyawan->performa)
                                {{ $karyawan->performa }}
                            @else
                                Belum Hadir
                            @endif
                        </td>
                        <td>{{ $karyawan->kehadiran->first()->waktu_masuk ?? '-' }}</td>
                        <td>{{ $karyawan->kehadiran->first()->waktu_keluar ?? '-' }}</td>
                        <td>{{ $karyawan->kehadiran->first()->jam_kerja ?? '-' }}</td>
                        <td>{{ $karyawan->kehadiran->first()->jam_lembur ?? '-' }}</td>
                        <td>
                            <a href="{{ route('kehadiran.history', $karyawan->id) }}" class="btn btn-sm btn-info">
                                History Kehadiran
                            </a>
                        </td>
                        <td>
                            <!-- Tombol untuk menambahkan kehadiran -->
                            <a href="{{ route('kehadiran.create', ['karyawan_id' => $karyawan->id]) }}" class="btn btn-sm btn-success">
                                Tambah Kehadiran
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3 d-flex justify-content-center">
                {{ $karyawans->links() }}  <!-- Paginasi ditampilkan di sini -->
            </div>
            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Tidak ada kehadiran untuk tanggal ini.
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Tombol Kembali -->
<div class="d-flex justify-content-end align-items-center gap-2 mt-3">
    <a href="{{ route('fitur.index') }}" class="btn btn-md btn-secondary text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-arrow-left"></i> <span>Kembali</span>
    </a>
</div>

@endsection
