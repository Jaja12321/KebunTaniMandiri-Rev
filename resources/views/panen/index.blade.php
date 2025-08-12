@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')

@php
    use Carbon\Carbon;
    $selectedTanggal = request('tanggal', now()->toDateString());
    $subTotalBerat = $panen->sum('berat');
    $subTotalNilai = $panen->sum('total_nilai');
@endphp

<!-- Judul -->
<h5 class="mb-4 d-flex align-items-center gap-2"
    style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.5rem; color: #212529;">
    <i class="fas fa-seedling text-success"></i> <span>Data Panen</span>
</h5>

{{-- Filter Form --}}
<div class="mb-3">
    <form method="GET" action="{{ route('panen.index') }}" class="d-flex align-items-center gap-1 flex-wrap">
        <div class="input-group input-group-sm" style="max-width: 150px;">
            <span class="input-group-text bg-white">
                <i class="fas fa-calendar-month text-primary"></i>
            </span>
            <select name="bulan" class="form-control" required>
                <option value="">Pilih Bulan</option>
                @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}" {{ $selectedBulan == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="input-group input-group-sm" style="max-width: 120px;">
            <span class="input-group-text bg-white">
                <i class="fas fa-calendar-year text-primary"></i>
            </span>
            <input type="number" name="tahun" class="form-control" value="{{ $selectedTahun ?? date('Y') }}" min="2020" max="{{ date('Y') }}" required>
        </div>

        <button type="submit" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
            <i class="fas fa-search"></i> <span>Cari</span>
        </button>
    </form>
</div>


<!-- Success Alert -->
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Tabel Panen -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            @if($panen->count() > 0)
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark text-white small">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Termin</th>
                        <th>Berat (kg)</th>
                        <th>Harga</th>
                        <th>Total Jumlah</th>
                        @if(auth()->user()->hasRole('mandor')) <th>Aksi</th> @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($panen as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->tanggal->format('Y-m-d') }}</td>
                        <td class="text-start">{{ $item->lokasiSawit->nama_lokasi }}</td>
                        <td>{{ $item->termin }}</td>
                        <td>{{ number_format($item->berat, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->harga_tbs, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                        @if(auth()->user()->hasRole('mandor'))
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('panen.edit', $item->id) }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1 px-2 py-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('panen.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                <tfoot class="text-sm fw-semibold">
    <tr class="table-secondary">
        <td colspan="6" style="text-align: left !important; padding-left: 0.75rem;">
            Total Berat TBS
        </td>
        <td colspan="2" style="text-align: left !important;">
            {{ number_format($totalBerat, 0, ',', '.') }} kg
        </td>
    </tr>
    <tr class="table-success">
        <td colspan="6" style="text-align: left !important; padding-left: 0.75rem;">
            Jumlah Panen
        </td>
        <td colspan="2" style="text-align: left !important;">
            Rp {{ number_format($totalNilai, 0, ',', '.') }}
        </td>
    </tr>
</tfoot>


            </table>

            <div class="mt-3 d-flex justify-content-center">
                {{ $panen->appends(request()->query())->links() }}
            </div>

            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Tidak ada panen untuk tanggal ini.
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
    <a href="{{ route('panen.create') }}" class="btn btn-md btn-success text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-plus-circle"></i> <span>Tambah Panen</span>
    </a>
    @endif
</div>

@endsection
