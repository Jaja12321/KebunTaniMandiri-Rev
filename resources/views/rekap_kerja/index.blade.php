@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak muncul di topbar --}}

@section('main-content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<h5 class="mb-3 d-flex align-items-center gap-2" style="font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1.5rem; color: #212529;">
    <i class="fas fa-clipboard-list text-info"></i>
    <span>Rekap Kerja</span>
</h5>

<form method="GET" action="{{ route('rekap_kerja.index') }}" class="mb-3 d-flex gap-3">
    <input type="text" name="search" class="form-control form-control-sm w-25" placeholder="Cari nama karyawan..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
</form>

{{-- Tabel Karyawan --}}
<div class="table-responsive">
    <table class="table table-bordered text-center">
        <thead class="table-dark text-white">
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Beban Kerja (Lahan)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawans as $index => $karyawan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
                <td>{{ $karyawan->jabatan }}</td>
                <td>
                    @if($karyawan->status == 'Aktif')
                        <span class="badge badge-success" style="box-shadow: 0 0 10px 3px rgba(40, 167, 69, 0.6); padding: 5px 15px; font-size: 14px;">
                            {{ $karyawan->status }}
                        </span>
                    @else
                        <span class="badge badge-danger" style="padding: 5px 15px; font-size: 14px;">
                            {{ $karyawan->status }}
                        </span>
                    @endif
                </td>
            <td>
                {{-- Menampilkan data dummy untuk Beban Kerja --}}
                @if($karyawan->id == 26)
                    9.5 Ha
                @elseif($karyawan->id == 29)
                    9.9 Ha
                @elseif($karyawan->id == 30)
                    10.8 Ha
                @elseif($karyawan->id == 31)
                    9.7 Ha
                @elseif($karyawan->id == 27)
                    39.9 Ha
                @else
                    0 Ha
                @endif
            </td>
            <td>
                    @if(auth()->user()->hasRole('mandor') && $karyawan->kehadiran->count() > 0)
    <a href="{{ route('rekap_kerja.create', $karyawan->id) }}" class="btn btn-success btn-sm">
        <i class="fas fa-plus"></i> Tambah
    </a>
@elseif($karyawan->status !== 'Aktif')
    <span class="badge badge-danger" style="font-size: 14px; padding: 5px 15px; font-weight: 600; text-transform: uppercase;">
        Belum Mengisi Kehadiran
    </span>
@endif


                    <a href="{{ route('rekap_kerja.detail', ['id' => $karyawan->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Paginasi --}}
<div class="d-flex justify-content-center mt-4">
    {{ $karyawans->links() }} <!-- Menampilkan navigasi halaman -->
</div>

{{-- Tombol Kembali --}}
<div class="d-flex justify-content-end gap-2 mt-3">
    <a href="{{ route('fitur.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@endsection
