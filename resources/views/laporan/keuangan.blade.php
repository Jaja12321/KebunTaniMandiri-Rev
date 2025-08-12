{{-- resources/views/laporan/keuangan.blade.php --}}

@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')
<div class="d-flex align-items-center gap-2 mb-4">
    <h5 class="mb-0 d-flex align-items-center gap-2"
        style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.6rem; color: #212529;">
        <span>Laporan Keuangan</span>
    </h5>
</div>

{{-- Filter Form and Print Button --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    {{-- Filter Form --}}
    <form method="GET" action="{{ route('laporan.keuangan') }}" class="d-flex align-items-center gap-3">
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


<div class="card shadow-sm rounded mb-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center" id="laporanTable">
                <thead class="table-dark text-white">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Jumlah (Rp)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendapatan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td class="text-success">{{ $item->jenis }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                    @endforeach
                    @foreach($pengeluaran as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td class="text-danger">{{ $item->jenis }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="font-weight-bold">
                    <tr style="background-color: #d4edda;">
                        <td colspan="4">Total Pendapatan</td>
                        <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    <tr style="background-color: #f8d7da;">
                        <td colspan="4">Total Pengeluaran</td>
                        <td>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    <tr style="background-color: #fff3cd;">
                        <td colspan="4">Selisih</td>
                        <td>Rp {{ number_format($selisih, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-3">
    <a href="{{ route('fitur.index') }}" class="btn btn-md btn-secondary text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-arrow-left"></i> <span>Kembali</span>
    </a>

    <a href="{{ route('laporan.keuangan.cetakPdf', ['bulan' => $selectedBulan, 'tahun' => $selectedTahun]) }}" class="btn btn-md btn-success text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-print"></i> <span>Cetak PDF</span>
    </a>
</div>


@endsection
