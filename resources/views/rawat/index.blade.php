@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')

<h5 class="mb-4 d-flex align-items-center gap-2"
    style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.5rem; color: #212529;">
    <i class="fas fa-seedling text-success"></i> <span>Data Rawat</span>
</h5>

{{-- Filter Bulan dan Tahun --}}
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
    <form method="GET" action="{{ route('rawat.index') }}" class="d-flex align-items-center gap-3">
        <!-- Filter Bulan -->
        <div class="input-group input-group-sm" style="max-width: 180px;">
            <span class="input-group-text bg-white">
                <i class="fas fa-calendar-month text-primary"></i>
            </span>
            <select name="bulan" class="form-control" required>
                <option value="">Pilih Bulan</option>
                @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request('bulan') == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Input Tahun -->
        <div class="input-group input-group-sm" style="max-width: 120px;">
            <span class="input-group-text bg-white">
                <i class="fas fa-calendar-year text-primary"></i>
            </span>
            <input type="number" name="tahun" class="form-control" value="{{ request('tahun', date('Y')) }}" min="2020" max="{{ date('Y') }}" required>
        </div>

        <button type="submit" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1">
            <i class="fas fa-search"></i> <span>Cari</span>
        </button>
    </form>
</div>

@if ($rawats->isNotEmpty())
<div class="card shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover w-100 align-middle text-center mb-0">
                <thead class="table-dark text-white small">
                    <tr>
                        <th>No</th>
                        <th class="text-start">Nama</th>
                        <th>Tanggal</th>
                        <th>Banyak</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th class="text-start">Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rawats as $rawat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start">{{ $rawat->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($rawat->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ number_format($rawat->banyak, 0) }}</td>
                        <td>Rp {{ number_format($rawat->harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($rawat->jumlah, 0, ',', '.') }}</td>
                        <td class="text-start">{{ $rawat->keterangan }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('rawat.edit', $rawat->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('rawat.destroy', $rawat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="text-sm fw-semibold">
                    <tr class="table-secondary">
                        <td colspan="5" class="text-left">Total Banyak</td>
                        <td colspan="3" class="text-left">{{ number_format($totalBanyak, 0) }}</td>
                    </tr>
                    <tr class="table-success">
                        <td colspan="5" class="text-left">Jumlah</td>
                        <td colspan="3" class="text-left">Rp {{ number_format($totalJumlah, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@else
<div class="alert alert-info text-center">
    <p>Tidak ada data rawat pada tanggal ini.</p>
</div>
@endif

{{-- Tombol Kembali dan Tambah Rawat --}}
<div class="d-flex justify-content-end align-items-center gap-3 mt-4">
    <a href="{{ route('fitur.index') }}" class="btn btn-md btn-secondary text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-arrow-left"></i> <span>Kembali</span>
    </a>

    @if(auth()->user()->hasRole('mandor'))
    <a href="{{ route('rawat.create') }}" class="btn btn-md btn-success text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-plus-circle"></i> <span>Tambah Rawat</span>
    </a>
    @endif
</div>

@endsection
