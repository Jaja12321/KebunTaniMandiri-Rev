@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak muncul di topbar --}}

@section('main-content')

<!-- Judul Halaman -->
<h5 class="mb-3 d-flex align-items-center gap-2" style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.5rem; color: #212529;">
    <i class="fas fa-users text-info"></i> <span>Data Karyawan</span>
</h5>

<!-- Pesan Sukses -->
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Form Pencarian Nama Karyawan -->
<form method="GET" action="{{ route('karyawan.index') }}" class="mb-3 d-flex gap-3">
    <input type="text" name="search" class="form-control form-control-sm w-25" placeholder="Cari nama karyawan..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
</form>

<!-- Tabel Data -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark text-white small">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        @if(auth()->user()->hasRole('mandor'))
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($karyawans as $karyawan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">{{ $karyawan->nama_lengkap }}</td>
                            <td>{{ $karyawan->jabatan }}</td>
                            <td>
                                <!-- Styling for Status 'Aktif' with a green background -->
                                @if($karyawan->status == 'Aktif')
                                    <span class="badge badge-success" style="background-color: #28a745; color: white; padding: 5px 15px; box-shadow: 0 0 10px 3px rgba(40, 167, 69, 0.6); font-size: 14px;">
                                        {{ $karyawan->status }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary" style="padding: 5px 15px; font-size: 14px;">
                                        {{ $karyawan->status }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $karyawan->nomor_telepon }}</td>
                            <td>{{ $karyawan->alamat }}</td>
                            @if(auth()->user()->hasRole('mandor'))
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1 px-2 py-1">
                                        <i class="fas fa-edit"></i> <span>Edit</span>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-1 px-2 py-1">
                                            <i class="fas fa-trash"></i> <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->hasRole('mandor') ? '7' : '6' }}">
                                Tidak ada data karyawan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center">
                {{ $karyawans->links() }} <!-- Menampilkan navigasi halaman -->
            </div>
        </div>
    </div>
</div>

{{-- Tombol Tambah & Kembali --}}
<div class="d-flex justify-content-end align-items-center gap-2 mt-4">
    <a href="{{ route('fitur.index') }}" class="btn btn-md btn-secondary text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-arrow-left"></i> <span>Kembali</span>
    </a>

    @if(auth()->user()->hasRole('mandor'))
    <a href="{{ route('karyawan.create') }}" class="btn btn-md btn-success text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-user-plus"></i> <span>Tambah Karyawan</span>
    </a>
    @endif
</div>

@endsection
