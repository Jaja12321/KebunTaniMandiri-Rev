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
            @if($kehadiran->count() > 0)
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark text-white small">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Jam Kerja</th>
                        <th>Lembur</th>
                        @if(auth()->user()->hasRole('mandor')) <th>Aksi</th> @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kehadiran as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start">{{ $item->karyawan->nama_lengkap ?? '-' }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>
                            <span class="badge bg-{{ $item->status == 'Hadir' ? 'success' : ($item->status == 'Izin' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->waktu_masuk }}</td>
                        <td>{{ $item->waktu_keluar }}</td>
                        <td>{{ $item->jam_kerja }}</td>
                        <td>{{ $item->jam_lembur }}</td>
                        @if(auth()->user()->hasRole('mandor'))
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('kehadiran.edit', $item->id) }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1 px-2 py-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('kehadiran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-1 px-2 py-1">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3 d-flex justify-content-center">
                {{ $kehadiran->links() }}
            </div>
            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Tidak ada kehadiran untuk tanggal ini.
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Tombol Kembali & Tambah -->
<div class="d-flex justify-content-end align-items-center gap-2 mt-3">
    <a href="{{ route('fitur.index') }}" class="btn btn-md btn-secondary text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-arrow-left"></i> <span>Kembali</span>
    </a>
    @if(auth()->user()->hasRole('mandor'))
    <a href="{{ route('kehadiran.create') }}" class="btn btn-md btn-success text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-plus-circle"></i> <span>Tambah Kehadiran</span>
    </a>
    @endif
</div>

@endsection
